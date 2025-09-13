<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() { return Product::all(); }
    public function show($id) { return Product::findOrFail($id); }

    public function store(Request $r) {
        $data = $r->validate([
            'name'=>'required|string',
            'description'=>'nullable|string',
            'price'=>'required|numeric'
        ]);
        return response()->json(Product::create($data), 201);
    }

    public function update(Request $r, $id) {
        $p = Product::findOrFail($id);
        $p->update($r->only(['name','description','price']));
        return $p;
    }

    public function destroy($id) {
        Product::findOrFail($id)->delete();
        return response()->noContent();
    }
}
