<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;

class SubCategoryController extends Controller
{
    public function subCategories()
    {
        $pageTitle = 'SubCategories';
        $emptyMessage = 'No data found';
        $categories = Category::paginate(getPaginate());
        $subCategories = SubCategory::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.sub_categories.log', compact('pageTitle', 'categories', 'subCategories'));
    }

    public function subCategoryStore(SubCategoryRequest $request)
    {
        $pageTitle = 'Create SubCategories';
        $subCategory = new SubCategory();
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category_id;
        $subCategory->status = $request->status;
        $subCategory->save();
        $notify[] = ['success', 'SubCategory create successfully'];
        return to_route('admin.sub.category.all')->withNotify($notify);
    }

    public function SubCategoryUpdate(SubCategoryRequest $request, SubCategory $subCategory)
    {
        $pageTitle = 'SubCategory Update';
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category_id;
        $subCategory->status = $request->status;
        $subCategory->save();
        $notify[] = ['success', 'SubCategory create successfully'];
        return to_route('admin.sub.category.all')->withNotify($notify);
    }

}
