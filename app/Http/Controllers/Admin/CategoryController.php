<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function categories()
    {
        $pageTitle = 'Categories';
        $emptyMessage = 'No data found';
        $categories = Category::paginate(getPaginate());
        return view('admin.categories.log', compact('pageTitle', 'categories'));
    }

    public function categoryStore(CategoryRequest $request)
    {
        $pageTitle = 'Create Category';
        $category = new Category(); 
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
        $notify[] = ['success', 'Category create successfully'];
        return to_route('admin.category.all')->withNotify($notify);
    }

    public function categoryUpdate(CategoryRequest $request, Category $category)
    {
        $pageTitle = 'Category Update';
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
        $notify[] = ['success', 'Category Update successfully'];
        return to_route('admin.category.all')->withNotify($notify);
    }

}
