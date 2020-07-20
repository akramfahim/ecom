<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class AdminController extends Controller
{
    
    public function allCategories()
    {
        return Category::orderBy('id','desc')->get();
    }
    
    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required|unique:categories'
        ]);
        return Category::create([
            'categoryName' => $request->categoryName,
            'status' => $request->status
        ]);
    }
    public function editCategory(Request $request)
    {
        $this->validate($request, [
            'id'=> 'required',
            'categoryName' => 'required| unique:categories,categoryName,'.$request->id
        ]);
        return Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'status' => $request->status
        ]);
    }
    public function deleteCategory(Request $request)
    {
        $this->validate($request, [
            'id'=> 'required'
        ]);
        return Category::where('id', $request->id)->delete();
    }
}
