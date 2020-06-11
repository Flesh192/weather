<?php

/**
 * @copyright Copyright (c) 2020
 * @author Vladymyr Drohovoz flesh192@gmail.com
 */

namespace App\Services;

/**
 * Interface ISenderInterface
 * @package App\Services
 */
interface ISenderInterface
{
    /**
     * @param string $number
     * @param string $temperature
     * @throws RequestException
     * @throws ClientException
     * @throws Exception
     */
    public function sendSms(string $number, string $text): void;
}
