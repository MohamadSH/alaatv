<?php namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

trait APIRequestCommon
{
    public function sendRequest($path, $method, $parameters = [], $headers = [])
    {
        $client = new Client();
        try {
            if (empty($headers)) {
                $res = $client->request($method, $path, ['form_params' => $parameters]);
            } else {
                $res = $client->request($method, $path, ['query' => $parameters, 'headers' => $headers]);
            }
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());
            Log::error('APIRequestCommon:sendRequest:'.$path);
//            throw new Exception($e->getMessage());
        }

        if(isset($res)){
            return [
                "statusCode" => $res->getStatusCode(),
                "result"     => $res->getBody()->getContents(),
            ];

        }

        return [
            "statusCode" => Response::HTTP_SERVICE_UNAVAILABLE,
            "result"     => 'cURL error',
        ];

    }
}
