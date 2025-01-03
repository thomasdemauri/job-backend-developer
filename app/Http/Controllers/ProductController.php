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
        $product = Product::create($request->all());
        return new ProductResource($product);
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
        $product->update($request->all());
        return new ProductResource($product);
    }

    /**
     *  Search product by name and category
     * 
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     * 
     */
    public function showByNameAndCategory(string $name, string $category) {

        $product = Product::where([['name', $name], ['category', $category]])->first();

        return (!$product) ? response()->json(['message' => 'Product not found.'], 404) : new ProductResource($product);
    }

    /**
     *  Search product by name with 'like'
     * 
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     * 
     */
    public function showByName(string $name) {

        $products = Product::where('name', 'like', "%$name%")->paginate();

        return ($products->isEmpty()) ? response()->json(['message' => 'Products not found.'], 404) : ProductResource::collection($products);
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

        return ($products->isEmpty()) ? response()->json(['message' => 'Products not found.'], 404) : ProductResource::collection($products);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return new ProductResource($product);
    }
}
