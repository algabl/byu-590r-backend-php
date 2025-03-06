<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use function Laravel\Prompts\error;

class RegisterController extends BaseController
{
    /**
     * Register api
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        Log::info("register");
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:10',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), code: 400);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                if ($user instanceof User) {
                    $user->tokens()->delete();
                    $success['token'] = $user->createToken('MyApp')->plainTextToken;
                    $success['name'] = $user->name;
                    return $this->sendResponse($success, 'User login successfully.');
                } else {
                    throw new Exception('User not found');
                }
            } else {
                return $this->sendError('Unauthorized.', ['error' => 'Unauthorized'], 401);
            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), [], 500);
        }
    }

    /**
     * Logout api
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = User::find($request->id);
        $user->tokens()->where('id', $request->token)->delete();
        $success['id'] = $request->id;
        return $this->sendResponse($success, 'User logout successfully.');
    }

    /**
     * Forgot password api
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), code: 400);
        }
        $existingToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if ($existingToken) {
            $token = $existingToken->token;
        } else {
            $token = Str::random(64);
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        }

        Mail::send('forgotpassword', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return $this->sendResponse([], 'We have e-mailed your password reset link!');
    }

    /**
     * Reset password api
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
            return $this->sendError('Validation Error.', ['token' => 'Token or email is required'], code: 400);
        }

        $record = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('email', $email)
            ->first();

        if (!$record) {
            return $this->sendError('Validation Error.', ['token' => 'Invalid token'], code: 400);
        }

        $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 12);


        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = bcrypt($newPassword);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $email)->delete();


        Mail::raw("Your password has been reset. Your new password is: $newPassword", function ($message) use ($email) {
            $message->to($email)
                ->subject('Your new password');
        });

        return $this->sendResponse([], 'Password has been reset successfully!');
    }
}
