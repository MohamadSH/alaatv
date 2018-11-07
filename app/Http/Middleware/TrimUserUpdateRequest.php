<?php

namespace App\Http\Middleware;

use App\Traits\RequestCommon;
use Closure;
use Illuminate\Http\Response;

class TrimUserUpdateRequest
{

    const USER_UPDATE_TYPE_REQUEST_INDEX = "updateType" ; //Index of request that determines which update type it is
    const USER_UPDATE_TYPE_TOTAL = "total" ;
    const USER_UPDATE_TYPE_PROFILE = "profile" ;
    const USER_UPDATE_TYPE_ATLOGIN = "atLogin" ;
    const USER_UPDATE_TYPE_PASSWORD = "password" ;
    const USER_UPDATE_TYPE_PHOTO = "photo" ;

    protected $validUpdateTypes = [
            self::USER_UPDATE_TYPE_TOTAL  ,
            self::USER_UPDATE_TYPE_PROFILE,
            self::USER_UPDATE_TYPE_ATLOGIN  ,
            self::USER_UPDATE_TYPE_PASSWORD,
            self::USER_UPDATE_TYPE_PHOTO
    ];

    use RequestCommon;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
/**      Useful snippet code for getting binded model in middleware */
//        $user =  $request->route('user');
        if(!$this->hasCorrectUpdateType($request))
            return response(
                    [
                        "message" => "Please provide updateType input"
                    ] ,
                Response::HTTP_BAD_REQUEST
            );

        $updateType = $request->get(self::USER_UPDATE_TYPE_REQUEST_INDEX);
        if(strcmp($updateType , self::USER_UPDATE_TYPE_TOTAL ) != 0)
        {
            $this->trimUserFormRequest($request );
        }

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    private function hasCorrectUpdateType(\Illuminate\Http\Request $request) : bool
    {
        return ( $request->has(self::USER_UPDATE_TYPE_REQUEST_INDEX) && in_array($request->get(self::USER_UPDATE_TYPE_REQUEST_INDEX) , $this->validUpdateTypes) );
    }
}
