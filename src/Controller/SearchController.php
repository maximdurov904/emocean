<?php
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
class SearchController extends AppController
{
    /**
     * Initialize handle.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
    }

    public $components = [
        'RequestHandler'
    ];

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
        $this->Auth->allow(['index', 'quick', 'advanced', 'input', 'products', 'shop', 'typeahead']);
    }

    public function index() {

		if(!empty($this->request->session()->read('Search.Quick.Products.Keyword'))){
			$this->request->session()->delete('Search.Quick.Products.Keyword');
		}
		
    }
	public function advanced($product_id = null) {
		
		if(isset($product_id) && !empty($product_id)){
			$this->request->session()->write('Search.AdvancedSearchProduct', $product_id);
		}	
		
		$this->loadModel('Products');
		if (!empty($this->request->data['advanced_search'])) {
			$searched_inputs = $this->request->data['advanced_search'];
			// Remove the previous advanced search session
			$this->request->session()->delete('Search.Advanced');
			$this->request->session()->write('Search.Advanced', $this->request->data['advanced_search']);
			return $this->redirect(['controller' => 'search', 'action' => 'shop']);
		}
		// Generate a Random Number
		$random =  mt_rand(5, 99999999);
		$this->set(compact('random', 'searched_inputs'));
		if(isset($product_id) && !empty($product_id)){
			$product = $this->Products
					->find()
					->where([
					'Products.id' => $product_id
					])
					->first();
			// prpr($product->name);die;
			$product = $product->name;		
			$this->set(compact('product'));
		}
		
	}

    public function advanced_backup() {

		
		if (!empty($this->request->data['advanced_search'])) {

            $searched_inputs = $this->request->data['advanced_search'];
            // Remove the previous advanced search session
            $this->request->session()->delete('Search.Advanced');

			//pr($searched_inputs);die;
            /* if (!empty($searched_inputs)) { 
                foreach ($searched_inputs as $input => $v) {
                    if ($v['value'] != '') { 
                        $this->request->session()->write('Search.Advanced.' . $input . '.value', $v['value']);
                    }
                }
            } */

			 $this->request->session()->write('Search.Advanced', $this->request->data['advanced_search']);
			 
