<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('completed_shopping_lists', function (Blueprint $table) {
            //$table->id();
            $table->unsignedInteger('id');
            //$table->unsignedBigInteger('shopping_list_id')->comment('完了した買い物リストの元ID');
            $table->string('item_name', 255)->comment('買うもの名');
            $table->unsignedBigInteger('user_id')->comment('この商品の所有者');
            //$table->foreign('shopping_list_id')->references('id')->on('shopping_lists'); // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users'); // 外部キー制約
            //$table->timestamps();
            $table->dateTime('created_at')->useCurrent()->comment('買い物完了日時');
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_shopping_lists');
    }
};
