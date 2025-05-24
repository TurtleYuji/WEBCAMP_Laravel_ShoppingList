<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    //ユーザ一覧を表示する
    public function list()
    {
        $group_by_column = ['users.id', 'users.name'];
        $users = User::select($group_by_column)
                      ->selectRaw('COUNT(completed_shopping_lists.id) AS shopping_count') // COUNT対象も変更
                      ->leftJoin('completed_shopping_lists', 'users.id', '=', 'completed_shopping_lists.user_id') // 結合テーブル名を変更
                      ->groupBy($group_by_column)
                      ->orderBy('users.id')
                      ->get();

        return view('admin.user.list', compact('users'));
    }
}