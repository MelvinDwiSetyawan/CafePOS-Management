<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableModel extends Model
{
    use HasFactory;

    protected $table = 'tables'; // penting: nama tabel beda dari nama class

    protected $fillable = ['table_number', 'capacity', 'status'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'table_id');
    }
}