<?php

namespace Appstract\Stock\Tests;

use Illuminate\Support\Carbon;

class HasStockTest extends TestCase
{
    /** @test */
    public function it_can_have_no_stock()
    {
        $this->assertEquals(0, $this->stockModel->stock);
        $this->assertTrue($this->stockModel->outOfStock());
    }

    /** @test */
    public function it_can_set_initial_stock()
    {
        $this->stockModel->setStock(10);

        $this->assertEquals(10, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_set_initial_stock_float()
    {
        $this->stockModel->setStock(8.94);

        $this->assertEquals(8.94, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_set_stock_after_mutations()
    {
        $this->stockModel->increaseStock(10);
        $this->stockModel->increaseStock(5);
        $this->stockModel->decreaseStock(8);

        $this->assertEquals(7, $this->stockModel->stock);

        $this->stockModel->setStock(2);

        $this->assertEquals(2, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_set_stock_after_mutations_float()
    {
        $this->stockModel->increaseStock(10.34);
        $this->stockModel->increaseStock(5.23);
        $this->stockModel->decreaseStock(8.9);

        $this->assertEquals(6.67, $this->stockModel->stock);

        $this->stockModel->setStock(2.0);

        $this->assertEquals(2.0, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_increase_stock()
    {
        $this->assertEquals(0, $this->stockModel->stock);

        $this->stockModel->increaseStock(10);

        $this->assertEquals(10, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_increase_stock_float()
    {
        $this->assertSame(0.0, $this->stockModel->stock);

        $this->stockModel->increaseStock(10.40);

        $this->assertSame(10.40, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_decrease_stock()
    {
        $this->assertEquals(0, $this->stockModel->stock);

        $this->stockModel->decreaseStock(10);

        $this->assertEquals(-10, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_mutate_stock()
    {
        $this->stockModel->mutateStock(-5);
        $this->stockModel->mutateStock(10);

        $this->assertEquals(5, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_clear_stock()
    {
        $this->stockModel->setStock(10);
        $this->stockModel->clearStock();

        $this->assertEquals(0, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_clear_stock_with_new_amount()
    {
        $this->stockModel->setStock(10);
        $this->stockModel->clearStock(5);

        $this->assertEquals(5, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_check_in_stock()
    {
        $this->assertTrue($this->stockModel->outOfStock());

        $this->stockModel->setStock(10);

        $this->assertTrue($this->stockModel->inStock());
        $this->assertTrue($this->stockModel->inStock(10));
        $this->assertTrue($this->stockModel->inStock(8));
        $this->assertFalse($this->stockModel->inStock(11));
        $this->assertTrue($this->stockModel->inStock(-1));
        $this->assertFalse($this->stockModel->outOfStock());

        $this->stockModel->setStock(-5);

        $this->assertFalse($this->stockModel->inStock());
        $this->assertFalse($this->stockModel->inStock(10));
        $this->assertFalse($this->stockModel->inStock(-5));
    }

    /** @test */
    public function it_can_have_stock_on_date()
    {
        Carbon::setTestNow(Carbon::now()->subDays(8));
        $this->stockModel->increaseStock(4);

        Carbon::setTestNow(Carbon::now()->subDays(6));
        $this->stockModel->increaseStock(4);

        Carbon::setTestNow(Carbon::now()->subDays(4));
        $this->stockModel->increaseStock(2);

        Carbon::setTestNow();

        $this->assertEquals(10, $this->stockModel->stock);
        $this->assertEquals(0, $this->stockModel->stock(Carbon::now()->subDays(20)));
        $this->assertEquals(2, $this->stockModel->stock(Carbon::now()->subDays(18)));
        $this->assertEquals(6, $this->stockModel->stock(Carbon::now()->subDays(14)));
        $this->assertEquals(2, $this->stockModel->stock(Carbon::now()->subDays(14)->subMinutes(1)));
        $this->assertEquals(6, $this->stockModel->stock(Carbon::now()->subDays(14)->addMinutes(1)));
    }
}
