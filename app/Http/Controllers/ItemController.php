<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index(){
        return Inertia::render('Item/Index')
        ->with([
            'items' => Item::all(),
        ]);
    }

    public function addItem(Request $request){
        $request->validate([
            'name' => 'required|string|unique:items,name'
        ]);

        return Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
        ]);
    }

    public function updateItem(Request $request){
        $request->validate([
            'id' => 'required|exists:items,id',
            'selected' => 'required'
        ]);

        $item = Item::find($request->id);
        $item->selected = !$request->selected;
        $item->save();
    }
}
