<?php
namespace SSCart;

use SSCart\CartItem;
use SSCart\Price;


/**
 * Cart: Simple Shopping Cart.
 *
 * Autor Gabriel Cabola
 *
 * Distributed under the terms of the MIT License.
*/


class Cart
{

      /**
      * An unique ID for the cart.
      * @var string
      */
      protected $id;

      /**
      * Default parameters.
      * @var string
      */
      private $items_prefix = 'items';

      /**
      * Itens added to cart.
      * @var array
      */
      private $items = [];


      /**
      * Class Constructor
      * @param options array
      */
      public function __construct($options = ['prefix'=>'simple_cart_'])
    	{
            if (!session_id()) {
                  session_start();
            }
           
            //get id from session
        	$this->id = $options['prefix'] . md5((isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : 'SSCart');
           
            //init cart by session id
            $this->_init();

    	}

      /** PRODUCT OPERATIONS */

      /**
       * ADD 
       */
      public function add($request)
    	{
          //validate item data;
          $item = new CartItem((object) $request);
          $id = $item->getId();

          //if already have item in cart increment quantities
          if (isset($this->items[$id])) {
                $item->incrementQuantity($this->items[$id]->quantity);
                $this->items[$id] = $item->get();
                $this->set($this->items_prefix,$this->items);
                return true;
          }

          $this->items[$id] = $item;
          $this->set($this->items_prefix,$this->items);
          return true;
      }

      /**
       * Increment Item quantity
       */
      public function upQuantity($id,$amount=1)
      {
        if (isset($this->items[$id])) {
              $item = new CartItem($this->items[$id]);
              $item->upQuantity($amount);
              $this->items[$id] = $item->get();
              $this->set($this->items_prefix,$this->items);
              return true;
        }
      }

      /**
       * Reduce Item Quantity
       */
      public function downQuantity($id,$amount=1)
      {
        if (isset($this->items[$id])) {
              $item = new CartItem($this->items[$id]);
              if($item->downQuantity($amount)<=0) return $this->remove($id);
              $this->items[$id] = $item->get();
              $this->set($this->items_prefix,$this->items);
              return true;
        }
      }


      /**
       * Remove Item
       */
       public function remove($id)
       {

         //Case have one left
         if(count($this->items)==1) $this->clearCart();

         //Remove from array
         if(isset($this->items[$id])) {
                unset($this->items[$id]);
                $this->set($this->items_prefix,$this->items);
           } return false;
       }


     /**
      * List all itens on Cart
      */
      public function items()
      {
        return $this->items;
      }

      /**
       * Count number of distinct products
       */
      public function productsTotal()
      {
          return (count($this->items)>0) ? count($this->items) : 0;
      }


      /**
       * Count number of total itens of products
       */
      public function itemsTotal()
      {

        return ($this->items) ? array_reduce($this->items, function($count, $item) {
            return  $count = $count + $item->quantity;
          }) : 0 ;
      }

      /**
       * SUM total price of products
       */
      public function sumTotal()
      {
        return Price::format(array_reduce($this->items, function($sum, $item){
            return  $sum = $sum + $item->total_price;
          })
        );
      }

      
      /**
       * SESSION
       */
      
      /**
       * Extract values from PHP session
       * @param key string
       */
      private function get($key)
      {
        return (isset($_SESSION[$this->id][$key])) ? $_SESSION[$this->id][$key] : null;
      }

      /**
       * Insert values in PHP session
       * @param key string
       */
      private function set($key,$value)
      {
          if(! empty($key) && ! empty($value)) {
            return $_SESSION[$this->id][$key] = $value;
          }
      }

      /**
       * Remove all itens from session
       */
      public function clearCart()
      {
        unset($_SESSION[$this->id]);
      }

      /**
       * Init Function
       */
      private function _init()
      {
          //get itens from session
          $this->items = $this->get($this->items_prefix);
      }


}
