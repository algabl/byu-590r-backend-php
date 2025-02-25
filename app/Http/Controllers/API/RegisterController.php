<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
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
}
