<?php

namespace App\Http\Controllers\API\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\Sale;
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

    public function GetTransaksiPelanggan()
    {
        return Sale::select('sale.tgl_sale', 'sale.nomor_invoice', 'sale.nomor_po', 'sale.total', 'sale.jatuh_tempo', 'sale.status_bayar', 'pelanggan.nama')
            ->join('pelanggan', 'pelanggan.uuid', '=', 'sale.pelanggan_id')
            ->distinct()
            ->get();
    }
}
