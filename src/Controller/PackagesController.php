<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Number;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Email\Email;
class PackagesController extends AppController
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
     * Beforefilter.
     *
     * @param Event $event The beforeFilter event that was fired.
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // $this->Auth->allow(['index', 'choose']);
    }

    /**
     * Index page.
     *
     * @return void
     */
    public function index() { 

        // Packages List
		// $this->Packages->hasOne('PackageUpgrades', [
			// 'foreignKey' => 'package_id'
		// ]);
        $packages = $this->Packages
            ->find()
			// ->contain(['PackageUpgrades'=>['fields'=>['PackageUpgrades.id','PackageUpgrades.package_id','PackageUpgrades.payment_status']]])
            ->order([
                'Packages.created' => 'desc'
            ]);
			// ->group('PackageUpgrades.package_id');
        $packages = $packages->toArray();
		// pr($packages);die;
        $this->set(compact('packages'));

    }
	
	public function choose($package_id){
		
		
		$this->loadModel('Users');
		$this->loadModel('PackageUpgrades');
		$this->loadModel('PackageRecurringDetails');
		
		$package = $this->PackageUpgrades->newEntity($this->request->data, ['validate' => 'billingaccount']);
		
		$package_data = $this->Packages->get($package_id);	
		
		$user = $this->Users->get($this->Auth->user('id'));	
		if ($this->request->is(['patch', 'post', 'put'])) {
			
		
			$queryPackageUpgrade = $this->PackageUpgrades->find()->where(['user_id' => $user->id,'payment_status'=>'1'])->first();
			if(isset($queryPackageUpgrade->ezy_customer_id) && !empty($queryPackageUpgrade->ezy_customer_id)){
			
				$data = array();
				$url = "https://demoapi.ezypay.com/api/v1/customers/".$queryPackageUpgrade->ezy_customer_id."";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"DELETE");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD, 'z4Mc2z0tYOFBUertWAZtDggEAJTKCq');
				curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
				$all_customers = curl_exec($ch);
				$all_result = curl_exec($ch);
				$data = json_decode($all_result, TRUE);								
				$queryPackageUpgrade->payment_status = '0';
				$this->PackageUpgrades->save($queryPackageUpgrade);
				
			}
			$digits = 5;
			$referenceId = rand(pow(10, $digits-1), pow(10, $digits)-1);
			
			$start_date = date('Y-m-d');
			$convert_date = strtotime($start_date);	
			$start_date_day = date('l',$convert_date);
			if($start_date_day == "Sunday"){
				$date1 = str_replace('-', '/', $start_date);
				$start_date = date('Y-m-d',strtotime($date1 . "+1 days"));
			}
			elseif($start_date_day == "Saturday"){
				$date1 = str_replace('-', '/', $start_date);
				$start_date = date('Y-m-d',strtotime($date1 . "+2 days"));
			}else{
			
				$start_date = $start_date;
			}
			
			
			$recurringDebitFirstDebitDate = date('Y-m-d', strtotime('+1 days'));
			$convert_date = strtotime($recurringDebitFirstDebitDate);	
			$start_date_day = date('l',$convert_date);
			if($start_date_day == "Sunday"){
				$date1 = str_replace('-', '/', $recurringDebitFirstDebitDate);
				$recurringDebitFirstDebitDate = date('Y-m-d',strtotime($date1 . "+1 days"));
			}
			elseif($start_date_day == "Saturday"){
				$date1 = str_replace('-', '/', $recurringDebitFirstDebitDate);
				$recurringDebitFirstDebitDate = date('Y-m-d',strtotime($date1 . "+2 days"));
			}else{
			
				$recurringDebitFirstDebitDate = $recurringDebitFirstDebitDate;
			}
			// echo'<pre>';print_r($start_date);die;
			
			$end = date('Y-m-d', strtotime('+6 months'));
			$convert_end_d = strtotime($end);	
			$end_date_day = date('l',$convert_end_d);
			
			if($end_date_day == "Sunday"){
				$date2 = str_replace('-', '/', $end);
				$recurringDebitEndDate = date('Y-m-d',strtotime($date2 . "+1 days"));
			}
			elseif($end_date_day == "Saturday"){
				$date2 = str_replace('-', '/', $end);
				$recurringDebitEndDate = date('Y-m-d',strtotime($date2 . "+2 days"));
			}else{
			
				$recurringDebitEndDate = $end;
			}
			
			
			
			$recurringStartDate = date('Y-m-d', strtotime('+1 months'));	
			$recurringSdate = strtotime($recurringStartDate);	
			$startRecrringDate = date('l',$recurringSdate);
			
			if($startRecrringDate == "Sunday"){
				$date3 = str_replace('-', '/', $recurringStartDate);
				$recurring_start_date = date('Y-m-d',strtotime($date3 . "+1 days"));
			}
			elseif($startRecrringDate == "Saturday"){
				$date3 = str_replace('-', '/', $recurringStartDate);
				$recurring_start_date = date('Y-m-d',strtotime($date3 . "+2 days"));
			}else{
			
				$recurring_start_date = $recurringStartDate;
			}
			
			$q_data = array(	
				'account' => array(		
					'AccountHolderName'=>$this->request->data['account_holder_name'],
					'AccountNumber'=>$this->request->data['account_number'],
					'BankCode'=>$this->request->data['bank_code'],						
					'ExpiryDate'=>null
				),
				'businessAccountReference'=>'63822',
				'firstname'=>$user->first_name,
				'surname'=>$user->last_name,
				'dateOfBirth'=>'05/80',
				'referenceId'=>$referenceId,
				'email'=>$this->request->data['email'],
				'gender'=>'F',
				'mobilePhone'=>'0481071112',
				'address1'=>$this->request->data['address1'],
				'address2'=>'losangeles',
				'suburb'=>'Chatswood',
				'state'=>'NSW',
				'postalCode'=>'2060',
				'countryCode'=>'AU',
				'TermsAndConditions'=>'True',		
				'debitType'=>'2',
				'postcode'=>'9660',
				'recurringDebitEndType'=>'3',
				'recurringWithDifferentFirstDebitAmount'=>$package_data->price,
				'recurringDebitAmount'=>$package_data->price,
				'totalAmountCollected'=>$package_data->price * 6,
				'onceOffAmount'=>$package_data->price,
				'recurringDebitTotalAmountCollected'=>$package_data->price * 6,
				'minimumNumberOfPayment'=>'3',
				'recurringDebitFrequency'=>'1',
				'recurringDebitFrequencyType'=>'4',
				'startDate'=>$start_date,	
			 	'recurringDebitFirstDebitDate'=>$recurringDebitFirstDebitDate, 	 	
				'recurringDebitStartDate'=> $recurring_start_date,
				'recurringDebitEndDate'=>$recurringDebitEndDate, 
		
				'recurringDebitDifferentFirstAmountEndType'=>'2',
				'recurringDebitMinimumNumberOfPayment'=>'2',
			);
		
			$account_create_url = 'https://demoapi.ezypay.com/api/v1/customerwithinstruction';
			$ch = curl_init($account_create_url);                                                                      
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                                   
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, "z4Mc2z0tYOFBUertWAZtDggEAJTKCq");
			curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($q_data));
			$all_result = curl_exec($ch);		
			$data = json_decode($all_result, TRUE);	
			if(isset($data['Message']) && !empty($data['Message']) && $data['Message'] == "Authorization has been denied for this request."){
				$this->Flash->error($data['Message']);
			}
			if(isset($data['Message']) && !empty($data['Message']) && $data['Message'] == "Validation Error"){
				$this->Flash->error("Something went wrong please try again.");
			}		
			if(isset($data['Message']) && !empty($data['Message']) && $data['Message'] == "Error"){
				$payment_cancel = explode(',',$data['Details']['Description']);
				$dateN = explode('and',$payment_cancel[1]);
				// if(isset($data['Details']['Code']) && $data['Details']['Code'] == "E0038"){
					$e_code = $data['Details']['Code'];
					$this->set(compact('e_code'));	
					if(isset($dateN[0]) && !empty($dateN[0])){
						$this->Flash->error("Today is public holiday or weekend so please payment on".$dateN[0]);
					}else{
						$this->Flash->error("Today is public holiday or weekend so please payment on working days");
					}
					
					
					return $this->redirect(['controller' => 'packages', 'action' => 'choose',$package_id]);
				// }
			
			}
			if(isset($data['Account']['Id']) && !empty($data['Account']['Id'])){
			
				if(isset($data['StartDate']) && !empty($data['StartDate'])){
					$sdate = explode("T",$data['StartDate']);
					$startdate = $sdate[0];
				}
				
				if(isset($data['EndDate']) && !empty($data['EndDate'])){
					$edate = explode("T",$data['EndDate']);
					$enddate = $edate[0];
				}
				
				if(isset($data['RecurringDebitFirstDebitDate']) && !empty($data['RecurringDebitFirstDebitDate'])){
					$recurring_debit_first = explode("T",$data['RecurringDebitFirstDebitDate']);
					$recurring_debit_first_debit_date = $recurring_debit_first[0];
				}
				
				if(isset($data['RecurringDebitStartDate']) && !empty($data['RecurringDebitStartDate'])){
					$recurring_start_date = explode("T",$data['RecurringDebitStartDate']);
					$recurring_debit_start_date = $recurring_start_date[0];
				}
				
				if(isset($data['RecurringDebitEndDate']) && !empty($data['RecurringDebitEndDate'])){
					$recurring_end_date = explode("T",$data['RecurringDebitEndDate']);
					$recurring_debit_end_date = $recurring_end_date[0];
				}
				
				if(isset($data['OnceOffStartDate']) && !empty($data['OnceOffStartDate'])){
					$once_start_date = explode("T",$data['OnceOffStartDate']);
					$once_off_start_date = $once_start_date[0];
				}
			
				$package->recurring_amount = $data['RecurringAmount'];
				$package->total_amount_collected = $data['TotalAmountCollected'];
				$package->recurring_with_different_first_debit_amount = $data['RecurringWithDifferentFirstDebitAmount'];
				$package->recurring_with_different_first_debit_amount = $data['RecurringWithDifferentFirstDebitAmount'];
				$package->recurring_debit_amount = $data['RecurringDebitAmount'];
				$package->recurring_debit_total_amount_collected = $data['RecurringDebitTotalAmountCollected'];
				$package->once_off_amount = $data['OnceOffAmount'];
				
				$package->start_date = $startdate;
				// $package->end_date = $enddate;
				$package->recurring_debit_first_debit_date = $recurring_debit_first_debit_date;
				$package->recurring_debit_start_date = $recurring_debit_start_date;
				$package->recurring_debit_end_date = $recurring_debit_end_date;
				$package->once_off_start_date = $once_off_start_date;
				
				$package->account_holder_name = $data['Account']['AccountHolderName'];
				$package->account_number = $data['Account']['AccountNumber'];
				$package->account_id = $data['Account']['Id'];
				$package->ezy_id = $data['Id'];
				$package->ezy_customer_id = $data['Account']['CustomerId'];
				$package->bank_code = $data['Account']['BankCode'];
				$package->first_name = $data['Firstname'];
				$package->user_id = $this->Auth->user('id');
				$package->package_id = $package_data->id;
				$package->email = $data['Email'];
				$package->address1 = $data['Address1'];
				$package->payment_status = '1';
				$saving_data = $this->PackageUpgrades->save($package);
				
				
				
				$this->loadModel('UserPackages');
				$userPackagesDetail = $this->UserPackages->find()->where(['user_id' => $this->Auth->user('id')])->first();
				if(isset($userPackagesDetail->id) && !empty($userPackagesDetail->id)){
					$this->loadModel('Packages');
					
					$message = "";			
					
					$message = "You have activated package ".$package_data->name." Now";
					
					$this->UserPackages->updateAll(['status' => 2,'package_id'=>$package_data->id,'is_trial_package'=>0,'trial_package_end_date'=>NULL,'requested_package_id'=>0], ['id IN' => $userPackagesDetail->id]);
					$userPackageDetail = $this->UserPackages->get($userPackagesDetail->id);
					$this->loadModel('UserNotifications');
					$userNotificationNewData = $this->UserNotifications->newEntity();
					$userNotificationNewData->user_id = $userPackagesDetail->user_id;
					$userNotificationNewData->message  = $message;
					$userNotificationNewData->created = date('Y-m-d H:i:s');
					$this->UserNotifications->save($userNotificationNewData);
			
				}

				
				
				
				$recurring_data = array();
				$url = "https://demoapi.ezypay.com/api/v1/debits?customerId=".$data['Account']['CustomerId']."&dateFrom=2017-03-30&dateTo=2019-12-30";

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"GET");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD, 'z4Mc2z0tYOFBUertWAZtDggEAJTKCq');
				curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($recurring_data));
				$all_customers = curl_exec($ch);
				$all_result = curl_exec($ch);
				$recurring_data = json_decode($all_result, TRUE);
				
				
				if(isset($recurring_data) && !empty($recurring_data)){
					foreach ($recurring_data as $k => $v) {

						$packageRecurring = $this->PackageRecurringDetails->newEntity($v);
						$packageRecurring->id = '';
						if(isset($v['Date']) && !empty($v['Date'])){
							$date = explode("T",$v['Date']);
							$sdate = $date[0];
						}
						$packageRecurring->amount = $v['Amount'];
						$packageRecurring->recurring_id = $v['Id'];
						$packageRecurring->customer_id = $v['CustomerId'];
						$packageRecurring->due_date = $sdate;
						$packageRecurring->payment_status = $v['Status'];
						$this->PackageRecurringDetails->save($packageRecurring);
					}
				}				

		
			$this->PackageUpgrades->belongsTo('Packages', [
				'className' => 'Packages',
				'foreignKey'=>'package_id'
			]);
			$queryFindPackageUpg = $this->PackageUpgrades
							->find()	
							->contain(['Packages'=>['fields'=>['Packages.id','Packages.name']]])	
							->where([
							'PackageUpgrades.ezy_customer_id' => $data['Account']['CustomerId']
							])->first();		
							$upgrade_data = $queryFindPackageUpg->toArray();

			$queryFindPackageRecUpg = $this->PackageRecurringDetails
											->find()		
											->where([
											'PackageRecurringDetails.customer_id' =>$data['Account']['CustomerId']
											])->toArray();
											
		
									
			
				$viewVars = [
					
					'packageFindRec'=> $queryFindPackageUpg,
					'packageRecUpg'=> $queryFindPackageRecUpg,
				];
				$email = new Email();
				$email->profile('default')
					->template('ezy_payment', 'default')
					->emailFormat('html')
					->from(['brian@emoceanstudios.com.au' => 'INABIT' ])
					->to($data['Email'])
					// ->cc('brian@emoceanstudios.com.au')
					->subject('[INABIT] Payment Detail EzyPay Upgrade Package')
					->viewVars($viewVars)
					->send();
											
											
											
				
				
				
				$this->Flash->success("Your recurring payment add !");
				return $this->redirect(['controller' => 'packages', 'action' => 'transaction']);
			}			
		}
		$this->set(compact('package'));	
		$this->set(compact('package_data'));	
	}
	
	public function transaction(){
	
		$this->loadModel('PackageUpgrades');
		$this->loadModel('OrderProducts');
		$this->PackageUpgrades->belongsTo('Packages', [
			'className' => 'Packages',
			'foreignKey'=>'package_id'
		]);
		$data = $this->PackageUpgrades
		->find()
		->contain(['Packages'=>['fields'=>['Packages.id','Packages.name']]])
		->where([
			'PackageUpgrades.user_id' => $this->Auth->user('id')
		]);		
		$upgrade_data = $data->toArray();
			$this->set(compact('upgrade_data'));
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

    public function backup_choose($package_id) {
	
		if(!empty($package_id))
		{
			$this->loadModel('UserPackages');
			$this->loadModel('AdminNotifications');
			$userId = $this->Auth->user('id');
			$queryPackages = $this->UserPackages->find()->where(['user_id' => $userId ]);
			$userPackageDetail = $queryPackages->first();
			$packageRowCount = $queryPackages->count();
			if($packageRowCount > 0){
				$id = $userPackageDetail->id;
				$this->UserPackages->updateAll(['requested_package_id' => $package_id,'status' =>1], ['id IN' => $id]);
				
				########## Entry in notification table start ############
				$adminNotificationNewData = $this->AdminNotifications->newEntity();
				$adminNotificationNewData->user_id = $userId;
				$adminNotificationNewData->message = "Request send for plan selection";
				$adminNotificationNewData->created = date('Y-m-d H:i:s');
				$this->AdminNotifications->save($adminNotificationNewData);
				########## Entry in notification table end ############
			
			}
			else
			{
				$userPackageNewData = $this->UserPackages->newEntity();
				$userPackageNewData->user_id = $userId;
				$userPackageNewData->package_id = $package_id;
				$userPackageNewData->created = date('Y-m-d H:i:s');
				$userPackageNewData->status = 1;
				$this->UserPackages->save($userPackageNewData);
				
				########## Entry in notification table start ############
				$adminNotificationNewData = $this->AdminNotifications->newEntity();
				$adminNotificationNewData->user_id = $userId;
				$adminNotificationNewData->message = "Request send for plan selection";
				$adminNotificationNewData->created = date('Y-m-d H:i:s');
				$this->AdminNotifications->save($adminNotificationNewData);
				########## Entry in notification table end ############
			}
			
			########### Mail To admin for plan request start #########
			$this->loadModel('Packages');
			$this->loadModel('Users');
			$packagesDetail = $this->Packages->get($package_id);
			$userDetail = $this->Users->get($userId);
			$email = $userDetail->email;
			$plan_name = $packagesDetail->name;
			$plan_price = $packagesDetail->price . " USD" ;
			
			/* $viewVars = [
			'email'=> $email,
			'plan_name'=> $plan_name,
			'plan_price'=>$plan_price
			];
			
			$email = new Email();
			$email->profile('default')
				->template('plan_request_to_admin', 'default')
				->emailFormat('html')
				->from($email)
				//->to('khemit.verma25@gmail.com')
				->to('brian@emoceanstudios.com.au')
				->subject('[INABIT] Welcome')
				->viewVars($viewVars)
				->send(); */
			
			########### Mail To admin for plan request end #########
			
		}
	
	
	
		
        //$url = 'https://api.ezypay.com/api/v1/debits';
        //$headers = array(
           // 'Content-Type:application/json',
        // 'Authorization: Basic '. base64_encode("z4Mc2z0tYOFBUertWAZtDggEAJTKCq")
        //);
        //$curlPost = array('variable' => 'value');

        //$process = curl_init($url);
        //curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($process, CURLOPT_HEADER, 1);
        //curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
        //curl_setopt($process, CURLOPT_TIMEOUT, 30);
        //curl_setopt($process, CURLOPT_POST, 1);
        //curl_setopt($process, CURLOPT_POSTFIELDS, $curlPost);
        //curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        //$result = curl_exec($process);

        //curl_close($process);

        //echo "<pre>";
        //print_r($result);
        //echo "</pre>";
        //die();

        $this->loadModel('Packages');

        $package = $this->Packages
            ->find()
            ->where([
                'Packages.id' => $package_id
            ])
            ->first();

        $this->set(compact('package'));

    }

}
