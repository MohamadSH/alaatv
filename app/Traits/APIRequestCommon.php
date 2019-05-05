<?php namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PHPUnit\Framework\Exception;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;

trait APIRequestCommon
{
    public function sendRequest($path, $method, $parameters = [])
    {
        $client  = new Client();
        $request = new Request();
        foreach ($parameters as $key => $parameter) {
            $request->offsetSet($key, $parameter);
        }
        try {
            $res = $client->request($method, $path, ['form_params' => $request->all()]);
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
        
        return [
            "statusCode" => $res->getStatusCode(),
            "result"     => $res->getBody()
                ->getContents(),
        ];
    }
}
