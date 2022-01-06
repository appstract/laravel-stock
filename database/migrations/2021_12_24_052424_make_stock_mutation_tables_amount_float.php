<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Make amount column float.
 */
class MakeStockMutationTablesAmountFloat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::raw('ALTER TABLE stock_mutations MODIFY COLUMN amount FLOAT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::raw('ALTER TABLE stock_mutations MODIFY COLUMN amount INTEGER;');
    }
}
