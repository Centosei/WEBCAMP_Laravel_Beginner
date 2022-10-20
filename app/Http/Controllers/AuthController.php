<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * トップページ を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }
    
    /**
     * 入力を受け取る
     * 
     * @return \Illuminate\View\View
     */
    public function login(LoginPostRequest $request)
    {
        $datum = $request->validated();
        // var_dump($datum); exit;
        
        // 認証
        if (Auth::attempt($datum) === false) {
            return back()
               ->withInput() // 入力値の保持
               ->withErrors(['auth' => 'emailかパスワードに誤りがあります。',]) // エラーメッセージの出力
               ;
        }

        //
        $request->session()->regenerate();
        return redirect()->intended('/task/list');
    }
    
    /**
     * ログアウト処理
     * 
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();  // CSRFトークンの再生成
        $request->session()->regenerate();  // セッションIDの再生成
        return redirect(route('front.index'));
    }
}

