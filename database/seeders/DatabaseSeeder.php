<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Payment;
use App\Models\Role;
use App\Models\TableModel;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $kasirRole = Role::firstOrCreate(['name' => 'kasir']);

        $admin = User::updateOrCreate([
            'role_id' => $adminRole->id,
        ], [
            'email' => env('ADMIN_EMAIL', 'admin'),
            'role_id' => $adminRole->id,
            'name' => 'Administrator',
            'password' => bcrypt(env('ADMIN_PASSWORD', '12345')),
        ]);

        $kasir = User::updateOrCreate([
            'role_id' => $kasirRole->id,
        ], [
            'email' => env('KASIR_EMAIL', 'kasir'),
            'role_id' => $kasirRole->id,
            'name' => 'Kasir Satu',
            'password' => bcrypt(env('KASIR_PASSWORD', '12345')),
        ]);

        $food = Category::firstOrCreate(['name' => 'Makanan']);
        $drink = Category::firstOrCreate(['name' => 'Minuman']);
        $coffee = Category::firstOrCreate(['name' => 'Kopi']);

        $menuNasi = Menu::firstOrCreate([
            'name' => 'Nasi Goreng Spesial',
        ], [
            'category_id' => $food->id,
            'price' => 25000,
            'cost_price' => 15000,
            'stock' => 20,
            'status' => 'active',
        ]);

        $menuMie = Menu::firstOrCreate([
            'name' => 'Mie Ayam',
        ], [
            'category_id' => $food->id,
            'price' => 20000,
            'cost_price' => 12000,
            'stock' => 15,
            'status' => 'active',
        ]);

        $menuEsTeh = Menu::firstOrCreate([
            'name' => 'Es Teh Manis',
        ], [
            'category_id' => $drink->id,
            'price' => 8000,
            'cost_price' => 3000,
            'stock' => 30,
            'status' => 'active',
        ]);

        $menuKopi = Menu::firstOrCreate([
            'name' => 'Kopi Tubruk',
        ], [
            'category_id' => $coffee->id,
            'price' => 12000,
            'cost_price' => 5000,
            'stock' => 25,
            'status' => 'active',
        ]);

        $table1 = TableModel::firstOrCreate([
            'table_number' => 'Meja 1',
        ], [
            'capacity' => 4,
            'status' => 'available',
        ]);

        $table2 = TableModel::firstOrCreate([
            'table_number' => 'Meja 2',
        ], [
            'capacity' => 4,
            'status' => 'available',
        ]);

        $table3 = TableModel::firstOrCreate([
            'table_number' => 'Meja 3',
        ], [
            'capacity' => 2,
            'status' => 'available',
        ]);

        $transactions = [
            [
                'transaction_code' => 'TXN-001',
                'table_id' => $table1->id,
                'user_id' => $kasir->id,
                'subtotal' => 33000,
                'discount' => 0,
                'tax' => 0,
                'grand_total' => 33000,
                'status' => 'paid',
                'created_at' => now()->subDays(1)->setHour(11)->setMinute(45),
                'updated_at' => now()->subDays(1)->setHour(11)->setMinute(45),
                'details' => [
                    ['menu_id' => $menuNasi->id, 'qty' => 1, 'price' => 25000],
                    ['menu_id' => $menuEsTeh->id, 'qty' => 1, 'price' => 8000],
                ],
                'payment' => ['method' => 'cash', 'amount_paid' => 33000],
            ],
            [
                'transaction_code' => 'TXN-002',
                'table_id' => $table2->id,
                'user_id' => $kasir->id,
                'subtotal' => 40000,
                'discount' => 0,
                'tax' => 0,
                'grand_total' => 40000,
                'status' => 'paid',
                'created_at' => now()->subDays(2)->setHour(13)->setMinute(30),
                'updated_at' => now()->subDays(2)->setHour(13)->setMinute(30),
                'details' => [
                    ['menu_id' => $menuMie->id, 'qty' => 1, 'price' => 20000],
                    ['menu_id' => $menuKopi->id, 'qty' => 1, 'price' => 12000],
                    ['menu_id' => $menuEsTeh->id, 'qty' => 1, 'price' => 8000],
                ],
                'payment' => ['method' => 'cash', 'amount_paid' => 40000],
            ],
            [
                'transaction_code' => 'TXN-003',
                'table_id' => $table3->id,
                'user_id' => $kasir->id,
                'subtotal' => 28000,
                'discount' => 0,
                'tax' => 0,
                'grand_total' => 28000,
                'status' => 'paid',
                'created_at' => now()->subDays(3)->setHour(18)->setMinute(10),
                'updated_at' => now()->subDays(3)->setHour(18)->setMinute(10),
                'details' => [
                    ['menu_id' => $menuKopi->id, 'qty' => 2, 'price' => 12000],
                    ['menu_id' => $menuEsTeh->id, 'qty' => 1, 'price' => 8000],
                ],
                'payment' => ['method' => 'cash', 'amount_paid' => 28000],
            ],
        ];

        foreach ($transactions as $data) {
            $transaction = Transaction::firstOrCreate([
                'transaction_code' => $data['transaction_code'],
            ], [
                'table_id' => $data['table_id'],
                'user_id' => $data['user_id'],
                'subtotal' => $data['subtotal'],
                'discount' => $data['discount'],
                'tax' => $data['tax'],
                'grand_total' => $data['grand_total'],
                'status' => $data['status'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);

            foreach ($data['details'] as $detail) {
                TransactionDetail::firstOrCreate([
                    'transaction_id' => $transaction->id,
                    'menu_id' => $detail['menu_id'],
                ], [
                    'qty' => $detail['qty'],
                    'price' => $detail['price'],
                    'subtotal' => $detail['price'] * $detail['qty'],
                ]);
            }

            Payment::firstOrCreate([
                'transaction_id' => $transaction->id,
            ], [
                'method' => $data['payment']['method'],
                'amount_paid' => $data['payment']['amount_paid'],
                'change' => 0,
            ]);
        }
    }
}
