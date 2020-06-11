<?php

/**
 * @copyright Copyright (c) 2020
 * @author Vladymyr Drohovoz flesh192@gmail.com
 */

namespace App\Gateway;

use App\Services\ISenderInterface;
use GuzzleHttp\Client;

/**
 * Class RouteeSmsSenderGataway
 * @package App\Gateway
 */
class RouteeSmsSenderGataway implements ISenderInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var
     */
    private $token;

    /**
     * RouteeSmsSenderGataway constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->authToken();
    }

    /**
     * @inheritDoc
     */
    public function sendSms(string $number, string $text): void
    {
        try {
            $this->client->post($_ENV['ROUTEE_SEND_SMS_URL'], [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'body' => $text,
                    'to' => $number,
                    'from' => 'Vladymyr',
                ],
            ]);
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

    /**
     * Get auth token and save them to apc
     * @throws RequestException
     * @throws ClientException
     * @throws Exception
     */
    private function authToken(): void
    {
        if (!apc_fetch('routee_token')) {
            try {
                $response = $this->client->post($_ENV['ROUTEE_AUTH_URL'], [
                    'headers' => [
                        'Authorization' => 'Basic ' . base64_encode($_ENV['ROUTEE_APP_ID'] . ':' . $_ENV['ROUTEE_APP_SECRET']),
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                    ],
                ]);
                $data = json_decode($response->getBody()->getContents());
                apc_store('routee_token', $data->access_token, $data->expires_in);
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
        $this->token = apc_fetch('routee_token');
    }

}