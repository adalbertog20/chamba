<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'street' => 'required',
            'postal_code' => 'required|max:6|regex:/^[0-9]*$/',
            'number' => 'required|regex:/^[0-9]*$/',
            'city' => 'required',
        ]);
        Address::create($validatedData);
        return redirect()->back()->with('success', 'Direccion creada satisfactoriamente');
    }
    public function update(Request $request, $id)
    {
        $address = Address::where('id', $id)->firstOrFail();
        $validatedData = $request->validate([
            'street' => 'required',
            'postal_code' => 'required|max:6|regex:/^[0-9]*$/',
            'number' => 'required|regex:/^[0-9]*$/',
            'city' => 'required',
        ]);
        $address->update($validatedData);
        return redirect()->back()->with('success', 'Direccion actualizada satisfactoriamente');
    }
    public function destroy($id)
    {
        $address = Address::where('id', $id)->firstOrFail();
        $address->delete();
        return redirect()->back()->with('success', 'La direccion ha sido eliminada correctamente.');
    }
}
