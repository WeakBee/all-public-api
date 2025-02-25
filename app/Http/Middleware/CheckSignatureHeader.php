<?php

namespace App\Http\Middleware;

use App\ApiConnectionToken;
use Closure;
use Illuminate\Http\Request;

class CheckSignatureHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    
    public function handle(Request $request, Closure $next)
    {
        $signature = $request->header('Signature');
        $apiPath = $request->path();
        $apiName = str_replace('api/', '',$apiPath);

        // check validation token expired
        $checkToken = ApiConnectionToken::where('token', $signature)->where('name', $apiName)->first();
        $responses = [
            'error' => true,
            'message' => 'Unauthorized, invalid or Token expired ',
            'api_name' => $apiName,
            'status' => 401
        ];
        if (!$checkToken || now()->greaterThan($checkToken->expired_date) ) {
            return response()->json($responses, 401);
        }

        return $next($request);
    }
}
