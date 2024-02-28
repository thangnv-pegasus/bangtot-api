<?php

namespace App\Http\Controllers;

use App\Models\AuthenModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->all()['data']['email'];
        $password = $request->all()['data']['password'];
        $validate = Validator::make($request->all()['data'], [
            'email' => 'email | max:255',
            'password' => 'required | nullable | min:7 | max:20'
        ]);

        if ($validate->fails()) {
            return response([
                'code' => '400',
                'data' => [],
                'message' => 'Đảm bảo tài khoản là email và mật khẩu từ 8 đến 20 kí tự'
            ]);
        } else if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
            $user = Auth::user();
            Auth::login($user);
            // Auth::loginUsingId($user->id);
            $token = $user->createToken('main')->plainTextToken;
            return response([
                'code' => '200',
                'token' => $token,
                'user'=> $user,
                'token_type' => 'Bearer',
                'message' => 'Đăng nhập thành công'
            ]);
        } else {
            return response([
                'code' => '400',
                'data' => [],
                'message' => 'Sai tài khoản hoặc mật khẩu!'
            ]);
        }
    }

    public function register(Request $request)
    {

        $email = $request->all()['data']['email'];
        $fullname = $request->all()['data']['fullname'];
        $address = $request->all()['data']['address'];
        $phone = $request->all()['data']['phone'];
        $password = $request->all()['data']['password'];
        $validate = Validator::make($request->all()['data'], [
            'email' => 'email | unique:users| min:16 | max:255',
            'password' => 'required | nullable | min:8 | max:20'
        ]);
        try {
            if ($validate->fails()) {
                return response([
                    'code' => '301',
                    'message' => 'Đảm bảo email chưa được dùng bởi 1 tài khoản khác và mật khẩu từ 8 đến 20 kí tự',
                    'data' => []
                ]);
            } else {
                $user = User::create([
                    'email' => $email,
                    'name' => $fullname,
                    'address' => $address,
                    'phone' => $phone,
                    'password' => $password,
                    'status' => 1,
                    'role' => 'user'
                ]);
                $token = $user->createToken('userToken')->plainTextToken;

                return response([
                    'code' => 200,
                    'message' => 'Đăng kí tài khoản thành công!',
                    'data' => $token
                ]);
            }
        } catch (Exception $e) {
            return response([
                'code' => '400',
                'message' => 'Đăng kí tài khoản không thành công!',
                'data' => $e
            ]);
        }
    }

    public function destroy(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response([
            'code' => 200,
            'message' => 'Đăng xuất thành công!',
        ]);
        // return 'logout';
    }

    public function user(Request $request){
        if(auth()->user()){
            return response([
                'user' => auth()->user(),
                'token' => $request->bearerToken()
            ]);
        }
        return response([
            'user' => null,
            'token' => null
        ]);
    }
}