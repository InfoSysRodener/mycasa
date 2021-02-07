<?php

namespace App\Http\Controllers;
use App\Services\ProductsServices;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    private $productsServices;

    // public function __construct(ProductsServices $productsServices){
    //     $this->productsServices = $productsServices;
    // }

    public function index(Request $request) {
        return [
            'data' => [
                [
                    'id' => 1,
                    'name' => 'test product',
                    'year' => 2019,
                    'brand' => 'Dell',
                    'model' => 'Inspiron',
                    'make' => '2014',
                    'price' => 2000,
                    'body' => 'plastic',
                    'category' => 'laptop',
                    'code' => 112233,
                    'description' => 'a laptop'
                ]
            ]
        ];
        return $this->productsServices->index($request);
    }

    public function store(Request $request) {
        return [
            'id' => 1,
            'name' => 'test product',
            'year' => 2019,
            'brand' => 'Dell',
            'model' => 'Inspiron',
            'make' => '2014',
            'price' => 2000,
            'body' => 'plastic',
            'category' => 'laptop',
            'code' => 112233,
            'description' => 'a laptop'
        ];
        return $this->productsServices->create($request);
    }

    public function show($id) {
        return [
            'id' => 1,
            'name' => 'test product',
            'year' => 2019,
            'brand' => 'Dell',
            'model' => 'Inspiron',
            'make' => '2014',
            'price' => 2000,
            'body' => 'plastic',
            'category' => 'laptop',
            'code' => 112233,
            'description' => 'a laptop'
        ];
        return $this->productsServices->show($id);
    }

    public function update(Request $request, $id) {
        return [
            'id' => 1,
            'name' => 'test product',
            'year' => 2019,
            'brand' => 'Dell',
            'model' => 'Inspiron',
            'make' => '2014',
            'price' => 2000,
            'body' => 'plastic',
            'category' => 'laptop',
            'code' => 112233,
            'description' => 'a laptop'
        ];
        return $this->productsServices->update($request, $id);
    }

}
