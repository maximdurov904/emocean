<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\I18n\Number;
use Mexitek\PHPColors\Color;
use Widop\GoogleAnalytics\Client;
use Widop\GoogleAnalytics\Query;
use Widop\GoogleAnalytics\Service;
use Widop\HttpAdapter\CurlHttpAdapter;

class AdminController extends AppController
{

    /**
     * Index page.
     *
     * @return void
     */
    public function home()
    {
        $this->loadModel('OrderProducts');

        $odr_row_data = $this->OrderProducts
            ->find()
            ->order([
                'OrderProducts.id' => 'desc'
            ])->first();
        $date = new \DateTime();
        $current_date = isset($odr_row_data)?$odr_row_data->created->format('Y-m-d'):$date->format('Y-m-d');

        $this->loadModel('Shops');
        $shopsData = $this->Shops
            ->find()
            ->where([
                // 'Shops.is_display' => 1,
            ])
            ->order([
                'Shops.id' => 'DESC'
            ]);
        // ->limit('5');
        // echo'<pre>';print_r($shopsData);die;
        $start_date = date('Y-m-d', strtotime('-100 days', strtotime($current_date)));
        $end_date = $current_date;
        $query = $this->OrderProducts->find('all')
            ->where(function ($exp, $q) use ($start_date, $end_date) {
                return $exp->between('created', $start_date, $end_date);
            });
        $result = $query->toArray();
        foreach ($result as $key => $value) {
            $prices[] = $value->price;
        }
        if (isset($prices) && !empty($prices)) {

            $graph_value = implode(",", $prices);

        } else {

            $graph_value = 0;

        }


        $orderData = $this->OrderProducts->find();
        $overAllSale = '';
        foreach ($orderData as $value) {
            $overAllSale += $value->price;
        }
        $overallPercentag = $overAllSale / 100 * 10;

        $overAllProfits = floor($overAllSale / 100 * 5);
        $overAllSale = floor($overAllSale);

        $todayOrderData = $this->OrderProducts
            ->find()
            ->where([
                'DATEDIFF(NOW(),OrderProducts.created)' => 0,
            ]);

        $todaySale = '';
        foreach ($todayOrderData as $value) {
            $todaySale += $value->price;
        }

        $todayPercentag = $todaySale / 100 * 10;

        $totalAmount = '';
        foreach ($todayOrderData as $val) {
            $totalAmount += $val->price;
        }

        $this->set(compact('graph_value', 'overAllSale', 'overAllProfits', 'shopsData', 'todaySale', 'totalAmount', 'todayPercentag', 'overallPercentag'));


        // Visitors Count
        if (Configure::read('Analytics.enabled') === true) {
            $httpAdapter = new CurlHttpAdapter();
            $client = new Client(Configure::read('Analytics.client_id'), Configure::read('Analytics.private_key'), $httpAdapter);
            $service = new Service($client);
            $statistics = Cache::remember('statistics', function () use ($service) {
                $statistics = new Query(Configure::read('Analytics.profile_id'));
                $statistics
                    ->setStartDate(new \DateTime(Configure::read('Analytics.start_date')))
                    ->setEndDate(new \DateTime())
                    ->setMetrics([
                        'ga:visits', 'ga:visitors', 'ga:pageviews', 'ga:pageviewsPerVisit',
                        'ga:avgtimeOnSite', 'ga:visitBounceRate', 'ga:percentNewVisits'
                    ]);
                return $service->query($statistics);
            }, 'analytics');

            $browsers = Cache::remember('browsers', function () use ($service) {
                $browsers = new Query(Configure::read('Analytics.profile_id'));
                $browsers
                    ->setStartDate(new \DateTime(Configure::read('Analytics.start_date')))
                    ->setEndDate(new \DateTime())
                    ->setDimensions(['ga:browser'])
                    ->setMetrics(['ga:pageviews'])
                    ->setSorts(['ga:pageviews'])
                    ->setFilters(['ga:browser==Chrome,ga:browser==Firefox,ga:browser==Internet Explorer,ga:browser==Safari,ga:browser==Opera']);
                return $service->query($browsers);
            }, 'analytics');
            $continents = Cache::remember('continents', function () use ($service) {
                $continentsRows = new Query(Configure::read('Analytics.profile_id'));
                $continentsRows
                    ->setStartDate(new \DateTime(Configure::read('Analytics.start_date')))
                    ->setEndDate(new \DateTime())
                    ->setDimensions(['ga:continent'])
                    ->setMetrics(['ga:visitors'])
                    ->setSorts(['ga:visitors'])
                    ->setFilters(['ga:continent==Africa,ga:continent==Americas,ga:continent==Asia,ga:continent==Europe,ga:continent==Oceania']);
                $continentsRows = $service->query($continentsRows);
                $color = new Color("1abc9c");
                $light = 1;
                $continents = [];
                foreach (array_reverse($continentsRows->getRows()) as $continentRow) {
                    $continent = [];
                    $continent['label'] = $continentRow[0];
                    $continent['data'] = $continentRow[1];
                    $continent['color'] = '#' . $color->lighten($light);
                    array_push($continents, $continent);
                    $light += 10;
                }
                return $continents;
            }, 'analytics');
            $graphVisitors = Cache::remember('graphVisitors', function () use ($service) {
                $graphVisitors = new Query(Configure::read('Analytics.profile_id'));
                $graphVisitors
                    ->setStartDate(new \DateTime('-7 days'))
                    ->setEndDate(new \DateTime())
                    ->setDimensions(['ga:date'])
                    ->setMetrics(['ga:visits', 'ga:pageviews'])
                    ->setSorts(['ga:date']);
                return $service->query($graphVisitors);
            }, 'analytics');
            $this->set(compact('statistics', 'browsers', 'continents', 'graphVisitors'));
        }

        // Products Count
        $this->loadModel('Products');
        $productsCount = Number::format($this->Products->find()->count());
        $this->set(compact('productsCount'));

        // Users Count
        $this->loadModel('Users');
        $usersCount = Number::format($this->Users->find()->count());
        $this->set(compact('usersCount'));

        // Transactions Count
        $this->loadModel('Transactions');
        $transactionsCount = Number::format($this->Transactions->find()->count());
        $this->set(compact('transactionsCount'));

        // Orders Count
        $this->loadModel('Orders');
        $ordersCount = Number::format($this->Orders->find()->count());
        $this->set(compact('ordersCount'));


    }

