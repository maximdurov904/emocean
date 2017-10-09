<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PackageUpgradesTable extends Table
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
        $this->table('package_upgrades');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Xety/Cake3Sluggable.Sluggable');
/* 
        $this->belongsTo('Shops', [
            'foreignKey' => 'shop_id'
        ]); */

    }
	
	public function validationBillingaccount(Validator $validator)
    {
		$validator
            ->notEmpty('account_holder_name','Account holder name is required')        
            ->notEmpty('account_number','Account number is required')
			->add('account_number', [
				'length' => [
					'rule' => ['maxLength', 8],
					 'message' =>'Account number Length 8'
				],
			])			
            ->notEmpty('email','Email is required')
            ->notEmpty('address1','Address is required')           
			->notEmpty('bank_code','Bank code is required')			
					
			->notEmpty('card_issuer','Billing address is required');
        return $validator;
    }
	
	
}
