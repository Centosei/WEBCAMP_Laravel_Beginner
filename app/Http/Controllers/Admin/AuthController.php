<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginPostRequest;
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
        return view('admin.index');
    }
    
    /**
     * 入力を受け取る
     * 
     * @return \Illuminate\View\View
     */
    public function login(AdminLoginPostRequest $request)
    {
        $datum = $request->validated();
        // var_dump($datum); exit;
        
        // 認証
        if (Auth::guard('admin')->attempt($datum) === false) {
            return back()
               ->withInput() // 入力値の保持
               ->withErrors(['auth' => 'ログインIDかパスワードに誤りがあります。',]) // エラーメッセージの出力
               ;
        }

        //
        $request->session()->regenerate();
        return redirect()->intended('/admin/top');
    }
    
    /**
     * ログアウト処理
     * 
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->regenerateToken();  // CSRFトークンの再生成
        $request->session()->regenerate();  // セッションIDの再生成
        return redirect(route('admin.index'));
    }
}

