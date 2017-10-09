<?= $this->Html->script(['front/highcharts.js']); ?>
<?= $this->Html->script(['front/exporting.js']); ?>

<?= $this->Html->css(['front/chart.css']); ?>
<?php use Cake\Routing\Router; ?>
<div class="page animsition" style="animation-duration: 0.8s; opacity: 1;">
    <div class="page-header height-296 margin-bottom-30"
         style="background-image: url('http://imagine.emoceanlab.com.au/img/admin/dashboard2-header.jpg');">
        <div class="text-center blue-grey-800 margin-top-80">
            <div class="font-size-50 margin-bottom-30 blue-grey-800">
                Welcome <?= $this->request->session()->read('Auth.User.first_name') ?> <?= $this->request->session()->read('Auth.User.last_name') ?></div>
        </div>
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-md-3">
                <div class="panel" style="min-height: 495px;">
                    <header class="panel-heading">
                        <div class="panel-actions"></div>
                        <h3 class="panel-title">Top 5 Merchant <span style="color: #ffa500;float: right;">
					<?php
                    $total = 0;
                    foreach ($shopsData as $value) { ?>
                        <?php if (!empty($this->Shop->countProductPrice($value->id))) { ?>

                            <?php $total += $this->Shop->countProductPrice($value->id); ?>

                        <?php } ?>
                    <?php }
                    echo('$'.$total);?>
                    </span></h3>
                    </header>
                    <div class="panel-body">
                        <div id="DataTables_Table_0_wrapper"
                             class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <!-- MAP & BOX PANE -->
                            <div class="box box-success" style="display: none;">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Visitors Report</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- DIRECT CHAT -->
                                    <div class="box box-warning direct-chat direct-chat-warning" style="display: none;">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Direct Chat</h3>

                                            <div class="box-tools pull-right">
                                                <span data-toggle="tooltip" title="3 New Messages"
                                                      class="badge bg-yellow">3</span>
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                        class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
                                                        title="Contacts" data-widget="chat-pane-toggle">
                                                    <i class="fa fa-comments"></i></button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                        class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <!-- Conversations are loaded here -->
                                            <div class="direct-chat-messages">
                                                <!-- Message. Default to the left -->
                                                <div class="direct-chat-msg">
                                                    <div class="direct-chat-info clearfix">
                                                        <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                                        <span
                                                            class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                                    </div>
                                                    <!-- /.direct-chat-info -->
                                                    <img class="direct-chat-img" src="dist/img/user1-128x128.jpg"
                                                         alt="message user image"><!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text">
                                                        Is this template really for free? That's unbelievable!
                                                    </div>
                                                    <!-- /.direct-chat-text -->
                                                </div>
                                                <!-- /.direct-chat-msg -->

                                                <!-- Message to the right -->
                                                <div class="direct-chat-msg right">
                                                    <div class="direct-chat-info clearfix">
                                                        <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                                        <span
                                                            class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                                    </div>
                                                    <!-- /.direct-chat-info -->
                                                    <img class="direct-chat-img" src="dist/img/user3-128x128.jpg"
                                                         alt="message user image"><!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text">
                                                        You better believe it!
                                                    </div>
                                                    <!-- /.direct-chat-text -->
                                                </div>
                                                <!-- /.direct-chat-msg -->

                                                <!-- Message. Default to the left -->
                                                <div class="direct-chat-msg">
                                                    <div class="direct-chat-info clearfix">
                                                        <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                                        <span
                                                            class="direct-chat-timestamp pull-right">23 Jan 5:37 pm</span>
                                                    </div>
                                                    <!-- /.direct-chat-info -->
                                                    <img class="direct-chat-img" src="dist/img/user1-128x128.jpg"
                                                         alt="message user image"><!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text">
                                                        Working with AdminLTE on a great new app! Wanna join?
                                                    </div>
                                                    <!-- /.direct-chat-text -->
                                                </div>
                                                <!-- /.direct-chat-msg -->

                                                <!-- Message to the right -->
                                                <div class="direct-chat-msg right">
                                                    <div class="direct-chat-info clearfix">
                                                        <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                                        <span
                                                            class="direct-chat-timestamp pull-left">23 Jan 6:10 pm</span>
                                                    </div>
                                                    <!-- /.direct-chat-info -->
                                                    <img class="direct-chat-img" src="dist/img/user3-128x128.jpg"
                                                         alt="message user image"><!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text">
                                                        I would love to.
                                                    </div>
                                                    <!-- /.direct-chat-text -->
                                                </div>
                                                <!-- /.direct-chat-msg -->

                                            </div>
                                            <!--/.direct-chat-messages-->

                                            <!-- Contacts are loaded here -->
                                            <div class="direct-chat-contacts">
                                                <ul class="contacts-list">
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                 src="dist/img/user1-128x128.jpg" alt="User Image">

                                                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Count Dracula
                                  <small class="contacts-list-date pull-right">2/28/2015</small>
                                </span>
                                                                <span class="contacts-list-msg">How have you been? I was...</span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                 src="dist/img/user7-128x128.jpg" alt="User Image">

                                                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Sarah Doe
                                  <small class="contacts-list-date pull-right">2/23/2015</small>
                                </span>
                                                                <span
                                                                    class="contacts-list-msg">I will be waiting for...</span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                 src="dist/img/user3-128x128.jpg" alt="User Image">

                                                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Nadia Jolie
                                  <small class="contacts-list-date pull-right">2/20/2015</small>
                                </span>
                                                                <span
                                                                    class="contacts-list-msg">I'll call you back at...</span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                 src="dist/img/user5-128x128.jpg" alt="User Image">

                                                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Nora S. Vans
                                  <small class="contacts-list-date pull-right">2/10/2015</small>
                                </span>
                                                                <span
                                                                    class="contacts-list-msg">Where is your new...</span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                 src="dist/img/user6-128x128.jpg" alt="User Image">

                                                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  John K.
                                  <small class="contacts-list-date pull-right">1/27/2015</small>
                                </span>
                                                                <span
                                                                    class="contacts-list-msg">Can I take a look at...</span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                 src="dist/img/user8-128x128.jpg" alt="User Image">

                                                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Kenneth M.
                                  <small class="contacts-list-date pull-right">1/4/2015</small>
                                </span>
                                                                <span
                                                                    class="contacts-list-msg">Never mind I found...</span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                </ul>
                                                <!-- /.contatcts-list -->
                                            </div>
                                            <!-- /.direct-chat-pane -->
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer">
                                            <form action="#" method="post">
                                                <div class="input-group">
                                                    <input name="message" placeholder="Type Message ..."
                                                           class="form-control" type="text">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-warning btn-flat">Send</button>
                          </span>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.box-footer-->
                                    </div>
                                    <!--/.direct-chat -->
                                </div>
                                <!-- /.col -->

                                <div class="col-md-6">
                                    <!-- USERS LIST -->
                                    <div class="box box-danger" style="display: none;">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Latest Members</h3>

                                            <div class="box-tools pull-right">
                                                <span class="label label-danger">8 New Members</span>
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                        class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                        class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body no-padding">
                                            <ul class="users-list clearfix">
                                                <li>
                                                    <img src="dist/img/user1-128x128.jpg" alt="User Image">
                                                    <a class="users-list-name" href="#">Alexander Pierce</a>
                                                    <span class="users-list-date">Today</span>
                                                </li>
                                                <li>
                                                    <img src="dist/img/user8-128x128.jpg" alt="User Image">
                                                    <a class="users-list-name" href="#">Norman</a>
                                                    <span class="users-list-date">Yesterday</span>
                                                </li>
                                                <li>
                                                    <img src="dist/img/user7-128x128.jpg" alt="User Image">
                                                    <a class="users-list-name" href="#">Jane</a>
                                                    <span class="users-list-date">12 Jan</span>
                                                </li>
                                                <li>
                                                    <img src="dist/img/user6-128x128.jpg" alt="User Image">
                                                    <a class="users-list-name" href="#">John</a>
                                                    <span class="users-list-date">12 Jan</span>
                                                </li>
                                                <li>
                                                    <img src="dist/img/user2-160x160.jpg" alt="User Image">
                                                    <a class="users-list-name" href="#">Alexander</a>
                                                    <span class="users-list-date">13 Jan</span>
                                                </li>
                                                <li>
                                                    <img src="dist/img/user5-128x128.jpg" alt="User Image">
                                                    <a class="users-list-name" href="#">Sarah</a>
                                                    <span class="users-list-date">14 Jan</span>
                                                </li>
                                                <li>
                                                    <img src="dist/img/user4-128x128.jpg" alt="User Image">
                                                    <a class="users-list-name" href="#">Nora</a>
                                                    <span class="users-list-date">15 Jan</span>
                                                </li>
                                                <li>
                                                    <img src="dist/img/user3-128x128.jpg" alt="User Image">
                                                    <a class="users-list-name" href="#">Nadia</a>
                                                    <span class="users-list-date">15 Jan</span>
                                                </li>
                                            </ul>
                                            <!-- /.users-list -->
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <a href="javascript:void(0)" class="uppercase">View All Users</a>
                                        </div>
                                        <!-- /.box-footer -->
                                    </div>
                                    <!--/.box -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- TABLE: LATEST ORDERS -->
                            <div class="box box-info">


                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table no-margin">

                                            <tbody>
                                            <?php
                                            foreach ($shopsData as $value) { ?>
                                                <?php if (!empty($this->Shop->countProductPrice($value->id))) { ?>
                                                    <tr>
                                                        <td><?php echo $value->name ?></td>
                                                        <td>
                                                            $<?php echo $this->Shop->countProductPrice($value->id) ?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.box-body -->

                                <!-- /.box-footer -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-calendar"></i> <i class="caret"></i></a>
                            <ul id="range" class="dropdown-menu dropdown-menu-right">
                                <li><a href="day">Today</a></li>
                                <li><a href="week">Week</a></li>
                                <li><a href="month">Month</a></li>
                                <li><a href="year">Year</a></li>
                            </ul>
                        </div>
                        <h3 class="panel-title">Sales Last 10 Days</h3>
                    </header>
                    <div class="panel-body">
                        <div id="DataTables_Table_0_wrapper"
                             class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="box-body chart-responsive">
                                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Info Boxes Style 2 -->
                <div class="info-box bg-blue">
                    <div class="info-box-content" style="margin:0 0 0 0">
                        <span class="info-box-text" style="padding-top: 10px; padding-bottom: 0px; padding-left: 16px;">OVERALL PROFITS</span>
                        <span class="info-box-number"
                              style="padding: 1px 0px 7px 16px; font-size: 61px;">$<?php if (isset($overAllProfits) && !empty($overAllProfits)) {
                                echo $overAllProfits;
                            } else {
                                echo '0';
                            } ?>
                        </span>
                        <div class="progress" style="width: 90%; margin: 0px 0px 18px 18px;">
                            <div class="progress-bar" style="width: <?php echo $overallPercentag ?>%"></div>
                        </div>
                    </div>
                </div>
                <div class="info-box bg-yellow">

                    <div class="info-box-content" style="margin:0 0 0 0">
                        <span class="info-box-text" style="padding-top: 10px; padding-bottom: 0px; padding-left: 16px;">OVERALL SALES</span>
                        <span class="info-box-number"
                              style="padding: 1px 0px 7px 16px; font-size: 61px;">$<?php if (isset($overAllSale) && !empty($overAllSale)) {
                                echo $overAllSale;
                            } else {
                                echo '0';
                            } ?></span>

                        <div class="progress" style="width: 90%; margin: 0px 0px 18px 18px;">
                            <div class="progress-bar" style="width: <?php echo $overallPercentag ?>%"></div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>

                <!-- /.info-box -->


                <div class="info-box bg-green">

                    <div class="info-box-content" style="margin:0 0 0 0">
                        <span class="info-box-text" style="padding-top: 10px; padding-bottom: 0px; padding-left: 16px;">TODAY SALES</span>
                        <span class="info-box-number"
                              style="padding: 1px 0px 7px 16px; font-size: 61px;">$ <?php if (isset($todaySale) && !empty($todaySale)) {
                                echo $todaySale;
                            } else {
                                echo '0';
                            } ?></span>

                        <div class="progress" style="width: 90%; margin: 0px 0px 18px 18px;">
                            <div class="progress-bar" style="width: <?php echo $todayPercentag ?>%"></div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>


                <!-- /.info-box -->
            </div>

        </div>

        <!-- End Panel Basic -->
    </div>


    <div class="page-content container-fluid">
        <h2 style="margin-bottom: 25px;">GOOGLE DATA</h2>

        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <div class="col-xlg-4 col-md-4">
                <div class="row">

                    <div class="col-xlg-12 col-md-12">
                        <!-- Panel Today's Sales -->
                        <div class="widget widget-shadow bg-red-600 white" style="background: #263238 !important;">
                            <div class="widget-content padding-30">
                                <div class="counter counter-lg counter-inverse text-left">
                                    <div class="counter-label margin-bottom-20">
                                        <h2 style="color: #fff; font-size: 22px;">Pages Views</h2>
                                    </div>
                                    <div class="counter-number-group margin-bottom-10">
                                        <?php /* <span class="counter-number"><?= $this->Number->format($statistics->getTotalsForAllResults()['ga:pageviews'],
                    ['locale' => 'fr_FR']) ?></span> */ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Panel Today's Sales -->
                    </div>
                </div>
            </div>
            <div class="col-xlg-4 col-md-4">
                <div class="row">

                    <div class="col-xlg-12 col-md-12">
                        <!-- Panel Today's Sales -->
                        <div class="widget widget-shadow bg-red-600 white" style="background: #263238 !important;">
                            <div class="widget-content padding-30">
                                <div class="counter counter-lg counter-inverse text-left">
                                    <div class="counter-label margin-bottom-20">
                                        <h2 style="color: #fff; font-size: 22px;">Pages/visit</h2>
                                    </div>
                                    <div class="counter-number-group margin-bottom-10">
                                        <?php /* <span class="counter-number"><?= $this->Number->format($statistics->getTotalsForAllResults()['ga:pageviewsPerVisit'],
                    ['locale' => 'fr_FR', 'precision' => 2]) ?></span>*/ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Panel Today's Sales -->
                    </div>
                </div>
            </div>
            <div class="col-xlg-4 col-md-4">
                <div class="row">
                    <div class="col-xlg-12 col-md-12">
                        <!-- Panel Overall Sales -->
                        <div class="widget widget-shadow bg-blue-600 white" style="background: #263238 !important;">
                            <div class="widget-content padding-30">
                                <div class="counter counter-lg counter-inverse text-left">
                                    <div class="counter-label margin-bottom-20">
                                        <h2 style="color: #fff; font-size: 22px;">Average length/Visit</h2>
                                    </div>
                                    <div class="counter-number-group margin-bottom-15">
                                        <?php /*  <span class="counter-number"><?= gmdate("H:i:s", $statistics->getTotalsForAllResults()['ga:avgtimeOnSite']); ?></span>*/ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Panel Overall Sales -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <div class="col-xlg-4 col-md-4">
                <div class="row">

                    <div class="col-xlg-12 col-md-12">
                        <!-- Panel Today's Sales -->
                        <div class="widget widget-shadow bg-red-600 white" style="background: #263238 !important;">
                            <div class="widget-content padding-30">
                                <div class="counter counter-lg counter-inverse text-left">
                                    <div class="counter-label margin-bottom-20">
                                        <h2 style="color: #fff; font-size: 22px;">Bounce Rate</h2>
                                    </div>
                                    <div class="counter-number-group margin-bottom-10">
                                        <?php /*  <span class="counter-number"><?= $this->Number->format($statistics->getTotalsForAllResults()['ga:visitBounceRate'],
                    ['locale' => 'fr_FR', 'precision' => 2]) ?>%</span>*/ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Panel Today's Sales -->
                    </div>
                </div>
            </div>
            <div class="col-xlg-4 col-md-4">
                <div class="row">

                    <div class="col-xlg-12 col-md-12">
                        <!-- Panel Today's Sales -->
                        <div class="widget widget-shadow bg-red-600 white" style="background: #263238 !important;">
                            <div class="widget-content padding-30">
                                <div class="counter counter-lg counter-inverse text-left">
                                    <div class="counter-label margin-bottom-20">
                                        <h2 style="color: #fff; font-size: 22px;">Visits</h2>
                                    </div>
                                    <div class="counter-number-group margin-bottom-10">
                                        <?php /* <span class="counter-number"><?= $this->Number->format($statistics->getTotalsForAllResults()['ga:visits'],
                    ['locale' => 'fr_FR']) ?></span>*/ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Panel Today's Sales -->
                    </div>
                </div>
            </div>
            <div class="col-xlg-4 col-md-4">
                <div class="row">
                    <div class="col-xlg-12 col-md-12">
                        <!-- Panel Overall Sales -->
                        <div class="widget widget-shadow bg-blue-600 white" style="background: #263238 !important;">
                            <div class="widget-content padding-30">
                                <div class="counter counter-lg counter-inverse text-left">
                                    <div class="counter-label margin-bottom-20">
                                        <h2 style="color: #fff; font-size: 22px;">Unique Visitors</h2>
                                    </div>
                                    <div class="counter-number-group margin-bottom-15">
                      <span class="counter-number">
                    <?php /* <?= $this->Number->format($statistics->getTotalsForAllResults()['ga:visitors'],
                    ['locale' => 'fr_FR']) ?></span>*/ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Panel Overall Sales -->
                    </div>
                </div>
            </div>
        </div>

        <h2 style="margin-bottom: 25px;">WEBSITE DATA</h2>

        <div class="row" data-plugin="matchHeight" data-by-row="true">

            <div class="col-xlg-3 col-md-4">
                <div class="row height-full">
                    <div class="col-xlg-12 col-md-12" style="height:50%;">
                        <!-- Panel Overall Sales -->
                        <div class="widget widget-shadow bg-blue-600 white">
                            <div class="widget-content padding-30">
                                <div class="counter counter-lg counter-inverse text-left">
                                    <div class="counter-label margin-bottom-20">
                                        <h2 style="color: #fff; font-size: 22px;">USERS</h2>
                                    </div>
                                    <div class="counter-number-group margin-bottom-15">
                                        <span class="counter-number"><?= $usersCount; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Panel Overall Sales -->
                    </div>
                </div>
            </div>
            <div class="col-xlg-3 col-md-4">
                <div class="row height-full">
                    <div class="col-xlg-12 col-md-12" style="height:50%;">
                        <!-- Panel Overall Sales -->
                        <div class="widget widget-shadow bg-blue-600 white">
                            <div class="widget-content padding-30">
                                <div class="counter counter-lg counter-inverse text-left">
                                    <div class="counter-label margin-bottom-20">
                                        <h2 style="color: #fff; font-size: 22px;">PRODUCTS</h2>
                                    </div>
                                    <div class="counter-number-group margin-bottom-15">
                                        <span class="counter-number"><?= $productsCount; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Panel Overall Sales -->
                    </div>
                </div>
            </div>
            <div class="col-xlg-3 col-md-4">
                <div class="row height-full">
                    <div class="col-xlg-12 col-md-12" style="height:50%;">
                        <!-- Panel Overall Sales -->
                        <div class="widget widget-shadow bg-blue-600 white">
                            <div class="widget-content padding-30">
                                <div class="counter counter-lg counter-inverse text-left">
                                    <div class="counter-label margin-bottom-20">
                                        <h2 style="color: #fff; font-size: 22px;">TRANSACTIONS</h2>
                                    </div>
                                    <div class="counter-number-group margin-bottom-15">
                                        <span class="counter-number"><?= $transactionsCount; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Panel Overall Sales -->
                    </div>
                </div>
            </div>
            <div class="col-xlg-3 col-md-4">
                <div class="row height-full">
                    <div class="col-xlg-12 col-md-12" style="height:50%;">
                        <!-- Panel Overall Sales -->
                        <div class="widget widget-shadow bg-blue-600 white">
                            <div class="widget-content padding-30">
                                <div class="counter counter-lg counter-inverse text-left">
                                    <div class="counter-label margin-bottom-20">
                                        <h2 style="color: #fff; font-size: 22px;">NUMBER OF ORDERS</h2>
                                    </div>
                                    <div class="counter-number-group margin-bottom-15">
                                        <span class="counter-number"><?= $ordersCount; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Panel Overall Sales -->
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<script>
    <!--
    $('#range a').on('click', function(e) {
        e.preventDefault();

        $(this).parent().parent().find('li').removeClass('active');

        $(this).parent().addClass('active');

        $.ajax({
            type: 'get',
            url: '<?php echo Router::url('/', true); ?>admin/chart?range='+$(this).attr('href'),
            dataType: 'json',
            success: function(json) {
                if (typeof json['order'] == 'undefined') { return false; }

                var option = {
                    shadowSize: 0,
                    colors: ['#9FD5F1', '#1065D2'],
                    bars: {
                        show: true,
                        fill: true,
                        lineWidth: 1
                    },
                    grid: {
                        backgroundColor: '#FFFFFF',
                        hoverable: true
                    },
                    points: {
                        show: false
                    },
                    xaxis: {
                        show: true,
                        ticks: json['xaxis']
                    }
                }

                $.plot('#chart-sale', [json['order'], json['customer']], option);

                $('#chart-sale').bind('plothover', function(event, pos, item) {
                    $('.tooltip').remove();

                    if (item) {
                        $('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1].toFixed(2) + '</div></div>').prependTo('body');

                        $('#tooltip').css({
                            position: 'absolute',
                            left: item.pageX - ($('#tooltip').outerWidth() / 2),
                            top: item.pageY - $('#tooltip').outerHeight(),
                            pointer: 'cusror'
                        }).fadeIn('slow');

                        $('#chart-sale').css('cursor', 'pointer');
                    } else {
                        $('#chart-sale').css('cursor', 'auto');
                    }
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('#range .active a').trigger('click');
    //-->
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: '  '
        },
        subtitle: {
            text: ' '
        },
        xAxis: {
            categories: [<?php echo $graph_value ?>],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Rainfall (mm)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px"></span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">Price: </td>' +
            '<td style="padding:0"><b>${point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Tokyo',
            data: [<?php echo $graph_value ?>]

        }]
    });


</script>