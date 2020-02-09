<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \App\Model\Table\ProductRatingsTable&\Cake\ORM\Association\HasMany $ProductRatings
 *
 * @method \App\Model\Entity\Product get($primaryKey, $options = [])
 * @method \App\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ProductRatings', [
            'foreignKey' => 'product_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->requirePresence('name')
            ->scalar('name')
            ->maxLength('name', 255)
            ->notEmptyString('name', 'Please fill this field')
            ->add('name',[
                'length' => [
                    'rule' => ['minLength', 2],
                    'message' => 'Name must be at least 2 characters long'
                ]
            ]);

        $validator
            ->numeric('price')
            ->notEmptyString('price');

        $validator
            ->numeric('width')
            ->allowEmptyString('width');
        $validator
            ->numeric('height')
            ->allowEmptyString('height');

        $validator
            ->scalar('description')
            ->notEmptyString('description')
            ->add('description',[
                'length' => [
                    'rule' => ['minLength', 10],
                    'message' => 'Description must be at least 10 characters long'
                ]
            ]);

        $validator
            ->scalar('photo')
            ->maxLength('photo', 255)
            ->allowEmptyFile('photo', null, 'edit');

        return $validator;
    }


}
