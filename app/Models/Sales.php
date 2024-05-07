<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $dates = ['SalesDate'];

    public function product()
    {
        $this->belongsTo(Product::class, 'ProductId', 'ProductId');
    }

    public function salesPerson()
    {
        $this->belongsTo(SalesPersons::class, 'SalesPersonId', 'SalesPersonId');
    }
}
