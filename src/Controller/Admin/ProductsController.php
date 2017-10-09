<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

class ProductsController extends AppController
{
	/**
     * Helpers.
     *
     * @var array
     */
	public $helpers = ['Shop'];
    /**
     * Components.
     *
     * @var array
     */
    public $components = [
        'RequestHandler'
    ];

    /**
     * Display all products.
     *
     * @return void
     */
	/* public function index($shop_id = null) {
        
		
        // Associated Products
        $this->loadModel('UserProducts');

        $this->paginate = [
            'limit' => 10,
            'order' => [
                'UserProducts.id' => 'asc'
            ],
			'contain'=>['Users'=>['fields'=>['Users.id','Users.first_name','Users.last_name']],'Shops'=>['fields'=>['Shops.id','Shops.name']],'Products'=>['fields'=>['Products.id','Products.name','Products.content','Products.created','Products.hero','Products.price']]],
        ];

        $products = $this->paginate($this->UserProducts->find());
		 $this->set(compact('products'));
    } */
	
	public function index()
    {
		
        $this->loadModel('Products');

        $products = $this->Products
            ->find()
            ->contain([
                'Users',
                'Shops'
            ])
            ->order([
                'Products.id' => 'DESC'
            ]);

        $products = $products->toArray();

        $this->set(compact('products'));

    }
		/**
	* toggle status existing Article
	*/
    public function status($id = null) {
	
		$this->loadModel('UserProducts');
		$this->loadModel('Products');

		// echo'kamal';die;
        if ($this->toggleStatus($id)) {
		
			$this->loadModel('UserProducts');
			
			$userPro = $this->UserProducts
					->find()
					->where([
							'UserProducts.product_id' => $id,
							'UserProducts.status' =>0
					])
					->first();
			// pr($userPro);die;
					
			if(isset($userPro) && !empty($userPro)){
			
				$this->UserProducts->updateAll(['status' =>1], ['product_id IN' => $id]);
			
			}

            $data = $this->Products
                ->find()
                ->where([
                    'Products.id' => $id
                ])
                ->first();

            $status = $data->status;
            $message = $status?'Product ['.$data->name.'] is now ACTIVE':'Product ['.$data->name.'] is now DISABLED';

			 $this->Flash->success($message);
//			 $this->Flash->success('Product is now ');
            $this->redirect($this->referer());
        }
       return $this->redirect($this->referer());
    }
	
	function toggleStatus($id = null)
	{	
	
			
		 $data = $this->Products
            ->find()
            ->where([
                'Products.id' => $id
            ])
            ->first();
	
		$status = $data->status;
		$status = $status?0:1;

		
		return $this->Products->updateAll(['status' =>$status], ['id IN' => $id]);
		
		
		
	}
	 
    public function index_backup()
    {

        $this->loadModel('Products');


        $products = $this->Products
            ->find()
            ->contain([
                'Users',
                'Shops'
            ])
            ->order([
                'Products.created' => 'desc'
            ]);

        $products = $products->toArray();

        $this->set(compact('products'));

    }

    /**
     * Add a product.
     *
     * @return \Cake\Network\Response|void
     */
    public function add()
    {
        $this->loadModel('Products');
        $this->loadModel('Users');
        $this->loadModel('Shops');

		$impdata = array();
        $product = $this->Products->newEntity($this->request->data);

		
        if ($this->request->is('post')) {
			
			$product->merchant_id = $product->user_id;
			
			if ($this->Products->save($product)) {	


				$lastInsertedId = $product->id;
				$this->loadModel('UserProducts');
				$user_product = $this->UserProducts->newEntity();
				$user_product->product_id = $lastInsertedId;
				// $user_product->price = $this->request->data['price'];
				
				if(isset($this->request->data['Product']['shop_id']) && !empty($this->request->data['Product']['shop_id'])){				
					$user_product->shop_id = $this->request->data['Product']['shop_id'];				
				}
				$user_product->user_id = $product->user_id;
				$this->UserProducts->save($user_product);

			
                $this->Flash->success('['.$this->request->data('name').'] has been created successfully !');
                return $this->redirect(['action' => 'index']);
            }
        }

		$shopUserIds = $this->Shops->find('list', [
			'conditions'=>['is_display'=>1],
			'keyField' => 'user_id',
			'valueField' => function ($user_id) {
				return ucwords($user_id->get('user_id'));
			}			
		]);
		$shopUserIds1 = $shopUserIds->toArray();		
		$impdata = implode(",", $shopUserIds1);		
		
		$merchants = $this->Users->find('list')->where(['Users.id IN ('.$impdata.') AND Users.group_id=3']);
        $this->set(compact('product', 'merchants'));

    }

