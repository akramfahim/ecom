<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

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



    // Product
    public function addProduct(Request $request)
    {
        $this->validate($request,[
            'productName' => 'required | unique:products',
            'productDescription' => 'required',
            'productPrice' => 'required|numeric|gt:0',
            'category_id' => 'required',
        ]);

        $image = $request->productImage;
        $file = $this->getFileName($image);
        $path = public_path().'/uploads/'.$file;
        file_put_contents($path, $file);

        $request->request->add(['productImage' => $file]);

        //return $request->all();

        return Product::create([
            'productName' => $request->productName,
            'productDescription' => $request->productDescription,
            'category_id' => $request->category_id,
            'productPrice' => $request->productPrice,
            'productImage' => $file,
            'productStatus' => $request->productStatus
        ]);


    }

    public function getFileName($file)
    {
        $exploded = explode(',' , $file);

        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg')){
            $extension = 'jpg';
        }else{
            $extension = 'png';
        }

        $filename = time().'.'.$extension;

        return $filename;
    }
}
