<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 13.12.22
 * Time: 13.25
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'registration']]);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="login",
     *      tags={"login"},
     *      summary="Login into the app",
     *      description="Logins user in a system",
     *      @OA\Parameter(
     *          name="email",
     *          description="user email",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="password",
     *          description="user pwd",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     */
    public function login()
    {

        $credentials = request(['email', 'password']);

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Cache::store('file')->put('jwt_token', $token, 1000);

        return $this->respondWithToken($token)->withCookie(\cookie('cookie_name', '1', 360));
    }

    /**
     * @OA\Post(
     *      path="/api/auth/registration",
     *      operationId="registration",
     *      tags={"login"},
     *      summary="Login into the app",
     *      description="Logins user in a system",
     *      @OA\Parameter(
     *          name="name",
     *          description="user name",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="email",
     *          description="user email",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="password",
     *          description="user password",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     */
    public function registration(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required|max:10',
        ]);

        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        return response()->json(['message' => 'Successfully registration!']);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/me",
     *      operationId="me",
     *      tags={"login"},
     *      summary="Login into the app",
     *      description="Logins user in a system",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     */
    public function me()
    {
        return response()->json(auth()->guard('api')->user());
    }

    /**
     * @OA\Post(
     *      path="/api/auth/logout",
     *      operationId="logout",
     *      tags={"login"},
     *      summary="Login into the app",
     *      description="Logins user in a system",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     */
    public function logout()
    {
        auth()->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/refresh",
     *      operationId="refresh",
     *      tags={"login"},
     *      summary="Login into the app",
     *      description="Logins user in a system",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60,
        ]);
    }
}
