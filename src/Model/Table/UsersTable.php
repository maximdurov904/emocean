<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
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
        $this->table('users');
        $this->displayField('email');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Xety/Cake3Upload.Upload', [
            'fields' => [
                'avatar' => [
                    'path' => 'upload/avatar/:id/:md5',
                    'overwrite' => true,
                    'prefix' => '../',
                    'defaultFile' => 'avatar.png'
                ]
            ]
        ]);
        $this->addBehavior('Xety/Cake3Sluggable.Sluggable', [
            'field' => 'email'
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
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
            ->notEmpty('password', "You must specify your password.")
            ->notEmpty('password_confirm', "You must specify your password (confirmation).")
            ->add('password_confirm', [
                'lengthBetween' => [
                    'rule' => ['lengthBetween', 8, 20],
                    'message' => "Your password (confirmation) must be between 8 and 20 characters."
                ],
                'equalToPassword' => [
                    'rule' => function ($value, $context) {
                        return $value === $context['data']['password'];
                    },
                    'message' => "Your password confirm must match with your password."
                ]
            ])
			->notEmpty('post_code')
			->add('post_code', 'validFormat', [
              'rule' => 'numeric',
              'message' =>'Post Code Numbers Only',
            ])
			->add('post_code', [
			'length' => [
				'rule' => ['lengthBetween', 4, 4],
				 'message' =>'Post Code Length 4'
			],
			])
			->notEmpty('phone')
            ->add('phone','validFormat',[
                'rule'=>'numeric',
                'message'=>'Phone Number Numbers Only'
            ])
			->notEmpty('date_of_birth')
			->notEmpty('last_name')
			->notEmpty('company_name')
			->notEmpty('abn_acn')
			->add('abn_acn', 'validFormat', [
              'rule' => 'numeric',
              'message' =>'ABN/ACN Numbers Only',
            ])
			->add('abn_acn', [
			'length' => [
				'rule' => ['lengthBetween', 11, 11],
				 'message' =>'Enter 11 Digits ABN/ACN Numbers'
			],
			])
			->notEmpty('billing_address')
			->notEmpty('billing_suburb')
			->notEmpty('billing_state')
			->notEmpty('billing_post_code')
			->add('billing_post_code', 'validFormat', [
              'rule' => 'numeric',
              'message' =>'Post Code Numbers Only',
            ])
			->add('billing_post_code', [
			'length' => [
				'rule' => ['lengthBetween', 4, 4],
				 'message' =>'Post Code Length 4'
			],
			])
			->notEmpty('first_name')			
            ->add('first_name', 'maxLength', [
                'rule' => ['maxLength', 100],
                'message' => "Your First Name can not contain more than 100 characters."
            ])
            ->notEmpty('email')
            ->add('email', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => "This E-mail is already used."
                ],
                'email' => [
                    'rule' => 'email',
                    'message' => "You must specify a valid E-mail address."
                ]
            ])
			->notEmpty('paypal_business_email')
            ->add('paypal_business_email', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => "This Paypal Business E-mail is already used."
                ],
                'paypal_business_email' => [
                    'rule' => 'email',
                    'message' => "You must specify a valid Paypal Business E-mail address."
                ]
            ]);

        return $validator;
    }

    /**
     * Account validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationAccount(Validator $validator)
    {
        return $validator
            ->provider('upload', 'App\Model\Validation\UploadValidator')
            ->provider('purifier', 'App\Model\Validation\PurifierValidator')
            ->allowEmpty('first_name')
            ->add('first_name', 'maxLength', [
                'rule' => ['maxLength', 100],
                'message' => "Your First Name can not contain more than 100 characters."
            ])
            ->allowEmpty('last_name')
            ->add('last_name', 'maxLength', [
                'rule' => ['maxLength', 100],
                'message' => "Your Last Name can not contain more than 100 characters."
            ])
            ->allowEmpty('avatar_file')
            ->add('avatar_file', [
                'mimeType' => [
                    'rule' => ['mimeType', ['image/jpeg', 'image/png']],
                    'message' => __("The mimeType is not allowed."),
                    'on' => function ($context) {
                            return !empty($context['data']['avatar_file']['name']);
                    }
                ],
                'fileExtension' => [
                    'rule' => ['extension', ['jpg', 'jpeg', 'png']],
                    'message' => __("The extensions allowed are {0}.", '.jpg, .jpeg and .png'),
                    'on' => function ($context) {
                            return !empty($context['data']['avatar_file']['name']);
                    }
                ],
                'fileSize' => [
                    'rule' => ['fileSize', '<', '500KB'],
                    'message' => __("The file exceeded the max allowed size of {0}", '500KB'),
                    'on' => function ($context) {
                            return !empty($context['data']['avatar_file']['name']);
                    }
                ],
                'maxDimension' => [
                    'rule' => ['maxDimension', 230, 230],
                    'provider' => 'upload',
                    'message' => __(
                        "The file exceeded the max allowed dimension. Max height : {0} Max width : {1}",
                        230,
                        230
                    ),
                ]
            ])
            ->allowEmpty('facebook')
            ->add('facebook', 'maxLength', [
                'rule' => ['maxLength', 200],
                'message' => "Your Facebook can not contain more than 200 characters."
            ])
            ->allowEmpty('twitter')
            ->add('twitter', 'maxLength', [
                'rule' => ['maxLength', 200],
                'message' => "Your Twitter can not contain more than 200 characters."
            ])
            ->allowEmpty('biography')
            ->add('biography', [
                'purifierMaxLength' => [
                    'rule' => ['purifierMaxLength', 3000],
                    'provider' => 'purifier',
                    'message' => __('Your biography can not contain more than {0} characters.', 3000)
                ]
            ])
            ->allowEmpty('signature')
            ->add('signature', [
                'purifierMaxLength' => [
                    'rule' => ['purifierMaxLength', 300],
                    'provider' => 'purifier',
                    'message' => __('Your biography can not contain more than {0} characters.', 300)
                ]
            ])
			->notEmpty('paypal_business_email')
            ->add('paypal_business_email', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => "This Paypal Business E-mail is already used."
                ],
                'paypal_business_email' => [
                    'rule' => 'email',
                    'message' => "You must specify a valid Paypal Business E-mail address."
                ]
            ]);
    }

    /**
     * Settings validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationSettings(Validator $validator)
    {
        return $validator
            ->notEmpty('email', "Your E-mail can not be empty.")
            ->add('email', [
                'email' => [
                    'rule' => 'email',
                    'message' => "You must specify a valid E-mail address."
                ],
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => "This E-mail is already used, please choose another E-mail."
                ],
            ])
            ->notEmpty('password', "You must specify your new password.")
            ->notEmpty('password_confirm', "You must specify your password (confirmation).")
            ->add('password_confirm', [
                'lengthBetween' => [
                    'rule' => ['lengthBetween', 8, 20],
                    'message' => "Your password (confirmation) must be between 8 and 20 characters."
                ],
                'equalToPassword' => [
                    'rule' => function ($value, $context) {
                            return $value === $context['data']['password'];
                    },
                    'message' => "Your password confirm must match with your new password"
                ]
            ]);
    }

    /**
     * ResetPassword validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationResetpassword(Validator $validator)
    {
        return $validator
            ->notEmpty('password', "You must specify your new password.")
            ->notEmpty('password_confirm', "You must specify your password (confirmation).")
            ->add('password_confirm', [
                'lengthBetween' => [
                    'rule' => ['lengthBetween', 8, 20],
                    'message' => "Your password (confirmation) must be between 8 and 20 characters."
                ],
                'equalToPassword' => [
                    'rule' => function ($value, $context) {
                            return $value === $context['data']['password'];
                    },
                    'message' => "Your password confirm must match with your new password"
                ]
            ]);
    }

    /**
     * Update validation rules. (Administration)
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationUpdate(Validator $validator)
    {
        $validator
            ->requirePresence('email', 'update')
            ->notEmpty('email')
            ->add('email', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => "This E-mail is already used."
                ],
                'email' => [
                    'rule' => 'email',
                    'message' => "You must specify a valid E-mail address."
                ]
            ]);

        return $validator;
    }
	
		public function validationBillingaccount(Validator $validator)
    {
		$validator
            ->notEmpty('delivery_address','Delivery address is required')
            ->notEmpty('delivery_suburb','Delivery suburb is required')
            ->notEmpty('delivery_state','Delivery state is required')
           
			->notEmpty('delivery_post_code','Delivery post code is required')
			->add('delivery_post_code', 'validFormat', [
              'rule' => 'numeric',
              'message' =>'Positive Numbers Only',
            ])
			->add('delivery_post_code', [
				'length' => [
					'rule' => ['maxLength', 5],
					 'message' =>'Post Code Length 5'
				],
			])
			
			->notEmpty('billing_address','Billing address is required')
			->notEmpty('billing_suburb','Billing suburb is required')
			->notEmpty('billing_state','Billing state is required')
			
			
			
			->notEmpty('billing_post_code')
			->add('billing_post_code', 'validFormat', [
              'rule' => 'numeric',
              'message' =>'Post Code Numbers Only',
            ])
			->add('billing_post_code', [
			'length' => [
				'rule' => ['lengthBetween', 4, 4],
				 'message' =>'Post Code Length 4'
			],
			]);

        return $validator;
	
	
	

    }

    /**
     * Custom finder for select only the required fields.
     *
     * @param \Cake\ORM\Query $query The query finder.
     *
     * @return \Cake\ORM\Query
     */
    public function findShort(Query $query)
    {
        return $query->select([
            'id',
            'first_name',
            'last_name',
            'username',
            'slug'
        ]);
    }

    /**
     * Custom finder for select the required fields and avatar.
     *
     * @param \Cake\ORM\Query $query The query finder.
     *
     * @return \Cake\ORM\Query
     */
    public function findMedium(Query $query)
    {
        return $query->select([
            'id',
            'first_name',
            'last_name',
            'username',
            'avatar',
            'slug'
        ]);
    }

    /**
     * Custom finder for select full fields.
     *
     * @param \Cake\ORM\Query $query The query finder.
     *
     * @return \Cake\ORM\Query
     */
    public function findFull(Query $query)
    {
        return $query->select([
            'id',
            'first_name',
            'last_name',
            'username',
            'avatar',
            'slug',
            'group_id',
            'forum_post_count',
            'forum_thread_count',
            'forum_like_received',
            'blog_articles_comment_count',
            'blog_article_count',
            'facebook',
            'twitter',
            'signature',
            'end_subscription',
            'created',
            'last_login'
        ]);
    }
}
