<?php

namespace Appstract\Stock\Tests;

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
    public function it_can_change_positive_amount_to_positive_become_positive()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(5);
        $this->orderRowUpdated(8);

        $this->assertEquals(2, $this->stockModel->stock);
    }

    public function it_can_change_positive_amount_to_positive_become_negative()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(5);
        $this->orderRowUpdated(13);

        $this->assertEquals(-8, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_negative_amount_to_negative_become_positive()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(-5);
        $this->orderRowUpdated(-6);

        $this->assertEquals(16, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_negative_amount_to_negative_become_negative()
    {
        $this->stockModel->setStock(-30);

        $this->orderRowCreated(-10);
        $this->orderRowUpdated(-6);

        $this->assertEquals(-24, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_positive_amount_to_negative_become_positive()
    {
        $this->stockModel->setStock(20);

        $this->orderRowCreated(18);
        $this->orderRowUpdated(-7);

        $this->assertEquals(27, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_positive_amount_to_negative_become_negative()
    {
        $this->stockModel->setStock(20);

        $this->orderRowCreated(35);
        $this->orderRowUpdated(-5);

        $this->assertEquals(25, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_negative_amount_to_positive_become_positive()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(-5);
        $this->orderRowUpdated(6);

        $this->assertEquals(4, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_negative_amount_to_positive_become_negative()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(-5);
        $this->orderRowUpdated(20);

        $this->assertEquals(-10, $this->stockModel->stock);
    }

    /** @test */
    public function it_can_change_mixed_amount()
    {
        $this->stockModel->setStock(10);

        $this->orderRowCreated(1);
        $this->orderRowUpdated(-2);
        $this->orderRowUpdated(4);
        $this->orderRowUpdated(-6);
        $this->orderRowUpdated(8);
        $this->orderRowUpdated(-3);

        $this->assertEquals(13, $this->stockModel->stock);
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
        $deltaStock = $this->deltaStock($this->orderRow->amount, $amount);

        $this->orderRow->update(['amount' => $amount]);

        return $this->orderRow->stockModel->mutateStock($deltaStock);
    }

    protected function deltaStock($oldAmount, $newAmount)
    {
        if ($this->positive($oldAmount) && $this->negative($newAmount)) {
            return abs($oldAmount) + abs($newAmount);
        }

        if ($this->negative($oldAmount) && $this->positive($newAmount)) {
            return (abs($oldAmount) + abs($newAmount)) * -1;
        }

        return $oldAmount - $newAmount;
    }

    protected function negative($integer)
    {
        return intval($integer) < 0;
    }

    protected function positive($integer)
    {
        return ! $this->negative($integer);
    }
}
