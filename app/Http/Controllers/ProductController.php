<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\Product;

use Illuminate\Http\Request;
// use App\Http\Controllers\BaseController;
use App\Http\Resources\Product as ProductResource;

class ProductController extends BaseController
{
    public function index(){
        $product = Product::all();
        return $this->sendResponse( ProductResource::collection($product), "OK");
    }


    public function store(Request $request){

        $input = $request->all();
        $validator = Validator::make($input, [

            "title" => "required",
            "description" => "required"
        ]);

        if($validator->fails()){
             return $this->sendError($validator->errors());
        
         }

        $product = Product::create( $input );
        // print_r("siker");
        return $this->sendResponse(new ProductResource( $product), "Post létrehozva");
    }
    public function show( $id){
        $product = Product::find($id);

        if( is_null($product)){
            return $this->sendError("Post nem létezik");
        }
        return $this->sendResponse( new ProductResource ($product), "Post betöltve" );
    }

    public function update(Request $request, $id){
        $input = $request->all();

        $validator = Validator::make($input, [

            "name" => "required",
            "price" => "required"

        ]);

        if($validator->fails()){
            return $this-sendError($validator->errors());
        }

        $product = Product::find( $id );
        $product->update( $request->all());


        return $this->sendResponse( new ProductResource ($product), "Post frissítve" );
    }

    public function destroy($id){

        Product::destroy($id);
        return $this->sendResponse([], "Post törölve");
    }
}
