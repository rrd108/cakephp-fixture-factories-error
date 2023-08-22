<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Booking Entity
 *
 * @property int $id
 * @property int $car_id
 * @property string $user_id
 * @property int $price_id
 * @property \Cake\I18n\FrozenTime $start
 * @property \Cake\I18n\FrozenTime $end
 * @property string|null $destination
 * @property int|null $freeSeats
 * @property int|null $milageStart
 * @property int|null $milageEnd
 * @property string|null $paying
 * @property int|null $petrol
 * @property string|null $comment
 * @property \Cake\I18n\FrozenTime $created
 * @property string|resource|null $image_data
 *
 * @property \App\Model\Entity\Car $car
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Price $price
 */
class Booking extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'car_id' => true,
        'user_id' => true,
        'price_id' => true,
        'start' => true,
        'end' => true,
        'destination' => true,
        'freeSeats' => true,
        'milageStart' => true,
        'milageEnd' => true,
        'paying' => true,
        'petrol' => true,
        'comment' => true,
        'created' => true,
        'image_data' => true,
        'confirmed' => true,
        'car' => true,
        'user' => true,
        'price' => true,
    ];
}
