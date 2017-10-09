<?php
namespace App\Controller;


use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Number;
use Cake\Network\Exception\NotFoundException;
use Intervention\Image\ImageManager;






class ShopController extends AppController
{

    /**
     * Components.
     *
     * @var array
     */
    public $components = [
        'RequestHandler'
    ];
	 public $helpers = ['Shop'];
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
        $this->Auth->allow(['index', 'view', 'products']); 
    }

    public function index($shop_id = null) {
	
		$searched_inputs = $this->request->session()->read('Search.Advanced');			
		
	

        $this->loadModel('Shops');
        $user_id = $this->Auth->user('id');

        if ($shop_id == null) {            
            // Store View
            $shop = $this->Shops
            ->find()
            ->where([
                'Shops.user_id' => $user_id
            ])
            ->first();

        } else {

            // Store View
            $shop = $this->Shops
            ->find()
            ->where([
                'Shops.id' => $shop_id
            ])
            ->first();

        }
        $states=[
            'New South Wales',
            'Northern Territory',
            'Victoria',
            'Queensland',
            'Western Australia',
            'South Australia',
            'Australian Capital Territory',
            'Tasmania'
        ];
        $shop->state = array_values($states)[$shop->state];
        if (is_null($shop)) {
            // It means that my shop doesn't exist yet
            return $this->redirect(['controller' => 'shop', 'action' => 'edit']);
        } else {
            $this->set(compact('shop', 'user_id'));
        }
		 $group = $this->Auth->user('group_id');
		 $this->set(compact('group'));
    }

    public function add_shop() {

        $this->loadModel('Shops');
		$this->loadModel('UserPackages');
		$userId = $this->request->session()->read('Auth.User.id');
		$queryUserPackage = $this->UserPackages->find()->where(['user_id' => $userId]);
		$userPackageData = $queryUserPackage->first();
		$userPackageCount =  $queryUserPackage->count();

        // add shop 
        $shop = $this->Shops->newEntity($this->request->data, ['validate' => 'default']);
		
        $shop->user_id = $this->Auth->user('id');
		
		
        if ($this->request->is(['patch', 'post', 'put'])) {

            // Shop Image
            if ((isset($_FILES["shop_file"]['name'])) && $_FILES["shop_file"]["name"] != '') { 

                $manager = new ImageManager();
                $file = $_FILES["shop_file"];
                $random = rand(1,99999);
                $filename = $random . $_FILES["shop_file"]["name"];

                // Thumbnail
                $directory_thumbnail = 'img/shops_images/thumbnail-' . $filename;
                $path_thumbnail = $_SERVER['DOCUMENT_ROOT'] . '/webroot/' . $directory_thumbnail;
                $manager->make($_FILES["shop_file"]["tmp_name"])->fit(240)->resize(240, 167)->save($path_thumbnail);
                // Large
                $directory_large = 'img/shops_images/large-' . $filename;
                $path_large = $_SERVER['DOCUMENT_ROOT'] . '/webroot/' . $directory_large;
                $manager->make($_FILES["shop_file"]["tmp_name"])->fit(767)->resize(767, 329)->save($path_large);
                // Original
                $directory = 'img/shops_images/original-' . $filename;
                $path = $_SERVER['DOCUMENT_ROOT'] . '/webroot/' . $directory;
                $manager->make($_FILES["shop_file"]["tmp_name"])->save($path);

                $shop->picture = $filename;
            
			}
			if ((isset($_FILES["shop_logo"]['name'])) && $_FILES["shop_logo"]["name"] != '') { 

                $manager = new ImageManager();
                $file = $_FILES["shop_logo"];
                $random = rand(1,99999);
                $filename = $random . $_FILES["shop_logo"]["name"];

                // logo
                $directory = 'img/shops_logos/' . $filename;
                $path = $_SERVER['DOCUMENT_ROOT'] . '/webroot/' . $directory;
                $manager->make($_FILES["shop_logo"]["tmp_name"])->save($path);
                $shop->shop_logo = $filename;
            
			}
			
			if($userPackageCount > 0)
			{
				$shop->package_id = $userPackageData->package_id;
				
			}////
            if ($this->Shops->save($shop)) {
				
                //$this->Flash->success("Your information has been add !");
				return $this->redirect(['controller' => 'shop', 'action' => 'listings']);
            }
        }

        $options = array('9am' => '9am', '10am' => '10am', '11am' => '11am', '12pm' => '12pm', '1pm' => '1pm', '2pm' => '2pm', '3pm' => '3pm', '4pm' => '4pm', '5pm' => '5pm');
        $options_choices = array('0' => 'No', '1' => 'Yes');
        $options_states = array('New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia', 'Australian Capital Territory', 'Tasmania');

        $this->set(compact('shop', 'options', 'options_choices', 'options_states','userPackageCount','userPackageData'));

    }

    public function edit($shop_id = null) {

		
        $this->loadModel('Shops');
		$this->loadModel('UserPackages');
		$userId = $this->request->session()->read('Auth.User.id');
		$queryUserPackage = $this->UserPackages->find()->where(['user_id' => $userId]);
		$userPackageData = $queryUserPackage->first();
		$userPackageCount =  $queryUserPackage->count();
        // Edit or add a store if the store doesn't exist yet 
        $shop = $this->Shops
        ->find()
        ->where([
            'Shops.user_id' => $this->Auth->user('id'),
            'Shops.id' => $shop_id
        ])
        ->first();
		
        if (is_null($shop)) {
            // The shop doesn't exist yet
            $shop = $this->Shops->newEntity($this->request->data);
            $shop->user_id = $this->Auth->user('id');
        } else {
            // The shop exist
            $this->Shops->patchEntity($shop, $this->request->data());
        }

		$shop->id = $shop_id;
		
		$shop_detail = $this->Shops->get($shop_id);
		$shop_old_logo = $shop_detail->shop_logo;
		
        if ($this->request->is(['patch', 'post', 'put'])) {

            // Shop Image
            if ((isset($_FILES["shop_file"]['name'])) && $_FILES["shop_file"]["name"] != '') { 

                $manager = new ImageManager();
                $file = $_FILES["shop_file"];
                $random = rand(1,99999);
                $filename = $random . $_FILES["shop_file"]["name"];

                // Thumbnail
                $directory_thumbnail = 'img/shops_images/thumbnail-' . $filename;
                $path_thumbnail = $_SERVER['DOCUMENT_ROOT'] . '/webroot/' . $directory_thumbnail;
                $manager->make($_FILES["shop_file"]["tmp_name"])->fit(240)->resize(240, 167)->save($path_thumbnail);
                // Large
                $directory_large = 'img/shops_images/large-' . $filename;
                $path_large = $_SERVER['DOCUMENT_ROOT'] . '/webroot/' . $directory_large;
                $manager->make($_FILES["shop_file"]["tmp_name"])->fit(767)->resize(767, 329)->save($path_large);
                // Original
                $directory = 'img/shops_images/original-' . $filename;
                $path = $_SERVER['DOCUMENT_ROOT'] . '/webroot/' . $directory;
                $manager->make($_FILES["shop_file"]["tmp_name"])->save($path);

                $shop->picture = $filename;
            
			}
			if ((isset($_FILES["shop_logo"]['name'])) && $_FILES["shop_logo"]["name"] != '') { 

                $manager = new ImageManager();
                $file = $_FILES["shop_logo"];
                $random = rand(1,99999);
                $filename1 = $random . $_FILES["shop_logo"]["name"];

                // logo
				
                $directory = 'img/shops_logos/' . $filename1;
                $path = $_SERVER['DOCUMENT_ROOT'] . '/webroot/' . $directory;
                $manager->make($_FILES["shop_logo"]["tmp_name"])->save($path);
                $shop->shop_logo = $filename1;
				
				if(!empty($shop_old_logo) && file_exists( WWW_ROOT . 'img/shops_logos' . DS . $shop_old_logo))
				{
					unlink(WWW_ROOT . 'img/shops_logos' . DS . $shop_old_logo);
				}	
            
			}
			
            if ($this->Shops->save($shop)) {
                $this->Flash->success("Your information has been updated !");
            }
        }

        $options = array('9am' => '9am', '10am' => '10am', '11am' => '11am', '12pm' => '12pm', '1pm' => '1pm', '2pm' => '2pm', '3pm' => '3pm', '4pm' => '4pm', '5pm' => '5pm');
        $options_choices = array('0' => 'No', '1' => 'Yes');
        $options_states = array('New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia', 'Australian Capital Territory', 'Tasmania');

        $this->set(compact('shop', 'options', 'options_choices', 'options_states','userPackageCount','userPackageData'));

    }
	
	
	
	    public function products($shop_id = null) {	
			$conditions = array();
			$name = array();			
			$this->viewBuilder()->layout('default_sorting');
			$this->loadModel('Shops');
			$shop = $this->Shops
			->find()
			->where([
				'Shops.id' => $shop_id,
			])
			->first();
			$this->loadModel('UserProducts');
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
			$this->paginate = [
				'limit' => 10,
				 'conditions' => $conditions,
				'order' => [
					'UserProducts.id' => 'asc'
				],
				'contain'=>['Users'=>['fields'=>['Users.id','Users.first_name','Users.last_name']],'Shops'=>['fields'=>['Shops.id','Shops.name']],'Products'=>['fields'=>['Products.id','Products.name','Products.content','Products.created','Products.hero','Products.price']]],
			];
			
			$product_list = $this->paginate($this->UserProducts->find()->where(['UserProducts.shop_id' => $shop_id,'UserProducts.status' => 1]));
			$user_data = $this->Auth->user();
	
			$userRoleId = $this->request->session()->read('Auth.User.group_id');
			$this->set(compact('product_list', 'shop', 'userRoleId','user_data'));
		}
