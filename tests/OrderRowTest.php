<?php

namespace Appstract\Stock\Tests;

use Illuminate\Support\Carbon;

class OrderRowTest extends TestCase
{
    /** @test */
    public function it_can_create_postitive_order_row()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(5);

        $this->assertEquals(5, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_create_negative_order_row()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(-5);

        $this->assertEquals(15, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_delete_positive_order_row()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(5);

        $this->assertEquals(5, $this->stockModel->stock);

        $this->orderRowDeleted();

        $this->assertEquals(10, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_delete_negative_order_row()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(-5);

        $this->assertEquals(15, $this->stockModel->stock);

        $this->orderRowDeleted();

        $this->assertEquals(10, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_positive_amount_to_positive()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(5);
        $this->orderRowUpdated(8);

        $this->assertEquals(2, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_negative_amount_to_negative()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(-5);
        $this->orderRowUpdated(-6);

        $this->assertEquals(16, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_positive_amount_to_negative()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(5);
        $this->orderRowUpdated(-2);

        $this->assertEquals(7, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_negative_amount_to_positive()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(-5);
        $this->orderRowUpdated(6);

        $this->assertEquals(9, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_mixed_amount()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(1);
        $this->orderRowCreated(-2);
        $this->orderRowCreated(4);
        $this->orderRowCreated(-6);
        $this->orderRowCreated(8);
        $this->orderRowCreated(-3);

        $this->assertEquals(8, $this->stockModel->stock);
    }

    protected function orderRowCreated($amount)
    {
        $this->orderRow->update(['amount' => $amount]);

        return $this->orderRow->stockModel->mutateStock(($amount * -1));
    }

    protected function orderRowDeleted($amount = null)
    {
        return $this->orderRow->stockModel->mutateStock($this->orderRow->amount);
    }

    protected function orderRowUpdated($amount)
    {
        $deltaStock = $this->orderRow->amount - $amount;

        $this->orderRow->update(['amount' => $amount]);

        return $this->orderRow->stockModel->mutateStock($deltaStock);
    }
}
