<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = auth()->user()->clients;
        

        return response()->json([
            'data' => ClientResource::collection($clients),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'company' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:100',
        ]);

        $client = Client::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'company' => $request->company,
            'tax_number' => $request->tax_number,
        ]);

        return response()->json([
            'data' => new ClientResource($client),
            'message' => 'Client created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::where('user_id', auth()->id())->findOrFail($id);
        return response()->json([
            'data' => new ClientResource($client),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|nullable|email|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:500',
            'company' => 'sometimes|nullable|string|max:255',
            'tax_number' => 'sometimes|nullable|string|max:100',
        ]);

        $client->update($request->only(['name', 'email', 'phone', 'address', 'company', 'tax_number']));

        return response()->json([
            'data' => new ClientResource($client),
            'message' => 'Client updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
