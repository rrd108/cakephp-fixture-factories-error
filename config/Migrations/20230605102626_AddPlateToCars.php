<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AddPlateToCars extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $carsTable = $this->table('cars');
        $bookingsTable = $this->table('bookings');

        $carsTable->addColumn('plate', 'string', [
            'default' => null,
            'limit' => 10,
            'null' => false,
        ]);

        $bookingsTable->dropForeignKey('car_id')->update();

        $carsTable->changeColumn('id', 'integer', [
            'autoIncrement' => true,
            'default' => null,
            'null' => false,
        ])->update();

        $bookingsTable->changeColumn('car_id', 'integer', [
            'default' => null,
            'null' => false,
        ])->update();

        $bookingsTable->addForeignKey(
            'car_id',
            'cars',
            'id',
            [
                'update' => 'RESTRICT',
                'delete' => 'RESTRICT',
                'constraint' => 'fk_bookings_cars'
            ]
        )->update();
    }
}
