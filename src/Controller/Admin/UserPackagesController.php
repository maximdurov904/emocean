<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Email\Email;

class UserPackagesController extends AppController
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
     * Display all UserPackages.
     *
     * @return void
     */
    public function index()
    {
		$this->UserPackages->belongsTo('Users');
		//$this->UserPackages->belongsTo('Packages');
		
		$this->UserPackages->belongsTo('RequestedPackageDetail', [
			'className' => 'Packages',
			'foreignKey' => 'requested_package_id 	'
		]);
		
		$this->UserPackages->belongsTo('Packages', [
			'className' => 'Packages',
			'foreignKey' => 'package_id'
		]);
		
		
        $this->paginate = [
			'contain'=>['Users','Packages','RequestedPackageDetail'],
			'order' => [
				'UserPackages.created' => 'DESC'
			]
        ];
		
		
		
		$userPackages = $this->paginate($this->UserPackages);
		/* pr($userPackages);
		die; */
        $this->set(compact('userPackages'));

    }
	
	public function approved($id)
    {
		$this->request->allowMethod(['post']);
		$this->loadModel('Packages');
		$userPackagesDetail = $this->UserPackages->get($id);
		$message = "";
		if(!empty($userPackagesDetail->requested_package_id))
		{
			$packagesDetail = $this->Packages->get($userPackagesDetail->requested_package_id);
			$message = "Your ".$packagesDetail->name." package request hasbeen approved by admin.";
		}
		
		$this->UserPackages->updateAll(['status' => 2,'package_id'=>$userPackagesDetail->requested_package_id,'is_trial_package'=>0,'trial_package_end_date'=>NULL,'requested_package_id'=>0], ['id IN' => $id]);
		$userPackageDetail = $this->UserPackages->get($id);
		$this->loadModel('UserNotifications');
		$userNotificationNewData = $this->UserNotifications->newEntity();
		$userNotificationNewData->user_id = $userPackagesDetail->user_id;
		$userNotificationNewData->message  = $message;
		$userNotificationNewData->created = date('Y-m-d H:i:s');
		$this->UserNotifications->save($userNotificationNewData);
		
		########### Mail To user for approved plan request start #########
		$this->loadModel('Packages');
		$this->loadModel('Users');
		$packagesDetail = $this->Packages->get($userPackagesDetail->package_id);
		$userDetail = $this->Users->get($userPackagesDetail->user_id);
		
		if(!empty($packagesDetail->name) && !empty($userDetail->email))
		{
			$plan_name = $packagesDetail->name;
			$plan_price = $packagesDetail->price . " USD" ;
			$viewVars = [
		'plan_name'=> $plan_name,
		'plan_price'=>$plan_price
			];
			$email = new Email();
			$email->profile('default')
				->template('plan_approved_by_admin', 'default')
				->emailFormat('html')
				->from(['brian@emoceanstudios.com.au' => 'INABIT' ])
				->to($userDetail->email)
				->subject('[INABIT] Welcome')
				->viewVars($viewVars)
				->send();
		
	
		}
		########### Mail To user for approved plan request end #########
		$this->Flash->success(__('User packages have been approved successfully.'));
		return $this->redirect(['action' => 'index']);
    }
	
	public function rejected($id)
    {
		$this->request->allowMethod(['post']);
		$this->loadModel('Packages');
		$userPackagesDetail = $this->UserPackages->get($id);
		$message = "";
		if(!empty($userPackagesDetail->requested_package_id))
		{
			$packagesDetail = $this->Packages->get($userPackagesDetail->requested_package_id);
			$message = "Your ".$packagesDetail->name." package request rejected approved by admin.";
		}
		
		$this->UserPackages->updateAll(['status' => 3], ['id IN' => $id]);
		$userPackageDetail = $this->UserPackages->get($id);
		$this->loadModel('UserNotifications');
		$userNotificationNewData = $this->UserNotifications->newEntity();
		$userNotificationNewData->user_id = $userPackagesDetail->user_id;
		$userNotificationNewData->message  = $message;
		$userNotificationNewData->created = date('Y-m-d H:i:s');
		$this->UserNotifications->save($userNotificationNewData);
		########### Mail To user for rejected plan request start #########
		$this->loadModel('Packages');
		$this->loadModel('Users');
		$packagesDetail = $this->Packages->get($userPackagesDetail->package_id);
		$userDetail = $this->Users->get($userPackagesDetail->user_id);
		
		if(!empty($packagesDetail->name) && !empty($userDetail->email))
		{
			$plan_name = $packagesDetail->name;
			$plan_price = $packagesDetail->price . " USD" ;
			$viewVars = [
		'plan_name'=> $plan_name,
		'plan_price'=>$plan_price
			];
			$email = new Email();
			$email->profile('default')
				->template('plan_approved_by_admin', 'default')
				->emailFormat('html')
				->from(['brian@emoceanstudios.com.au' => 'INABIT' ])
				->to($userDetail->email)
				->subject('[INABIT] Welcome')
				->viewVars($viewVars)
				->send();
		
	
		}
		########### Mail To user for rejected plan request end #########
		$this->Flash->success(__('User packages have been rejected successfully.'));
		return $this->redirect(['action' => 'index']);
    }

   

}
