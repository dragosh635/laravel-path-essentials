<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckQueryParam {
    /**
     * Quick example about how to create a custom middleware
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle( Request $request, Closure $next ) {
        if ( $request->query( 'test' ) !== null ) {
            abort( 404 );
        }

        return $next( $request );
    }
}
