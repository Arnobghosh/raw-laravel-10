<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'bank_id',
        'expense_amount',
        'remarks',
        'type',
        'cashbook_id',
        'expense_date',
        'on_expense_date',
    ];

    public function added_by()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id', 'id');
    }

    public function bankTransactions()
    {
        return $this->morphOne(BankTransaction::class, 'transactionable');
    }
    public function transactionables()
    {
        return $this->morphMany(BankTransaction::class, 'transactionable');
    }

    public static function boot()
    {
        parent::boot();

        // Automatically delete the related BankTransaction when an Expense is deleted
        static::deleted(function ($expense) {
            $expense->bankTransactions()->delete();
        });
    }
}
