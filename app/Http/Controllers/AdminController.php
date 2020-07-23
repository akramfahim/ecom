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
    //Get All Product List
    public function allProducts()
    {
        return Product::with('category')->orderBy('id','desc')->get();
    }

    //Add new Product
    public function addProduct(Request $request)
    {
        $this->validate($request,[
            'productName' => 'required | unique:products',
            'productDescription' => 'required',
            'productPrice' => 'required|numeric|gt:0',
            'category_id' => 'required',
            'productImage' => 'sometimes'
        ]);

        // $imageName = time().'.'.$request->productImage->extension();  
        // $request->productImage->move(public_path('uploads'), $imageName);

        // $image = time().'.' . explode('/', explode(':', substr($request->productImage, 0, strpos($request->productImage, ';')))[1])[1];

        $exploded = explode(',',$request->productImage);
        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg')){
            $extension = 'jpeg';
        }else if(str_contains($exploded[0],'jpg')){
            $extension = 'jpg';
        }else{
            $extension = 'png';
        }

        $fileName = time().'.'.$extension ;

        
        //return $request->all();

        $created = Product::create([
            'productName' => $request->productName,
            'productDescription' => $request->productDescription,
            'category_id' => $request->category_id,
            'productPrice' => $request->productPrice,
            'productImage' => $fileName,
            'productStatus' => $request->productStatus
        ]);
        if($created){
            $path = public_path().'/uploads/'.$fileName ;
            file_put_contents($path,$decoded);
            return response()->json([
                'msg' => 'Product Uploaded Successfully',
                'product' => $created
            ],201);
        }


    }

    //upload Image 
    public function uploadImage(Request $request)
    {
        $exploded = explode(',',$request);
        $decoded = base64_decode($exploded[1]);

        return $decoded;

        if(str_contains($exploded[0],'jpg')){
            $extension = 'jpg';
        }else if(str_contains($exploded[0],'png')){
            $extension = 'png';
        }else{
            $extension = 'jpeg';
        }

        $fileName = time().'.'.$extension ;
        $path = public_path().'/uploads/'.$fileName ;
        file_put_contents($path,$decoded);

        return $fileName;
    }

}
