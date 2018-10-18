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
     * @var \GuzzleHttp\Client
     */
    protected $http;

    public function __construct(HttpClient $http, $userName, $password, $number, $url)
    {
        $this->number = $number;
        $this->userName = $userName;
        $this->http = $http;
        $this->password = $password;
        $this->url = $url;


    }

    /**
     * @param array $params
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(array $params)
    {
        $url = $this->url;
        $base = [
            'username' => $this->userName,
            'password' => $this->password,
            'from' => $this->number,
        ];
        if (isset($params['from']))
            unset($base["from"]);

        $params = array_merge($base, $params);

        try {
            $response = $this->http->request('GET', $url, [
                'query' => $params
            ]);
        } catch (GuzzleException $e) {
            throw $e;
        }

        return json_decode((string)$response->getBody(), true);
    }
}