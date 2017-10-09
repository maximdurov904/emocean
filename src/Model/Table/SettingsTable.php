<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Network\Session;

class SettingsTable extends Table
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
        $this->table('settings');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');


        $this->addBehavior('Xety/Cake3Sluggable.Sluggable');

       

    }

    /**
     * Create validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
			 ->requirePresence('paypal_email', 'update')
            ->notEmpty('paypal_email')
            ->add('paypal_email', [                
                'paypal_email' => [
                    'rule' => 'email',
                    'message' => "You must specify a valid E-mail address."
                ]
            ])           
            ->notEmpty('paypal_fees_value', "You must specify the price.");		
        return $validator;
    }
	
	
	
	public function checkDescriptionLength($value, $context) {
	
		$userPackages = TableRegistry::get('UserPackages');
		$session = new Session();
		$userId = $session->read('Auth.User.id');
		// Start a new query.
		$queryUserPackage = $userPackages->find()->where(['user_id' => $userId]);
		$userPackageData = $queryUserPackage->first();
		$userPackageCount =  $queryUserPackage->count();
		if($userPackageCount > 0)
		{
			if($userPackageData->package_id == STARTER)
			{
				if(strlen($value) > 300)
				{
					return false;
				}
			}
		}
		return true;
	
    }
	
	
	
}
