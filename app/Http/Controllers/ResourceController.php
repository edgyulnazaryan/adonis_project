<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Resource::whereStatus(1)->get();
        return view('resource.index', compact('data'));
    }

    public function getResourcesJson(Request $request)
    {
        $data = Resource::whereStatus(1)->orderByDesc('created_at');
        if (!is_null($request->search)) {
            return $this->search($data, $request->search);
        }
        $data = $data->paginate(20);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::where('status', 1)->get();
        return view('resource.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'image|max:4096',
        ]);
        $inputs = $request->all();
        if (!is_null($request->image)) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $inputs['image'] = $imageName;
        }
        $data = Resource::create($inputs);
        return redirect()->back();
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource)
    {
        $data = $resource->update([$request->all()]);
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        $resource->delete();
        return response()->json(true);
    }

    public function search($query, $search)
    {
        return response()->json($query->where('name', 'LIKE', "%$search%")->paginate(20));
    }

    public function changeStatus(Resource $resource)
    {
        $resource->update(['status' => !$resource->status]);
        return redirect()->back();
    }
}
