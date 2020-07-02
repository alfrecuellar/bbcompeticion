<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $origins = Tag::whereHas('parent', function ($query) {
            $query->where('name','origin');
        })->get();

        $brands = Tag::whereHas('parent', function ($query) {
            $query->where('name','brand');
        })->get();

        $providers = Tag::whereHas('parent', function ($query) {
            $query->where('name','provider');
        })->get();

        return response()->json([
            'origins'  => $origins,
            'brands'   => $brands,
            'providers' => $providers,
        ]);
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $type = $request->input('type');

        $parent = Tag::where('name', $type)->first();

        $tag = new Tag();
        $tag->name = $name;
        $tag->parent_id = $parent->id;
        $tag->save();

        return response()->json($tag);
    }
}
