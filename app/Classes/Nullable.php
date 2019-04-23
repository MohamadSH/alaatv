<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;

class Nullable
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

    /**
     * @param $default
     * @return mixed
     */
    public function getValue($default)
    {
        if (! is_null($this->result) && $this->result !== false) {
            return $this->result;
        }

        if (is_null($default)) {
            return optional();
        } elseif (is_callable($default)) {
            return call_user_func($default);
        } else {
            return $default;
        }
    }

    /**
     * @param $response
     * @return mixed
     */
    public function orFailWith($response)
    {
        return $this->getValue(function () use ($response) {
            if (is_callable($response)) {
                $response = call_user_func($response);
            }

            throw new HttpResponseException($response);
        });
    }

    public function otherwise($response)
    {
        $this->orFailWith($response);
    }

    public function then($response)
    {
        if ($this->result) {
            throw new HttpResponseException($response);
        }
    }
}