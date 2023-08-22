<?php

declare(strict_types=1);

namespace App\Test\Factory;

use Faker\Generator;
use Cake\I18n\FrozenTime;
use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;

/**
 * BookingFactory
 *
 * @method \App\Model\Entity\Booking getEntity()
 * @method \App\Model\Entity\Booking[] getEntities()
 * @method \App\Model\Entity\Booking|\App\Model\Entity\Booking[] persist()
 * @method static \App\Model\Entity\Booking get(mixed $primaryKey, array $options = [])
 */
class BookingFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Bookings';
    }

    /**
     * Defines the factory's default values. This is useful for
     * not nullable fields. You may use methods of the present factory here too.
     *
     * @return void
     */
    protected function setDefaultTemplate(): void
    {
        $this->setDefaultData(function (Generator $faker) {
            $now = FrozenTime::now();
            $tomorrow = $now->modify('+1 day');
            $tomorrowNoon = $tomorrow->setTime(12, 0, 0);
            $tomorrowEvening = $tomorrow->setTime(18, 0, 0);

            return [
                'id' => $faker->randomNumber(3),
                'start' => $tomorrowNoon,
                'end' => $tomorrowEvening,
                'destination' => $faker->city(),
            ];
        })
            //->with('Cars')    // should be set manually
            ->with('Users')
            ->with('Prices');
    }
}
