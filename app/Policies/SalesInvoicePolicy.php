<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sales\Invoice;

class SalesInvoicePolicy
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
