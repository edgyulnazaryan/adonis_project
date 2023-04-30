<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::whereStatus(1)->orderByDesc('created_at');
        if (!is_null($request->search)) {
            return $this->search($suppliers, $request->search);
        }
        $suppliers = $suppliers->paginate(20);
        return view('supplier.index', compact('suppliers'));
    }

    public function search($query, $search)
    {
        return response()->json($query->where('name', 'LIKE', "%$search%")->paginate(20));
    }

    public function getSupplierJson(Request $request)
    {
        $data = Supplier::whereStatus(1)->orderByDesc('created_at');
        if (!is_null($request->search)) {
            return $this->search($data, $request->search);
        }
        $data = $data->paginate(20);
        return response()->json($data);
    }

    public function changeStatus(Supplier $supplier)
    {
        $supplier->update(['status' => !$supplier->status]);
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $data = Supplier::create($inputs);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $inputs = $request->all();
        $data = $supplier->update($inputs);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->back();
    }
}
