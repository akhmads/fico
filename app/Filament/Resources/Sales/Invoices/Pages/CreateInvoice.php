<?php

namespace App\Filament\Resources\Sales\Invoices\Pages;

use App\Filament\Resources\Sales\Invoices\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;
}
