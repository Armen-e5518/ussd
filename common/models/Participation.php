<?php

namespace common\models;

use common\components\WinCirculation;

/**
 * This is the model class for table "participation".
 *
 * @property int $id
 * @property string $grille
 * @property double $coeff
 * @property int $uniteBase
 * @property int $flash true or false
 * @property int $numParty
 * @property string $account_id
 * @property string $date
 * @property string $numCollector
 * @property int $status
 * @property string $state
 * @property int $dateSession
 * @property int $session
 * @property int $bet_amount
 * @property int $party
 * @property int $drawing_id
 * @property int $win_amount
 * @property int $result_numbers
 * @property string $nature
 * @property string $timer
 * @property string $step
 * @property string $save_data
 */
class Participation extends \yii\db\ActiveRecord
{
   const NATURE = 'real';

   const FLASH_IS_ACTIVE = 1;
   const FLASH_IS_NOT_ACTIVE = 0;

   const STATUS_BET = 0;
   const STATUS_WIN = 1;
   const STATUS_SHIPPED = 2;
   const STATUS_CANCEL = 3;

   public $timer;
   public $step;

   /**
    * {@inheritdoc}
    */
   public static function tableName()
   {
      return 'participation';
   }

   /**
    * {@inheritdoc}
    */
   public function rules()
   {
      return [
         [['coeff'], 'number'],
         [['win_amount'], 'number'],
         [['uniteBase', 'flash', 'numParty', 'status', 'dateSession', 'session', 'bet_amount', 'party', 'drawing_id', 'account_id'], 'integer'],
         [['date'], 'safe'],
         [['grille', 'numCollector', 'state', 'nature', 'result_numbers',], 'string', 'max' => 255],
      ];
   }

   /**
    * {@inheritdoc}
    */
   public function attributeLabels()
   {
      return [
         'id' => 'ID',
         'grille' => 'Grille',
         'coeff' => 'Coeff',
         'uniteBase' => 'Unite Base',
         'flash' => 'Flash',
         'numParty' => 'Num Party',
         'account_id' => 'Account',
         'date' => 'Date',
         'numCollector' => 'Num Collector',
         'status' => 'Status',
         'state' => 'State',
         'dateSession' => 'Date Session',
         'session' => 'Session',
         'bet_amount' => 'Amount',
         'party' => 'Party',
         'nature' => 'Nature',
         'drawing_id' => 'Drawing id',
         'win_amount' => 'Win amount',
         'result_numbers' => 'Result numbers',
         'win_date' => 'Win date',
//         'save_data' => 'Win date',
      ];
   }

   public static function GetResultsByDaySession($date)
   {
      return self::find()
         ->where(['dateSession' => $date['dateSession']])
         ->where(['party' => $date['party']])
         ->limit($date['nbParty']);
   }

   public static function UpdateBet($id, $where)
   {
      $player_game = $where == 'host' ? self::findOne(['idHost' => $id]) : self::findOne(['idRemote' => $id]);
      if (!empty($player_game['drawing_id'])) {
         $win_result = GameResults::GetResultByDrawingId($player_game['drawing_id']);
         $exist_count = WinCirculation::getExistNumbersCount($player_game->grille, $win_result['results']);
         $player_game->result_numbers = $win_result['results'];
         $player_game->win_amount = WinCirculation::getWinAmount($player_game->bet_amount, $exist_count);
         $player_game->status = self::STATUS_WIN;
         return $player_game->save();
      }
      return true;
   }

   public static function Cancel($id, $where)
   {
      $player_game = $where == 'host' ? self::findOne(['idHost' => $id]) : self::findOne(['idRemote' => $id]);
      $player_game->status = self::STATUS_CANCEL;
      return $player_game->save() ? $player_game : false;
   }

   public static function GetResultsByPartyAndDate($get)
   {
      return self::find()
         ->where(['party' => (int)$get['party']])
         ->andFilterWhere(['between', 'create_at', $get['date_from'], $get['date_to']])
         ->all();
   }

   public static function GetResultsByStatus($get)
   {
      return self::find()
         ->where(['status' => (int)$get['status']])
         ->all();
   }
}

