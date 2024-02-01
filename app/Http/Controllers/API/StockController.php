<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        if($search){
            $stocks = Stock::with('category')
            ->where(function ($query) use($search){
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest()
            ->get();
            return response()->json([
                'status' => 'success',
                'data' => ['stocks' => $stocks,]
            ], 200);
        }

        $stocks = Stock::where('id', '!=', '1')
            ->latest()
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => [
                'stocks' => $stocks,
            ]
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|max:255',
                'stock' => 'required|numeric',
                'category_id' => [
                    'nullable',
                    Rule::exists('categories', 'id')]

                ]
            );
            $stock = Stock::create($request->all());

            $stock = Stock::with('category')
            ->where('id', $stock->id)
            ->first();
            return response()->json([
                'status' => 'success',
                'message' => 'Stock Created',
                'data' => [
                    'stock' => $stock,
                ]
            ], 201);
        } catch (ValidationException $exception){
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Not Found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => [
                'stock' => $stock,
            ]
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        try {
            $request->validate([
                'title' => 'required|max:255',
                'stock' => 'required|numeric',
                'category_id' => [
                    'nullable',
                    Rule::exists('categories', 'id')]

            ]);

            $stock->update($request->all());

            $stock = Stock::with('category')
                ->where('id', $stock->id)
                ->first();
            return response()->json([
                'status' => 'success',
                'message' => 'Stock updated',
                'data' => [
                    'stock' => $stock,
                ]
            ], 200);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $exception->errors(),
            ], 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Data Not Found'
            ], 404);
        }

        $stock->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Stock deleted'
        ], 200);
    }
}
