<?php

/**
 * @copyright Copyright (c) 2020
 * @author Vladymyr Drohovoz flesh192@gmail.com
 */

namespace App\Gateway;

use App\Services\IWeatherInterface;
use GuzzleHttp\Client;

/**
 * Class OpenweathermapGataway
 * @package App\Gateway
 */
class OpenweathermapGataway implements IWeatherInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * OpenweathermapGataway constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }


    /**
     * @inheritDoc
     */
    public function getWeather(): object
    {
        try {
            $response = $this->client->get($_ENV['WEATHER_URI'], [
                'query' => [
                    'q' => $_ENV['WEATHER_CITY'],
                    'appid' => $_ENV['WEATHER_APPID'],
                    //to get in degrees of Celsius
                    'units' => 'metric'
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        //TODO: Here we can process different kind of exception, but its simple test, so just echo
        } catch (RequestException $e) {
            echo $e->getRequest();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        } catch (ClientException $e) {
            echo $e->getMessage();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}