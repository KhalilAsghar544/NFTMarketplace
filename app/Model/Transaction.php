<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
      'amount',
      'from_address',
      'to_address',
      'transaction_hash',
      'fees',
      'transaction_time',
      'status',
      'token_id',
      'token_address',
      'type',
    ];
}
