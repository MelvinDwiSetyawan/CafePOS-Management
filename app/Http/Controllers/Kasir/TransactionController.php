<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\TableModel;
use App\Models\Transaction;
use App\Services\TransactionService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(protected TransactionService $transactionService)
    {
    }

    public function create()
    {
        $tables = TableModel::where('status', 'available')->get();
        $menus = Menu::with('category')->where('status', 'active')->get();

        return view('kasir.transactions.create', compact('tables', 'menus'));
    }

    public function index()
    {
        $transactions = Transaction::with('table', 'payment')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('kasir.transactions.index', compact('transactions'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = $this->transactionService->createTransaction(
            items: $request->items,
            tableId: $request->table_id,
            userId: auth()->id(),
            discount: $request->discount ?? 0,
            taxPercentage: $request->tax_percentage ?? 0,
        );

        return redirect()->route('kasir.transactions.payment', $transaction);
    }

    public function payment(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return redirect()->route('kasir.dashboard');
        }

        $transaction->load('details.menu', 'table');

        return view('kasir.transactions.payment', compact('transaction'));
    }

    public function processPayment(Request $request, Transaction $transaction)
    {
        $request->validate([
            'method' => 'required|in:cash,qris,debit',
            'amount_paid' => 'required|numeric|min:' . $transaction->grand_total,
        ]);

        $this->transactionService->processPayment(
            transaction: $transaction,
            method: $request->method,
            amountPaid: $request->amount_paid,
        );

        return redirect()->route('kasir.transactions.detail', $transaction);
    }

    public function detail(Transaction $transaction)
    {
        $transaction->load('details.menu', 'table', 'user', 'payment');

        return view('kasir.transactions.detail', compact('transaction'));
    }

    public function print(Transaction $transaction)
    {
        $transaction->load('details.menu', 'table', 'user', 'payment');
        $setting = Setting::first();

        $pdf = Pdf::loadView('pdf.struk', compact('transaction', 'setting'))
            ->setPaper([0, 0, 226.77, 600], 'portrait'); // ukuran struk thermal 80mm

        return $pdf->stream('struk-' . $transaction->transaction_code . '.pdf');
    }
}