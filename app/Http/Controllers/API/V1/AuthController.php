<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'email' => 'required|string|unique:users|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $token = $user->createToken('register_token')->plainTextToken;

            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => $user,
                'access_token' => $token,
                'type' => 'Bearer'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
            //throw $th;
        }
    }
    /**
     * @OA\Post(
     *     path="/api/V1/login",
     *     summary="Login user",
     *     description="Login dengan email dan password untuk mendapatkan token Bearer",
     *     operationId="login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="jian"),
     *             @OA\Property(property="email", type="string", example="jianaja@gmail.com"),
     *             @OA\Property(property="password", type="string", example="123.321A")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login berhasil, token diberikan",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="your_generated_token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized, login gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if (!Auth::attempt($credentials)) {
            if (!$user || !Hash::check($request['password'], $user->password)) {
                return response()->json([
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'Invalid credentials'
                ], Response::HTTP_UNAUTHORIZED);
            }
        }
        $token = $user->createToken('login_token')->plainTextToken;
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Login success',
            'data' => $request->user(),
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Logout success'
        ], Response::HTTP_OK);
    }
}
