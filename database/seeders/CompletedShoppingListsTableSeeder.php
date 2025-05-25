<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // DBファサードを使用
use App\Models\User; // Userモデルを使用
use Carbon\Carbon; // 日付を扱うCarbonを使用

class CompletedShoppingListsTableSeeder extends Seeder
{

    public function run(): void
    {
        // 既存のユーザーIDを取得、または存在しない場合は作成
        $user1 = User::firstOrCreate(
            ['email' => 'test3@example.com'], // 存在確認用のカラム
            [
                'name' => 'テスト3',
                'password' => bcrypt('dmmcamp'), // パスワードは適宜設定
                'email_verified_at' => now(), // メールの認証日時も設定（nullableでなければ）
            ]
        );

        // 外部キー制約を一時的に無効にする（必要な場合のみ。通常はシーダーの実行順序で解決）
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 既存のデータを削除（もしあれば。重複挿入を避けるため）
        DB::table('completed_shopping_lists')->truncate(); // 全て削除してIDもリセット

        // 挿入するデータ
        $data = [
            // ユーザー1のデータ
            [
                'id' => 101, // 手動でユニークなIDを指定
                'item_name' => 'aaa',
                'user_id' => $user1->id,
                'created_at' => Carbon::parse('2025-01-01 10:00:00'), // 日付を明示的に指定
                'updated_at' => Carbon::parse('2025-01-01 10:00:00'),
            ],
            [
                'id' => 102,
                'item_name' => 'aaa',
                'user_id' => $user1->id,
                'created_at' => Carbon::parse('2025-05-05 15:00:00'), // 異なる日付
                'updated_at' => Carbon::parse('2025-05-05 15:00:00'),
            ],
            [
                'id' => 103,
                'item_name' => 'aaa',
                'user_id' => $user1->id,
                'created_at' => Carbon::parse('2024-01-01 12:00:00'), // ソートテスト用のデータ
                'updated_at' => Carbon::parse('2024-01-01 12:00:00'),
            ],
            [
                'id' => 104,
                'item_name' => 'aaa',
                'user_id' => $user1->id,
                'created_at' => Carbon::parse('2024-05-05 09:30:00'),
                'updated_at' => Carbon::parse('2025-05-05 09:30:00'),
            ],
        ];

        // データを挿入
        DB::table('completed_shopping_lists')->insert($data);

        // 外部キー制約を有効に戻す（無効にした場合のみ）
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}