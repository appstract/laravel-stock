<?php

namespace Appstract\Stock\Tests;

class QueryScopeTest extends TestCase
{
    /** @test */
    public function it_can_check_in_stock()
    {
        $queryEmpty = StockModel::whereInStock()->count();

        $this->stockModel->setStock(10);

        $queryResult = StockModel::whereInStock()->count();

        $this->assertEquals(0, $queryEmpty);
        $this->assertEquals(1, $queryResult);
    }

    /** @test */
    public function it_can_check_out_of_stock()
    {
        $queryResult = StockModel::whereOutOfStock()->count();

        $this->stockModel->setStock(10);

        $queryEmpty = StockModel::whereOutOfStock()->count();

        $this->assertEquals(1, $queryResult);
        $this->assertEquals(0, $queryEmpty);
    }

    /** @test */
    public function it_can_check_out_of_stock_when_zero()
    {
        $queryEmpty = StockModel::whereInStock()->count();
        $queryResult = StockModel::whereOutOfStock()->count();

        $this->assertEquals(0, $queryEmpty);
        $this->assertEquals(1, $queryResult);
    }
}
