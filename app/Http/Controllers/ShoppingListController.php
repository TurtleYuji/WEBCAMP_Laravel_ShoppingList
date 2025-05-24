<?php

declare(strict_types=1); 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShoppingListRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\ShoppingList as ShoppingListModel;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedShoppingList as CompletedShoppingListModel;

class ShoppingListController extends Controller
{

    protected function getListBuilder()
    {
        return ShoppingListModel::where('user_id', Auth::id())
                     ->orderBy('item_name', 'ASC')
                     ->orderBy('created_at');
    }  

    public function list()
    {
        // 1Page辺りの表示アイテム数を設定
        $per_page = 2;
        
        // 一覧の取得
        $list = $this->getListBuilder()
                     ->paginate($per_page);

        return view('shopping_list.list', ['list' => $list]);
    }

    public function register(ShoppingListRegisterPostRequest $request)
    {
         // validate済みのデータの取得
        $datum = $request->validated();

        // user_id の追加
        $datum['user_id'] = Auth::id();

        // テーブルへのINSERT
        try {
            $r = ShoppingListModel::create($datum);
        } catch(\Throwable $e) {
            // XXX 本当はログに書く等の処理をする。今回は一端「出力する」だけ
            echo $e->getMessage();
            exit;
        }

            // タスク登録成功
            $request->session()->flash('front.task_register_success', true);

            // リダイレクト
            return redirect('/shopping_list/list');
    }

    public function delete(Request $request, $shopping_list_id)
    {
        // shopping_list_idのレコードを取得する
        $shoppingItem = $this->getShoppingListModel($shopping_list_id);

        // 「買うもの」を削除する
        if ($shoppingItem !== null) {
            $shoppingItem->delete();
            $request->session()->flash('front.task_delete_success', true);
        }

        // 一覧に遷移する
        return redirect('/shopping_list/list');
    }

    //「単一の買うもの」Modelの取得
   
    protected function getShoppingListModel($shopping_list_id)
    {
        // shopping_list_idのレコードを取得する
        $shoppingItem = ShoppingListModel::find($shopping_list_id); 
        if ($shoppingItem === null) {
            return null;
        }
        // 本人以外のアイテムならNGとする
        if ($shoppingItem->user_id !== Auth::id()) {
            return null;
        }
        
        return $shoppingItem;
    }

     //買うものの完了

    public function complete(Request $request, $shopping_list_id)
    {
        /* 買うものを完了テーブルに移動させる */
        try {
            // トランザクション開始
            DB::beginTransaction();

            // $shopping_list_idのレコードを取得する
            $shoppingItem = $this->getShoppingListModel($shopping_list_id);
            if ($shoppingItem === null) {
                // $shopping_list_idが不正なのでトランザクション終了
                throw new \Exception('');
            }

            //var_dump($shoppingItem->toArray()); exit;
            //shopping_lists側を削除する
            $shoppingItem->delete();

            //completed_shopping_lists側にinsertする
            $shopping_datum = $shoppingItem->toArray();
            unset($shopping_datum['created_at']);
            unset($shopping_datum['updated_at']);
            $r = CompletedShoppingListModel::create($shopping_datum);
            if ($r === null) {
                // insertで失敗したのでトランザクション終了
                throw new \Exception('');
            }
            // echo '処理成功'; exit;

            // トランザクション終了
            DB::commit();
            // 完了メッセージ出力
            $request->session()->flash('front.task_completed_success', true);
        } catch(\Throwable $e) {
            var_dump($e->getMessage()); exit;
            // トランザクション異常終了
            DB::rollBack();
            // 完了失敗メッセージ出力
            $request->session()->flash('front.task_completed_failure', true);
        }

        // 一覧に遷移する
        return redirect('/shopping_list/list');
    }

}