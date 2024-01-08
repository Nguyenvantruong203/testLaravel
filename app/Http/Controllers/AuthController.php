<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email',
            'name' => 'required',
        ], [
            'username.required' => 'Nhập tên tài khoản',
            'username.unique' => 'Tên tài khoản đã tồn tại',
            'password.required' => 'Nhập mật khẩu',
            'email.required' => 'Nhập Email',
            'email.email' => 'Email không hợp lệ',
            'name.required' => 'Nhập họ và tên',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $input = $request->all();
        User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully'
        ], 201);
    }
    // public function login(Request $request){
    //     if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
    //         $user = Auth::user();
    //         $success['token'] = $user->createToken('MyApp')->plainTextToken;

    //         // Lỗi ở đây, bạn ghi đè giá trị token bằng $user->name
    //         $success['token'] = $user->name;

    //         $response = [
    //             'success' => true,
    //             'data' => $success,
    //             'message' => 'user login successfully'
    //         ];
    //         return response()->json($response, 200);
    //     }else{
    //         $response = [
    //             'success' => false,
    //             'message' => 'Unauthorised'
    //         ];
    //         return response()->json($response);

    //     }
    // }
    public function login(Request $request){

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json(['mesages' => "login successgully", 'token' => $user->createToken('token')->plainTextToken], 201 );

}


    // public function login(Request $request)
    // {
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password, [])) {
    //         return response()->json([
    //             "message" => "user not exist"
    //         ], 404);
    //     }
    //     $token = $user->createToken('authToken')->plainTextToken;

    //     return response()->json([
    //         "access_token" => $token,
    //         "type_token" => "Bearer",
    //         $request

    //     ], 200);

    // }

}
