<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\http\Requests\RegisterRequest;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Contracts\RegisterResponse;


class RegisterController extends Controller
{


    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }


    public function store(RegisterRequest $request,
                          CreatesNewUsers $creator): RegisterResponse
    {
        if (config('fortify.lowercase_usernames')) {
            $request->merge([
                Fortify::username() => Str::lower($request->{Fortify::username()}),
            ]);
        }

        event(new Registered($user = $creator->create($request->all())));

        return app(RegisterResponse::class);
    }

    

}
