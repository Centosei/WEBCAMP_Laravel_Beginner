<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CompletedTask as CompletedTaskModel;
use Illuminate\Support\Facades\Auth;

class CompletedTaskController extends Controller
{
    /**
    * 完了したタスク一覧ページ を表示する
    * 
    * @return \Illuminate\View\View
    */
    public function list()
    {
        // 
        $per_page = 10;
        // 一覧の取得
        $list = $this->getListBuilder()
                     ->paginate($per_page);
        // 
        return view('task.completed_list', ['list' => $list]);
    }
     
    protected function getListBuilder()
    {
        return CompletedTaskModel::where('user_id', Auth::id())
                     ->orderBy('created_at');
    }
}