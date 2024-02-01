<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $search = request('search');
        if ($search) {
            $stocks = Stock::where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
                ->orderBy('title')
                ->where('id', '!=', '1')
                ->paginate(10)
                ->withQueryString();
        } else {
                $stocks = Stock::where('id', '!=', '1')
                ->orderBy('title')
                ->paginate(10);
        }

        return view('stock.index', compact('stocks'));
    }

    public function store(Request $request)
    {
        // $user->is_admin = true;
        $request->validate([
            'title' => 'required|max:255',
            'stock' => 'required|numeric',
            'category_id' => 'nullable',
        ]);

        Stock::create($request->all());

        return redirect()->route('stock.index')->with('success', 'Stock created successfully!');
    }

    public function create(User $user)
    {
        $user->is_admin = true;
        $categories = Category::all();
        return view('stock.create', compact('categories'));
    }

    public function edit($id)
    {
        $categories = Category::all();
        $stock = Stock::findOrFail($id);

        return view('stock.edit', compact('stock', 'categories'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'title' => 'required|max:255',
            'stock' => 'required|numeric',
            'category_id' => 'nullable',

        ]);

        $stock->update($request->all());

        return redirect()->route('stock.index')->with('success', 'Stock update successfully');

    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stock.index')->with('success', 'Data Successfull deleted');
    }
}
