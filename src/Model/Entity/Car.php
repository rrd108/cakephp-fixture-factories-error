<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Car Entity
 *
 * @property int $id
 * @property string|null $type
 * @property string $plate
 * @property string|null $fuel
 * @property bool|null $highwayTicket
 * @property bool $onlyLocal
 * @property bool $needsConfirmation
 *
 * @property \App\Model\Entity\Booking[] $bookings
 */
class Car extends Entity
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
        'type' => true,
        'plate' => true,
        'fuel' => true,
        'highwayTicket' => true,
        'onlyLocal' => true,
        'needsConfirmation' => true,
        'bookings' => true,
    ];
}
