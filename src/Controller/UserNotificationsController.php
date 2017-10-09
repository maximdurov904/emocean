<?php
namespace App\Controller;
use App\Event\Badges;
use App\Event\Forum\Notifications;
use App\Event\Forum\Statistics;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Email\Email;

class UserNotificationsController extends AppController
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
		$this->viewBuilder()->layout('default_sorting');
        $this->paginate = [
			'order' => [
				'UserNotifications.created' => 'DESC'
			]
        ];
		$userNotifications = $this->paginate($this->UserNotifications);
		/* pr($userPackages);
		die; */
        $this->set(compact('userNotifications'));

    }
   

}
