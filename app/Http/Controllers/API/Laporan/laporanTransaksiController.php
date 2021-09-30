<?php

namespace App\Http\Controllers\API\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\InvoiceJual;
use App\Models\Penjualan\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class laporanTransaksiController extends Controller
{
    public function index()
    {
        // return Sale::get();
    }
    public function GetlaporanInvoice()
    {
        return Sale::select('sale.nomor_invoice', 'sale.tgl_sale', 'sale.total', 'sale.jatuh_tempo', 'sale.status_bayar', 'pelanggan.nama', 'invoice_jual.total_satuan_jual', 'invoice_jual.satuan_jual', 'invoice_jual.barang_id', 'barang.nama as barang')
            ->join('pelanggan', 'pelanggan.uuid', '=', 'sale.pelanggan_id')
            ->join('invoice_jual', 'invoice_jual.uuid', '=', 'sale.invoicejual_id')
            ->join('barang', 'barang.uuid', '=', 'invoice_jual.barang_id')
            ->get();
    }
    public function GetLaporanPengiriman()
    {
        return Sale::select('sale.nomor_invoice', 'sale.total', 'sale.jatuh_tempo', 'sale.status_pengiriman', 'sale.biaya_kirim', 'pelanggan.nama', 'invoice_jual.barang_id', 'barang.nama as barang')
            ->join('pelanggan', 'pelanggan.uuid', '=', 'sale.pelanggan_id')
            ->join('invoice_jual', 'invoice_jual.uuid', '=', 'sale.invoicejual_id')
            ->join('barang', 'barang.uuid', '=', 'invoice_jual.barang_id')
            ->get();
    }

    public function GetTransaksiPelanggan(Request $request)
    {
        if ($request->tanggal) {
            $tanggal = Carbon::parse($request->tanggal)->toDateString();
            return Sale::select('sale.tgl_sale', 'sale.nomor_invoice', 'pelanggan.nama')
                ->join('pelanggan', 'pelanggan.uuid', '=', 'sale.pelanggan_id')
                ->where('tgl_sale', $tanggal)
                ->distinct()
                ->get();
        } elseif ($request->bulan) {
            $bulan = Carbon::parse($request->bulan)->month;
            return Sale::select('sale.tgl_sale', 'sale.nomor_invoice', 'pelanggan.nama')
                ->join('pelanggan', 'pelanggan.uuid', '=', 'sale.pelanggan_id')
                ->whereMonth('tgl_sale', $bulan)
                ->distinct()
                ->get();
        } elseif ($request->nama) {
            return Sale::select('sale.tgl_sale', 'sale.nomor_invoice', 'pelanggan.nama')
                ->join('pelanggan', 'pelanggan.uuid', '=', 'sale.pelanggan_id')
                ->where('pelanggan.nama', $request->nama)
                ->distinct()
                ->get();
        } else {
            return Sale::select('sale.tgl_sale', 'sale.nomor_invoice', 'pelanggan.nama')
                ->join('pelanggan', 'pelanggan.uuid', '=', 'sale.pelanggan_id')
                ->distinct()
                ->get();
        }
    }
    public function GetDetail($id)
    {
        // return dd($request->all());
        return Sale::select('sale.tgl_sale', 'sale.nomor_invoice', 'invoice_jual.uuid', 'invoice_jual.barang_id', 'invoice_jual.satuan_id', 'invoice_jual.harga', 'invoice_jual.harga_akhir', 'invoice_jual.total_satuan_jual', 'invoice_jual.jumlah_satuan_dijual', 'invoice_jual.jumlah_satuan_isi', 'invoice_jual.satuan_jual', 'satuan.satuan_isi', 'barang.nama as produk')
            ->join('invoice_jual', 'invoice_jual.uuid', '=', 'sale.invoicejual_id')
            ->join('satuan', 'satuan.uuid', '=', 'invoice_jual.satuan_id')
            ->join('barang', 'barang.uuid', '=', 'invoice_jual.barang_id')
            ->where('sale.nomor_invoice', $id)
            ->get();
    }
}
