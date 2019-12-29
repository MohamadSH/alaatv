<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-04-23
 * Time: 21:24
 */

namespace App\Classes\sms;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;

class MedianaPatternClient implements SmsSenderClient
{
    /**
     * The SMS Number to send the message from.
     *
     * @var int
     */
    protected $number;

    /**
     * Username for SMS Gateway.
     *
     * @var string
     */
    protected $userName;

    /**
     * Password for SMS Gateway.
     *
     * @var string
     */
    protected $password;

    protected $url;

    /**
     * The HTTP Client instance.
     *
     * @var HttpClient
     */
    protected $http;

    public function __construct(HttpClient $http, $userName, $password, $number, $url)
    {
        $this->number   = $number;
        $this->userName = $userName;
        $this->http     = $http;
        $this->password = $password;
        $this->url      = $url;
    }

    /**
     * @param array $params
     *
     * @return array
     * @throws GuzzleException
     */
    public function send(array $params)
    {
        $url  = $this->url;
        $base = [
            'user'    => $this->userName,
            'pass'    => $this->password,
            'fromNum' => $this->number,
        ];
        if (isset($params['from'])) {
            unset($base["from"]);
        }

        $params = array_merge($base, $params);
        try {
            $response = $this->http->post($url, [
                'headers' => [
                    'Accept'     => 'application/json',
                    'User-Agent' => 'GuzzleHttp/6.3.3 curl/7.52.1',
                ],
                'json'    => $params,
            ]);
        } catch (GuzzleException $e) {
            throw $e;
        }

        return json_decode((string)$response->getBody(), true);
    }
}
