<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\User;
use Auth;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        if(!Auth::check() && $request->path() != 'login'){
            return redirect('/login');
        }
        if(!Auth::check() && $request->path() == 'login'){
            return view('admin');
        }
        $user = Auth::user();
        if($user->userType == 'user'){
            return redirect('/login');
        }
        if($request->path() == 'login'){
            return redirect('/');
        }
        return view('admin');
    }
    //logout 
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    
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
        
        $image_parts = explode(";base64,", $request);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = time() . '.'.$image_type;

        //path
        $path = public_path().'/uploads/'.$file;

        file_put_contents($path, $image_base64);


        return $file;
    }

    //Edit Product
    public function editProduct(Request $request)
    {
        $this->validate($request, [
            'id'=> 'required',
            'productName' => 'required| unique:products,productName,'.$request->id,
            'productDescription' => 'required',
            'productPrice' => 'required',
            'category_id' => 'required',
            'productImage' => 'required',
        ]);
        $product = Product::find($request->id);
        $currentPhoto = $product->productImage;
        
        if($request->productImage != $currentPhoto){
            $imageLocation = public_path().'/uploads/'.$currentPhoto;
            if(file_exists($imageLocation)){
                @unlink($imageLocation);
            }
        }

        return $product->update([
            'productName' => $request->productName,
            'productDescription' =>  $request->productDescription,
            'category_id' =>  $request->category_id,
            'productImage' =>  $request->productImage,
            'productPrice' =>  $request->productPrice,
            'productStatus' =>  $request->productStatus
        ]);
    }

    //delete Product 
    public function deleteProduct(Request $request)
    {
        $this->validate($request, [
            'id'=> 'required'
        ]);
        $product = Product::find($request->id);
        $imageName =  $product->productImage;
        $imageLocation = public_path().'uploads/'.$imageName;
        //return Category::where('id', $request->id)->delete();
        $deleted = $product->delete();
        if($deleted){
            if(file_exists($imageLocation)){
                @unlink($imageLocation);
            }

            return response()->json([
                'msg' => 'Product Deleted Successfully'
            ],200);
        }
    }


    // Admin User Start
    public function addAdminUser(Request $request)
    {
        $this->validate($request,[
            'fullName' => 'required',
            'email'=> 'bail|required|email',
            'password' => 'required|min:5',
            'userType' => 'required',
            'status' => 'sometimes| required'
        ]);

        $password = bcrypt($request->password);
        
        return User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'userType' => $request->userType,
            'status' => $request->status,
        ]);
    }

    public function allAdminUsers()
    {
        return User::orderBy('id','desc')->get();
    }

    public function editAdminUser(Request $request)
    {
        $this->validate($request, [
            'id'=> 'required',
            'fullName' => 'required',
            'email' => 'required| unique:products,productName,'.$request->id,
            'userType' => 'required',
            'status' => 'sometimes|required',
        ]);
        $product = User::find($request->id);
        

        return $product->update([
            'fullName' => $request->fullName,
            'email' =>  $request->email,
            'userType' =>  $request->userType,
            'status' =>  $request->status,
        ]);
    }

    //delete Admin User
    public function deleteAdminUser(Request $request)
    {
        $this->validate($request, [
            'id'=> 'required'
        ]);
        $adminuser = User::find($request->id);
        $deleted = $adminuser->delete();
        if($deleted){
            return response()->json([
                'msg' => 'Admin Deleted Successfully'
            ],200);
        }
    }

    public function loginAdmin(Request $request)
    {
        $this->validate($request,[
            'email' => 'bail | required | email',
            'password' => 'bail | required | min:6'
        ]);

        if( Auth::attempt(['email' => $request->email, 'password' => $request->password ]) ){
            $user =  Auth::user();
            if($user->userType == 'user'){
                return response()->json([
                    'msg' => 'Incorrect Login Details'
                ],401);
            }else{
                return response()->json([
                    'msg' => 'You are login Now'
                ]);
            }
            
        }else{
            return response()->json([
                'msg' => 'Incorrect Login Details'
            ],401);
        }
    }

}
