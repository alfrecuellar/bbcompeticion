<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Price;
use App\Models\Code;
use App\Models\Tag;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['codes','tags.parent','prices' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->orderBy('name')->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->save();

        $codes = $request->input('codes', []);
        foreach ($codes as $value) {
            if (!isset($value['id'])) {
                $code = new Code();
                $code->value = $value['value'];
                $code->product_id = $product->id;
                $code->save();
            }
        }

        if ($amount = $request->input('price')) {
            $price = new Price();
            $price->amount = $amount;
            $price->product_id = $product->id;
            $price->save();
        }

        $tags = [];
        if($brand = $request->input('brand')) {
            $tags[] = $brand['id'];
        }
        if($origin = $request->input('origin')) {
            $tags[] = $origin['id'];
        }
        if($provider = $request->input('provider')) {
            $tags[] = $provider['id'];
        }
        if(count($tags)) {
            $product->tags()->sync($tags);
        }

        return $product->load(['codes','tags.parent','prices' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->save();

        $codes = $request->input('codes', []);
        foreach ($codes as $value) {
            if (!isset($value['id'])) {
                $code = new Code();
                $code->value = $value['value'];
                $code->product_id = $product->id;
                $code->save();
            }
        }

        if ($amount = $request->input('price')) {
            $price = new Price();
            $price->amount = $amount;
            $price->product_id = $product->id;
            $price->save();
        }

        $tags = [];
        if($brand = $request->input('brand')) {
            $tags[] = $brand['id'];
        }
        if($origin = $request->input('origin')) {
            $tags[] = $origin['id'];
        }
        if($provider = $request->input('provider')) {
            $tags[] = $provider['id'];
        }
        if(count($tags)) {
            $product->tags()->sync($tags);
        }

        return $product->load(['codes','tags.parent','prices' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
}
