	<?= $this->assign('title', 'Dashboard') ?>
	
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">

    <div class="navbar-header" style="background-color: #000;">
      <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided"
      data-toggle="menubar">
        <span class="sr-only">Toggle navigation</span>
        <span class="hamburger-bar"></span>
      </button>
      <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse"
      data-toggle="collapse">
        <i class="icon wb-more-horizontal" aria-hidden="true"></i>
      </button>
      <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
        <?php echo $this->Html->link(($this->Html->image('logo.png', ['alt' => \Cake\Core\Configure::read('Site.name'), 'class' => 'navbar-brand-logo'])), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        <span class="navbar-brand-text"> <?= \Cake\Core\Configure::read('Site.name'); ?></span>
      </div>
      <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-search"
      data-toggle="collapse">
        <span class="sr-only">Toggle Search</span>
        <i class="icon wb-search" aria-hidden="true"></i>
      </button>
    </div>

    <div class="navbar-container container-fluid">
      <!-- Navbar Collapse -->
      <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
        <!-- Navbar Toolbar -->
        <ul class="nav navbar-toolbar">
          <li class="hidden-float" id="toggleMenubar">
            <a data-toggle="menubar" href="#" role="button">
              <i class="icon hamburger hamburger-arrow-left">
                  <span class="sr-only">Toggle menubar</span>
                  <span class="hamburger-bar"></span>
                </i>
            </a>
          </li>
          <li class="hidden-xs" id="toggleFullscreen">
            <a class="icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
              <span class="sr-only">Toggle fullscreen</span>
            </a>
          </li>
        </ul>
        <!-- End Navbar Toolbar -->

        <!-- Navbar Toolbar Right -->
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
          <li class="dropdown">
            <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"
            data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
                  <?= $this->Html->image(h($this->request->session()->read('Auth.User.avatar'))) ?>
                <i></i>
              </span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li role="presentation">
                <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'logout', 'prefix' => 'admin']);?>" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- End Navbar Toolbar Right -->
      </div>
      <!-- End Navbar Collapse -->
    </div>
  </nav>
  <div class="site-menubar">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu">
            <li class="site-menu-category">General</li>
            <li class="site-menu-item has-sub <?php echo $this->request->params['controller']=='Admin'?'active open':''; ?>">
              <a href="<?= $this->Url->build(['controller' => 'admin', 'action' => 'home', 'prefix' => 'admin']);?>" data-slug="dashboard">
                <i class="site-menu-icon fa fa-dashboard" aria-hidden="true"></i>
                <span class="site-menu-title">Dashboard</span>
              </a>
            </li>
            <li class="site-menu-item has-sub <?php echo $this->request->params['controller']=='Products'?'active open':''; ?>">
              <a href="<?= $this->Url->build(['controller' => 'products', 'action' => 'index', 'prefix' => 'admin']);?>" data-slug="dashboard">
                <i class="site-menu-icon fa fa-product-hunt" aria-hidden="true"></i>
                <span class="site-menu-title">Products</span>
              </a>
            </li>
            <li class="site-menu-item has-sub <?php echo $this->request->params['controller']=='Users'?'active open':''; ?>">
              <a href="javascript:void(0)">
                <i class="site-menu-icon fa fa-user" aria-hidden="true"></i>
                <span class="site-menu-title">Users</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub" style="">
                <li class="site-menu-item">
                  <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'index', 'prefix' => 'admin']);?>" data-slug="dashboard">
                    <i class="site-menu-icon fa fa-users" aria-hidden="true"></i>
                    <span class="site-menu-title">All Users</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'customers', 'prefix' => 'admin']);?>" data-slug="dashboard">
                    <i class="site-menu-icon fa fa-user-circle-o" aria-hidden="true"></i>
                    <span class="site-menu-title">Customers</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'merchants', 'prefix' => 'admin']);?>" data-slug="dashboard">
                    <i class="site-menu-icon fa fa-user-o" aria-hidden="true"></i>
                    <span class="site-menu-title">Merchants</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'admins', 'prefix' => 'admin']);?>" data-slug="dashboard">
                    <i class="site-menu-icon fa fa-user-circle" aria-hidden="true"></i>
                    <span class="site-menu-title">Admins</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="site-menu-item has-sub <?php echo $this->request->params['controller']=='Orders'?'active open':''; ?>">
              <a href="<?= $this->Url->build(['controller' => 'orders', 'action' => 'index', 'prefix' => 'admin']);?>" data-slug="dashboard">
                <i class="site-menu-icon fa fa-first-order" aria-hidden="true"></i>
                <span class="site-menu-title">Orders</span>
              </a>
            </li>
            <li class="site-menu-item has-sub <?php echo $this->request->params['controller']=='Shops'?'active open':''; ?>">
              <a href="<?= $this->Url->build(['controller' => 'shops', 'action' => 'index', 'prefix' => 'admin']);?>" data-slug="dashboard">
                <i class="site-menu-icon fa fa-shopping-basket" aria-hidden="true"></i>
                <span class="site-menu-title">Shops</span>
              </a>
            </li>
			<li class="site-menu-item has-sub <?php echo $this->request->params['controller']=='Transactions'?'active open':''; ?>">
              <a href="javascript:void(0)">
                <i class="site-menu-icon fa fa-money" aria-hidden="true"></i>
                <span class="site-menu-title">Transactions</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub" style="">
                <li class="site-menu-item">
                  <a href="<?= $this->Url->build(['controller' => 'transactions', 'action' => 'index', 'prefix' => 'admin']);?>" data-slug="dashboard">
                    <i class="site-menu-icon fa fa-sliders" aria-hidden="true"></i>
                    <span class="site-menu-title">All Transactions</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a href="<?= $this->Url->build(['controller' => 'transactions', 'action' => 'customer', 'prefix' => 'admin']);?>" data-slug="dashboard">
                    <i class="site-menu-icon fa fa-paypal" aria-hidden="true"></i>
                    <span class="site-menu-title">EzyPay</span>
                  </a>
                </li>                
              </ul>
            </li>
			
            <?php 
            /* <li class="site-menu-item has-sub <?php echo $this->request->params['controller']=='Packages'?'active':''; ?>">
              <a href="<?= $this->Url->build(['controller' => 'packages', 'action' => 'index', 'prefix' => 'admin']);?>" data-slug="dashboard">
                <i class="site-menu-icon wb-edit" aria-hidden="true"></i>
                <span class="site-menu-title">Packages</span>
              </a>
            </li>
			 */?>
            <li class="site-menu-item has-sub <?php echo $this->request->params['controller']=='Settings'?'active open':''; ?>">
              <a href="<?= $this->Url->build(['controller' => 'settings', 'action' => 'index', 'prefix' => 'admin']);?>" data-slug="dashboard">
                <i class="site-menu-icon fa fa-wrench" aria-hidden="true"></i>
                <span class="site-menu-title">Settings</span>
              </a>
            </li>
			 <li class="site-menu-item has-sub <?php echo $this->request->params['controller']=='UserPackages'?'active open':''; ?>">
              <a href="<?= $this->Url->build(['controller' => 'user_packages', 'action' => 'index', 'prefix' => 'admin']);?>" data-slug="dashboard">
                <i class="site-menu-icon fa fa-retweet" aria-hidden="true"></i>
                <span class="site-menu-title">User Packages</span>
              </a>
            </li>
			 <li class="site-menu-item has-sub <?php echo $this->request->params['controller']=='AdminNotifications'?'active open':''; ?>">
              <a href="<?= $this->Url->build(['controller' => 'admin_notifications', 'action' => 'index', 'prefix' => 'admin']);?>" data-slug="dashboard">
                <i class="site-menu-icon fa fa-whatsapp" aria-hidden="true"></i>
                <span class="site-menu-title">Notifications</span>
              </a>
            </li>
			
          </ul>
        </div>
      </div>
    </div>

    <div class="site-menubar-footer">
      <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'logout', 'prefix' => 'admin']);?>" data-placement="top" data-toggle="tooltip" data-original-title="Logout" style="width: 100%;">
        <span class="icon wb-power" aria-hidden="true"></span>
      </a>
    </div>
  </div>