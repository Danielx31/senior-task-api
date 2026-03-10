<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiLoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);

        $queryCount = 0;
        $queryTime = 0;

        DB::listen(function ($query) use (&$queryCount, &$queryTime) {
            $queryCount++;
            $queryTime += $query->time;
        });


        $response = $next($request);

        $executionTime = microtime(true) - $start;

        Log::info("API Request Log", [
            'method' => $request->method(),
            'url'    => $request->fullUrl(),
            'status' => $response->getStatusCode(),
            'execution_time' => $executionTime,
            'query_count'    => $queryCount,
            'query_time_ms'  => $queryTime

        ]);

        return $response;
    }
}
