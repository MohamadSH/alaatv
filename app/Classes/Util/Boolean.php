<?php

namespace App\Classes\Util;

use Illuminate\Http\Exceptions\HttpResponseException;

class Boolean
{
    private $result;
    
    /**
     * Nullable constructor.
     *
     * @param $result
     */
    public function __construct($result)
    {
        $this->result = $result;
    }
    
    public static function if($boolean)
    {
        return new static($boolean);
    }
    
    public function thenRespondWith($response)
    {
        if ($this->result) {
            $this->respond($response);
        }
    }

    public function orRespondWith($response)
    {
        if (! $this->result) {
            $this->respond($response);
        }
    }

    /**
     * @param $response
     */
    private function respond($response)
    {
        if (is_array($response)) {
            $response = call_user_func_array($response[0], $response[1]);
        }

        throw new HttpResponseException($response);
    }
}