    /**
     * Edit a Product.
     *
     * @return \Cake\Network\Response|void
     */
    public function edit()
    {
        $this->loadModel('Products');

        $product = $this->Products
            ->find('all')
            ->where([
                'Products.id' => $this->request->id
            ])
            ->first();

        //Check if the product is found.
        if (empty($product)) {
            $this->Flash->error('This product doesn\'t exist or has been deleted.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('put')) {
            $this->Products->patchEntity($product, $this->request->data());
            if ($this->Products->save($product)) {
                $this->Flash->success('['.$this->request->data('name').'] has been updated successfully !');
                return $this->redirect(['action' => 'index']);
            }
        }

        // The product has to be linked to a store

        //$categories = $this->Products->BlogCategories->find('list');
        $this->set(compact('product'));
    }

    /**
     * Delete a Product.
     *
     * @return \Cake\Network\Response
     */
    public function delete()
    {

        $this->loadModel('Products');

        $product = $this->Products
            ->find('all')
            ->where([
                'Products.id' => $this->request->id
            ])
            ->first();

        //Check if the product is found.
        if (empty($product)) {
            $this->Flash->error('This product doesn\'t exist or has been deleted.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Products->delete($product)) {
            $this->Flash->success('['.$product->name.'] has been deleted successfully !');
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error('Unable to delete this product.');

        return $this->redirect(['action' => 'index']);

    }

    public function uploadImages() {

        $this->loadModel('ProductImages');

        $unique_id = $_GET['slug'];
        $upload_folder = '/products/';

        // Main Directory
        $upload_dir = '/webroot/upload' . $upload_folder;

        // Then... We need to parse the id or the slug
        $upload_dir = $upload_dir . $unique_id;

        $targetPath = $_SERVER['DOCUMENT_ROOT'] . $upload_dir . DIRECTORY_SEPARATOR;

        // If the directory doesn't exist, create it
        if (!file_exists($targetPath)) { 
            mkdir($targetPath, 0755, true); 
        }

        if (!empty($_FILES)) {
             $tempFile = $_FILES['file']['tmp_name'];
             // Adding timestamp with image's name so that files with same name can be uploaded easily.
             $file_name = time().'-'. $_FILES['file']['name'];
             $mainFile = $targetPath.$file_name;
             move_uploaded_file($tempFile,$mainFile);
             $this->request->data['product_id'] = $_GET['product_id'];
             $this->request->data['picture'] = 'upload' . $upload_folder . $unique_id . '/' . $file_name;
             $this->request->data['unique_id'] = $unique_id;
             $image = $this->ProductImages->newEntity($this->request->data);
             $this->ProductImages->save($image);
        }

        die();
    }

    public function getImages() {

        $unique_id = $_GET['unique_id'];
        $upload_folder = '/products/';
        $storeFolder = '/webroot/upload' . $upload_folder;  
        $storeFolder = $storeFolder . $unique_id;

        $files = preg_grep('~\.(jpeg|jpg|png|gif)$~', scandir($_SERVER['DOCUMENT_ROOT'] . $storeFolder));

        // If the directory doesn't exist, create it
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $storeFolder)) { 
            mkdir($_SERVER['DOCUMENT_ROOT'] . $storeFolder, 0755, true); 
        }

        foreach($files as $file){ //get an array which has the names of all the files and loop through it 
            $obj['name'] = $file; //get the filename in array
            $obj['size'] = filesize($_SERVER['DOCUMENT_ROOT'] . $storeFolder. '/' . $file); //get the flesize in array
            $obj['url'] = Router::url('/upload', true) . $upload_folder . $unique_id . '/' . $file; 
            $result[] = $obj; // copy it to another array
        }

        $this->set(compact('result'));
        $this->set('_serialize', ['result']);

    }

    public function deleteImage() {

        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $this->loadModel('ProductImages');

        $json = [];
        $json['file'] = $_POST['id'];
        $upload_folder = '/products/';
        $json['storeFolder'] = '/webroot/upload' . $upload_folder . $_POST['unique_id'];
        $filepath = $_SERVER['DOCUMENT_ROOT'] . $json['storeFolder']. '/' . $json['file'];
        $json['filepath'] = $filepath;

        // Remove the image if exist
        if (is_file($filepath)) { 
            unlink($filepath);
             $image = $this->ProductImages
            ->find()
            ->where([
                'ProductImages.portfolio_id' => $_GET['portfolio_id'],
                'ProductImages.unique_id'    => $_POST['unique_id']
            ])
            ->first();
            $this->ProductImages->delete($image);
        }

        $this->set(compact('json'));
        $this->set('_serialize', 'json');
    }

	public function get_shop_marchant()	
	{		
		$this->viewBuilder()->layout(false);
		$this->loadModel('Shops');
		$marchant_id = $_POST['marchant_id'];		
		$shop_data = array();
		
		$shop_data = $this->Shops->find('list', [
			'conditions'=>['is_display'=>1,'user_id'=>$marchant_id],
			'keyField' => 'id',
			'order'=>['name'=>'ASC'],
			'valueField' => function ($shopName) {
				return ucwords($shopName->get('name'));
			}
		]);
		
		$shop_data = $shop_data->toArray();		
		
		$this->set(compact('shop_data'));
	}
	
	
	 /**
     * Display all products.
     *
     * @return void
     */
    public function feedbacks($product_id)
    {

        $this->loadModel('Feedbacks');
		$this->Feedbacks->belongsTo('Products');
		$this->Feedbacks->belongsTo('Users');
        $feedbacks = $this->Feedbacks
            ->find()
			->where(['product_id'=>$product_id])
            ->contain([
                'Users',
                'Products'
            ])
            ->order([
                'Feedbacks.created' => 'desc'
            ]);

        $feedbacks = $feedbacks->toArray();
		/* pr($feedbacks);
		die; */

        $this->set(compact('feedbacks'));

    }
	
	
	
}
