<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Network\Session;

class ProductsTable extends Table
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
        $this->table('products');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Xety/Cake3Upload.Upload', [
            'fields' => [
                'hero' => [
                    'path' => 'upload/product/hero/:id/:md5',
                    'overwrite' => true,
                    'prefix' => '/',
                    'defaultFile' => 'hero.jpg'
                ]
            ]
        ]);

        $this->addBehavior('Xety/Cake3Sluggable.Sluggable');

        $this->hasMany('ProductImages', [
            'foreignKey' => 'project_id',
            'dependent' => true
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'merchant_id'
        ]);

        $this->belongsTo('Shops', [
            'foreignKey' => 'shop_id'
        ]);

    }

    /**
     * Create validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationCreate(Validator $validator)
    {
        $validator
            ->notEmpty('name', "You must specify the name of the product.")
            ->notEmpty('content', "You must specify the description.")
			 ->add("content", [
                    "custom" => [
                        "rule" => [$this, "checkDescriptionLength"], //add the new rule 'checkDescriptionLength' to content field
                        "message" => "You cannot enter the description more then 300 characters."
                    ]
                        ]
                )
			;

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
