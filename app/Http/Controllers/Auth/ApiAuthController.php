<?php

namespace Framework\Http\Controllers\Auth;

use Framework\Features\Auth\RegisterUserFeature;
use Framework\Features\Auth\LoginUserFeature;
use Lucid\Foundation\Http\Controller;
use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    public function register (Request $request)
    {
        return $this->serve(RegisterUserFeature::class);
    }

    public function login (Request $request)
    {
        return $this->serve(LoginUserFeature::class);
    }

    public function logout (Request $request)
    {

    }
}
