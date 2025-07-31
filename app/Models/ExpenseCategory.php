<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_name',
        'status'
    ];

    public function added_by()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function expense()
    {
        return $this->hasMany(Expense::class, 'category_id', 'id');
    }
}
