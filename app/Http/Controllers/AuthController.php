<?php

namespace App\Http\Controllers;

use External\Bar\Auth\LoginService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;





class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {

        $login = $request->input('login');
        $password = $request->input('password');

        $barLoginService = new LoginService();

        $res = $barLoginService->login((string) $login, (string) $password);

        

        return response()->json([
            'res' => $res,
            'status' => 'failure',

        ]);
    }
}
