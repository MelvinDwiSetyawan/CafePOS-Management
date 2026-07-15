<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\Payment;
use App\Models\StockHistory;
use App\Models\TableModel;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Str;

class TransactionService
{
    public function createTransaction(array $items, int $tableId, int $userId, float $discount = 0, float $taxPercentage = 0): Transaction
    {
        return DB::transaction(function () use ($items, $tableId, $userId, $discount, $taxPercentage) {
            $subtotal = 0;

            foreach ($items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);
                $subtotal += $menu->price * $item['qty'];
            }

            $tax = $subtotal * ($taxPercentage / 100);
            $grandTotal = $subtotal - $discount + $tax;

            $transaction = Transaction::create([
                'transaction_code' => 'TRX-' . strtoupper(Str::random(8)),
                'table_id' => $tableId,
                'user_id' => $userId,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'menu_id' => $menu->id,
                    'qty' => $item['qty'],
                    'price' => $menu->price,
                    'subtotal' => $menu->price * $item['qty'],
                ]);

                $menu->decrement('stock', $item['qty']);

                StockHistory::create([
                    'menu_id' => $menu->id,
                    'user_id' => $userId,
                    'type' => 'out',
                    'qty' => $item['qty'],
                    'note' => 'Terjual pada transaksi ' . $transaction->transaction_code,
                ]);
            }

            TableModel::where('id', $tableId)->update(['status' => 'occupied']);

            ActivityLogger::log('Transaksi', 'Transaksi baru: ' . $transaction->transaction_code);

            return $transaction;
        });
    }

    public function processPayment(Transaction $transaction, string $method, float $amountPaid): Payment
    {
        return DB::transaction(function () use ($transaction, $method, $amountPaid) {
            $change = $amountPaid - $transaction->grand_total;

            $payment = Payment::create([
                'transaction_id' => $transaction->id,
                'method' => $method,
                'amount_paid' => $amountPaid,
                'change' => $change,
            ]);

            $transaction->update(['status' => 'paid']);

            TableModel::where('id', $transaction->table_id)->update(['status' => 'available']);

            ActivityLogger::log('Pembayaran', 'Pembayaran transaksi: ' . $transaction->transaction_code);

            return $payment;
        });
    }
}