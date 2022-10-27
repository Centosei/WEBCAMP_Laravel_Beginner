<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * 会員登録ページ を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('user.register');
    }
    
    /*
     * 会員登録
     */
    public function register(UserRegisterPost $request)
    {
        $datum = $request->validated();
        // 
        try {
            DB::table('users')->insert([
            'name' => $datum['name'],
            'email' => $datum['email'],
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make($datum['password']),
            ]);
        } catch(\Throwable $e) {
            echo $e->getMessage();
            exit;
        }
        
        // 会員登録成功
        $request->session()->flash('front.user_register_success', true);

        // ログインページにリダイレクト
        return redirect('/');
    }
}