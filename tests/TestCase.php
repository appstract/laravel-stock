<?php

namespace Appstract\Stock\Tests;

use Appstract\Stock\StockServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as BaseTest;

abstract class TestCase extends BaseTest
{
    protected $stockModel;

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');

        $app['config']->set(
            'database.connections.testbench', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]
        );
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->stockModel = StockModel::first();
        $this->referenceModel = ReferenceModel::first();
        $this->orderRow = OrderRow::first();
    }

    /**
     * Setup database.
     */
    protected function setUpDatabase($app)
    {
        $builder = $app['db']->connection()->getSchemaBuilder();

        // Create tables
        $builder->create('stock_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        $builder->create('reference_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        $builder->create('order_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('stock_model_id');
            $table->string('name');
            $table->string('amount');
        });

        // Create models
        StockModel::create(['name' => 'StockModel']);
        ReferenceModel::create(['name' => 'ReferenceModel']);
        OrderRow::create(['stock_model_id' => 1, 'name' => 'OrderRow', 'amount' => 0]);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            StockServiceProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //
        ];
    }
}
