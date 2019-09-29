<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\CharacterCommon;

class ModifyRequestInputMiddleware
{
    use CharacterCommon;

    protected $input;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param                            $index
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $index)
    {
        $this->replaceNumbers($request, explode("|", $index));

        return $next($request);
    }
    
    protected function replaceNumbers(Request $request, array $array)
    {
        $input = $request->all();
        foreach ($array as $item) {
            if (isset($input[$item])) {
                $input[$item] = $this->convertToEnglish($input[$item]);
            }
        }
        $request->replace($input);
    }
}
