<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use App\Test\Factory\CarFactory;
use App\Model\Table\BookingsTable;
use App\Test\Factory\BookingFactory;
use CakephpTestSuiteLight\Fixture\TruncateDirtyTables;

/**
 * App\Model\Table\BookingsTable Test Case
 */
class BookingsTableTest extends TestCase
{

    use TruncateDirtyTables;

    /**
     * Test subject
     *
     * @var \App\Model\Table\BookingsTable
     */
    protected $BookingsTable;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Bookings') ? [] : ['className' => BookingsTable::class];
        $this->BookingsTable = $this->getTableLocator()->get('Bookings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BookingsTable);
        parent::tearDown();
    }

    public function testGetLastUse()
    {
        $car = CarFactory::make()->persist();
        $lastBooking = BookingFactory::make([
            'car_id' => $car->id,
            'start' => '2023-06-19 10:00',
            'end' => '2023-06-19 12:00',
        ])->persist();
        $currentBooking = BookingFactory::make([
            'car_id' => $car->id,
            'start' => '2023-06-20 10:00',
            'end' => '2023-06-20 12:00',
        ])->persist();

        $actual = $this->BookingsTable->getLastUse($currentBooking->id);
        $this->assertEquals($lastBooking->id, $actual->id);
    }

    public function testFindForTimes(): void
    {
        $cars = CarFactory::make(3)->persist();
        BookingFactory::make([
            'car_id' => $cars[0]->id,
            'start' => '2023-06-05 10:00',
            'end' => '2023-06-05 18:00',
        ])->persist();
        BookingFactory::make([
            'car_id' => $cars[2]->id,
            'start' => '2023-06-05 11:00',
            'end' => '2023-06-05 17:00',
        ])->persist();

        $actual = $this->BookingsTable->find('forTimes', [
            'start' => '2023-06-05 10:00',
            'end' => '2023-06-05 18:00',
        ]);
        $this->assertCount(2, $actual);
    }

    public function testGetLastMilageEnd(): void
    {
        $car = CarFactory::make()->persist();
        BookingFactory::make([
            'car_id' => $car->id,
            'start' => '2023-06-20 10:00',
            'end' => '2023-06-20 12:00',
            'milageEnd' => 100,
        ])->persist();
        BookingFactory::make([
            'car_id' => $car->id,
            'start' => '2023-06-20 14:00',
            'end' => '2023-06-20 17:00',
            'milageEnd' => 150,
        ])->persist();

        $actual = $this->BookingsTable->getLastMilageEnd($car->id);
        $this->assertEquals(100, $actual);
    }
}