            return $this->redirect(['controller' => 'search', 'action' => 'shop']);

        } else {
           /*  if ($this->request->session()->read('Search.Advanced')) {
                $searched_inputs = $this->request->session()->read('Search.Advanced');
            } else {
                $searched_inputs = '';
            } */
		
			//$this->Flash->error("Please enter store name.");  
        }
		

		
        // Generate a Random Number
        $random =  mt_rand(5, 99999999);
        $this->set(compact('random', 'searched_inputs'));

    }
	
	public function shop() {
	
		$this->viewBuilder()->layout('default_sorting');
		$this->loadModel('UserProducts');
		$conditions = array();
		$name = array();
		
		if(!empty($this->request->session()->read('Search.Advanced'))){
			$searched_inputs = $this->request->session()->read('Search.Advanced');				
		
			foreach ($searched_inputs as $input => $v) {            
				// Now we need to loop into each store to see if they have got the product or not.			
				$name[] = array('Products.name LIKE'=>"%".$v['value']."%");			
			} 		
			if(!empty($name))
			{
				$conditions = ["OR"=>$name];
			}			
		}
        
		if(isset($this->request->query['sort_type']) && !empty($this->request->query['sort_type'])){
			$shortType = $this->request->query['sort_type'];
		}else{			
			$shortType = 'desc';
		}
	
        $this->paginate = [
            'limit' => 10,
           'conditions' => $conditions,
            'order' => [
                'Products.name' => $shortType
            ],'group' => [
                'UserProducts.shop_id'
            ],
			'contain'=>['Products','Shops']
        ];
        $shops = $this->paginate($this->UserProducts->find());
		
		$this->set(compact('shops'));
    }
	
	
	/* public function shop() {
	
		$this->viewBuilder()->layout('default_sorting');
		$conditions = array();
		$name = array();	
		if(!empty($this->request->session()->read('Search.Advanced'))){
			$searched_inputs = $this->request->session()->read('Search.Advanced');				
		
			foreach ($searched_inputs as $input => $v) {            
				// Now we need to loop into each store to see if they have got the product or not.			
				$name[] = array('Products.name LIKE'=>"%".$v['value']."%");			
			} 		
			if(!empty($name))
			{
				$conditions = ["OR"=>$name];
			}			
		}
        $this->loadModel('Products');
		if(isset($this->request->query['sort_type']) && !empty($this->request->query['sort_type'])){
			$shortType = $this->request->query['sort_type'];
		}else{			
			$shortType = 'desc';
		}
		
		$this->Products->belongsTo('Shops', [
			'foreignKey' => 'shop_id'
		]);

        $this->paginate = [
            'limit' => 10,
           'conditions' => $conditions,
            'order' => [
                'Products.name' => $shortType
            ],'group' => [
                'Products.shop_id'
            ],
			'contain'=>['Shops'],
        ];

        $shops = $this->paginate($this->Products->find());
		
       $this->set(compact('shops'));
		
    } */
	
	
	/* public function shop() {
	
		
		$this->loadModel('Shops');
		$this->loadModel('Products');

		// Make a query to get the best prices by shop
		$this->viewBuilder()->layout('default_sorting'); 
		$conditions = array();
		$name = array();	
		if(!empty($this->request->session()->read('Search.Advanced'))){
			$searched_inputs = $this->request->session()->read('Search.Advanced');	
			foreach ($searched_inputs as $input => $v) {            
				// Now we need to loop into each store to see if they have got the product or not.			
				$name[] = array('Shops.name LIKE'=>"%".$v['value']."%");			
			} 
			if(!empty($name))
			{
				$conditions = ["OR"=>$name];
			}			
		}
		$this->paginate = [
			'limit' => 15,
			'order' => [
				'Shops.name' => 'asc'
			]
		];

		$shops = $this->paginate($this->Shops->find()->contain(['Products']));

		// Need to find if the shop has the products that the user search, at least one product
		// First loop into each shop 

		foreach ($shops as $k => $v) {
		  // $shops[$k]['matched_products'] = 0;
		   foreach ($searched_inputs as $input_key => $input_v) {
			   foreach ($v['products'] as $product_key => $product_value) { 
			   
			   pr($product_value);
					//$shops[$k]['matched_products'] += 1; 
			   }
			}
		}
die;		
		
		$this->paginate = [
			'limit' => 10,
			'conditions' => $conditions,			
			'order' => [
				'Shops.package_id' => 'DESC',
				'Shops.rating' => 'DESC',
			]
		];
		$shops = $this->paginate($this->Shops);
		$this->set(compact('shops'));
		
    } */
	
	

   public function shop_backup() {

		// Make a query to get the best prices by shop
		$this->viewBuilder()->layout('default_sorting'); 
		$conditions = array();
		$name = array();	
		if(!empty($this->request->session()->read('Search.Advanced'))){
			$searched_inputs = $this->request->session()->read('Search.Advanced');				
		
			//pr($searched_inputs);die;
			foreach ($searched_inputs as $input => $v) {            
				// Now we need to loop into each store to see if they have got the product or not.			
				$name[] = array('Shops.name LIKE'=>"%".$v['value']."%");			
			} 
			
			//$name[] = array('Shops.name LIKE'=>"%".$searched_inputs."%");
			
			if(!empty($name))
			{
				$conditions = ["OR"=>$name];
			}			
		}
		
		$this->loadModel('Shops');
		$this->loadModel('Products');

	     
		$this->paginate = [
			'limit' => 15,
			'order' => [
				'Shops.name' => 'asc'
			]
		];

		$shops = $this->paginate($this->Shops->find()->contain(['Products']));

		// Need to find if the shop has the products that the user search, at least one product
		// First loop into each shop 

		foreach ($shops as $k => $v) {
		  // $shops[$k]['matched_products'] = 0;
		   foreach ($searched_inputs as $input_key => $input_v) {
			   foreach ($v['products'] as $product_key => $product_value) {
					//$shops[$k]['matched_products'] += 1; 
			   }
			}
		}	
		
		$this->paginate = [
			'limit' => 10,
			'conditions' => $conditions,			
			'order' => [
				'Shops.package_id' => 'DESC',
				'Shops.rating' => 'DESC',
			]
		];
		 $this->paginate = [
			'limit' => 10,
			'conditions' => $conditions,			
			'order' => [
				'Shops.package_id' => 'DESC',
				'Shops.rating' => 'DESC',
			]
		]; 
		$shops = $this->paginate($this->Shops);
		$this->set(compact('shops'));
		
    }

    public function input() {

         $this->viewBuilder()->layout(false);
         // Generate a Random Number
         $random =  mt_rand(5, 99999999);
         $this->set(compact('random'));
		 $product = "";
         $this->set(compact('product'));

    }


    /**
     * Display all Products based on the search.
     *
     * @return void
     */
	public function new_quick($short_type=null)
    {
        $this->viewBuilder()->layout('default_sorting');
        $this->loadModel('UserProducts');
        //Keyword to search. (For pagination)
	
		
		if (!empty($this->request->data['search'])) {
            $keyword = $this->request->data['search'];
            $this->request->session()->write('Search.Quick.Products.Keyword', $keyword);
        } else {
            if ($this->request->session()->read('Search.Quick.Products.Keyword')) {
                $keyword = $this->request->session()->read('Search.Quick.Products.Keyword');
            } else {
                $this->request->session()->delete('Search.Quick.Products.Keyword');
				$keyword = '';
            }
        }
		
		
		
		if(isset($this->request->query['sort_type']) && !empty($this->request->query['sort_type'])){
			$shortType = $this->request->query['sort_type'];
		}else{
			
			$shortType = 'desc';
		}

        $this->paginate = [
            'limit' => 10,
			'contain'=>['Users'=>['fields'=>['Users.id','Users.first_name','Users.last_name']],'Shops'=>['fields'=>['Shops.id','Shops.name']],'Products'=>['fields'=>['Products.id','Products.name','Products.content','Products.created','Products.hero','Products.price']]],
            'conditions' => [
                'Products.name LIKE' => "%$keyword%",'Products.status'=>1
            ],
			'group' => [
                'UserProducts.product_id'
            ],
            'order' => [
                'Products.name' => $shortType
            ]
        ];

        $products = $this->paginate($this->UserProducts->find());
		// pr($products);die;
        $this->set(compact('products', 'keyword'));

    }
	public function quick($short_type=null)
    {
        $this->viewBuilder()->layout('default_sorting');
        $this->loadModel('Products');

        //Keyword to search. (For pagination)
		
		
		if (!empty($this->request->data['search'])) {
            $keyword = $this->request->data['search'];
            $this->request->session()->write('Search.Quick.Products.Keyword', $keyword);
        } else {
            if ($this->request->session()->read('Search.Quick.Products.Keyword')) {
                $keyword = $this->request->session()->read('Search.Quick.Products.Keyword');
            } else {
                $this->request->session()->delete('Search.Quick.Products.Keyword');
				$keyword = '';
            }
        }

		if(isset($this->request->query['sort_type']) && !empty($this->request->query['sort_type'])){
			$shortType = $this->request->query['sort_type'];
		}else{
			
			$shortType = 'desc';
		}

		$this->Products->belongsTo('Users', [
			'className' => 'Users',
			'foreignKey' => 'merchant_id'
		]);
 //paypal_business_email
        $this->paginate = [
            'limit' => 10,
			'contain'=>[
				'Users'
			],
            'conditions' => [
                array( //implied and
                    'or' => array(
                        array('Products.name LIKE' => "%$keyword%"),
                        array('Products.content LIKE' => "%$keyword%"), )
                   ),'Products.status'=>1,'Products.is_display' => 1,
            ],

            'order' => [
                'Products.name' => $shortType
            ]
        ];

        $products = $this->paginate($this->Products->find());

        $this->set(compact('products', 'keyword'));

    }
    public function typeahead_for_product()
    {
        
        $this->loadModel('Products');
        $keyword = strtolower($this->request->data['q']);
        $products = $this->Products
            ->find()
            ->where(function ($q) use ($keyword) {
                return $q
                ->like('LOWER(Products.name)', "%$keyword%");
            })
            ->limit(5)
            ->toArray();
        
        $json['status'] = true;
        $json['error'] = null;
        
        foreach ($products as $product) {
            $json['data'][] = h($product->name);
        }
                
        $this->set(compact('json'));
        $this->set('_serialize', 'json');
        
    }
	
    // public function typeahead()
    // {
        
        // $this->loadModel('Shops');
        // $keyword = strtolower($this->request->data['q']);
		
        // $shops = $this->Shops
            // ->find()
            // ->where(function ($q) use ($keyword) {
                // return $q
                // ->like('LOWER(Shops.name)', "%$keyword%");
            // })
            // ->limit(5)
            // ->toArray();
        
        // $json['status'] = true;
        // $json['error'] = null;
        
        // foreach ($shops as $shp) {
            // $json['data1'] = base64_encode($shp->name);
            // $json['data'][] = base64_decode($json['data1']);
        // }

        // $this->set(compact('json'));
        // $this->set('_serialize', 'json');
        
    // }
	
	public function typeahead()
    {
        
        $this->loadModel('Products');
        $keyword = strtolower($this->request->data['q']);
		
        $products = $this->Products
            ->find()
            ->where(function ($q) use ($keyword) {
                return $q
                ->like('LOWER(Products.name)', "%$keyword%");
            })
            ->limit(5)
            ->toArray();
        
        $json['status'] = true;
        $json['error'] = null;
        
        foreach ($products as $shp) {
            $json['data1'] = base64_encode($shp->name);
            $json['data'][] = base64_decode($json['data1']);
        }
        $this->set(compact('json'));
        $this->set('_serialize', 'json');
        
    }
}