<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Database\Expression\QueryExpression;

/**
 * Bookings Model
 *
 * @property \App\Model\Table\CarsTable&\Cake\ORM\Association\BelongsTo $Cars
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PricesTable&\Cake\ORM\Association\BelongsTo $Prices
 *
 * @method \App\Model\Entity\Booking newEmptyEntity()
 * @method \App\Model\Entity\Booking newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Booking[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Booking get($primaryKey, $options = [])
 * @method \App\Model\Entity\Booking findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Booking patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Booking[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Booking|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Booking saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Booking[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Booking[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Booking[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Booking[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BookingsTable extends Table
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

        $this->setTable('bookings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cars', [
            'foreignKey' => 'car_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Prices', [
            'foreignKey' => 'price_id',
            'joinType' => 'INNER',
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
            ->integer('car_id')
            ->notEmptyString('car_id');

        $validator
            ->uuid('user_id')
            ->notEmptyString('user_id');

        $validator
            ->notEmptyString('price_id');

        $validator
            ->dateTime('start')
            ->requirePresence('start', 'create')
            ->notEmptyDateTime('start');

        $validator
            ->dateTime('end')
            ->requirePresence('end', 'create')
            ->notEmptyDateTime('end');

        $validator
            ->scalar('destination')
            ->maxLength('destination', 45)
            ->allowEmptyString('destination');

        $validator
            ->allowEmptyString('freeSeats');

        $validator
            ->integer('milageStart')
            ->allowEmptyString('milageStart');

        $validator
            ->integer('milageEnd')
            ->allowEmptyString('milageEnd');

        $validator
            ->scalar('paying')
            ->maxLength('paying', 45)
            ->allowEmptyString('paying');

        $validator
            ->integer('petrol')
            ->allowEmptyString('petrol');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 255)
            ->allowEmptyString('comment');

        $validator
            ->allowEmptyFile('image_data');

        $validator
            ->boolean('confimred');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('car_id', 'Cars'), ['errorField' => 'car_id']);
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn('price_id', 'Prices'), ['errorField' => 'price_id']);

        return $rules;
    }

    public function findNotClosed(Query $query)
    {
        return $query->where([
            'Bookings.end <=' => date('Y-m-d H:i:s'),
            'Bookings.milageEnd IS' => null,
        ]);
    }

    public function findForTimes(Query $query, array $options)
    {
        return $query->where(function (QueryExpression $exp) use ($options) {
            return $exp->or(function (QueryExpression $exp) use ($options) {
                return [
                    $exp->between('Bookings.start', $options['start'], $options['end']),
                    $exp->between('Bookings.end', $options['start'], $options['end']),
                    $exp->add('(Bookings.start <="' . $options['start'] . '" AND Bookings.end >="' . $options['end'] . '")')
                ];
            });
        });
    }

    public function getLastUse(int $bookingId)
    {
        $currentBooking = $this->get($bookingId);
        return $this->find()
            ->where([
                'Bookings.car_id' => $currentBooking->car_id,
                'Bookings.start <' => $currentBooking->start,
            ])
            ->order(['Bookings.start' => 'DESC'])
            //->contain(['Users'])
            ->all()
            ->first();
    }

    public function getLastMilageEnd(int $carId)
    {
        return $this->find()
            ->where(['car_id' => $carId])
            ->order(['Bookings.start' => 'DESC'])
            //->contain(['Users'])
            ->all()
            ->skip(1)
            ->first()->milageEnd;
    }
}
