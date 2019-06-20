<?php

namespace api\components;


use common\components\Api;
use common\models\GameResults;
use common\models\Participation;

/**
 * Extend Active Controller.  All controllers for the API should extend from here.
 */
class AddPart
{
   public static function NewPart(Participation $model)
   {
      $current_game = Api::getGameState();
      $model->nature = Participation::NATURE;
      $model->drawing_id = self::GetDrawingId($current_game);
      $model->party = self::GetParty($current_game);
      $model->bet_amount = 1 * (float)$model->coeff * (int)$model->uniteBase;
      $model->timer = self::GetTimer($current_game);
      $model->step = $current_game['step'];
   }

   public static function GetDrawingId($current_game)
   {
      if ($current_game['step'] == GameResults::STEPS[0] || $current_game['step'] == GameResults::STEPS[1] || $current_game['step'] == GameResults::STEPS[2]) {
         return $current_game['drawing_id'];
      }
      return $current_game['next_drawing_id'];
   }

   public static function GetParty($current_game)
   {
      if ($current_game['step'] == GameResults::STEPS[0] || $current_game['step'] == GameResults::STEPS[1] || $current_game['step'] == GameResults::STEPS[2]) {
         return $current_game['party'];
      }
      return 1 * $current_game['party'] + 1;
   }

   public static function GetTimer($current_game)
   {
      switch ($current_game['step']) {
         case GameResults::STEPS[0]:
            return GameResults::TIME_MISE + GameResults::TIME_LMISE + GameResults::TIME_TIRAGE + GameResults::TIME_RESULT + GameResults::TIME_DIFF;
            break;
         case GameResults::STEPS[1]:
            return GameResults::TIME_LMISE + GameResults::TIME_TIRAGE + GameResults::TIME_RESULT + GameResults::TIME_DIFF;
            break;
         case GameResults::STEPS[2]:
            return GameResults::TIME_TIRAGE + GameResults::TIME_RESULT + GameResults::TIME_DIFF;
            break;
         case GameResults::STEPS[3]:
            return GameResults::TIME_MISE + GameResults::TIME_LMISE + GameResults::TIME_TIRAGE + GameResults::TIME_RESULT + GameResults::TIME_DIFF;
            break;
      }
   }


}