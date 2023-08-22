<?php

declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * PriceFactory
 *
 * @method \App\Model\Entity\Price getEntity()
 * @method \App\Model\Entity\Price[] getEntities()
 * @method \App\Model\Entity\Price|\App\Model\Entity\Price[] persist()
 * @method static \App\Model\Entity\Price get(mixed $primaryKey, array $options = [])
 */
class PriceFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Prices';
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
                'id' => $faker->randomNumber(1),
                'name' => $faker->sentence(1),
                'price' => $faker->randomFloat(2, 0, 100),
            ];
        });
    }
}
