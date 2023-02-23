<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = ['account_name', 'account_number', 'bank_name', 'status', 'author_id'];
}
