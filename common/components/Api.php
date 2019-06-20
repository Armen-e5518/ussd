<?php

namespace common\components;


class Api
{
  /**
   * @return array
   *"return": "OK",
  * "step": "MISE",
   * "timeleft": 57,
   * "timeleft2draw": 72,
   * "timeleft2lbet": 57,
  * "party": "395",
  * "drawing_id": "66743",
  * "next_drawing_id": "66744",
  * "next_drawing_day_id": "396",
  * "results": "",
  * "time": 1558096216,
  * "duration": 80,
  * "timePassing": 23,
  * "playlistRun": "start",
  * "open": false
   */
  public static function getGameState()
  {
    return (array)json_decode(file_get_contents(\Yii::$app->params['api_url_get_game_state']));
  }
}

?>