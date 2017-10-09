<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FeedbacksTable extends Table
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
		$this->table('feedbacks');
		$this->primaryKey('id');
		$this->addBehavior('Timestamp');
		
    }
	
	
	public function validationDefault(Validator $validator)
    {
	

	
        $validator
			->requirePresence('rating')
			->notEmpty('rating','Rating Required')
			->requirePresence('feedback')
			->notEmpty('feedback', __('Feedback Required'))
			->add('feedback', 'required', array(
				'rule' => 'notBlank',
				'required' => true
			)) ;


        return $validator;
    }
	
	public function validationFront($validator)
    {
		
		$validator			
			->requirePresence('feedback')
			->notEmpty('feedback', __('feedback is required.'))
			->add('feedback', 'required', array(
				'rule' => 'notBlank',
				'required' => true
			))
			->requirePresence('rating')
			->notEmpty('rating', __('rating is required.'))
			->add('rating', 'required', array(
				'rule' => 'notBlank',
				'required' => true
			))
			
			;	
		return $validator;			
	}

   
	
	
	
}
