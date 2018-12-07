<?php
namespace SSCart;

use SSCart\Price;
use SSCart\ValidationItem;

class CartItem
{
      /**
      * An unique ID for item
      * @var string
      */
      public $id;

      /**
      * An name of product
      * @var string
      */
      public $name;

      /**
      * Product price
      * @var float
      */
      public $price;

      /**
      * Product Quantity
      * @var integer
      */
      public $quantity;

      /**
      * Total price ($quantity * $price).
      * @var float
      */
      public $total_price;

      /**
       * Extra informations
       *@var array
       */
      public $extra = [];

      public $currency;

      /**
      * Class Constructor
      * @param options array
      */
      public function __construct($product)
    	{
          $validation = new ValidationItem($product);
          //Validate Request
          $this->currency = Price::currency();
          $this->id = $product->id;
          $this->name = $product->name;
          $this->price = $product->price;
          $this->quantity = (preg_match('/^\d+$/', $product->quantity)) ? $product->quantity : 1;
          $this->total_price = $this->quantity * $product->price;
          $this->extra = (isset($request->extra)) ? $request->extra : [];
    	}

      /**
      * Get object
      * @return string
      */
      public function get()
      {
        return $this;
    	}


      /**
      * Get param id
      * @return string
      */
      public function getId()
      {
        return $this->id;
      }

      /**
      * Get param id
      * @return string
      */
      public function getName()
      {
        return $this->name;
      }

      /**
      * Get param id
      * @return string
      */
      public function getPrice()
      {
          return $this->price;
      }


      /**
      * Get param id
      * @return string
      */
      public function getTotalPrice()
      {
        return $this->total_price;
      }

      /**
      * Get param id
      * @return string
      */
      public function getQuantity()
      {
          return $this->quantity;
      }

      /**
      * Get param id
      * @return string
      */
      public function getExtra()
      {
          return $this->extra;
      }

      /**
      *Add item quantity
      * @return string
      */
      public function incrementQuantity($increment)
      {
        $this->quantity = $this->quantity + $increment;
        $this->total_price = $this->quantity * $this->price;
        return $this->quantity;
      }

      /**
      * Calculate item quantity by increasing
      * @return int
      */
      public function upQuantity($increment)
      {
        $this->quantity = $this->quantity + $increment;
        $this->total_price = $this->quantity * $this->price;
        return $this->quantity;
      }

      /**
      * Calculate item quantity by decreasing
      * @return int
      */
      public function downQuantity($increment)
      {
        $this->quantity = $this->quantity - $increment;
        $this->total_price = $this->quantity * $this->price;
        return $this->quantity;
      }

      /**
      * Format Price
      * @return float
      */
      public static function price_format($number) {
          if(! empty($number)) return Price::format($number);
      }



}
