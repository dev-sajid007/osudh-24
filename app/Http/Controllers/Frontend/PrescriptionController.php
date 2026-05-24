<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::latest()->get();
        return view('frontend.prescription.index', compact('prescriptions'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'required|string',
            'notes' => 'nullable|string',

            'prescription' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Upload File
        $path = null;

        if ($request->hasFile('prescription')) {

            $path = $request->file('prescription')
                ->store('prescriptions', 'public');
        }

        Prescription::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'notes' => $request->notes,
            'prescription' => $path,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Prescription uploaded successfully.');
    }
}

