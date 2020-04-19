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
    /*
        /api/products?fields=name,price&conditions=price:=:6.42;name:like:Toby%
    */
    public function index(Request $request)
    {
        $products = $this->product;
        if($request->has('fields')){ //Verifica se o campo 'fields' tem alguma coisa
            $fields = $request->get('fields');
            $products = $products->selectRaw($fields);// Pegas os campos do 'fieldes' do banco
        }

        if($request->has('conditions')){
            $conditions = explode(';',$request->get('conditions'));
            
            foreach($conditions as $c){
                /*  
                    $con[0] = campo do banco de dados
                    $con[1] = operador
                    $con[2] = valor a ser pesquisado no banco 
                */
                $cond = explode(':', $c);
                $products = $products->where($cond[0],$cond[1], $cond[2]);
            }
        }
        
        return new ProductCollection($products->paginate(5));
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
