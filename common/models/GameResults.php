<?php

namespace common\models;

use common\components\Api;

/**
 * This is the model class for table "game_resluts".
 *
 * @property int $id
 * @property string $step
 * @property string $return
 * @property int $timeleft
 * @property int $timeleft2draw
 * @property int $timeleft2lbet
 * @property int $party
 * @property int $drawing_id
 * @property int $next_drawing_id
 * @property int $next_drawing_day_id
 * @property string $results
 * @property int $time
 * @property int $duration
 * @property int $timePassing
 * @property string $playlistRun
 * @property string $save_date
 * @property int $open
 */
class GameResults extends \yii\db\ActiveRecord
{

   const TIME_MISE = 80;
   const TIME_LMISE = 15;
   const TIME_TIRAGE = 20;
   const TIME_RESULT = 15;
   const TIME_DIFF = 10;

   const STEPS = [
      'MISE',
      'LMISE',
      'TIRAGE',
      'RESULT',
   ];

   /**
    * {@inheritdoc}
    */
   public static function tableName()
   {
      return 'game_resluts';
   }

   /**
    * {@inheritdoc}
    */
   public function rules()
   {
      return [
         [['timeleft', 'timeleft2draw', 'timeleft2lbet', 'party', 'drawing_id', 'next_drawing_id', 'next_drawing_day_id', 'time', 'duration', 'timePassing', 'open'], 'integer'],
         [['step', 'return', 'results', 'playlistRun'], 'string', 'max' => 255],
      ];
   }

   /**
    * {@inheritdoc}
    */
   public function attributeLabels()
   {
      return [
         'id' => 'ID',
         'step' => 'Step',
         'return' => 'Return',
         'timeleft' => 'Timeleft',
         'timeleft2draw' => 'Timeleft2draw',
         'timeleft2lbet' => 'Timeleft2lbet',
         'party' => 'Party',
         'drawing_id' => 'Drawing ID',
         'next_drawing_id' => 'Next Drawing ID',
         'next_drawing_day_id' => 'Next Drawing Day ID',
         'results' => 'Results',
         'time' => 'Time',
         'duration' => 'Duration',
         'timePassing' => 'Time Passing',
         'playlistRun' => 'Playlist Run',
         'open' => 'Open',
      ];
   }

   /**
    * Crone job get results from api
    * MISE
    * LMISE
    * TIRAGE
    */
   static function CroneJob()
   {
      $res = Api::getGameState();
      $model = new self();
      $model->load($res, '');
      $model->open = $res['open'] == true ? 1 : 0;
      $model->save();
   }

   static function CroneJobFor()
   {
      $s = 0;
      for ($i = 0; $i < 100; $i++) {
         $res = Api::getGameState();
         if ($res['step'] == self::STEPS[$s]) {
            $s++;
            if ($s == 4) $s = 0;
            $model = new self();
            $model->load($res, '');
            $model->open = $res['open'] == true ? 1 : 0;
            $model->playlistRun = date('H:i:s');
            $model->save();
         }
         sleep(5);
      }
      return true;
   }

   public static function GetResultByDrawingId($drawing_id)
   {
      return self::findOne(['drawing_id' => $drawing_id, 'step' => self::STEPS[3]]);
   }
}
