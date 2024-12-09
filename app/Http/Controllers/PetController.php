<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderBy = $request->sort_stock ? 'stock' : 'name';
        // appends : menambahkan/membawa request pagination (data-data pagination tidak berubah meskipun ada request)
        $pets = Pet::where('name', 'LIKE', '%' . $request->cari . '%')->orderBy($orderBy, 'ASC')->simplePaginate(5)->appends($request->all());
        // compact() -> mengirimkan data ($) agar data $nya bisa dipake di blade
        return view('pages.data_hewan', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|max:100',
            'species' => 'required|in:cat,dog,bird,fish,reptile',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ], [
            'name.required' => 'Nama Hewan Harus Diisi!',
            'name.max' => 'Nama Hewan Maksimal 100 Karakter!',
            'species.required' => 'Jenis Hewan Harus Diisi!',
            'species.in' => 'Jenis Hewan Tidak Valid!',
            'price.required' => 'Harga Hewan Harus Diisi!',
            'price.numeric' => 'Harga Hewan Harus Angka!',
            'stock.required' => 'Stok Hewan Harus Diisi!',
            'stock.numeric' => 'Stok Hewan Harus Angka!'
        ]);

        Pet::create($request->all());

        return redirect()->back()->with('success', 'Berhasil Menambah Data Hewan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pet = Pet::find($id);
        return view('pet.edit', compact('pet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        //
        $request->validate([
            'name' => 'required|max:100',
            'species' => 'required|in:cat,dog,bird,fish,reptile',
            'price' => 'required|numeric',
        ], [
            'name.required' => 'Nama Hewan Harus Diisi!',
            'name.max' => 'Nama Hewan Maksimal 100 Karakter!',
            'species.required' => 'Jenis Hewan Harus Diisi!',
            'species.in' => 'Jenis Hewan Tidak Valid!',
            'price.required' => 'Harga Hewan Harus Diisi!',
            'price.numeric' => 'Harga Hewan Harus Angka!',
        ]);

        Pet::find($id)->update($request->all());

        return redirect()->route('data_hewan.data')->with('success', 'Berhasil Mengubah Data Hewan!');
    }

    public function updateStock(Request $request, $id)
    {
        if (isset($request->stock) == FALSE) {
            $petBefore = Pet::find($id);
            return redirect()->back()->with([
                'failed' => 'Stok Hewan ' . $petBefore['name'] . ' Tidak Boleh Berkurang!',
                'id' => $id,
                'stock' => $petBefore['stock']
            ]);
        }

        Pet::where('id', $id)->update([
            'stock' => $request->stock
        ]);

        return redirect()->back()->with('success', 'Berhasil Mengubah Stok Hewan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pet = Pet::find($id);
        $pet->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus Data Hewan!');
    }
}