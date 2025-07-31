<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'bank_name',
        'branch_name',
        'account_name',
        'account_number',
        'bank_balance',
        'type',
        'remarks',
        'opening_date',
    ];

    public function added_by()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function bank()
    {
        return $this->hasMany(BankTransaction::class, 'bank_id', 'id');
    }

    public function courier_payment()
    {
        return $this->hasMany(CourierPayment::class, 'bank_id', 'id');
    }
}
