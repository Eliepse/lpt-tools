<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function __construct()
	{
		$this->middleware("throttle:api.auth")->only(["login"]);
		$this->middleware("auth:sanctum")->except(["login"]);
	}


	public function login(Request $request)
	{
		if (Auth::guard("web")->attempt($request->only(['email', 'password']))) {
			return Auth::user();
		}

		return response(status: 401);
	}


	public function logout()
	{
		Auth::guard("web")->logout();
		return response()->noContent();
	}
}