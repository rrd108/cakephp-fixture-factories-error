<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Database\Expression\QueryExpression;

/**
 * Cars Model
 *
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\HasMany $Bookings
 *
 * @method \App\Model\Entity\Car newEmptyEntity()
 * @method \App\Model\Entity\Car newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Car[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Car get($primaryKey, $options = [])
 * @method \App\Model\Entity\Car findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Car patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Car[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Car|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Car saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Car[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Car[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Car[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Car[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CarsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('cars');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Bookings', [
            'foreignKey' => 'car_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmptyString('type');

        $validator
            ->scalar('plate')
            ->maxLength('plate', 10)
            ->requirePresence('plate', 'create')
            ->notEmptyString('plate');

        $validator
            ->scalar('fuel')
            ->maxLength('fuel', 10)
            ->allowEmptyString('fuel');

        $validator
            ->boolean('highwayTicket')
            ->allowEmptyString('highwayTicket');

        $validator
            ->boolean('onlyLocal')
            ->notEmptyString('onlyLocal');

        $validator
            ->boolean('needsConfirmation')
            ->notEmptyString('needsConfirmation');

        return $validator;
    }

    public function findAvailable(Query $query, array $options)
    {
        $bookedCarIds = $this->Bookings->find('forTimes', $options)->all()->extract('car_id')->toArray();

        $query->distinct(['Cars.id'])
            ->leftJoinWith('Bookings')
            ->order(['Cars.plate' => 'ASC']);

        if (count($bookedCarIds)) {
            $query->where(function (QueryExpression $exp) use ($bookedCarIds) {
                return $exp->or([
                    ['Bookings.car_id IS' => null],
                    ['Bookings.car_id NOT IN' => $bookedCarIds]
                ]);
            });
        }

        return $query;
    }

    public function findForLocalTravel(Query $query, array $options)
    {
        return $query->find('available', $options)->where(['Cars.onlyLocal' => true]);
    }
}
