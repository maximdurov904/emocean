<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Network\Session;

class UserProductsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('user_products');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Xety/Cake3Sluggable.Sluggable');
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id'
		]);
		$this->belongsTo('Products', [
			'foreignKey' => 'product_id'
		]);
		$this->belongsTo('Shops', [
			'foreignKey' => 'shop_id'
		]);
    }
	

	
	 public function validationSettings(Validator $validator)
    {
        $validator
            ->notEmpty('price', "You must specify the price of the product.");

        return $validator;
    }
	
	
	
	
	
	
	
}