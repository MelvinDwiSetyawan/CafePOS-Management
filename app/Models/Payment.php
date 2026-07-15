<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'method', 'amount_paid', 'change'];

    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'change' => 'decimal:2',
        ];
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}