<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

class CheckoutController extends AppController
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
        $this->Auth->allow(['index']);
    }

    public function index()
    {

        // Current Logged User
        $this->loadModel('Users');
        $user = $this->Users->get($this->Auth->user('id'));
        $options_states = array(
            'New South Wales',
            'Northern Territory',
            'Victoria',
            'Queensland',
            'Western Australia',
            'South Australia',
            'Australian Capital Territory',
            'Tasmania'
        );
        if ($this->request->is('put')) {

            $this->Users->patchEntity($user, $this->request->data(), ['validate' => 'billingaccount']);

            if ($this->Users->save($user)) {
                $session = $this->request->session();
                // Billing
                $session->write('Cart.user_billing.address', $user->billing_address);
                $session->write('Cart.user_billing.suburb', $user->billing_suburb);
                $session->write('Cart.user_billing.state', $user->billing_state);
                $session->write('Cart.user_billing.post_code', $user->billing_post_code);
                // Delivery
                $session->write('Cart.user_delivery.address', $user->delivery_address);
                $session->write('Cart.user_delivery.suburb', $user->delivery_suburb);
                $session->write('Cart.user_delivery.state', $user->delivery_state);
                $session->write('Cart.user_delivery.post_code', $user->delivery_post_code);

                return $this->redirect(['controller' => 'checkout', 'action' => 'preview_order']);

            }

        }

        // Get the cart of the user
        $cart = $this->request->session()->read('Cart');
        $this->set(compact('cart', 'user', 'options_states'));


    }

    public function payment()
    {

        // Get the cart of the user
        $cart = $this->request->session()->read('Cart');
        $order_id= $cart['order_id'];
        $this->LoadModel('Orders');
        $order=$this->Orders
            ->find()
            ->where(['id'=>$order_id])
            ->first();
        $this->set(compact('cart', 'order'));
    }


    public function chainpay($mentor_id = null)
    {

        $this->loadModel('Settings');
        $this->loadModel('Orders');
        $setting = $this->Settings
            ->find()
            ->first();

        $cart = $this->request->session()->read('Cart');


        if (isset($cart['order_id']) && !empty($cart['order_id'])) {

            $order_data = $this->Orders
                ->find()
                ->where([
                    'id' => $cart['order_id']
                ])->first();


            $this->loadModel('Users');
            $user = $this->Users
                ->find()
                ->where([
                    'id' => $order_data->merchant_id
                ])
                ->first();

        }

        $myNumber = $cart['total'];
        $percentToGet = $setting['paypal_fees_value'];

        //Convert our percentage value into a decimal.
        $percentInDecimal = $percentToGet / 100;
        //Get the result.
        $adminAmount = $percentInDecimal * $myNumber;
        $totalPaidAmount = $cart['total'] - $adminAmount;
        $mentor_id = 2;
        /* 	$this->loadModel('User');
        $this->loadModel('UserProfile');
        $this->User->bindModel(array('hasOne'=>array('UserProfile')));
        $this->User->recursive = 3;
        $mentor_data = $this->User->read(null, $mentor_id); */
        $errors = '';
        $student_id = 1;
        include('Adaptive/Paypalplatform.php');
        // App::import('Vendor','Adaptive/Paypalplatform');
        $actionType = "PAY";
        $cancelUrl = "http://imagine.emoceanlab.com.au/cart/cancel";    // TODO - If you are not executing the Pay call for a preapproval,
        //        then you must set a valid cancelUrl for the web approval flow
        //        that immediately follows this Pay call
        $returnUrl = "http://imagine.emoceanlab.com.au/cart/success";
        //http://192.168.1.69/adaptive/return.php";	// TODO - If you are not executing the Pay call for a preapproval,
        //        then you must set a valid returnUrl for the web approval flow
        //        that immediately follows this Pay call
        $currencyCode = "USD";

        // A parallel payment can be made among two to six receivers
        // TODO - specify the receiver emails
        //        remove or set to an empty string the array entries for receivers that you do not have


        $receiverEmailArray = [
            $user['paypal_business_email'],
            $setting['paypal_email']
        ];

        // TODO - specify the receiver amounts as the amount of money, for example, '5' or '5.55'
        //        remove or set to an empty string the array entries for receivers that you do not have


        $receiverAmountArray = [
            round($totalPaidAmount, 2),
            round($adminAmount, 2)
        ];
        // pr($receiverAmountArray);die;
        // for parallel payment, no primary indicators are needed, so set empty array
        $receiverPrimaryArray = [true, false];

        // TODO - Set invoiceId to uniquely identify the transaction associated with each receiver
        //        set the array entries with value for receivers that you have
        //		  each of the array values must be unique
        $receiverInvoiceIdArray = [
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        // Request specific optional fields
        //   Provide a value for each field that you want to include in the request, if left as an empty string the field will not be passed in the request
        $senderEmail = "";        // TODO - If you are executing the Pay call against a preapprovalKey, you should set senderEmail
        //        It is not required if the web approval flow immediately follows this Pay call
        $feesPayer = "EACHRECEIVER";
        //$ipnNotificationUrl				= SITE_URL."mentors/thanks_ipn/success";
        $ipnNotificationUrl = "http://imagine.emoceanlab.com.au/cart/notify";
        // $ipnNotificationUrl				= "http://imagine.emoceanlab.com.au/checkout/ipn/".$student_id."/".$mentor_id;
        $memo = $mentor_id;        // maxlength is 1000 characters
        $pin = "";        // TODO - If you are executing the Pay call against an existing preapproval
        //        the requires a pin, then you must set this
        $preapprovalKey = "";        // TODO - If you are executing the Pay call against an existing preapproval, set the preapprovalKey here
        $reverseAllParallelPaymentsOnError = "";    // TODO - Set this to "true" if you would like each parallel payment to be reversed if an error occurs
        //        defaults to "false" if you don't specify
        $trackingId = generateTrackingID();    // generateTrackingID function is found in paypalplatform.php

        //-------------------------------------------------
        // Make the Pay API call
        //
        // The CallPay function is defined in the paypalplatform.php file,
        // which is included at the top of this file.
        //-------------------------------------------------
        //echo $trackingId;die;
        $resArray = CallPay($actionType, $cancelUrl, $returnUrl, $currencyCode, $receiverEmailArray,
            $receiverAmountArray, $receiverPrimaryArray, $receiverInvoiceIdArray,
            $feesPayer, $ipnNotificationUrl, $memo, $pin, $preapprovalKey,
            $reverseAllParallelPaymentsOnError, $senderEmail, $trackingId
        );
        //pr($receiverEmailArray);
        // pr($resArray);die('test');
        $ack = strtoupper($resArray["responseEnvelope.ack"]);
        if ($ack == "SUCCESS") {
            if ("" == $preapprovalKey) {
                $session = $this->request->session();
                $session->write('PAY_KEY', urldecode($resArray["payKey"]));
                $save_data['paykey'] = "'" . urldecode($resArray["payKey"]) . "'";
                // $this->UserProfile->updateAll($save_data,array('UserProfile.user_id'=>$mentor_id));
                //$_SESSION['PAY_KEY']			=		urldecode($resArray["payKey"]);
                $cmd = "cmd=_ap-payment&paykey=" . urldecode($resArray["payKey"]);
                RedirectToPayPal($cmd);
            } else {
                // payKey is the key that you can use to identify the result from this Pay call
                $payKey = urldecode($resArray["payKey"]);
                // paymentExecStatus is the status of the payment
                $paymentExecStatus = urldecode($resArray["paymentExecStatus"]);
            }
        } else {
            //Display a user friendly Error on the page using any of the following error information returned by PayPal
            //TODO - There can be more than 1 error, so check for "error(1).errorId", then "error(2).errorId", and so on until you find no more errors.
            $ErrorCode = urldecode($resArray["error(0).errorId"]);
            $ErrorMsg = urldecode($resArray["error(0).message"]);
            $ErrorDomain = urldecode($resArray["error(0).domain"]);
            $ErrorSeverity = urldecode($resArray["error(0).severity"]);
            $ErrorCategory = urldecode($resArray["error(0).category"]);

            $errors = "Preapproval API call failed.<br> ";
            $errors .= "Detailed Error Message: " . $ErrorMsg . ".<br>";
            $errors .= "Error Code: " . $ErrorCode . ".<br>";
            $errors .= "Error Severity: " . $ErrorSeverity . ".<br>";
            $errors .= "Error Domain: " . $ErrorDomain . ".<br>";
            $errors .= "Error Category: " . $ErrorCategory . ".<br>";
        }
        $this->set('errors', $errors);

    }


    public function payment_by_paypal($mentor_id = null)
    {

        $mentor_id = 2;
        $this->loadModel('Settings');
        $this->loadModel('Orders');
        $setting = $this->Settings
            ->find()
            ->first();
        /* 	$this->loadModel('User');
            $this->loadModel('UserProfile');
            $this->User->bindModel(array('hasOne'=>array('UserProfile')));
            $this->User->recursive = 3;
            $mentor_data = $this->User->read(null, $mentor_id); */
        $cart = $this->request->session()->read('Cart');
        if (isset($cart['order_id']) && !empty($cart['order_id'])) {

            $order_data = $this->Orders
                ->find()
                ->where([
                    'id' => $cart['order_id']
                ])->first();


            $this->loadModel('Users');
            $user = $this->Users
                ->find()
                ->where([
                    'id' => $order_data->merchant_id
                ])
                ->first();

        }
        $errors = '';
        $student_id = 1;
        include('Adaptive/Paypalplatform.php');
        // App::import('Vendor','Adaptive/Paypalplatform');
        $actionType			= "PAY";
        $cancelUrl			= "http://imagine.emoceanlab.com.au/cart/cancel";	// TODO - If you are not executing the Pay call for a preapproval,
        //        then you must set a valid cancelUrl for the web approval flow
        //        that immediately follows this Pay call
        $returnUrl			= "http://imagine.emoceanlab.com.au/cart/success";
        //http://192.168.1.69/adaptive/return.php";	// TODO - If you are not executing the Pay call for a preapproval,
        //        then you must set a valid returnUrl for the web approval flow
        //        that immediately follows this Pay call
        $currencyCode		= "USD";

        // A parallel payment can be made among two to six receivers
        // TODO - specify the receiver emails
        //        remove or set to an empty string the array entries for receivers that you do not have
        $receiverEmailArray	= [
            $user['paypal_business_email'],
            $setting['paypal_email']
        ];

        // TODO - specify the receiver amounts as the amount of money, for example, '5' or '5.55'
        //        remove or set to an empty string the array entries for receivers that you do not have
        $Total = $cart['total'];
        $percentToGet = $setting['paypal_fees_value'];

        //Convert our percentage value into a decimal.
        $percentInDecimal = $percentToGet / 100;
        //Get the result.
        $adminAmount = $percentInDecimal * $Total;
        $totalPaidAmount = $cart['total'] - $adminAmount;
//        $adminAmount = (10 * (15 / 100));
        $mentorAmount = 10;

        $receiverAmountArray = [
            $totalPaidAmount,
            $adminAmount
        ];

        $receiverAmountArray = [
            $mentorAmount,
            $adminAmount
        ];
//pr($receiverAmountArray);die;
        // for parallel payment, no primary indicators are needed, so set empty array
        $receiverPrimaryArray = [true, false];

        // TODO - Set invoiceId to uniquely identify the transaction associated with each receiver
        //        set the array entries with value for receivers that you have
        //		  each of the array values must be unique
        $receiverInvoiceIdArray = [
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        // Request specific optional fields
        //   Provide a value for each field that you want to include in the request, if left as an empty string the field will not be passed in the request
        $senderEmail = "";        // TODO - If you are executing the Pay call against a preapprovalKey, you should set senderEmail
        //        It is not required if the web approval flow immediately follows this Pay call
        $feesPayer = "EACHRECEIVER";
        //$ipnNotificationUrl				= SITE_URL."mentors/thanks_ipn/success";
//        $ipnNotificationUrl = "http://imagine.emoceanlab.com.au/checkout/ipn/" . $student_id . "/" . $mentor_id;
        $ipnNotificationUrl = "http://imagine.emoceanlab.com.au/cart/notify";
        $memo = $mentor_id;        // maxlength is 1000 characters
        $pin = "";        // TODO - If you are executing the Pay call against an existing preapproval
        //        the requires a pin, then you must set this
        $preapprovalKey = "";        // TODO - If you are executing the Pay call against an existing preapproval, set the preapprovalKey here
        $reverseAllParallelPaymentsOnError = "";    // TODO - Set this to "true" if you would like each parallel payment to be reversed if an error occurs
        //        defaults to "false" if you don't specify
        $trackingId = generateTrackingID();    // generateTrackingID function is found in paypalplatform.php

        //-------------------------------------------------
        // Make the Pay API call
        //
        // The CallPay function is defined in the paypalplatform.php file,
        // which is included at the top of this file.
        //-------------------------------------------------
        //echo $trackingId;die;
        $resArray = CallPay($actionType, $cancelUrl, $returnUrl, $currencyCode, $receiverEmailArray,
            $receiverAmountArray, $receiverPrimaryArray, $receiverInvoiceIdArray,
            $feesPayer, $ipnNotificationUrl, $memo, $pin, $preapprovalKey,
            $reverseAllParallelPaymentsOnError, $senderEmail, $trackingId
        );
        //pr($receiverEmailArray);
        //pr($resArray);die('test');
        $ack = strtoupper($resArray["responseEnvelope.ack"]);
        if ($ack == "SUCCESS") {
            if ("" == $preapprovalKey) {
                // redirect for web approval flow


                // pr($resArray["payKey"]);die;
                $session = $this->request->session();
                $session->write('PAY_KEY', urldecode($resArray["payKey"]));
                $save_data['paykey'] = "'" . urldecode($resArray["payKey"]) . "'";
                // $this->UserProfile->updateAll($save_data,array('UserProfile.user_id'=>$mentor_id));
                //$_SESSION['PAY_KEY']			=		urldecode($resArray["payKey"]);
                $cmd = "cmd=_ap-payment&paykey=" . urldecode($resArray["payKey"]);
                RedirectToPayPal($cmd);
            } else {
                // payKey is the key that you can use to identify the result from this Pay call
                $payKey = urldecode($resArray["payKey"]);
                // paymentExecStatus is the status of the payment
                $paymentExecStatus = urldecode($resArray["paymentExecStatus"]);
            }
        } else {
            //Display a user friendly Error on the page using any of the following error information returned by PayPal
            //TODO - There can be more than 1 error, so check for "error(1).errorId", then "error(2).errorId", and so on until you find no more errors.
            $ErrorCode = urldecode($resArray["error(0).errorId"]);
            $ErrorMsg = urldecode($resArray["error(0).message"]);
            $ErrorDomain = urldecode($resArray["error(0).domain"]);
            $ErrorSeverity = urldecode($resArray["error(0).severity"]);
            $ErrorCategory = urldecode($resArray["error(0).category"]);

            $errors = "Preapproval API call failed.<br> ";
            $errors .= "Detailed Error Message: " . $ErrorMsg . ".<br>";
            $errors .= "Error Code: " . $ErrorCode . ".<br>";
            $errors .= "Error Severity: " . $ErrorSeverity . ".<br>";
            $errors .= "Error Domain: " . $ErrorDomain . ".<br>";
            $errors .= "Error Category: " . $ErrorCategory . ".<br>";
        }
        $this->set('errors', $errors);
    }


    public function preview_order()
    {

        if (!empty($this->request->session()->read('Cart'))) {
            $cart_data = $this->request->session()->read('Cart');
            $this->set(compact('cart_data', 'user'));
        }
        $this->loadModel('UserProducts');
        $store_data = $this->request->session()->read('Cart.stores');
        foreach ($store_data as $value) {
            $stored = $value['store_id'];
        }
        $this->loadModel('Orders');
        $this->loadModel('OrderProducts');
        $newOrder = $this->Orders->newEntity($this->request->data);

        if ($this->request->is('post')) {

            // User Details
            $newOrder->first_name = $this->Auth->user('first_name');
            $newOrder->last_name = $this->Auth->user('last_name');
            $newOrder->email = $this->Auth->user('email');
            //If phone number is always required, this field is available.
            //validation is important.
            $newOrder->phone = 0000;
            $newOrder->user_id = $this->Auth->user('id');
            // Save User Billing Details
            $newOrder->billing_address = $this->request->session()->read('Cart.user_billing.address');
            $newOrder->billing_suburb = $this->request->session()->read('Cart.user_billing.suburb');
            $newOrder->billing_state = $this->request->session()->read('Cart.user_billing.state');
            $newOrder->billing_post_code = $this->request->session()->read('Cart.user_billing.post_code');

            // Save User Delivery Details
            $newOrder->delivery_address = $this->request->session()->read('Cart.user_delivery.address');
            $newOrder->delivery_suburb = $this->request->session()->read('Cart.user_delivery.suburb');
            $newOrder->delivery_state = $this->request->session()->read('Cart.user_delivery.state');
            $newOrder->delivery_post_code = $this->request->session()->read('Cart.user_delivery.post_code');

            // Amount
            $newOrder->subtotal = $this->request->session()->read('Cart.subtotal');
            $newOrder->gst = $this->request->session()->read('Cart.gst');
            $newOrder->total = $this->request->session()->read('Cart.total');

            // Delivery Method Name & Price
            $newOrder->delivery_method_name = $this->request->session()->read('Cart.delivery.name');
            $newOrder->delivery_method_price = $this->request->session()->read('Cart.delivery.price');
            $newOrder->shop_id = $stored;

            $this->loadModel('UserProducts');
            $marchant_user = $this->UserProducts
                ->find()
                ->where([
                    'UserProducts.shop_id' => $stored
                ])->first();

            if (isset($marchant_user['user_id']) && !empty($marchant_user['user_id'])) {
                $newOrder->merchant_id = $marchant_user['user_id'];

            }

            if ($result = $this->Orders->save($newOrder)) {
                $session = $this->request->session();
                $session->write('Cart.order_id', $result->id);
                $error = 0;
            } else {
                $error = 1;
            }

            // Now Save Products if the order has been previously saved
            if ($error == 0) {
                $products = $this->UserProducts
                    ->find()
                    ->contain(['Users' => ['fields' => ['Users.id', 'Users.first_name', 'Users.last_name']], 'Shops' => ['fields' => ['Shops.id', 'Shops.name', 'Shops.shop_logo']], 'Products' => ['fields' => ['Products.id', 'Products.name', 'Products.content', 'Products.hero', 'Products.price', 'Products.price', 'Products.product_code', 'Products.merchant_id', 'Products.weight']]])
                    ->where([
                        'UserProducts.shop_id' => $stored
                    ])->toArray();
//			foreach ($products as $k => $v) {
                foreach ($this->request->session()->read('Cart.products') as $k => $v) {
                    $newOrderProduct = $this->Orders->newEntity();
                    $newOrderProduct->id = '';
                    $newOrderProduct->product_id = $v['id'];
                    $newOrderProduct->order_id = $newOrder['id'];
                    $newOrderProduct->product_code = $v['product_code'];
                    $newOrderProduct->name = $v['name'];
                    $newOrderProduct->price = $v['price'];
                    $newOrderProduct->qty = 1;
                    $newOrderProduct->store_id = $v['store_id'];
                    $newOrderProduct->merchant_id = $v['merchant_id'];
                    $this->OrderProducts->save($newOrderProduct);
                }
                // die;
                /*
                    foreach ($this->request->session()->read('Cart.products') as $k => $v) {

                        $newOrderProduct = $this->Orders->newEntity($v);
                        $newOrderProduct->id = '';
                        $newOrderProduct->product_id = $v['id'];
                        $newOrderProduct->order_id = $newOrder['id'];
                        $newOrderProduct->product_code = $v['product_code'];
                        $newOrderProduct->shop_id = $v['store_id'];

                        // Save the product in the order products table
                        $this->OrderProducts->save($newOrderProduct);

                    } */

            }

            if ($error == 0) {
                // The order has been successfuly placed, a redirection needs to be made
                return $this->redirect(['controller' => 'checkout', 'action' => 'payment', 'order_id'=>$newOrder['id']]);
            }
        }
        // Get the cart of the user
        $cart = $this->request->session()->read('Cart');
        $this->set(compact('cart', 'newOrder'));

    }


}