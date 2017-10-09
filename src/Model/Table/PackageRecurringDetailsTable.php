<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PackageRecurringDetailsTable extends Table
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
        $this->table('package_recurring_details');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Xety/Cake3Sluggable.Sluggable');
/* 
        $this->belongsTo('Shops', [
            'foreignKey' => 'shop_id'
        ]); */

    }
	
	
}