    public function chart()
    {
        $this->autoRender = false;
        $json = array();
        $json['order'] = array();
        $json['customer'] = array();
        $json['xaxis'] = array();
        $json['order']['label'] = "Orders";
        $json['customer']['label'] = "Customers";
        $json['order']['data'] = array();
        $json['customer']['data'] = array();
        $this->loadModel('OrderProducts');

        $order_data = array();
        if (isset($this->request->query['range'])) {
            $range = $this->request->query['range'];
        } else {
            $range = 'day';
        }
        switch ($range) {
            default:
            case 'day':


                for ($i = 0; $i < 24; $i++) {
                    $order_data[$i] = array(
                        'hour' => $i,
                        'total' => 0
                    );
                }

                $query = $this->OrderProducts->find('all', array('conditions' => array('date(created)' => 'CURDATE()')));

                $results = $query->toArray();
                foreach ($results as $result) {
                    $order_data[$result['hour']] = array(
                        'hour' => $result['hour'],
                        'total' => $result['total']
                    );
                }
                $query = $this->OrderProducts->find('all', array('conditions' => array('date(created)' => 'CURDATE()')));

                $results = $query->toArray();
                foreach ($results as $key => $value) {
                    $json['order']['data'][] = array($key, $value['total']);
                }
//
                $query = $this->OrderProducts->find('all', array('conditions' => array('date(created)' => 'CURDATE()')));

                $results = $query->toArray();
                foreach ($results as $key => $value) {
                    $json['customer']['data'][] = array($key, $value['total']);
                }

                for ($i = 0; $i < 24; $i++) {
                    $json['xaxis'][] = array($i, $i);
                }
                break;
            case 'week':
                $date_start = strtotime('-' . date('w') . ' days');
                for ($i = 0; $i < 7; $i++) {
                    $date = date('Y-m-d', $date_start + ($i * 86400));

                    $order_data[date('w', strtotime($date))] = array(
                        'day'   => date('D', strtotime($date)),
                        'total' => 0
                    );
                }
                $query = $this->OrderProducts->find('all', array('conditions' => array('date(created)' => 'CURDATE()')));

                $results = $query->toArray();

                break;
            case 'month':
                break;
            case 'year':
                break;
        }
        if ($this->request->is('ajax')) {
            $this->response->disableCache();
            $this->response->body(json_encode($json));
        }

    }
}
