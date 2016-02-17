<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/products/create',
        'api/samplings/create'
    ];

    protected function shouldPassThrough($request)
    {
        if ($request->is('login') && $request->ajax()) return true;
        return parent::shouldPassThrough($request);
    }


}
