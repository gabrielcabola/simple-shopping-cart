<h1>Simple Shopping Cart</h1>
<br>
<div class="row">
<div class="col-lg-4 col-sm-12">
  <h4>Products</h4>
    <hr>

    <?php if($products) { foreach ($products as $key => $product) { ?>
      <div class="card col-12" >
        <div class="card-body">
          <div class="col-12">
            <h5 class="card-title"><?php echo $product['name']; ?></h5>
            <h6 class="card-subtitle mb-2 text-muted">$<?php echo SSCart\Price::format($product['price']) ?></h6>
          </div>
          <div class="col-12">
            <form class="form-inline" name="add" action="add" method="post">
              <input type="hidden" name="id" value="<?php echo $key; ?>">
                <div class="form-group mr-2">
                <select  class="form-control" name="quantity">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="10">10</option>
                </select>
              </div>
              <button class="btn btn-primary float-right" type="submit" name="add">Add to cart</button>
          </form>

          </div>
        </div>
      </div>
    <?php }} ?>

    <br>
</div>
<div class="col-lg-8 col-sm-12">
  <h4>Your Cart</h4>
    <hr>

  <div class="card border-primary mb-3" >
    <div class="card-header">
      You have <?php echo $cart->itemsTotal(); ?> products in cart</div>

<?php if ($cart->itemsTotal()) { ?>
    <div class="card-body text-primary">

      <?php
          foreach ($cart->items() as $key => $item) { ?>
            <div class="row">

                <div class="col-md-6"><h4><?php  echo $item->name; ?></h4>
                  <form class="" name="remove" action="remove" method="post">
                    <input type="hidden" name="id" value="<?php echo $key; ?>">
                    <button  type="submit" class="text-danger btn-link btn btn-sm">remove</button>
                  </form>
                </div>

                <div class="col-md-3">
                  <center>
                    <small class="muted">Quantity</small><br>
                    <a class="btn btn-primary-outline btn-sm" href="down?id=<?php echo $item->id; ?>">-</a>
                    <?php  echo $item->quantity; ?>
                    <a class="btn btn-default-outline btn-sm" href="up?id=<?php echo $item->id; ?>">+</a>
                  </center>
                </div>
                <div class="col-md-3 text-right"><?php  echo $item->currency . SSCart\Price::format($item->total_price); ?></div>

            </div>
            <hr>
      <?php }  ?>
      <div class="row">


          <div class="col-md-3 offset-md-9 text-right"><?php echo SSCart\Price::currency() . $cart->sumTotal(); ?></div>
      </div>
  </div>
    <h5 class="card-title"><a href="clear" style="margin:20px;" class="btn btn-sm btn-outline-primary float-right">empyt cart</a></h5>
  <?php } ?>
</div>
