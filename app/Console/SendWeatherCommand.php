<?php

/**
 * @copyright Copyright (c) 2020
 * @author Vladymyr Drohovoz flesh192@gmail.com
 */

namespace App\Console;


use App\Services\ISenderInterface;
use App\Services\IWeatherInterface;

/**
 * Class SendWeatherCommand
 * @package App\Console
 */
class SendWeatherCommand
{
    /**
     * @var IWeatherInterface
     */
    private $weatherGateway;

    /**
     * @var ISenderInterface
     */
    private $senderGateway;

    /**
     * SendWeatherCommand constructor.
     * @param IWeatherInterface $weatherGateway
     * @param ISenderInterface $senderGateway
     */
    public function __construct(IWeatherInterface $weatherGateway, ISenderInterface $senderGateway)
    {
        $this->weatherGateway = $weatherGateway;
        $this->senderGateway = $senderGateway;
    }

    /**
     * Send sms depends of temperature
     * @return string
     */
    public function sendWeather(): string
    {
        $temperature = $this->weatherGateway->getWeather()->main->temp ?? null;
        //TODO: Here better to call helper, but to keep it simple I decide left this logic as it is
        if ($temperature) {
            if ($temperature>20) {
                $text = "Your name and Temperature more than 20C. $temperature";
                $this->senderGateway->sendSms($_ENV['PHONE_MORE_20'], $text);
            } else {
                $text = "Your name and Temperature less than 20C. $temperature";
                $this->senderGateway->sendSms($_ENV['PHONE_LESS_20'], $text);
            }
        }
        return 'Message was sent';
    }
}