<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $products = $this->product->paginate(1);

        return new ProductCollection($products);
        //return response()->json($products);
    }    

    public function show($id)
    {
        $product = $this->product->find($id);
        // return response()->json($product);
        return new ProductResource($product);
    }

    public function save(Request $request)
    {
        $data = $request->all();
        var_dump($data);
        $data = $this->product->create($data);
        return response()->json($data);  
    }

    public function update(Request $request)
    {
        $data = $request->all();
        var_dump($data);
        $product = $this->product->find($data["id"]);
        $product->update($data);

        return response()->json($product);
    }

    public function delete($id)
    {
        $product = $this->product->find($id);
        $product->delete($id);

        return response()->json(["msg" => "Apagado com sucesso", 200]);
    }
}
