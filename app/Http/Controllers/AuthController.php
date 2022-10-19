<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;

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
        var_dump($datum); exit;
        
        // return view('test.input', ['datum' => $validatedData]);
    }
}

