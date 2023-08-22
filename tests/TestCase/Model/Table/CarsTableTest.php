<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use App\Model\Table\CarsTable;
use App\Test\Factory\BookingFactory;
use App\Test\Factory\CarFactory;
use CakephpTestSuiteLight\Fixture\TruncateDirtyTables;

/**
 * App\Model\Table\CarsTable Test Case
 */
class CarsTableTest extends TestCase
{
    use TruncateDirtyTables;

    /**
     * Test subject
     *
     * @var \App\Model\Table\CarsTable
     */
    protected $Cars;


    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Cars') ? [] : ['className' => CarsTable::class];
        $this->Cars = $this->getTableLocator()->get('Cars', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Cars);
        parent::tearDown();
    }

    public function testFindAvailableNoOverlappingBooking(): void
    {
        // TODO move tests for booking tests
        $cars = CarFactory::make(3)->persist();
        BookingFactory::make([
            'car_id' => $cars[0]->id,
            'start' => '2023-06-05 10:00',
            'end' => '2023-06-05 18:00',
        ])->persist();

        // 1. exact same starting and ending time
        $actual = $this->Cars->find('available', [
            'start' => '2023-06-05 10:00',
            'end' => '2023-06-05 18:00',
        ]);
        $this->assertCount(2, $actual);
    }
}
