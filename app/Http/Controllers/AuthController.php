<?php

namespace App\Http\Controllers;

use App\Services\TokenService;
use Exception;
use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;
use External\Foo\Auth\AuthWS;
use External\Foo\Exceptions\AuthenticationFailedException;
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
        $bazLoginService = new Authenticator();
        $fooLoginService = new AuthWS();
        $barRes = $barLoginService->login((string) $login, (string) $password);
        $bazRes = $bazLoginService->auth((string) $login, (string) $password);
        
        try {
            $fooRes = $fooLoginService->authenticate((string) $login, (string) $password);

        } catch (AuthenticationFailedException $e) {
            
        }
        if ($barRes || $bazRes instanceof Success || is_null($fooRes)) {
            return $this->getTokenSuccess();
        }

        return response()->json([
            'status' => 'failure'
        ]);

    }

       

    private function getTokenSuccess()
    {
        $tokenService = new TokenService();
        $token = $tokenService->generate();

        return response()->json([
            'status' => 'success',
            'token'  => $token
        ]);
    }
}
