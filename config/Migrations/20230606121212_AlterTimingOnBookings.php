<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AlterTimingOnBookings extends AbstractMigration
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
        $table = $this->table('bookings');

        $table->changeColumn('dayStart', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->changeColumn('dayEnd', 'datetime', [
            'default' => null,
            'null' => false,
        ])->update();

        $table->renameColumn('dayStart', 'start');
        $table->renameColumn('dayEnd', 'end');

        $table->removeColumn('timeStart');
        $table->removeColumn('timeEnd');

        $table->update();
    }
}
