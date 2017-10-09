<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Number;
use Cake\Log\Log;
use Cake\Network\Email\Email;
use Cake\ORM\TableRegistry;

class CartController extends AppController
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
        //$this->Auth->allow(['index', 'notify', 'test', 'add_cart','success']); 
    }

    public function index()
    {

        // Get the cart of the user
        $cart = $this->request->session()->read('Cart');
        if(isset($cart['order_id']))
        {
            return $this->redirect(['controller' => 'checkout', 'action' => 'payment']);
        }
        $this->loadModel('Shops');
        if (!empty($cart)) {
            // pr($cart);die;
            foreach ($cart['stores'] as $k => $v):
                // We need to find the delivery methods of the store
                $shop = $this->Shops
                    ->find()
                    ->where([
                        'Shops.id' => $v['store_id']
                    ])
                    ->first();


                if (!is_null($shop)) {

                    $cart['stores'][$k]['delivery_methods'][0]['name'] = 'Select a shipping method...';
                    $cart['stores'][$k]['delivery_methods'][0]['value'] = '';

                    // Weight, Order Price
                    if ($shop['order_greater_activated'] == 1 && $shop['order_greater_value'] >= $cart['total']) {
                        $cart['stores'][$k]['delivery_methods'][1]['name'] = 'Free Delivery';
                        $cart['stores'][$k]['delivery_methods'][1]['value'] = 0.00;
                    } else if ($shop['order_greater_weight_activated'] == 1 && $shop['order_greater_weight_value'] >= $cart['weight']) {
                        $cart['stores'][$k]['delivery_methods'][1]['name'] = 'Free Delivery';
                        $cart['stores'][$k]['delivery_methods'][1]['value'] = 0.00;
                    } else {
                        if ($shop['flat_rate_activated'] == 1) {
                            $cart['stores'][$k]['delivery_methods'][1]['name'] = 'Flat Rate';
                            $cart['stores'][$k]['delivery_methods'][1]['value'] = $shop['flat_rate_value'];
                        }
                        if ($shop['pickup_activated'] == 1) {
                            $cart['stores'][$k]['delivery_methods'][2]['name'] = 'Pickup';
                            $cart['stores'][$k]['delivery_methods'][2]['value'] = 0.00;
                        }
                    }
                }


            endforeach;
        }

        $this->set(compact('cart'));

    }

    public function add_shop_cart($shop_id)
    {

        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $json = [];

        $read_session = $this->request->session()->read('Cart');
        $session = $this->request->session();
        // pr($read_session);die;
        //error : false
        //message:"Product added to the cart!"
            //order:{products: {11: {id: 11, qty: "1", name: "Green Belo", content: "asdfsaf",…}},…}
                //gst:"4.42"
            //products:{11: {id: 11, qty: "1", name: "Green Belo", content: "asdfsaf",…}}
                //11:{id: 11, qty: "1", name: "Green Belo", content: "asdfsaf",…}
                    //content:"asdfsaf"
                    //hero:"/upload/product/hero//71159f8d02b4797a35ac35895880a6ed.jpg"
                    //id:11
                    //merchant_id:79
                    //name:"Green Belo"
                    //picture:"90685511mTmMwZZL.jpg"
                    //price:25
                    //product_code:"QW15852"
                    //product_shop:"New Shop"
                    //qty:"1"
                    //shop_color:null
                    //shop_logo:null
                    //store_id:4
                    //weight:""
            //stores:{4: {store_id: 4, store_name: "New Shop", shop_price: 44.2, picture: "90685511mTmMwZZL.jpg",…}}
            //4:{store_id: 4, store_name: "New Shop", shop_price: 44.2, picture: "90685511mTmMwZZL.jpg",…}
            //delivery_method_name:""
            //delivery_method_price:""
            //gst:"4.42"
            //picture:"90685511mTmMwZZL.jpg"
            //shop_price:44.2
            //store_id:4
            //store_name:"New Shop"
            //subtotal:44.2
            //total:"48.62"
        //subtotal:44.2
        //total:"48.62"
        //weight:"0.00"
        if (isset($read_session['products']) && !empty($read_session['products'])) {
            $session->delete('Cart');
        }

        $this->loadModel('UserProducts');
        $this->loadModel('Shops');

        $searched_inputs = $this->request->session()->read('Search.Advanced');
        foreach ($searched_inputs as $p_name) {
            $pname = $p_name['value'];
        }

        $user_product = $this->UserProducts
            ->find()
            ->contain(['Users' => ['fields' => ['Users.id', 'Users.first_name', 'Users.last_name']], 'Shops' => ['fields' => ['Shops.id', 'Shops.name', 'Shops.shop_logo', 'Shops.picture']], 'Products' => ['fields' => ['Products.id', 'Products.name', 'Products.content', 'Products.hero', 'Products.price', 'Products.product_code', 'Products.merchant_id', 'Products.weight']]])
            ->where([
                'Products.name LIKE' => "%$pname%", 'UserProducts.shop_id' => $shop_id
            ])
            ->first();

        if (!is_null($user_product)) {

            // Create session for carts
            $session = $this->request->session();

            /////////////////////////////////////////////////////////////////////
            /////////////////////////// PRODUCTS ////////////////////////////////
            /////////////////////////////////////////////////////////////////////

            $session->write('Cart.products.' . $user_product->product->id . '.id', $user_product->product->id);
            // Calculate the price based on the qty 
            $price = $user_product->product->price;
            // QTY
            $qty_to_be_read = $this->request->session()->read('Cart.products.' . $user_product->product->id . '.qty');
            if (isset($qty_to_be_read)) {
                $qty = $this->request->data['qty'] + $qty_to_be_read;
            } else {
                $qty = $this->request->data['qty'];
            }

            $session->write('Cart.products.' . $user_product->product->id . '.qty', $qty);
            $price = number_format((float)$price * $qty, 2, '.', '');
            $session->write('Cart.products.' . $user_product->product->id . '.name', $user_product->product->name);
            $session->write('Cart.products.' . $user_product->product->id . '.content', $user_product->product->content);
            $session->write('Cart.products.' . $user_product->product->id . '.hero', $user_product->product->hero);
            $session->write('Cart.products.' . $user_product->product->id . '.price', $user_product->price);
            $session->write('Cart.products.' . $user_product->product->id . '.product_code', $user_product->product->product_code);
            $session->write('Cart.products.' . $user_product->product->id . '.merchant_id', $user_product->product->merchant_id);
            $session->write('Cart.products.' . $user_product->product->id . '.store_id', $user_product->shop_id);
            $session->write('Cart.products.' . $user_product->product->id . '.weight', $user_product->product->weight);
            $cart = $this->request->session()->read('Cart.products');
            /////////////////////////////////////////////////////////////////////
            /////////////////////////// Stores //////////////////////////////////
            /////////////////////////////////////////////////////////////////////
            $shop = $this->Shops
                ->find()
                ->where([
                    'Shops.id' => $user_product->shop_id
                ])
                ->first();

            $count_product = $this->UserProducts
                ->find()
                ->where([
                    'UserProducts.shop_id' => $shop_id, 'UserProducts.status' => 1
                ]);
            $total = 0;
            foreach ($count_product as $value) {
                $total += $value->price;
            }

            // The product needs to be linked to a store anyway
            $session->write('Cart.products.' . $user_product->product->id . '.product_shop', $shop->name);
            $session->write('Cart.products.' . $user_product->product->id . '.shop_logo', $shop->shop_logo);
            $session->write('Cart.products.' . $user_product->product->id . '.shop_color', $shop->shop_color);
            $session->write('Cart.products.' . $user_product->product->id . '.picture', $shop->picture);

            $session->write('Cart.stores.' . $user_product->shop_id . '.store_id', $user_product->shop_id);
            $session->write('Cart.stores.' . $user_product->shop_id . '.store_name', $shop->name);
            $session->write('Cart.stores.' . $user_product->shop_id . '.shop_price', $total);
            $session->write('Cart.stores.' . $user_product->shop_id . '.picture', $shop->picture);

            $stores = $this->request->session()->read('Cart.stores');
            // pr( $stores);die;


            // Calcul the subtotal, gst, total
            $subtotal_store = '';
            $gst_store = '';
            $total_store = '';
            foreach ($cart as $k => $v) {

                // Need to loop each store to see if the shop match the shop cart product
                foreach ($stores as $k_store => $v_store) {
                    if ($v['store_id'] == $v_store['store_id']) {
                        $subtotal_store += $v_store['shop_price'];


                        $gst_store = number_format((float)0.10 * $subtotal_store, 2, '.', '');
                        $delivery_store = '';
                        $total_store = number_format((float)$subtotal_store + $gst_store + $delivery_store, 2, '.', '');
                        // SUBTOTAL
                        $session->write('Cart.stores.' . $user_product->shop_id . '.subtotal', $subtotal_store);
                        // GST
                        $session->write('Cart.stores.' . $user_product->shop_id . '.gst', $gst_store);
                        // TOTAL
                        $session->write('Cart.stores.' . $user_product->shop_id . '.total', $total_store);
                        // Delivery Method Name and Price
                        $session->write('Cart.stores.' . $user_product->shop_id . '.delivery_method_name', '');
                        $session->write('Cart.stores.' . $user_product->shop_id . '.delivery_method_price', '');
                    }
                }
            }

            $subtotal = '';
            $weight = '';
            $delivery = $this->request->session()->read('Cart.delivery.name');
            // Loop to concenate the subtotal value

            // pr($cart);die;
            foreach ($cart as $k => $v) {
                foreach ($stores as $k_store => $v_store) {

                    $subtotal += $v_store['shop_price'];
                    $weight += $v['weight'];
                }
            }

            // Subtotal
            $session->write('Cart.subtotal', $subtotal);

            // Taxes and Delivery
            if (empty($delivery)) {
                $delivery = 0;
            }

            $subtotal = number_format((float)$subtotal, 2, '.', '');

            // GST
            $gst = number_format((float)0.10 * $subtotal, 2, '.', '');
            $session->write('Cart.gst', $gst);

            // Total
            $session->write('Cart.total', number_format((float)$subtotal + $gst + $delivery, 2, '.', ''));

            // Total Weight
            $session->write('Cart.weight', number_format((float)$weight, 2, '.', ''));

            $json['message'] = "Product added to the cart!";
            $json['error'] = false;
            $json['order'] = $this->request->session()->read('Cart');
            $this->set(compact('json'));

        } else {

            $json['message'] = "This product doesn't exist";
            $json['error'] = true;
            $this->set(compact('json'));

        }

        //Send response in JSON.
        $this->set('_serialize', 'json');

    }

    public function add_cart($product_id)
    {

        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $json = [];

        $this->loadModel('Products');
        $this->loadModel('Shops');
        $product = $this->Products
            ->find()
            ->where([
                'Products.id' => $product_id
            ])
            ->first();

        if (!is_null($product)) {

            // Create session for carts
            $session = $this->request->session();

            /////////////////////////////////////////////////////////////////////
            /////////////////////////// PRODUCTS ////////////////////////////////
            /////////////////////////////////////////////////////////////////////

            $session->write('Cart.products.' . $product_id . '.id', $product_id);
            // Calculate the price based on the qty 
            $price = $product->price;
            // QTY
            $qty_to_be_read = $this->request->session()->read('Cart.products.' . $product_id . '.qty');
            if (isset($qty_to_be_read)) {
                $qty = $this->request->data['qty'] + $qty_to_be_read;
            } else {
                $qty = $this->request->data['qty'];
            }

            $session->write('Cart.products.' . $product_id . '.qty', $qty);
            $price = number_format((float)$price * $qty, 2, '.', '');
            $session->write('Cart.products.' . $product_id . '.name', $product->name);
            $session->write('Cart.products.' . $product_id . '.content', $product->content);
            $session->write('Cart.products.' . $product_id . '.hero', $product->hero);
            $session->write('Cart.products.' . $product_id . '.price', $price);
            $session->write('Cart.products.' . $product_id . '.product_code', $product->product_code);
            $session->write('Cart.products.' . $product_id . '.merchant_id', $product->merchant_id);
            $session->write('Cart.products.' . $product_id . '.store_id', $product->shop_id);
            $session->write('Cart.products.' . $product_id . '.weight', $product->weight);
            $cart = $this->request->session()->read('Cart.products');
            /////////////////////////////////////////////////////////////////////
            /////////////////////////// Stores //////////////////////////////////
            /////////////////////////////////////////////////////////////////////
            $shop = $this->Shops
                ->find()
                ->where([
                    'Shops.id' => $product->shop_id
                ])
                ->first();
            // The product needs to be linked to a store anyway
            $session->write('Cart.products.' . $product_id . '.product_shop', $shop->name);
            $session->write('Cart.products.' . $product_id . '.shop_logo', $shop->shop_logo);
            $session->write('Cart.products.' . $product_id . '.shop_color', $shop->shop_color);
            $session->write('Cart.products.' . $product_id . '.picture', $shop->picture);
            $session->write('Cart.stores.' . $product->shop_id . '.store_id', $product->shop_id);
            $session->write('Cart.stores.' . $product->shop_id . '.store_name', $shop->name);
            $session->write('Cart.stores.' . $product->shop_id . '.picture', $shop->picture);
            $stores = $this->request->session()->read('Cart.stores');
            // Calcul the subtotal, gst, total
            $subtotal_store = '';
            $gst_store = '';
            $total_store = '';
            foreach ($cart as $k => $v) {
                // Need to loop each store to see if the shop match the shop cart product
                foreach ($stores as $k_store => $v_store) {
                    if ($v['store_id'] == $v_store['store_id']) {
                        $subtotal_store += $v['price'];
                        $gst_store = number_format((float)0.10 * $subtotal_store, 2, '.', '');
                        $delivery_store = '';
                        $total_store = number_format((float)$subtotal_store + $gst_store + $delivery_store, 2, '.', '');
                        // SUBTOTAL
                        $session->write('Cart.stores.' . $product->shop_id . '.subtotal', $subtotal_store);
                        // GST
                        $session->write('Cart.stores.' . $product->shop_id . '.gst', $gst_store);
                        // TOTAL
                        $session->write('Cart.stores.' . $product->shop_id . '.total', $total_store);
                        // Delivery Method Name and Price
                        $session->write('Cart.stores.' . $product->shop_id . '.delivery_method_name', '');
                        $session->write('Cart.stores.' . $product->shop_id . '.delivery_method_price', '');
                    }
                }
            }

            $subtotal = '';
            $weight = '';
            $delivery = $this->request->session()->read('Cart.delivery.name');
            // Loop to concenate the subtotal value
            foreach ($cart as $k => $v) {
                $subtotal += $v['price'];
                $weight += $v['weight'];
            }

            // Subtotal
            $session->write('Cart.subtotal', $subtotal);

            // Taxes and Delivery
            if (empty($delivery)) {
                $delivery = 0;
            }

            $subtotal = number_format((float)$subtotal, 2, '.', '');

            // GST
            $gst = number_format((float)0.10 * $subtotal, 2, '.', '');
            $session->write('Cart.gst', $gst);

            // Total
            $session->write('Cart.total', number_format((float)$subtotal + $gst + $delivery, 2, '.', ''));

            // Total Weight
            $session->write('Cart.weight', number_format((float)$weight, 2, '.', ''));

            $json['message'] = "Product added to the cart!";
            $json['error'] = false;
            $json['order'] = $this->request->session()->read('Cart');
            $this->set(compact('json'));

        } else {

            $json['message'] = "This product doesn't exist";
            $json['error'] = true;
            $this->set(compact('json'));

        }

        //Send response in JSON.
        $this->set('_serialize', 'json');

    }

    public function remove_cart($product_id)
    {

        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $json = [];

        $this->loadModel('Products');

        $product = $this->Products
            ->find()
            ->where([
                'Products.id' => $product_id
            ])
            ->first();

        if (!is_null($product)) {

            // Remove session for this product
            $session = $this->request->session();
            //$session->delete('Cart'); 
            $session->delete('Cart.products.' . $product_id);

            $cart = $this->request->session()->read('Cart.products');

            // First we need to check if there is still at least one product of the merchant
            // Then if it's the case we don't need to remove the merchant otherwise remove it
            $contain = 0;
            foreach ($cart as $k => $v) {
                if ($v['store_id'] == $product['shop_id']) {
                    $contain++;
                }
            }

            if ($contain == 0) {
                $session->delete('Cart.stores.' . $product['shop_id']);
            }

            $subtotal = '';
            $delivery = $this->request->session()->read('Cart.delivery.name');
            // Loop to concenate the subtotal value
            foreach ($cart as $k => $v) {
                $subtotal += $v['price'];
            }

            // Subtotal
            $session->write('Cart.subtotal', $subtotal);

            // Taxes and Delivery
            if (empty($delivery)) {
                $delivery = 0;
            }

            $subtotal = number_format((float)$subtotal, 2, '.', '');

            // GST
            $gst = number_format((float)0.10 * $subtotal, 2, '.', '');
            $session->write('Cart.gst', $gst);

            // Total
            $session->write('Cart.total', number_format((float)$subtotal + $gst + $delivery, 2, '.', ''));

            $json['message'] = "Product removed to the cart!";
            $json['cart'] = $this->request->session()->read('Cart');
            $json['error'] = false;
            $this->set(compact('json'));

        } else {

            $json['message'] = "This product doesn't exist";
            $json['error'] = true;
            $this->set(compact('json'));

        }

        //Send response in JSON.
        $this->set('_serialize', 'json');

    }

    public function update_cart($product_id)
    {

        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        // QTY
        $qty = $this->request->data['qty'];
        $json = [];

        $this->loadModel('Products');

        $product = $this->Products
            ->find()
            ->where([
                'Products.id' => $product_id
            ])
            ->first();

        if (!is_null($product)) {

            // Create session for carts
            $session = $this->request->session();
            $session->write('Cart.products.' . $product_id . '.id', $product_id);
            $session->write('Cart.products.' . $product_id . '.qty', $qty);
            $price = $product->price;
            $qty = $this->request->session()->read('Cart.products.' . $product_id . '.qty');
            $price = number_format((float)$price * $qty, 2, '.', '');

            $session->write('Cart.products.' . $product_id . '.name', $product->name);
            $session->write('Cart.products.' . $product_id . '.content', $product->content);
            $session->write('Cart.products.' . $product_id . '.hero', $product->hero);
            $session->write('Cart.products.' . $product_id . '.price', $price);
            // Merchant
            $session->write('Cart.products.' . $product_id . '.merchant_id', $product->merchant_id);
            $session->write('Cart.products.' . $product_id . '.store_id', $product->store_id);

            $cart = $this->request->session()->read('Cart.products');
            $subtotal = '';
            // Loop to concenate the subtotal value
            foreach ($cart as $k => $v) {
                $subtotal += $v['price'];
            }

            // Subtotal
            $session->write('Cart.subtotal', $subtotal);

            $subtotal = number_format((float)$subtotal, 2, '.', '');

            // GST
            $gst = number_format((float)0.10 * $subtotal, 2, '.', '');
            $session->write('Cart.gst', $gst);

            // Total
            $session->write('Cart.total', number_format((float)$subtotal + $gst + $delivery, 2, '.', ''));

            $json['message'] = "Qty of this product updated!";
            $json['cart'] = $this->request->session()->read('Cart');
            $json['error'] = false;
            $this->set(compact('json'));

        } else {
            $json['message'] = "This product doesn't exist";
            $json['error'] = true;
            $this->set(compact('json'));
        }

        //Send response in JSON.
        $this->set('_serialize', 'json');

    }

    public function choose_delivery()
    {

        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $session = $this->request->session();
        $json = [];

        // Delivery and store variables
        $store_id = $this->request->data['store_id'];
        $delivery_name = $this->request->data['delivery_name'];
        $delivery_price = $this->request->data['delivery_price'];

        // Need to write the delivery name and price for the store
        $session->write('Cart.stores.' . $store_id . '.delivery_method_name', $delivery_name);
        $session->write('Cart.stores.' . $store_id . '.delivery_method_price', number_format((float)$delivery_price, 2, '.', ''));

        $cart = $this->request->session()->read('Cart.products');
        $stores = $this->request->session()->read('Cart.stores');
        $subtotal = '';
        $delivery = '';
        // Loop to concenate the subtotal value
        foreach ($cart as $k => $v) {
            $subtotal += $v['price'];
        }

        $subtotal = number_format((float)$subtotal, 2, '.', '');

        // Calcul the delivery price for each store
        foreach ($stores as $k_store => $v_store) {
            $delivery += number_format((float)$v_store['delivery_price'], 2, '.', '');
        }

        $delivery = number_format((float)$delivery, 2, '.', '');

        // GST
        $gst = number_format((float)0.10 * $subtotal, 2, '.', '');
        $session->write('Cart.gst', $gst);

        // Total
        $session->write('Cart.total', number_format((float)$subtotal + $gst + $delivery, 2, '.', ''));

        $json['cart'] = $this->request->session()->read('Cart');
        $json['error'] = true;
        $this->set(compact('json'));

        //Send response in JSON.
        $this->set('_serialize', 'json');


    }

    /**
     * Paypal has sent a notification.
     *
     * @return void
     *
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function notify()
    {

        define("LOG_FILE", WWW_ROOT . "export.txt");
        define("DEBUG", 1);
        file_put_contents('export.txt', var_export($_POST, true));


        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        // Read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        /*
        * Post IPN data back to PayPal to validate the IPN data is genuine
        * Without this step anyone can fake IPN data
        */
        $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        $ch = curl_init($paypalURL);
        if ($ch == FALSE) {
            return FALSE;
        }
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        if (DEBUG == true) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }

        // Set TCP timeout to 30 seconds
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        $res = curl_exec($ch);
        if (curl_errno($ch) != 0) // cURL error
        {
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
            }
            curl_close($ch);
            exit;
        } else {
            // Log the entire HTTP response if debug is switched on.
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "HTTP request of validation request:" . curl_getinfo($ch, CURLINFO_HEADER_OUT) . " for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
                error_log(date('[Y-m-d H:i e] ') . "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
            }
            curl_close($ch);
        }

        /*
        * Inspect IPN validation result and act accordingly
        * Split response headers and payload, a better way for strcmp
        */
        $tokens = explode("\r\n\r\n", trim($res));
        $res = trim(end($tokens));
        if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {

            $myfile = fopen(LOG_FILE, "w") or die("Unable to open file!");
            fwrite($myfile, json_encode($_POST));
            fclose($myfile);
            if (!empty($_POST) && $_POST['payment_status'] == 'Completed') {

                $this->loadModel('Orders');
                $order = $this->Orders->get($_POST['custom']);
                if (!empty($order)) {

                    $transactionsTable = TableRegistry::get('Transactions');
                    $transactions = $transactionsTable->newEntity();
                    $transactions['order_id'] = $_POST['custom'];
                    $transactions['user_id'] = $order->user_id;
                    $transactions['tnx_id'] = $_POST['txn_id'];
                    $transactions['amount'] = $_POST['mc_gross'];
                    $transactions['payment_status'] = $_POST['payment_status'];
                    $transactions['created_date'] = date('Y-m-d H:i:s');

                    if ($transactionsTable->save($transactions)) {


                        $this->Orders->updateAll(['status' => 4], ['id' => $_POST['custom']]);

                        $order = $this->Orders->get($_POST['custom']);

                        $cart = $this->request->session()->read('Cart');
                        $viewVars = [
                            'tnx' => $_POST['txn_id'],
                            'amount' => $order['total'],
                            'payment_date' => date("Y-m-d h:i:s"),
                            'products' => $cart,
                        ];
                        /*
                            $email = new Email();
                            $email->profile('default')
                                ->template('payment', 'default')
                                ->emailFormat('html')
                                ->from(['brian@emoceanstudios.com.au' => 'INABIT' ])
                                ->to($order['total'])
                                ->subject('[INABIT] Payment Detail')
                                ->viewVars($viewVars)
                                ->send(); */


                        $session = $this->request->session();
                        $session->delete('Cart');


                    }


                }
            }
        }

        die("success");
    }


    public function test()
    {


        $this->loadComponent('Paypal');

        $response = $this->Paypal->_saveOrder();

        echo "<pre>";
        print_r($response);
        echo "</pre>";

        echo $response;
        die();

    }

    public function pay_order()
    {

        // if get = paypal or .... 

        $cart = $this->request->session()->read('Cart');
        $this->loadComponent('Transaction');

        // Need to get the price and the needed variables
        $price = Number::format($this->request->session()->read('Cart.total'), ['locale' => 'au_AU']);
        $tax = Number::format(0.00, ['locale' => 'au_AU']);
        $discountPercentage = null;

        $custom = [
            'user_id' => $this->request->session()->read('Auth.User.id'),
            'order_id' => ''
        ];

        $paypalUrl = $this->Transaction->getPaypalUrl(
            $price,
            $tax,
            'Payment Order',
            http_build_query($custom),
            $discountPercentage
        );

        if (!$paypalUrl) {
            $this->Flash->error("Unable to get the Paypal URL, please contact an administrator or try again later.");
            return $this->redirect(['controller' => 'checkout', 'action' => 'payment']);
        }

        $this->redirect($paypalUrl);

    }

    /**
     * A payment has been done.
     *
     * @return void
     */
    /* public function success(){

        if(isset($_POST['custom']) && !empty($_POST['custom'])){
            $this->loadModel('Orders');
            $session = $this->request->session();

            $this->Orders->updateAll(['status' => 4], ['id' => $_POST['custom']]);
            $order = $this->Orders->get($_POST['custom']);
            if(!empty($order))
            {
                $transactionsTable = TableRegistry::get('Transactions');
                $transactions = $transactionsTable->newEntity();
                $transactions['order_id'] = $_POST['custom'];
                $transactions['user_id'] = $order->user_id;
                $transactions['tnx_id'] = $_POST['txn_id'];
                $transactions['amount'] = $_POST['mc_gross'];
                $transactions['payment_status'] = $_POST['payment_status'];
                $transactions['created_date'] = date('Y-m-d H:i:s');

                if($transactionsTable->save($transactions))
                {
                    $cart = $this->request->session()->read('Cart');
                    $store_data = $this->request->session()->read('Cart.stores');
                    foreach($store_data as $value){
                        $stored = $value['store_id'];
                    }
                    $this->loadModel('UserProducts');
                    $user_product = $this->UserProducts
                                    ->find()
                                    ->contain(['Users'=>['fields'=>['Users.id','Users.first_name','Users.last_name']],'Shops'=>['fields'=>['Shops.id','Shops.name','Shops.shop_logo']],'Products'=>['fields'=>['Products.id','Products.name','Products.content','Products.hero','Products.price','Products.product_code','Products.merchant_id','Products.weight']]])
                                    ->where([
                                    'UserProducts.shop_id'=>$stored
                                    ])->toArray();
                    // pr($user_product);die;
                    $viewVars = [
                        'tnx' => $_POST['txn_id'],
                        'amount' => $order['total'],
                        'payment_date'=> date("Y-m-d h:i:s"),
                        'user_product'=> $user_product,
                        'products'=> $cart,
                    ];

                    $email = new Email();
                    $email->profile('default')
                        ->template('payment', 'default')
                        ->emailFormat('html')
                        ->from(['brian@emoceanstudios.com.au' => 'INABIT' ])
                        ->to($order['email'])
                        ->subject('[INABIT] Payment Detail')
                        ->viewVars($viewVars)
                        ->send();
                    $session->delete('Cart');
                }
            }
        }
    } */

    public function success()
    {

        $nvpReqArray = $this->request->session()->read();
        if (isset($nvpReqArray) && !empty($nvpReqArray)) {
            $transactionsTable = TableRegistry::get('Transactions');
            $transactions = $transactionsTable->newEntity();
            $transactions['user_id'] = $this->request->session()->read('Auth.User.id');
            $transactions['pay_key'] = $nvpReqArray['PAY_KEY'];
            $transactions['payment_email_id'] = $nvpReqArray['nvpReqArray']['receiverList.receiver(0).email'];
            $transactions['payment_primary_email_id'] = $nvpReqArray['nvpReqArray']['receiverList.receiver(1).email'];
            $transactions['order_id'] = $this->request->session()->read('Cart.order_id');
            $transactions['amount'] = $nvpReqArray['nvpReqArray']['receiverList.receiver(0).amount'];
            $transactions['primary_amount'] = $nvpReqArray['nvpReqArray']['receiverList.receiver(1).amount'];
            $transactions['tnx_id'] = $nvpReqArray['PAY_KEY'];
            $transactions['payment_status'] = 4;
            $transactions['created_date'] = date('Y-m-d H:i:s');
            if ($transactionsTable->save($transactions)) {
                $this->loadModel('Orders');
                $this->Orders->updateAll(['status' => 4], ['id' => $nvpReqArray['Cart']['order_id']]);
                $cart = $this->request->session()->read('Cart');
                $order = $this->Orders->get($nvpReqArray['Cart']['order_id']);
                $store_data = $this->request->session()->read('Cart.stores');
                foreach ($store_data as $value) {
                    $stored = $value['store_id'];
                }
                $this->loadModel('UserProducts');
                $user_product = $this->UserProducts
                    ->find()
                    ->contain(['Users' => ['fields' => ['Users.id', 'Users.first_name', 'Users.last_name']], 'Shops' => ['fields' => ['Shops.id', 'Shops.name', 'Shops.shop_logo']], 'Products' => ['fields' => ['Products.id', 'Products.name', 'Products.content', 'Products.hero', 'Products.price', 'Products.product_code', 'Products.merchant_id', 'Products.weight']]])
                    ->where([
                        'UserProducts.shop_id' => $stored
                    ])->toArray();
                $viewVars = [
                    'tnx' => $nvpReqArray['PAY_KEY'],
                    'amount' => $order['total'],
                    'payment_date' => date("Y-m-d h:i:s"),
                    'user_product' => $user_product,
                    'products' => $cart,
                ];
                $email = new Email();
                $email->profile('default')
                    ->template('payment', 'default')
                    ->emailFormat('html')
                    ->from(['brian@emoceanstudios.com.au' => 'INABIT'])
                    ->to($order['email'])
                    ->subject('[INABIT] Payment Detail')
                    ->viewVars($viewVars)
                    ->send();
                $session = $this->request->session();
                $session->delete('Cart');

            }

        }
    }

    public function cancel()
    {

        $this->redirect(['controller' => 'cart', 'action' => 'index']);

    }


}