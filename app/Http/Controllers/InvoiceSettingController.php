<?php

namespace App\Http\Controllers;

use App\Models\InvoiceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoiceSettings = auth()->user()->invoiceSetting;

        return response()->json([
            'data' => $invoiceSettings,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'default_currency' => 'required|string|max:10',
            'default_language' => 'required|string|max:10',
            'invoice_prefix' => 'nullable|string|max:20',
            'next_invoice_number' => 'nullable|integer|min:1',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:500',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'company_tax_number' => 'nullable|string|max:100',
            'footer_notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'digital_signature' => 'nullable|file|image|max:2048', // optional validation
        ]);

        // Get or create invoice setting record
        $invoiceSetting = InvoiceSetting::firstOrNew(['user_id' => auth()->id()]);

        // Handle digital signature upload
        if ($request->hasFile('digital_signature')) {
            // Delete old signature if it exists
            if ($invoiceSetting->digital_signature) {
                // Extract relative path e.g. digital_signatures/filename.jpg
                $oldPath = str_replace('/storage/', '', $invoiceSetting->digital_signature);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Store new signature
            $path = $request->file('digital_signature')->store('digital_signatures', 'public');
            $validated['digital_signature'] = Storage::url($path);
        }

        // Update or create the setting record
        $invoiceSetting->fill($validated);
        $invoiceSetting->user_id = auth()->id();
        $invoiceSetting->save();

        return response()->json([
            'data' => $invoiceSetting,
            'message' => 'Invoice settings saved successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
