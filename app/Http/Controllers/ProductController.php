<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $productCreateValidationRules = [
        'images.*'=>'sometimes|required|image',
        'name'=>'required',
        'price'=>'required|integer',
        'qty'=>'required|integer',
    ];
    private $validationMessages = [
        'images.*.image' => 'Product images should be an image.',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate($this->productCreateValidationRules,$this->validationMessages);
        $allFileNames = [];
        if($request->hasFile('images')){
             foreach ($request->file('images') as $file){
                 $fileName = $file->getClientOriginalName();
                 $newFileName = time().'_'.$fileName;
                 $storedFile = Storage::putFileAs('public/product_images',$file,$newFileName);
                 if($storedFile)
                 {
                     $allFileNames[] = $newFileName;
                 }
             }
         }
        Product::create([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'qty'=>$request->input('qty'),
            'description'=>$request->input('description'),
            'images'=>$allFileNames,
        ]);
        return response()->json('Product created Successfully',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function filter(Request $request){
//      $prices = ['0-5','5-10','10'];
//      $qty = ['0-5','5-10','10'];
        $prices = ['10'];
        $qty = ['10'];
        $products = Product::query();
        if(isset($prices) && count($prices)> 0){
            foreach ($prices as $price){
                if(strpos($price,'-')){
                    $priceExploded = explode("-",$price);
                    $minPrice = $priceExploded[0];
                    $maxPrice = $priceExploded[1];
                    $products->orWhereBetween('price',[$minPrice,$maxPrice]);
                }else {
                    $products->orWhere('price','>',$price);
                }
            }
        }
        if(isset($qty) && count($qty)> 0){
            foreach ($qty as $key=>$singleQty){
                if(strpos($singleQty,'-')){
                    $singleQtyExploded = explode("-",$singleQty);
                    $minQty = $singleQtyExploded[0];
                    $maxQty = $singleQtyExploded[1];
                    if($key==0){
                        $products->whereBetween('qty',[$minQty,$maxQty]);
                    }else {
                        $products->orWhereBetween('qty',[$minQty,$maxQty]);
                    }
                }else {
                    if($key==0){
                        $products->where('qty','>',$singleQty);
                    }else {
                        $products->orWhere('qty','>',$singleQty);
                    }
                }
            }
        }
        return $products->get();
    }
}
