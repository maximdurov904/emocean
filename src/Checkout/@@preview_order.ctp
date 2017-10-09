
<?php use Cake\Routing\Router; ?>

<?php $this->start('scriptBottom'); ?>

<?php $this->end() ?>

<body class="product-view">

    <div class="container">

      <section class="product_breadcrumb" style="background:#fff !important; margin-top: 90px;">
        <div class="row">
            <p class="grey-color fs21 text-center" style="margin-bottom: 0px !important;" class="grey-color"><a href="<?= $this->Url->build(['controller' => 'cart', 'action' => 'index', 'prefix' => false]) ?>" class="grey-color">Cart</a> > <a href="<?= $this->Url->build(['controller' => 'checkout', 'action' => 'index', 'prefix' => false]) ?>" class="grey-color">Billing & Shipping</a> > <span class="black-color">Preview Order </span> > Pay Method</p>
        </div>
      </section>

      <div class="row">
        <div class="col-md-12" style="background: #fff;">
          <h3 class="text-center pd-l-lg pd-r-lg black-text fs35 mgt-xs" style="padding-bottom: 5px;">PREVIEW ORDER</h3>
        </div>
      </div>

    </div>

     <?php if ($cart_data['products']): ?>

       <table class="table mgt-xs" style="background-color: #f7f7f7;">
        <tbody>

            <?php foreach ($cart_data['products'] as $product): ?>
              <tr class="product-line">
                  <td style="width: 80px;"><?= $this->Html->image($product['hero'], ['class' => 'img-responsive', 'style' => 'max-width: 80px; min-height: 70px; max-height: 70px; margin-top: 10px;']) ?></td>
                  <td>
                    <strong><?php echo $product['name']; ?></strong><br />
                    <span style="color: #999999">
                      <?=
                      $this->Text->truncate(
                          $product['content'],
                          30,
                          [
                              'ellipsis' => '...',
                              'exact' => false
                          ]
                      ) ?>
                    </span>
                    <div>
                      <input type="text" class="form-control updateQty" value="<?= $product['qty']; ?>" data-url="<?php echo $this->Url->build(['controller' => 'cart', 'action' => 'update_cart',$product['id']]); ?>" style="background: #fff !important; width: 55px; text-align: center; padding-top: 5px; padding-bottom: 5px;">
                    </div>
                  </td>
                  <td>
                    <a href="#" class="removeProduct" data-url="<?php echo $this->Url->build(['controller' => 'cart', 'action' => 'remove_cart',$product['id']]); ?>">
                      <span class="glyphicon glyphicon-remove" style="top: 5px; color: red;"></span>
                    </a>
                    <div style="margin-top:30px;">
                      <span class="blue-color">$<?= $product['price']; ?></span>
                    </div>
                  </td>
              </tr>
            <?php endforeach; ?>

          </tbody>
      </table>
<?php endif; ?>
    <div class="row">
      <div class="col-md-12" style="background: #fff;">
        <h3 class="text-center pd-l-lg pd-r-lg black-text fs35 mgt-xs" style="padding-bottom: 5px; font-size: 25px !important;">SHIPPING METHODS</h3>
      </div>
    </div>
 
      
   

    <br /><br /><?php /* echo $this->element('Cart/total')  */?>

    <div class="container mgb-sm">
      <div class="product_search">
        <div class="mbr-buttons btn-inverse mbr-buttons--center">
             <a class="mbr-buttons__btn btn btn-lg btn-info btn-green-transparent" href="<?= $this->Url->build(['controller' => 'cart', 'action' => 'pay_order', 'prefix' => false]) ?>" id="next_link_payment">Next</a>
        </div>
      </div>
    </div>

  
      <p class="text-center fs21"><strong>There are no items in your cart!</strong></p>
   

</body>