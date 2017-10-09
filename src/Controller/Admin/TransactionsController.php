<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

class TransactionsController extends AppController
{

    /**
     * Components.
     *
     * @var array
     */
    public $components = [
        'RequestHandler'
    ];

    /**
     * Display all transactions.
     *
     * @return void
     */
    public function index()
    {

        $this->loadModel('Transactions');
        $this->loadModel('Users');
		$this->Transactions->belongsTo('Users', [
            'className' => 'Users',
			'foreignKey' => 'user_id'
        ]);

      $transactions = $this->Transactions
            ->find()
			->contain(['Users'])
            ->order([
                'Transactions.created_date' => 'desc'
            ])->toArray();	
		
        $this->set(compact('transactions'));
        
    }

    /**
     * Add a Transaction.
     *
     * @return \Cake\Network\Response|void
     */
    public function add()
    {
        $this->loadModel('Transactions');

        $transaction = $this->Transactions->newEntity($this->request->data);

        if ($this->request->is('post')) {

            if ($this->Transactions->save($transaction)) {
                $this->Flash->success('Your transaction has been created successfully !');
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('transaction'));
    }

    /**
     * Edit a transaction.
     *
     * @return \Cake\Network\Response|void
     */
    public function edit()
    {
        $this->loadModel('Transactions');

        $transaction = $this->Transactions
            ->find('all')
            ->where([
                'Transactions.id' => $this->request->id
            ])
            ->first();

        //Check if the transaction is found.
        if (empty($transaction)) {
            $this->Flash->error('This transaction doesn\'t exist or has been deleted.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('put')) {
            $this->Transactions->patchEntity($transaction, $this->request->data());
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success('This transaction has been updated successfully !');
                return $this->redirect(['action' => 'index']);
            }
        }

        //$categories = $this->Transactions->BlogCategories->find('list');
        $this->set(compact('transaction'));
    }

    /**
     * Delete an Transaction and all his comments and likes.
     *
     * @return \Cake\Network\Response
     */
    public function delete()
    {

        $this->loadModel('Transactions');

         $transaction = $this->Transactions
            ->find('all')
            ->where([
                'Transactions.id' => $this->request->id
            ])
            ->first();

        //Check if the transaction is found.
        if (empty($transaction)) {
            $this->Flash->error('This transaction doesn\'t exist or has been deleted.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Transactions->delete($transaction)) {
            $this->Flash->success('This transaction has been deleted successfully !');
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error('Unable to delete this transaction.');

        return $this->redirect(['action' => 'index']);
    }
	public function customer(){
	
		$this->loadModel('PackageUpgrades');
		
		$this->PackageUpgrades->belongsTo('Packages', [
		'className' => 'Packages',
		'foreignKey'=>'package_id'
		]);
		
		$data = $this->PackageUpgrades
				     ->find()
					 ->contain(['Packages'=>['fields'=>['Packages.id','Packages.name']]]);		
					 $upgrade_data = $data->toArray();
		
		$this->set(compact('data'));
		
	}
	
	public function detail($customerId){
	
		$this->loadModel('PackageUpgrades');
		
		$this->PackageUpgrades->belongsTo('Packages', [
		'className' => 'Packages',
		'foreignKey'=>'package_id'
		]);
		
		$data = $this->PackageUpgrades
				     ->find()
					 ->contain(['Packages'=>['fields'=>['Packages.id','Packages.name']]])->first();		
					 $upgrade_data = $data->toArray();
		
		$this->set(compact('data'));
	
	
		
		
	}
	public function invoice($customerId){
		
		$this->loadModel('PackageRecurringDetails');	
		$rdata = $this->PackageRecurringDetails
						->find()		
						->where([
						'PackageRecurringDetails.customer_id' => $customerId
				]);		
		$data = $rdata->toArray();		
		$this->set(compact('data'));

	}
/* 	public function customer(){
	
		$data = array();
		$url = "https://demoapi.ezypay.com/api/v1/customers";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, 'z4Mc2z0tYOFBUertWAZtDggEAJTKCq');

		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));


		$all_customers = curl_exec($ch);
		$all_result = curl_exec($ch);
		$data = json_decode($all_result, TRUE);
		$this->set(compact('data'));
	} */
	
	
	
	public function transaction_detail($id)
    {

		$this->loadModel('Transactions');
        
        $data = $this->Transactions
            ->find()
			->where(['id'=>$id])
            ->first();		
       
	

        $this->set(compact('data'));

    }
	
	
	
	

}
