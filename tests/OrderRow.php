<?php

namespace Appstract\Stock\Tests;

use Appstract\Stock\HasStock;
use Illuminate\Database\Eloquent\Model;

class OrderRow extends Model
{
    use HasStock;

    protected $table = 'order_rows';

    protected $guarded = [];

    public $timestamps = false;

    public function stockModel()
    {
        return $this->belongsTo(StockModel::class);
    }
}
