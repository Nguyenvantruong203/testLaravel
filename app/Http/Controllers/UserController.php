<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    public function show(string $id)
    {
        return User::findOrFail($id);

    }
    public function index()
    {
        $users = User::
            join('departments', 'users.department_id', '=', 'departments.id')
            ->join('users_status', 'users.status_id', '=', 'users_status.id')
            ->select('users.*', 'departments.name as departments', 'users_status.name as users_status')
            ->get();

            return response()->json($users);
    }

    public function create(){

        $users_status = DB::table('users_status')
        ->select(
            "id as value",
            "name as label"
        )
        ->get();
        $departments = DB::table('departments')
            ->select(
            "id as value",
            "name as label"
        )
        ->get();

        return response()->json([
            "users_status" => $users_status,
            "departments" => $departments
        ]);

    }

    public function store(Request $request){
        $validated = $request->validate([
            'password'=> 'required|confirmed',
            'email'=> 'required|email',
            'name'=> 'required',
            'department_id'=> 'required',
            'status_id'=> 'required',
        ],
        [
            'password.required'=> 'Nhập mật khẩu',
            'password.confirmed'=> 'Nhập mật khẩu không khớp',
            'email.required'=> 'Nhập Email',
            'email.email'=> 'Email không hợp lệ',
            'name.required'=> 'Nhập họ và tên',
            'department_id.required'=> 'Nhập phòng ban',
            'status_id.required'=> 'Nhập trạng thái'

        ]);

        $user = $request->except(['password', 'password_confirmation']);
        $user['password'] = bcrypt($request->password);
        User::create($user);

        // User::create([
        //     "status_id" => $request['status_id'],
        //     'username'=> $request['username'],
        //     'name'=> $request['name'],
        //     'email'=> $request['email'],
        //     'password'=> bcrypt($request['password']),
        //     'department_id'=> $request['department_id'],

        // ]);
    }

    public function edit($id){
        $users = User::find($id);

        $users_status = DB::table('users_status')
        ->select(
            "id as value",
            "name as label"
        )
        ->get();
        $departments = DB::table('departments')
            ->select(
            "id as value",
            "name as label"
        )
        ->get();

        return response()->json([
            "users" => $users,
            "users_status" => $users_status,
            "departments" => $departments
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "status_id" => "required",
            // "username" => "required|",
            "name" => "required|unique:users,name,".$id,
            "email" => "required|email",
            "department_id" => "required"
        ], [
            "status_id.required" => "Nhập Tình trạng",
            // "username.required" => "Nhập Tên Tài khoản",
            // "username.unique" => "Tên Tài khoản đã tồn tại",
            "name.required" => "Nhập Họ và Tên",
            "name.max" => "Ký tự tối đa là 255",
            "email.required" => "Nhập Email",
            "email.email" => "Email không hợp lệ",
            "department_id.required" => "Nhập Phòng ban"
        ]);

        User::find($id)->update([
            "status_id" => $request["status_id"],
            "name" => $request["name"],
            "email" => $request["email"],
            "department_id" => $request["department_id"]
        ]);

        if($request["change_password"] == true)
        {
            $validated = $request->validate([
                "password" => "required|confirmed"
            ], [
                "password.required" => "Nhập Mật khẩu",
                "password.confirmed" => "Mật khẩu và Xác nhận mật khẩu không khớp"
            ]);

            User::find($id)->update([
            'password'=> bcrypt($request['password']),
                "change_password_at" => NOW()
            ]);
        }
    }
    public function destroy($id)
    {
        $product = User::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
    public function getUser(Request $request)
    {
        return response()->json(['user' => $request->user()], 200);
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout success'], 200);
    }

}
