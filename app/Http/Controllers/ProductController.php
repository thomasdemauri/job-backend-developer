<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use PHPUnit\Framework\Constraint\IsEmpty;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(Product::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        return new ProductResource(Product::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     *  Search product by name
     * 
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     * 
     */
    public function showByNameAndCategory(string $name, string $category) {

        $product = Product::where([
            ['name', $name], ['category', $category]
        ])->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);   
        }

        return new ProductResource($product);
    }

        /**
     *  Search product by category
     * 
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     * 
     */
    public function showByCategory(string $category) {
        $products = Product::where('category', $category)->paginate();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'Product not found.'], 404);   
        }

        return ProductResource::collection($products);
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
}
