<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * @OA\SecurityScheme(
     *     securityScheme="bearerAuth",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     description="Autenticación con token JWT"
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar nuevo usuario",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *             @OA\Property(property="name", type="string", minLength=10, maxLength=100),
     *             @OA\Property(property="email", type="string", format="email", minLength=10, maxLength=50),
     *             @OA\Property(property="password", type="string", format="password", minLength=8),
     *             @OA\Property(property="password_confirmation", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario registrado con éxito"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:10|max:100',
            'email' => 'required|string|email|min:10|max:50|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json($user);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Iniciar sesión y obtener token JWT",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", minLength=10, maxLength=50),
     *             @OA\Property(property="password", type="string", format="password", minLength=8)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso, devuelve token JWT"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales inválidas"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|min:10|max:50',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $credentials = $request->only(['email', 'password']);
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
            $user = Auth::user();
            $expiresIn = JWTAuth::factory()->getTTL() * 60;
            $expiresAt = now()->addSeconds($expiresIn);
            return response()->json([
                'token' => $token,
                'expires_in' => $expiresIn,
                'expires_at' => $expiresAt->toDateTimeString(),
                'user'  => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ], 200);
            return response()->json(['token' => $token], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token', $e], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/me",
     *     summary="Obtener datos del usuario autenticado",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Datos del usuario autenticado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o no enviado"
     *     )
     * )
     */
    public function getUser()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json($user, 200);
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Cerrar sesión (invalidar token JWT)",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Sesión cerrada correctamente"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token inválido o no autenticado"
     *     )
     * )
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
