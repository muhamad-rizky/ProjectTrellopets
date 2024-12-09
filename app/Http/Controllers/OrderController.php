<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = Order::orderBy('created_at', 'DESC')->with('user');

        if ($request->has('search_date') && $request->search_date != '') {
            $search->whereDate('created_at', '=', $request->search_date);
        }

        $orders = $search->simplePaginate(5);
        return view('order.kasir.kasir', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pets = Pet::all();
        return view('order.kasir.create', compact('pets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',
            'pets' => 'required',
        ]);

        $arrayValues = array_count_values($request->pets);

        $arrayNewPets = [];

        foreach ($arrayValues as $key => $value) {
            $pet = Pet::where('id', $key)->first();
            $totalPrice = $pet->price * $value;
            if ($pet->stock < $value) {
                $valueFormBefore = [
                    'name_customer' => $request->name_customer,
                    'pets' => $request->pets,
                ];
                $alert = 'Stock Hewan ' . $pet->name . ' tidak mencukupi, hanya tersisa ' . $pet->stock . ' item';
                return redirect()->back()->with([
                    'failed' => $alert,
                    'valueFormBefore' => $valueFormBefore
                ]);
            }
            $arrayItem = [
                'id' => $key,
                'name_pet' => $pet->name,
                'species' => $pet->species,
                'qty' => $value,
                'price' => $pet->price,
                'total_price' => $totalPrice
            ];
            array_push($arrayNewPets, $arrayItem);
        }

        $total = 0;
        foreach ($arrayNewPets as $item) {
            $total += $item['total_price'];
        }

        $ppn = $total + ($total * 0.1);

        $newOrder = Order::create([
            'user_id' => Auth::user()->id,
            'pets' => $arrayNewPets,
            'name_customer' => $request->name_customer,
            'total_price' => $ppn,
        ]);

        foreach ($arrayNewPets as $key => $value) {
            $stockBefore = Pet::where('id', $value['id'])->value('stock');
            Pet::where('id', $value['id'])->update([
                'stock' => $stockBefore - $value['qty']
            ]);
        }

        if ($newOrder) {
            return redirect()->route('kasir.order.print', $newOrder['id'])->with('success', 'Order berhasil dibuat');
        } else {
            return redirect()->back()->with('error', 'Order gagal dibuat');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('order.kasir.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function downloadPDF($id)
    {
        $order = Order::find($id)->toArray();
        // return $order;
        view()->share('order', $order);
        $pdf = PDF::loadView('order.kasir.download-pdf', $order);
        return $pdf->download('struk.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new OrderExport, 'order.xlsx');
    }
}