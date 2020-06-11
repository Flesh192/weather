<?php

/**
 * @copyright Copyright (c) 2020
 * @author Vladymyr Drohovoz flesh192@gmail.com
 */

namespace App\Services;

/**
 * Interface IWeatherInterface
 * @package App\Services
 */
interface IWeatherInterface
{
    /**
     * Request current weather
     * @return object
     * @throws RequestException
     * @throws ClientException
     * @throws Exception
     */
    public function getWeather(): object;
}
