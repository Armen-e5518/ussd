<?php

namespace common\components;


class WinCirculation
{
   const WIN_5 = 50000;
   const WIN_4 = 500;
   const WIN_3 = 35;
   const WIN_2 = 5;

   /**
    *
    * 5 winning numbers 1’ 50 000 x bet
    * 4 winning numbers 2’ 500 x bet
    * 3 winning numbers 3’ 35 x bet
    * 2 winning numbers 4’ 5 x bet
    * 0 / 1 winning numbers 5’ No win
    * No win
    * 43;11;14;9;20
    * 2#5#12#4#6
    */
   public static function getExistNumbersCount($bet, $res)
   {
      $bet_arr = explode('#', $bet);
      $res_arr = explode(';', $res);
      $count_exist = 0;
      if (!empty($bet_arr) && !empty($res_arr)) {
         foreach ($bet_arr as $b) {
            if (in_array($b, $res_arr)) {
               $count_exist++;
            }
         }
      }
      return $count_exist;
   }

   public static function getWinAmount($bet_amount, $number)
   {
      switch ($number) {
         case 5:
            return $bet_amount * self::WIN_5;
            break;
         case 4:
            return $bet_amount * self::WIN_4;
            break;
         case 3:
            return $bet_amount * self::WIN_3;
            break;
         case 2:
            return $bet_amount * self::WIN_2;
            break;
         default:
            return 0;
      }
   }
}

?>



