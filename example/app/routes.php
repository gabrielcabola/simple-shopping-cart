<?php
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
$source = __DIR__ .'/../views/';

//Load Cart
use SSCart\Cart;

$masterpage =  __DIR__ . '/views/masterpage.php';
$products = require __DIR__ . '/../data/products.php';
$cart = new Cart();

switch ($request_uri[0])
{
    // Cart index
    case '/example/':
        $view = 'cart.php';
        include $source.'masterpage.php';
        break;

    // Add
    case '/example/add':
          $view = 'cart.php';
          $request = $_POST;
          if(empty($request)) return array('error'=>'Empty post data');
            $product = $products[$request['id']]; //product get
            if(! empty($product)) {
                $cart->add(
                  array(
                    'id'=>$request['id'],
                    'name'=>$product['name'],
                    'price'=>$product['price'],
                    'quantity'=>$request['quantity'],
                  )
                );
                redirect('/example');
            }
        //request_result();
        //include $source.'masterpage.php';
        break;

    // Remove
    case '/example/remove':
              $request = $_POST;
              if(empty($request)) return array('error'=>'Empty post data');

              $cart->remove($request['id']);
              redirect('/example');

            //request_result();
            //include $source.'masterpage.php';
            break;

    // Up item quantity
    case '/example/up':
              $request = explode('=',$request_uri[1]);
              if(empty($request)) return array('error'=>'Empty post data');
              $cart->upQuantity($request[1]);
              redirect('/example');
            break;

    // Down item quantity
    case '/example/down':
              $request = explode('=',$request_uri[1]);
              if(empty($request)) return array('error'=>'Empty post data');
              $cart->downQuantity($request[1]);
              redirect('/example');
            break;

    //clear cart
    case '/example/clear':
              $cart->clearCart();
              redirect('/example');
              break;

    // Everything else
    default:
        header('HTTP/1.0 404 Not Found');
        require $source.'404.php';
        break;
}



function request_result($method)
{
    $result  = $method;
    if($result['error']) {
      echo '<div class="alert alert-danger" style="margin:20px 0;" role="alert">'. $result['error'] . '</div>';
    }
}

function redirect($url, $statusCode = 303)
{

   header('Location: ' . $url, true, $statusCode);
   die();
}



?>
