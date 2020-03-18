<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{

    public function index() {
        $items = Item::orderBy('completed', 'asc')->get();

        return view('index', compact('items'));
    }

    public function get_all() {
        $items = Item::orderBy('completed', 'asc')->get();

        return $items;
    }

    public function store(StoreRequest $request) {
        $item = new Item();
        $item->title = $request->title;
        $item->description = $request->description;
        $item->image = $request->image ? $request->image->getClientOriginalName() : null;

        $item->save();

        if($request->image) {
            $request->image->move(public_path('images/'.$item->id), $request->image->getClientOriginalName());
        }

        return $item;
    }

    public function update(UpdateRequest $request) {
        $item = Item::findOrFail($request->id);
        $item->title = $request->title;
        $item->description = $request->description;
        if(isset($request->del_image)) {
            File::deleteDirectory(public_path('images/'.$item->id));
            $item->image = null;
        } else if($request->image) {
            File::deleteDirectory(public_path('images/'.$item->id));
            $item->image = $request->image->getClientOriginalName();
            $request->image->move(public_path('images/'.$item->id), $request->image->getClientOriginalName());
        }

        $item->save();

        return $item;
    }

    public function change_completed(Request $request) {
        $item = Item::findOrFail($request->id);
        $item->completed = !$item->completed;
        $item->save();
    }

    public function destroy(Request $request) {
        $item = Item::findOrFail($request->id);
        if($item->image) {
            File::deleteDirectory(public_path('images/'.$item->id));
        }
        $item->delete();
    }
}
