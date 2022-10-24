<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;

class TaskController extends Controller
{
    /**
     * タスク一覧ページ を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function list()
    {
        // 
        $per_page = 5;
        // 一覧の取得
        $list = TaskModel::where('user_id', Auth::id())
                        ->orderBy('priority', 'DESC')
                        ->orderBy('period')
                        ->orderBy('created_at')
                        ->paginate($per_page);
                        // ->get();
// $sql = TaskModel::where('user_id', Auth::id())
//                  ->orderBy('priority', 'DESC')
//                  ->orderBy('period')
//                  ->orderBy('created_at')
//                  ->toSql();
        return view('task.list', ['list' => $list]);
    }
    
    /**
     * タスクの詳細閲覧
     */
    public function detail($task_id)
    {
        // task_idのレコードを取得する
        $task = TaskModel::find($task_id);
        if ($task === null) {
            return redirect('/task/list');
        }
        // 本人以外のタスクならNGとする
        if ($task->user_id !== Auth::id()) {
            return redirect('/task/list');
        }
        // テンプレートに「取得したレコード」の情報を渡す
        return view('task.detail', ['task' => $task]);
    }
    
    /**
     * タスクの新規登録
     */
    public function register(TaskRegisterPostRequest $request)
    {
        $datum = $request->validated();
        
        // user_id の追加
        $datum['user_id'] = Auth::id();
        
        // テーブルへのINSERT
        try {
            $r = TaskModel::create($datum);
        } catch(\Throwable $e) {
            echo $e->getMessage();
            exit;
        }
        
        // タスク登録成功
        $request->session()->flash('front.task_register_success', true);

        //
        return redirect('/task/list');
    }
}

