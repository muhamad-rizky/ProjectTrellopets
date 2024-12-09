<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::with('user')->orderBy('name_customer', 'ASC')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name Kasir',
            'Daftar Hewan',
            'Total Harga',
            'Nama Customer',
            'Tanggal Pembelian',
        ];
    }

    public function map($order): array
    {
        $daftarHewan = "";

        foreach ($order->pets as $key => $value) {
            $format = $key + 1 . ". " . $value['name_pet'] . "| " . $value['species'] . " (" . $value['qty'] . "pcs) - Rp. " . number_format($value['price'], 0, ',', '.') . " | ";
            $daftarHewan .= $format;
        }

        return [
            $order->id,
            $order->user->name,
            $daftarHewan,
            $order->total_price,
            $order->name_customer,
            \Carbon\Carbon::create($order->created_at)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i:s'),
        ];
    }
}