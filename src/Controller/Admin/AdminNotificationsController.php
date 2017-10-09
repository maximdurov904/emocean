<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

class AdminNotificationsController extends AppController
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
		 $this->loadModel('UserNotifications');
		$this->UserNotifications->belongsTo('Users');
        $this->paginate = [
			'contain'=>['Users'],
			'order' => [
				'UserNotifications.created' => 'DESC'
			]
        ];
		$adminNotifications = $this->paginate($this->UserNotifications);
		
        $this->set(compact('adminNotifications'));

    }
   

}
