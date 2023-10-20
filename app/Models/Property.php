<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'PostedBy',
        'IdNumber',
        'Phone',
        'PropertyCategory',
        'PropertyType',
        'Neighbourhood',
        'County',
        'ManagedBy',
        'CompanyName',
        'payment',
        'code',
        'Price',
        'AssistingAgent',
        'AssistingId',
        'PropertyDescription',
        'PropertyFeatures',
        'Mpesa',
        'AgentAmount',
        'Status',
        'Hide',
        'Vacant',
        'PostingDate',
        'expiry',
        'Vimage1',
        'Vimage2',
        'Vimage3',
        'Vimage4',
        'Vimage5',
        'Vimage6',
        'Vimage7',
        'Vimage8'
    ];
}
