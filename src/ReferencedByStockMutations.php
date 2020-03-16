<?php

namespace Appstract\Stock;

trait ReferencedByStockMutations
{
    /**
     * Relation with StockMutation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function stockMutations()
    {
        return $this->morphMany(StockMutation::class, 'reference');
    }
}
