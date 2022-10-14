<?php

namespace App\Models;

use App\Events\PaymentUpdated;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Payment extends Authenticatable
{
    /**
     * dispatchesEvents
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'updated' => PaymentUpdated::class
    ];
}
