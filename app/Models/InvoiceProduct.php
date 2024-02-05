<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    use HasFactory;
    // protected $guarded = [];
    protected $fillable = [
        'invoice_id',
        'product_id',
        'qty',
        'user_id',
        'sale_price'
    ];
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
