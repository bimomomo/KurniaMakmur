<template>
  <div class="card">
    <div class="card-header">
      <button class="btn btn-primary btn-sm" @click="showModal">
        <i class="bx bx-plus"></i>Tambah
      </button>
    </div>
    <div class="card-body">
      <table id="tabelReturn" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th width="1%">No</th>
            <th>Tanggal Stok Keluar</th>
            <th>Nomor Invoice</th>
            <th>Nomor PO</th>
            <th>Nomor Surat Jalan</th>
            <th>Nama Barang dan Gudang</th>
            <th>Total Satuan Jual</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>

      <!-- Modal -->
      <div
        class="modal fade"
        id="modalDataReturn"
        data-backdrop="static"
        data-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Data Return</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-6">
                  <label>Data Invoice</label>
                  <multiselect
                    v-model="form.idsale"
                    label="namaPelanggan"
                    track-by="namaPelanggan"
                    :custom-label="nameWithLang"
                    :options="dataReturn"
                    :class="{ 'is-invalid': form.errors.has('return') }"
                  >
                  </multiselect>
                </div>
                <div class="form-group col-md-3">
                  <label>Jumlah Satuan Jual</label>
                  <input
                    v-model="form.jumlah_satuan_jual"
                    class="form-control"
                  />
                </div>
                <div class="form-group col-md-3">
                  <label>Jumlah Satuan Isi</label>
                  <input
                    v-model="form.jumlah_satuan_isi"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-3">
                  <label>No Invoice</label>
                  <input
                    v-model="form.no_invoice"
                    class="form-control"
                    readonly
                  />
                </div>
                <div class="form-group col-md-3">
                  <label>No Surat Jalan</label>
                  <input
                    v-model="form.no_surat_jalan"
                    class="form-control"
                    readonly
                  />
                </div>
                <div class="form-group col-md-3">
                  <label>Nama Driver</label>
                  <input
                    v-model="form.nama_driver"
                    class="form-control"
                    readonly
                  />
                </div>
                <div class="form-group col-md-3">
                  <label>Nomer HP Driver no_hp</label>
                  <input
                    v-model="form.no_hp_driver"
                    class="form-control"
                    readonly
                  />
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-3">
                  <label>Nama Barang nama</label>
                  <input
                    v-model="form.nama_barang"
                    class="form-control"
                    readonly
                  />
                </div>
                <div class="form-group col-md-3">
                  <label>Gudang</label>
                  <input v-model="form.gudang" class="form-control" readonly />
                </div>
                <div class="form-group col-md-3">
                  <label>Total</label>
                  <input v-model="form.total" class="form-control" readonly />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                Close
              </button>
              <button type="button" class="btn btn-primary">Understood</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// Import boostrap and jquery
//Bootstrap and jQuery libraries
import "bootstrap/dist/css/bootstrap.min.css";
import "jquery/dist/jquery.min.js";
//Datatable Modules
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";

export default {
  // Inisialisasi variable pada tabel
  created() {
    this.loadUsers();
    Fire.$on("reloadUsers", () => {
      this.loadUsers();
    });
  },
  data() {
    //  Save variabel object or array 'ex: users{}'
    return {
      data: {},
      dataReturn: [],
      all_select: false,
      deleteItems: [],
      // Save input for modal form
      form: new Form({
        uuid: "",
        tgl_sale: "",
        nomor_invoice: "",
        nomor_po: "",
        nomor_surat_jalan: "",
        faktur_pajak: "",
        nama: "",
        gudang: "",
        total_satuan_jual: "",
        harga_akhir: "",
        namaBarang: "",
        satuan_jual: "",
      }),
    };
  },
  methods: {
    noUrut(index) {
      return index;
    },
    nameWithLang({ namaPelanggan, nama }) {
      return `${namaPelanggan} | [${nama}]`;
    },
    // Load data pada tabel with axios
    loadUsers() {
      // axios.get("api/golongan").then(({ data }) => (this.golongans = data));
      axios.get("api/data-return").then((res) => {
        $("#tabelReturn").DataTable().destroy();
        this.data = res.data.data;
        setTimeout(function () {
          $("#tabelReturn").DataTable();
        }, 1000);
      });
    },
    getDataReturn() {
      axios.get("api/getAllDataSale").then((res) => {
        this.dataReturn = res.data.data;
      });
    },
    showModal() {
      this.getDataReturn();
      $("#modalDataReturn").modal("show");
    },
    closeModal() {
      $("#modalDataReturn").modal("show");
    },
    detail(
      tgl_sale,
      nomor_invoice,
      nomor_po,
      nomor_surat_jalan,
      faktur_pajak,
      nama,
      gudang,
      total_satuan_jual,
      harga_akhir,
      namaBarang,
      satuan_jual
    ) {
      this.showModal();
      this.form.tgl_sale = tgl_sale;
      this.form.nomor_invoice = nomor_invoice;
      this.form.nomor_po = nomor_po;
      this.form.nomor_surat_jalan = nomor_surat_jalan;
      this.form.faktur_pajak = faktur_pajak;
      this.form.nama = nama;
      this.form.gudang = gudang;
      this.form.total_satuan_jual = total_satuan_jual;
      this.form.harga_akhir = harga_akhir;
      this.form.namaBarang = namaBarang;
      this.form.satuan_jual = satuan_jual;
    },
  },
};
</script>