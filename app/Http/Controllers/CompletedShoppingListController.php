<?php

declare(strict_types=1); 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CompletedShoppingList as CompletedShoppingListModel;

class CompletedShoppingListController extends Controller
{
    protected function getListBuilder()
    {
        return CompletedShoppingListModel::where('user_id', Auth::id())
                    ->orderBy('item_name', 'ASC')
                    ->orderBy('created_at', 'ASC');
    }  

    public function list()
    {
       // 1Page辺りの表示アイテム数を設定
       $per_page = 2;
        
       // 一覧の取得
       $list = $this->getListBuilder()
                    ->paginate($per_page);
                       // ->get();
       
       return view('completed_shopping_list.list', ['list' => $list]);
    }
}