<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Number;
use Cake\Network\Exception\NotFoundException;

class OrdersController extends AppController
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
        $this->Auth->allow(['index', 'view']);
    }

    public function merchant()
    {

        $this->loadModel('Shops');
        $this->loadModel('Products');
        $shop = $this->Shops
            ->find()
            ->where([
                'Shops.user_id' => $this->Auth->user('id')
            ])
            ->first();

        if (isset($shop->id) && !empty($shop->id)) {

            $this->loadModel('OrderProducts');

            $this->Orders->belongsTo('Shops', [
                'className' => 'Shops',
                'foreignKey' => 'shop_id'
            ]);

            /* $this->Orders->belongsTo('OrderProducts', [
                'className' => 'OrderProducts',
                'foreignKey'=>'order_id'
            ]); */

            $conditionss[] = ['Orders.merchant_id' => $this->Auth->user('id'), 'Orders.status' => 1];
            $orders = $this->Orders
                ->find('all', ['conditions' => $conditionss])
                ->contain(['Shops' => ['fields' => ['Shops.id', 'Shops.name', 'Shops.picture']]]);

            $orders_count = $orders->count();

            $this->set(compact('orders', 'orders_count'));

            /*



                $this->loadModel('OrderProducts');
                $this->OrderProducts->belongsTo('Orders', [
                    'className' => 'Orders',
                    'foreignKey'=>'order_id'
                ]);

                $this->OrderProducts->belongsTo('Products', [
                    'className' => 'Products',
                    'foreignKey'=>'product_id'
                ]);

                $conditionss[] = ['OrderProducts.store_id'=>$shop->id,'Orders.status'=>1];
                $orders = $this->OrderProducts
                    ->find('all',['conditions' => $conditionss])
                    ->contain(['Products'=>['fields'=>['Products.id','Products.name','Products.price']],'Orders'=>['fields'=>['Orders.id','Orders.first_name','Orders.last_name','Orders.created','Orders.status']]]);

                $orders_count = $orders->count();
                $this->set(compact('orders', 'orders_count')); */
        }


    }

    public function merchant_completed()
    {

        $this->loadModel('Shops');
        $this->loadModel('Products');
        $shop = $this->Shops
            ->find()
            ->where([
                'Shops.user_id' => $this->Auth->user('id')
            ])
            ->first();
        if (isset($shop->id) && !empty($shop->id)) {


            $this->Orders->belongsTo('Shops', [
                'className' => 'Shops',
                'foreignKey' => 'shop_id'
            ]);


            $conditionss[] = ['Orders.merchant_id' => $this->Auth->user('id'), 'Orders.status' => 4];
            $orders = $this->Orders
                ->find('all', ['conditions' => $conditionss])
                ->contain(['Shops' => ['fields' => ['Shops.id', 'Shops.name', 'Shops.picture']]]);

            $orders_count = $orders->count();

            $this->set(compact('orders', 'orders_count'));


            /* 	$this->loadModel('OrderProducts');
                $this->OrderProducts->belongsTo('Orders', [
                    'className' => 'Orders',
                    'foreignKey'=>'order_id'
                ]);

                $this->OrderProducts->belongsTo('Products', [
                    'className' => 'Products',
                    'foreignKey'=>'product_id'
                ]);

                $conditionss[] = ['OrderProducts.store_id'=>$shop->id,'Orders.status'=>4];
                $orders = $this->OrderProducts
                    ->find('all',['conditions' => $conditionss])
                    ->contain(['Products'=>['fields'=>['Products.id','Products.name','Products.price']],'Orders'=>['fields'=>['Orders.id','Orders.first_name','Orders.last_name','Orders.created','Orders.status']]]);

                $orders_count = $orders->count(); */
            // $this->set(compact('orders', 'orders_count'));

        }
    }

    public function merchant_completed_backup()
    {

        $this->loadModel('Shops');
        $this->loadModel('Products');
        $shop = $this->Shops
            ->find()
            ->where([
                'Shops.user_id' => $this->Auth->user('id')
            ])
            ->first();
        if (isset($shop->id) && !empty($shop->id)) {


            $this->loadModel('OrderProducts');
            $this->OrderProducts->belongsTo('Orders', [
                'className' => 'Orders',
                'foreignKey' => 'order_id'
            ]);

            $this->OrderProducts->belongsTo('Products', [
                'className' => 'Products',
                'foreignKey' => 'product_id'
            ]);

            $conditionss[] = ['OrderProducts.store_id' => $shop->id, 'Orders.status' => 4];
            $orders = $this->OrderProducts
                ->find('all', ['conditions' => $conditionss])
                ->contain(['Products' => ['fields' => ['Products.id', 'Products.name', 'Products.price']], 'Orders' => ['fields' => ['Orders.id', 'Orders.first_name', 'Orders.last_name', 'Orders.created', 'Orders.status']]]);

            $orders_count = $orders->count();
            $this->set(compact('orders', 'orders_count'));

        }
    }

    /**
     * Index page.
     *
     * @return void
     */
    public function index()
    {

        $orders = $this->Orders
            ->find()
            ->contain([
                'Shops'
            ])
            ->where([
                'Orders.user_id' => $this->Auth->user('id'),
                'Orders.status' => 1
            ])
            ->order(['Orders.id' => 'DESC']);

        $orders_count = $orders->count();
        $orders = $orders->toArray();

        $this->loadModel('OrderProducts');

        // Loop into the orders to count the number of products
        if ($orders_count >= 1) {
            foreach ($orders as $k => $v) {

                $orders[$k]['products_nbr'] = $this->OrderProducts
                    ->find()
                    ->where([
                        'OrderProducts.order_id' => $v['id']
                    ])->count();

            }
        }

        $this->set(compact('orders', 'orders_count'));


    }

    /**
     * Index page.
     *
     * @return void
     */
    public function completed()
    {

        $orders = $this->Orders
            ->find()
            ->contain([
                'Shops'
            ])
            ->where([
                'Orders.user_id' => $this->Auth->user('id'),
                'Orders.status' => 4
            ]);

        $orders_count = $orders->count();
        $orders = $orders->toArray();
        $this->loadModel('OrderProducts');

        // Loop into the orders to count the number of products
        if ($orders_count >= 1) {
            foreach ($orders as $k => $v) {

                $orders[$k]['products_nbr'] = $this->OrderProducts
                    ->find()
                    ->where([
                        'OrderProducts.order_id' => $v['id']
                    ])->count();

            }
        }

        $this->set(compact('orders', 'orders_count'));

    }

    public function view($order_id)
    {
        // Orders
        $this->loadModel('Orders');
        $this->loadModel('Transactions');
        $this->loadModel('OrderProducts');

        $order = $this->Orders
            ->find()
            ->where([
                'Orders.id' => $order_id
            ])
            ->first();
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
        $order->billing_state = array_values($states)[$order->billing_state];
        $order->delivery_state = array_values($states)[$order->delivery_state];
        $transaction = $this->Transactions
            ->find()
            ->where([
                'Transactions.order_id' => $order_id
            ])
            ->first();

        $order_products = $this->OrderProducts
            ->find()
            ->contain([
                'Products'
            ])
            ->where([
                'OrderProducts.order_id' => $order_id
            ])
            ->toArray();
// pr($order_products);die;
        if (is_null($order)) {
            // redirect to the home page because htis order doesn't exist
            return $this->redirect(['controller' => 'pages', 'action' => 'home']);
        } else {
            $this->set(compact('transaction', 'order', 'order_products'));
        }

    }

}
