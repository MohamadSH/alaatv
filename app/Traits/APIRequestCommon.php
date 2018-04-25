<?php namespace App\Traits;

use GuzzleHttp\Exception\GuzzleException;
use \Illuminate\Http\Request;
use \GuzzleHttp\Client;

trait APIRequestCommon
{
    public function sendRequest( $path , $method , $parameters=[]) {
        $client = new Client();
        $request = new Request();
        foreach ($parameters as $key => $parameter)
        {
            $request->offsetSet($key , $parameter);
        }
        try {
            $res = $client->request($method, $path, ['form_params' => $request->all()]);
        } catch (GuzzleException $e) {
            dd($e);
        }
        return ["statusCode"=>$res->getStatusCode() , "result"=>$res->getBody()->getContents()];
    }

}