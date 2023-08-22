<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AlterIdnOnPrices extends AbstractMigration
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
        $bookingsTable = $this->table('bookings');
        $pricesTtable = $this->table('prices');
        $pricesTtable->changeColumn('id', 'tinyinteger', [
            'autoIncrement' => true,
            'default' => null,
            'limit' => null,
            'null' => false,
            'signed' => false,
        ]);

        $bookingsTable->dropForeignKey('price_id')->update();

        $pricesTtable->renameColumn('prices', 'price')->update();

        $bookingsTable->changeColumn('price_id', 'tinyinteger', [
            'default' => null,
            'null' => false,
            'signed' => false,
        ])->update();

        $bookingsTable->addForeignKey(
            'price_id',
            'prices',
            'id',
            [
                'update' => 'RESTRICT',
                'delete' => 'RESTRICT',
                'constraint' => 'fk_bookings_prices'
            ]
        )->update();
    }
}
