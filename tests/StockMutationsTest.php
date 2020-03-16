<?php

namespace Appstract\Stock\Tests;

class StockMutationsTest extends TestCase
{
    /** @test */
    public function it_can_have_no_mutations()
    {
        $this->assertEmpty($this->stockModel->stockMutations->toArray());
    }

    /** @test */
    public function it_can_have_some_mutations()
    {
        $this->stockModel->increaseStock(10);
        $this->stockModel->increaseStock(1);
        $this->stockModel->decreaseStock(1);

        $mutations = $this->stockModel->stockMutations->pluck(['amount'])->toArray();

        $this->assertEquals(['10', '1', '-1'], $mutations);
    }

    /** @test */
    public function it_can_have_mutations_with_description()
    {
        $this->stockModel->increaseStock(10, [
            'description' => 'Test'
        ]);

        $mutations = $this->stockModel->stockMutations->pluck(['description'])->toArray();

        $this->assertEquals(['Test'], $mutations);
    }

    /** @test */
    public function it_can_have_mutations_with_reference()
    {
        $this->stockModel->increaseStock(10, [
            'reference' => $this->referenceModel,
        ]);

        $stockMutation = $this->stockModel->stockMutations->first();
        $referenceMutation = $this->referenceModel->stockMutations->first();

        $this->assertEquals(1, $stockMutation->reference_id);
        $this->assertEquals(ReferenceModel::class, $stockMutation->reference_type);
        $this->assertEquals(1, $referenceMutation->stockable_id);
        $this->assertEquals(StockModel::class, $referenceMutation->stockable_type);
    }
}