/*    public function products($shop_id = null) {
        
		$this->viewBuilder()->layout('default_sorting');
        // Store
        $this->loadModel('Shops');

        $shop = $this->Shops
        ->find()
        ->where([
            'Shops.id' => $shop_id,
        ])
        ->first();

        // Associated Products
        $this->loadModel('UserProducts');

        $this->paginate = [
            'limit' => 10,
            'order' => [
                'UserProducts.id' => 'asc'
            ],
			'contain'=>['Users'=>['fields'=>['Users.id','Users.first_name','Users.last_name']],'Shops'=>['fields'=>['Shops.id','Shops.name']],'Products'=>['fields'=>['Products.id','Products.name','Products.content','Products.created','Products.hero','Products.price']]],
        ];

        $product_list = $this->paginate($this->UserProducts->find()->where(['UserProducts.shop_id' => $shop_id,'UserProducts.status' => 1]));
		// pr($products);die;
        if (is_null($shop)) {
            // It means that my shop doesn't exist yet
            return $this->redirect(['controller' => 'shop', 'action' => 'edit']);
        } else {
            $this->set(compact('shop', 'product_list', 'user_id'));
        }
    }  */

  /*   public function products($shop_id = null) {
        
		$this->viewBuilder()->layout('default_sorting');
        // Store
        $this->loadModel('Shops');

        $shop = $this->Shops
        ->find()
        ->where([
            'Shops.id' => $shop_id
        ])
        ->first();

        // Associated Products
        $this->loadModel('Products');

        $this->paginate = [
            'limit' => 10,
            'order' => [
                'Products.name' => 'asc'
            ]
        ];

        $products = $this->paginate($this->Products->find()->where(['Products.shop_id' => $shop_id]));
		// pr($products);die;
        if (is_null($shop)) {
            // It means that my shop doesn't exist yet
            return $this->redirect(['controller' => 'shop', 'action' => 'edit']);
        } else {
            $this->set(compact('shop', 'products', 'user_id'));
        }
    } */
   
	public function listings() {
        
        // Shops
		$this->viewBuilder()->layout('default_sorting');
		$this->loadModel('Shops');
		$user_id = $this->Auth->user('id');     

        $this->paginate = [
            'limit' => 10,
            'order' => [
                'Shops.name' => 'asc'
            ]
        ];

        $shops = $this->paginate($this->Shops->find()->where(['Shops.user_id' => $user_id]));
		//pr($shops);die;
        $this->set(compact('shops','user_id'));
    }

    public function add_product($shop_id = null) {
		
        // Products
        $this->loadModel('Products');
        $this->loadModel('UserProducts');
        $product = $this->Products->newEntity($this->request->data, ['validate' => 'create']);
        $product->merchant_id = $this->Auth->user('id');
        $product->shop_id = $shop_id;
		//pr($product);die;
        if ($this->request->is('post')) {
		
            if ($this->Products->save($product)) {
					
					
					$lastInsertedId = $product->id;
					$this->loadModel('UserProducts');
					$user_product = $this->UserProducts->newEntity();
					$user_product->product_id = $lastInsertedId;
					$user_product->price = $this->request->data['price'];
					$user_product->shop_id = $shop_id;
					$user_product->user_id = $this->Auth->user('id');   
					// pr($user_product);die;
					$this->UserProducts->save($user_product);
					
					$this->Flash->success("Your product has been add successfully !! your request has been send to admin");
					return $this->redirect(['controller' => 'shop', 'action' => 'products',$shop_id]);
            }
        }
        $this->set(compact('product'));

    }

    public function edit_product($product_id = null) {

        // Products
        $this->loadModel('Products');

        $shop = $this->Products
        ->find()
        ->where([
            'Products.id' => $product_id,
            'Products.user_id' => $this->Auth->user('id')
        ])
        ->first();

        $this->Products->patchEntity($product, $this->request->data());

        if ($this->request->is('put')) {
            if ($this->Products->save($product)) {
                $this->Flash->success("Your product has been updated!");
            }
        }

    }
	
	public function edit_shop_product($product_id = null) {
		$this->loadModel('UserProducts');
		$product = $this->UserProducts
            ->find('all')
			->contain(['Users'=>['fields'=>['Users.id','Users.first_name','Users.last_name']],'Shops'=>['fields'=>['Shops.id','Shops.name']],'Products'=>['fields'=>['Products.id','Products.name','Products.content','Products.created','Products.hero','Products.price']]])
			->where([
                'UserProducts.id' => $product_id
            ])
            ->first();
		if (empty($product)) {
            $this->Flash->error('This product doesn\'t exist or has been deleted.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('put')) {
			// $products =  $this->UserProducts->patchEntity($product,$this->request->data);
			$this->UserProducts->patchEntity($product, $this->request->data(), ['validate' => 'settings']);
			$products['price'] = $this->request->data['price'];
			$products['id'] = $product_id;	
			
            if ($this->UserProducts->save($product)) {
                $this->Flash->success('This product has been updated successfully !');
                return $this->redirect(['action' => 'shop','action' => 'products',$product->shop_id]);
            }
        }		
        $this->set(compact('product'));
    }

}
