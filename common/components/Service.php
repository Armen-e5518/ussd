<?php

namespace common\components;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Yii;
use yii\base\Component;

class Service extends Component
{

  private $_baseUrl = 'https://sitesvtt.ffc.fr/wp-json/wp/v2/app/trace-vtt';

  public function run()
  {

  }

  public function getBaseUrl()
  {
    return $this->_baseUrl;
  }

  public function getCourses()
  {
    $response_data = [];
    $client = new Client(['verify' => false]);
    try {
      $response = $client->request('GET', $this->getBaseUrl());
      $response_data = json_decode($response->getBody(), true);
    } catch (ClientException $e) {
      Yii::info('ClientException: ' . $e->getMessage(), 'ffc-external-api-service');
    } catch (RequestException $e) {
      Yii::info('RequestException: ' . $e->getMessage(), 'ffc-external-api-service');
    } catch (\Exception $e) {
      Yii::info('Exception: ' . $e->getMessage(), 'ffc-external-api-service');
    }

    return $response_data;
  }


}

?>