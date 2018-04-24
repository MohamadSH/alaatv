<?php namespace App\Traits;

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
        $res = $client->request($method, $path , ['form_params'=>$request->all()]);
        return ["statusCode"=>$res->getStatusCode() , "result"=>$res->getBody()->getContents()];
    }

}