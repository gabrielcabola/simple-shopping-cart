<?php
namespace SSCart;


class Price
{

      /**
      * Format Price
      * @return float
      */
      public static function format($number) {
          if(! empty($number)) return number_format($number, 2, ',', '');
      }

      public static function currency() {
        return '$';
      }


}
