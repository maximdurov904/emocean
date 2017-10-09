<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ShopsTable extends Table
{

    /**
     * Initialize method.
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('shops');
        $this->displayField('email');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Products', [
            'foreignKey' => 'shop_id'
        ]);

        $this->hasMany('Orders', [
            'foreignKey' => 'shop_id'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);

    }
	
	 public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('name', __("You must set a name."))
            ->add('name', 'minLength', [
                'rule' => ['minLength', 3],
                'message' => __("The name can not be less than {0} characters.", 3)
            ]);

        return $validator;
    }

}
