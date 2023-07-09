<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->dropForeign(['category_id']); // 外部キー制約を削除
            $table->dropColumn('category_id'); // category_idカラムを削除
        });

        Schema::table('spots', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable(); // category_idカラムを再作成し、null許容にする
            $table->foreign('category_id')->references('id')->on('categories'); // 外部キー制約を再設定
        });
    }

    public function down()
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::table('spots', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained(); // 元の状態に戻す
        });
    }
};
