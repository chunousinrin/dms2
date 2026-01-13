<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceType extends Model
{
    protected $table = 'invoice_type';
    protected $primaryKey = 'InvoiceTypeID';
    protected $fillable = ['DocumentType'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'InvoiceTypeID', 'InvoiceTypeID');
    }
}
