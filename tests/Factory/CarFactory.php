<?php

declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * CarFactory
 *
 * @method \App\Model\Entity\Car getEntity()
 * @method \App\Model\Entity\Car[] getEntities()
 * @method \App\Model\Entity\Car|\App\Model\Entity\Car[] persist()
 * @method static \App\Model\Entity\Car get(mixed $primaryKey, array $options = [])
 */
class CarFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Cars';
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
            return [
                'id' => $faker->randomNumber(3),
                'type' => $faker->sentence(3),
                'plate' => strtoupper($faker->lexify('??')) . ' ' . strtoupper($faker->lexify('??')) . ' ' . $faker->randomNumber(3),
            ];
        });
    }
}
