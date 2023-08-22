<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class SpotCategoryController extends Controller
{
    public function store(Request $request)
{
    DB::transaction(function () use ($request) {
        $user = auth()->user();

        // リクエストからスポットとカテゴリーの情報を取得
        $spot = Spot::find($request->input('spot.id'));
        $categories = $request->input('categories');

        // カテゴリーが選択されていない場合は保存しない
        if (!$categories) {
            session()->flash('message', 'カテゴリーを選択してください');
            return back();
        }

        // 現在のユーザーのカテゴリーとスポットの関連付けを取得
        $userCategoryIds = $user->categories->pluck('id')->toArray();

        // 現在のユーザーの関連付けを削除
        $spot->categories()->detach($userCategoryIds);

        // ユーザーが選択したカテゴリーにスポットを保存
        foreach ($categories as $category) {
            $userCategory = Category::find($category);
            if ($userCategory && $userCategory->user_id === $user->id) {
                $spot->categories()->attach($userCategory->id);
            }
        }

        session()->flash('message', '保存しました');

    });
    
    return back();
}


    public function destroy(Request $request)
    {
    }
}
