<?php
namespace App\Controller;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;
use Cake\I18n\I18n;
use Cake\Core\Configure;
use Cake\Event\Event;


class ProductsController extends AppController
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
     * Initialize handle.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * BeforeFilter handle.
     *
     * @param Event $event The beforeFilter event that was fired.
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index', 'view', 'history','view_detail','view_detail_search']);
    }

    public function index() {

    }

    public function view() {

        $this->loadModel('Products');

        $product = $this->Products
            ->find('slug', [
                'slug' => $this->request->slug,
                'slugField' => 'Products.slug'
            ])
            ->contain([
                'ProductImages'
            ])
            ->where([
                'Products.is_display' => 1
            ])
            ->first();

        //Check if the product is found.
        if (empty($product)) {
            $this->Flash->error('This product doesn\'t exist or has been deleted.');
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('product'));		
		
    }
	 public function view_detail($product_id = null) {
		
		$group_id = $this->Auth->user('group_id');
		
		$this->loadModel('Products');
        $product = $this->Products
            ->find('all')
            ->contain([
                'ProductImages'
            ])
            ->where([
                'Products.is_display' => 1,
				'Products.id' => $product_id
            ])
            ->first();
			
		$this->loadModel('Users');
		$this->loadModel('Feedbacks');
		$this->loadModel('UserProducts');
         $user_product = $this->UserProducts
             ->find('all')
             ->where([
                 'UserProducts.user_id' => $this->Auth->user('id'),
                 'UserProducts.product_id' => $product_id
             ])
             ->first();

		$conditions = array();

		$name = array();	
		$this->Feedbacks->belongsTo('Users');
		$conditions = array('Feedbacks.product_id'=>$product_id);		
		$this->paginate = [
			'limit' => 10,
			'conditions' => $conditions,			
			'order' => [
				'Feedbacks.created' => 'DESC'
			],
			'contain'=>['Users'=>['fields'=>['Users.id','Users.first_name','Users.last_name']]],
		];
		$feedbacks = $this->paginate($this->Feedbacks);
		

		
        //Check if the product is found.
        if (empty($product)) {
            $this->Flash->error('This product doesn\'t exist or has been deleted.');
            return $this->redirect(['action' => 'index'],$product_id);
        }
        $this->set(compact('feedbacks','product','user_product','group_id'));

    }
	
	
    public function view_detail_search($product_id = null) {
		
		$group_id = $this->Auth->user('group_id');
		$this->loadModel('Products');		
        $product = $this->Products
            ->find('all')
            ->contain([
                'ProductImages'
            ])
            ->where([
                'Products.is_display' => 1,
				'Products.id' => $product_id
            ])
            ->first();
		// echo'<pre>';print_r($product);die;
		
        //Check if the product is found.
        if (empty($product)) {
            $this->Flash->error('This product doesn\'t exist or has been deleted.');
            return $this->redirect(['action' => 'index'],$product_id);
        }
		
		$this->loadModel('Users');
		$this->loadModel('Feedbacks');
		$conditions = array();

		$name = array();	
		$this->Feedbacks->belongsTo('Users');
		$conditions = array('Feedbacks.product_id'=>$product_id);		
		$this->paginate = [
			'limit' => 10,
			'conditions' => $conditions,			
			'order' => [
				'Feedbacks.created' => 'DESC'
			],
			'contain'=>['Users'=>['fields'=>['Users.id','Users.first_name','Users.last_name']]],
		];
		$feedbacks = $this->paginate($this->Feedbacks);
		
		$this->set(compact('feedbacks','product','group_id'));

    }

    public function history($product_id) {

        $this->loadModel('Products');
        $this->loadModel('OrderProducts');

        $product = $this->Products
            ->find('all')
            ->where([
                'Products.id' => $product_id
            ])
            ->first();

        // Find how many time this product has been ordered

        $this->paginate = [
            'limit' => 15,
            'conditions' => [
                'OrderProducts.product_id' => $product_id
            ],
            'order' => [
                'OrderProducts.created' => 'asc'
            ]
        ];

        $orders = $this->paginate($this->OrderProducts->find());

        $this->set(compact('orders', 'product'));

    }
	
	
	public function feedback($productId)
	{
		$this->set('title_for_layout','Feedback');
		$feedbackTable = TableRegistry::get('Feedbacks');
		$userId = $this->request->session()->read('Auth.User.id');
		$feedback = $feedbackTable->find()
					->where(['user_id'=>$userId,'product_id'=>$productId])
					->first();				
		
		if(empty($feedback)){		
			$feedback = $feedbackTable->newEntity();
		}
		if ($this->request->is('post')) {			
			$feedback = $feedbackTable->patchEntity($feedback,$this->request->data);
			$feedback['user_id'] = $userId;
			$feedback['product_id'] = $productId;
			
			if ($feedbackTable->save($feedback)) {
			
				$ratingData = TableRegistry::get('Feedbacks');
				$ratingQuery = $ratingData->find();
				$result = $ratingQuery->select([
					'total' => $ratingQuery->func()->avg('rating')
				])
				->where(['Feedbacks.product_id' => $productId])
				->group('product_id');
				$totalPrice = $result->first();
				
				
				if(!empty($totalPrice->total)){
					$this->loadModel('Products');
					$product_data = $this->Products->get($productId);
					$product_data->avg_rating = $totalPrice->total;				
					$this->Products->save($product_data);
				}
				/* Count product total rating  */
				
				
				
				/* Count shop total rating  */			
				$productData = TableRegistry::get('Products');				
				$product = $productData->find()
					->where(['id'=>$productId])
					->first();			
				$shopRatingQuery = $productData->find();
				$shop_result = $shopRatingQuery->select([
					'total' => $shopRatingQuery->func()->avg('avg_rating')
				])
				->where(['Products.shop_id' => $product->shop_id])
				->group('shop_id');
				$totalShopPrice = $shop_result->first();			
				if(!empty($totalShopPrice)){				
					$this->loadModel('Shops');
					$shop_data = $this->Shops->get($product->shop_id);
					$shop_data->rating = $totalShopPrice->total;										
					$this->Shops->save($shop_data);					
				}
				/* Count shop total rating  */				
				
				$this->Flash->success("Thank for feedback !");				
				echo "<script>window.history.go(-2);</script>";
			}	
			if(!empty($feedback->errors())){			
				 $this->set('feedbackFormErrors', $feedback->errors()); 
			}
		}
		
		$this->set('feedback',$feedback);

	}
	public function listings(){
		$this->loadModel('Products');

		 $this->paginate = [
            'limit' => 15,
			'conditions' => [
                'Products.status' => 1
            ],
			'order' => [
				'Products.name' => 'ASC'
			]
        ];

        $product_list = $this->paginate($this->Products->find());
		
		$this->set(compact('product_list'));
	}

	public function assign_product($product_id) {		
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }
        $json = [];
	
        $product = $this->Products
        ->find()
        ->where([
            'Products.id' => $product_id
        ])
        ->first();
		$this->loadModel('UserProducts');
		$userProductData = $this->UserProducts
						->find()
						->where([
							'UserProducts.product_id' => $product_id,'UserProducts.shop_id' => $this->request->data['shop'],'UserProducts.user_id' => $this->request->session()->read('Auth.User.id')
						])
						->first();
		if(!empty($userProductData->id)){
		
				$jsons['message'] = "Product already added to shop list!";
				$jsons['error'] = false;
				$this->set(compact('jsons'));

		}else{
		
			if (!is_null($product)) {
				
				$userProductTable = TableRegistry::get('UserProducts');	
				$json = $userProductTable->newEntity();				
				$json['user_id'] = $this->request->session()->read('Auth.User.id');
				$json['product_id'] = $product->id;
				$json['shop_id'] = $this->request->data['shop'];
				$json['price'] = $product->price;
				$json['status'] = 1;
				$json['created_date'] = date('d-m-Y H:i:s');

				$data = $userProductTable->save($json);
				
				$jsons['message'] = "Product added to the shop list!";
				$jsons['error'] = false;
				$this->set(compact('jsons'));

			} else {

				$jsons['message'] = "This product doesn't exist";
				$jsons['error'] = true;
			

			}
		}
        $this->set('_serialize', 'jsons');

    }

}