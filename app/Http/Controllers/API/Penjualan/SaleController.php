<?php

namespace App\Http\Controllers\API\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Master\Driver;
use App\Models\Master\Pelanggan;
use App\Models\Penjualan\InvoiceJual;
use App\Models\Penjualan\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    public function cancelOrder($id)
    {
        $x =  Sale::select(
            'sale.*',
            'sale.uuid as uuidSale',
            'invoice_jual.*',
            'barang.uuid as uuidBarang',
            'barang.*',
        )
            ->join('invoice_jual', 'invoice_jual.uuid', 'sale.invoicejual_id')
            ->join('barang', 'barang.uuid', 'invoice_jual.barang_id')
            ->where('sale.uuid', $id)
            ->first();
        if (!$x) {
            return response()->json(['data' => $x, 'pesan' => 'Load data Server Error : Sale']);
        } else {
            $iniSisa = $x->sisa + $x->total_satuan_jual;
            $iniTerjual = $x->terjual - $x->total_satuan_jual;
            Barang::where('uuid', $x->barang_id)->update([
                'sisa' => $iniSisa,
                'terjual' => $iniTerjual,
            ]);
            Sale::where('uuid', $x->uuidSale)->update([
                'status_bayar' => 9,
                'status_pengiriman' => 9,
            ]);
        }
        return response()->json(['data' => $x, 'pesan' => 'Load data Server Error : Sale']);
    }
    public function getAllDataSale()
    {
        $x =  Sale::select(
            'sale.*',
            'invoice_jual.*',
            'driver.*',
            'pelanggan.nama as namaPelanggan',
            'pelanggan.*',
            'barang.*',
            'gudang.*',
        )
            ->join('invoice_jual', 'invoice_jual.uuid', 'sale.invoicejual_id')
            ->join('driver', 'driver.uuid', 'sale.driver_id')
            ->join('pelanggan', 'pelanggan.uuid', 'sale.pelanggan_id')
            ->join('barang', 'barang.uuid', 'invoice_jual.barang_id')
            ->join('gudang', 'gudang.uuid', 'invoice_jual.gudang_id')
            ->where('sale.status_bayar', 1)
            ->get();

        if ($x) {
            $pesan = 'Oke';
        } else {
            $pesan = 'Data Error';
        }
        return response()->json(['data' => $x, 'pesan' => $pesan]);
    }
    public function index(Request $request)
    {
        if ($request->uuid) {
            return Sale::select(
                'driver.*',
                'gudang.*',
                'barang.*',
                'barang.nama as namaBarang',
                'satuan.*',
                'sale.uuid as uuidSale',
                'sale.*',
                'invoice_jual.*',
                'invoice_jual.uuid as uuidInvJual',
                'pelanggan.nama',
            )
                ->join('invoice_jual', 'invoice_jual.uuid', 'sale.invoicejual_id')
                ->join('satuan', 'satuan.uuid', 'invoice_jual.satuan_id')
                ->join('driver', 'driver.uuid', 'sale.driver_id')
                ->join('gudang', 'gudang.uuid', 'invoice_jual.gudang_id')
                ->join('barang', 'barang.uuid', 'invoice_jual.barang_id')
                ->join('pelanggan', 'pelanggan.uuid', '=', 'sale.pelanggan_id')
                ->where('sale.nomor_invoice', $request->uuid)
                ->distinct()
                ->get();
        }
        return Sale::select('sale.tgl_sale', 'sale.nomor_invoice', 'sale.driver_id', 'sale.nomor_po', 'sale.total', 'sale.jatuh_tempo', 'sale.status_bayar', 'sale.status_pengiriman', 'pelanggan.nama')
            ->join('pelanggan', 'pelanggan.uuid', '=', 'sale.pelanggan_id')
            ->groupBy('sale.nomor_invoice')
            ->distinct()
            ->get();
    }

    public function store(Request $request)
    {
        foreach ($request->invoivejual_id as $key => $value) {
            $data[$key] = $value;
        }
        for ($i = 0; $i < count($data); $i++) {
            $invoicejual_id = $request->invoivejual_id[$i]['uuid'];

            $subtotal = explode(",", $request->subttl);
            $biaya_kirim = explode(",", $request->biaya_kirim);
            $total = explode(",", $request->total);
            Sale::create([
                "uuid" => Str::uuid(),
                "invoicejual_id" => $invoicejual_id,
                "pelanggan_id" => $request->pelanggan_id["uuid"],
                "driver_id" => $request->driver_id["uuid"],
                "tgl_sale" => $request->tgl_sale,
                "jatuh_tempo" => $request->jatuh_tempo,
                "nomor_invoice" => $request->nomor_invoice,
                "faktur_pajak" => $request->faktur_pajak,
                "nomor_po" => $request->nomor_po,
                "nomor_surat_jalan" => $request->nomor_surat_jalan,
                "total" => (preg_replace('/\D/', '', $total[0]) / 1000),
                "diskon" => $request->diskon,
                "ppn" => $request->ppn,
                "subtotal" => (preg_replace('/\D/', '', $subtotal[0]) / 1000),
                "biaya_kirim" => (preg_replace('/\D/', '', $biaya_kirim[0]) / 1000),
            ]);

            InvoiceJual::where('uuid', $invoicejual_id)
                ->update([
                    'status' => 1
                ]);
        }
    }
    public function updatebayar($id, Request $request)
    {
        Sale::where('nomor_invoice', $id)->update([
            'status_bayar' => $request->status_bayar,
        ]);
    }
    public function updatekirim($id, Request $request)
    {
        Sale::where('nomor_invoice', $id)->update([
            'status_pengiriman' => $request->status_pengiriman,
        ]);
    }

    public function updatehormatkami(Request $request, $id)
    {
        // return $request->all();
        Sale::where('nomor_invoice', $id)->update([
            'driver_id' => $request->driver['uuid'],
        ]);
    }
    public function detailinvoice($id)
    {
        return Sale::select('sale.nomor_invoice', 'invoice_jual.uuid', 'invoice_jual.barang_id', 'invoice_jual.satuan_id', 'invoice_jual.harga', 'invoice_jual.harga_akhir', 'invoice_jual.total_satuan_jual', 'invoice_jual.jumlah_satuan_dijual', 'invoice_jual.jumlah_satuan_isi', 'invoice_jual.satuan_jual', 'satuan.satuan_isi', 'barang.nama as produk')
            ->join('invoice_jual', 'invoice_jual.uuid', '=', 'sale.invoicejual_id')
            ->join('satuan', 'satuan.uuid', '=', 'invoice_jual.satuan_id')
            ->join('barang', 'barang.uuid', '=', 'invoice_jual.barang_id')
            ->where('sale.nomor_invoice', $id)
            ->get();
    }
    public function test($id)
    {
        return Sale::select('sale.tgl_sale', 'sale.nomor_invoice', 'sale.nomor_po', 'sale.faktur_pajak', 'sale.ppn', 'sale.biaya_kirim', 'sale.diskon', 'sale.subtotal', 'sale.jatuh_tempo', 'sale.status_bayar', 'pelanggan.nama', 'pelanggan.alamat', 'driver.driver')
            ->join('pelanggan', 'pelanggan.uuid', '=', 'sale.pelanggan_id')
            ->join('driver', 'driver.uuid', '=', 'sale.driver_id')
            ->where('nomor_invoice', $id)
            ->distinct()
            ->get();
    }

    public function drivers(Request $request)
    {
        return Driver::where('uuid', $request->driver_id)->get();
    }
}
