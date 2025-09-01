<?php

namespace App\Policies\Sales;

use App\Models\User;
use App\Models\Sales\Invoice;

class InvoicePolicy
{
    public function __construct()
    {
        //
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $invoice->status->value == 'open';
    }
}
