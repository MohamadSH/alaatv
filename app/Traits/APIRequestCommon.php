<?php namespace App\Traits;

use GuzzleHttp\Client;
use PHPUnit\Framework\Exception;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;

trait APIRequestCommon
{
    public function sendRequest($path, $method, $parameters = [] , $headers = [])
    {
        $client  = new Client();
        try {
            if(empty($headers)){
                $res = $client->request($method, $path, ['form_params' => $parameters]);
            }else{
               $res = $client->request($method, $path, ['query' => $parameters , 'headers' => $headers]);
            }
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());
            throw new Exception($e->getMessage());
        }

        return [
            "statusCode" => $res->getStatusCode(),
            "result"     => $res->getBody()->getContents(),
        ];
    }
}
