<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'branch_id',
        'bank_id',
        'purhcase_id',
        'payment_id',
        'sale_id',
        'collection_id',
        'expense_id',
        'tranaction_note',
        'purpose',
        'debit',
        'credit',
        'remarks',
        'type',
        'transaction_date',
        'on_transaction_date',
        'transactionable_id',
        'transactionable_type',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function added_by()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function transactionable()
    {
        return $this->morphTo();
    }
}
