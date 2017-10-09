<?php
namespace App\Controller;
use Cake\ORM\TableRegistry;

class AssignmentsController extends AppController
{
	
	public function initialize()
    {
        parent::initialize(); 
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
	public function index()
    {	
	
		// die('dd');
		$this->viewBuilder()->layout('lay_dashboard');
		$this->set('title_for_layout', __('Assignments', true));
		/* $conditions = array();
		$userId = $this->request->session()->read('Auth.User.id');
		$conditions[] = ['Assignments.user_id'=>$userId];
		$this->paginate = [
            'limit' => FRONT_PAGE_LIMIT,
			'conditions' => $conditions,
			'order' => [
				'Assignments.title' => 'ASC'
			]
        ];

		$projects = $this->paginate($this->Projects);
		$this->set(compact('projects')); */
		
    }
	
	
	/**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
	public function add()
    {
		$this->viewBuilder()->layout('lay_dashboard');
		$this->set('title_for_layout', __('Projects', true));	
        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {
			$userId = $this->request->session()->read('Auth.User.id');
			$this->request->data['user_id'] = $userId;
			$project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->front_flash_success(__('Project has been saved.'));
                return $this->redirect(['action' => 'index','language'=>$this->request->session()->read('Config.language')]);
            }
            $this->Flash->front_flash_error(__('Unable to add project.'));
        }
        $this->set('project', $project);
    }
	
	/**
     * Edit method
     *
     * @param string|null $id Project Time id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	public function edit($id = null){
		if (!$id) {
			throw new \Cake\Network\Exception\NotFoundException(__('Id is not valid!'));
		}
		$this->viewBuilder()->layout('lay_dashboard');
		$this->set('title_for_layout','Project');			
		$project = $this->Projects->get($id);
		if ($this->request->is(['post', 'put'])) {
			$this->Projects->patchEntity($project, $this->request->data);
			if ($this->Projects->save($project)) {
				$this->Flash->front_flash_success(__('Project has been updated.'));
				return $this->redirect(['action' => 'index','language'=>$this->request->session()->read('Config.language')]);
			}
			$this->Flash->admin_flash_error(__('Unable to update your project.'));
		}
		$this->set('project', $project);
	}
	
	/**
     * View method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
	public function view($id = null)
    {
		if (!$id) {
			throw new \Cake\Network\Exception\NotFoundException(__('Id is not valid!'));
		}
		$this->viewBuilder()->layout('lay_dashboard');
		$this->set('title_for_layout','Project');	
		
		
        $project = $this->Projects->get($id);
        $this->set(compact('project'));
    }
	
	/**
     * Delete method
     *
     * @param string|null $id Projects id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	public function delete($id){
		if (!$id) {
			throw new \Cake\Network\Exception\NotFoundException(__('Id is not valid!'));
		}
		$this->request->allowMethod(['post', 'delete']);
		$project = $this->Projects->get($id);
		if ($this->Projects->delete($project)){
			$this->Flash->front_flash_success(__('The project has been deleted'));
			return $this->redirect(['action' => 'index','language'=>$this->request->session()->read('Config.language')]);
		}
	}
	
	
	
	
}