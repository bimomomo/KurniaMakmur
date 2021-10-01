<template>
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="form-group col-md-3">
          <label>Pencarian Berdasarkan Gudang</label>
          <multiselect
            v-model="form.gudang"
            label="gudang"
            track-by="gudang"
            :options="dataGudang"
            :class="{ 'is-invalid': form.errors.has('nama_barang') }"
            @input="setGudang"
          >
          </multiselect>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table
          id="tabelMutasiKeluar"
          class="table table-striped table-bordered"
        >
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
          <tbody>
            <tr v-for="(item, index) in data" :key="item.index">
              <td>{{ index + 1 }}</td>
              <td>
                {{
                  new Date(item.tgl_sale).toLocaleDateString("id-ID", {
                    dateStyle: "full",
                  })
                }}
              </td>
              <td>{{ item.nomor_invoice }}</td>
              <td>{{ item.nomor_po }}</td>
              <td>{{ item.nomor_surat_jalan }}</td>
              <td>{{ item.namaBarang + " | " + item.gudang }}</td>
              <td>{{ item.total_satuan_jual + " " + item.satuan_jual }}</td>
              <td>
                <button
                  class="btn btn-warning btn-sm"
                  @click="
                    detail(
                      item.tgl_sale,
                      item.nomor_invoice,
                      item.nomor_po,
                      item.nomor_surat_jalan,
                      item.faktur_pajak,
                      item.nama,
                      item.gudang,
                      item.total_satuan_jual,
                      item.harga_akhir,
                      item.namaBarang,
                      item.satuan_jual
                    )
                  "
                >
                  <i class="bx bx-detail"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modal -->
      <div
        class="modal fade"
        id="modalStokKeluar"
        data-backdrop="static"
        data-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Stok Keluar</h5>
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
                <div class="col-md-12 text-right">
                  {{
                    new Date(form.tgl_sale).toLocaleDateString("id-ID", {
                      dateStyle: "full",
                    })
                  }}
                </div>
              </div>
              <table>
                <tbody>
                  <tr>
                    <td>Nomor Invoice</td>
                    <td>:</td>
                    <td>{{ form.nomor_invoice }}</td>
                  </tr>
                  <tr>
                    <td>Nomor Po</td>
                    <td>:</td>
                    <td>{{ form.nomor_po }}</td>
                  </tr>
                  <tr>
                    <td>Nomor Surat Jalan</td>
                    <td>:</td>
                    <td>{{ form.nomor_surat_jalan }}</td>
                  </tr>
                  <tr>
                    <td>Faktur Pajak</td>
                    <td>:</td>
                    <td>{{ form.faktur_pajak }}</td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Nama Customer</th>
                    <th>Nama Barang</th>
                    <th>Gudang</th>
                    <th>Total Satuan Jual</th>
                    <th>Total Harga</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ form.nama }}</td>
                    <td>{{ form.namaBarang }}</td>
                    <td>{{ form.gudang }}</td>
                    <td>
                      {{ form.total_satuan_jual + " " + form.satuan_jual }}
                    </td>
                    <td>
                      {{
                        new Intl.NumberFormat("id-ID", {
                          style: "currency",
                          currency: "IDR",
                        }).format(form.harga_akhir * 1000)
                      }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                Close
              </button>
              <!-- <button type="button" class="btn btn-primary">Understood</button> -->
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
      dataGudang: [],
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
    // Load data pada tabel with axios
    loadUsers() {
      this.getDataGudang();
      // axios.get("api/golongan").then(({ data }) => (this.golongans = data));
      axios.get("api/mutasi-keluar").then((res) => {
        $("#tabelMutasiKeluar").DataTable().destroy();
        this.data = res.data.data;
        setTimeout(function () {
          $("#tabelMutasiKeluar").DataTable();
        }, 1000);
      });
    },
    setGudang(value) {
      axios
        .get("api/mutasi-keluar", { params: { gudang: value.uuid } })
        .then((res) => {
          $("#tabelMutasiKeluar").DataTable().destroy();
          this.data = res.data.data;
          setTimeout(function () {
            $("#tabelMutasiKeluar").DataTable();
          }, 1000);
        });
    },
    getDataGudang() {
      axios.get("api/gudang").then((res) => {
        this.dataGudang = res.data;
      });
    },
    showModal() {
      $("#modalStokKeluar").modal("show");
    },
    closeModal() {
      $("#modalStokKeluar").modal("show");
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