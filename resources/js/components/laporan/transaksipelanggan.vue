<template>
  <div>
    <div class="card">
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-lg-2">
            <!-- <label for="form-control">Filter</label> -->
            <select class="form-control" id="filter" v-model="filter">
              <option value="">pilih</option>
              <option value="tanggal">Tanggal</option>
              <option value="bulan">Bulan</option>
              <option value="pelanggan">Pelanggan</option>
            </select>
          </div>
          <div class="col-lg-3" id="tanggal">
            <input type="date" class="form-control" v-model="form.tanggal" />
          </div>
          <div class="col-lg-3" id="bulan">
            <input type="month" class="form-control" v-model="form.bulan" />
          </div>
          <div class="col-lg-4" id="nama">
            <multiselect
              v-model="pelanggan"
              label="nama"
              track-by="nama"
              :options="pelanggans"
              :searchable="true"
              :multiple="false"
              :close-on-select="false"
              :show-labels="true"
              :hide-selected="false"
              placeholder="Pilih Pelanggan"
              :class="{ 'is-invalid': form.errors.has('nama') }"
              @input="setmultiselect"
            >
            </multiselect>
          </div>
          <div class="col-lg-2" id="cari">
            <button class="btn btn-primary btn-sm" @click="loadUsers()">
              <i class="bx bx-search-alt-2"></i>
            </button>
            <button class="btn btn-warning btn-sm" @click="refresh()">
              <i class="bx bx-refresh"></i>
            </button>
          </div>
        </div>
        <div class="table-responsive-lg">
          <table id="example" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="15%">No. Invoice</th>
                <th width="30%">Tanggal transaksi</th>
                <th>Pelanggan</th>
                <th width="2%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in GetTransaksiPelanggan" :key="index">
                <td>{{ item.nomor_invoice }}</td>
                <td>
                  {{
                    new Date(item.tgl_sale).toLocaleDateString("id-ID", {
                      dateStyle: "full",
                    })
                  }}
                </td>
                <td>{{ item.nama }}</td>
                <td>
                  <button
                    class="btn btn-info btn-sm"
                    @click="detail(item.nomor_invoice)"
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
          id="modelId"
          tabindex="-1"
          role="dialog"
          aria-labelledby="modelTitleId"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
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
                <div class="table-responsive-lg">
                  <table
                    class="table table-striped table-bordered"
                    id="example2"
                  >
                    <thead>
                      <tr>
                        <th>Tanggal transaksi</th>
                        <th width="3%">Qty</th>
                        <th width="12%">Total Qty</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Sub total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(items, index) in GetDetail" :key="index">
                        <td>
                          {{
                            new Date(items.tgl_sale).toLocaleDateString(
                              "id-ID",
                              {
                                dateStyle: "full",
                              }
                            )
                          }}
                        </td>
                        <td>
                          {{ items.jumlah_satuan_dijual }}
                          {{ items.satuan_isi }}
                        </td>
                        <td>
                          {{ items.total_satuan_jual }} {{ items.satuan_jual }}
                        </td>
                        <td>{{ items.produk }}</td>
                        <td>
                          {{
                            new Intl.NumberFormat("id-ID", {
                              style: "currency",
                              currency: "IDR",
                            }).format(items.harga * 1000)
                          }}
                        </td>
                        <td>
                          {{
                            new Intl.NumberFormat("id-ID", {
                              style: "currency",
                              currency: "IDR",
                            }).format(items.harga_akhir * 1000)
                          }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
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
                <button type="button" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import "bootstrap/dist/css/bootstrap.min.css";
import "jquery/dist/jquery.min.js";
//Datatable Modules
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";

export default {
  created() {
    this.loadUsers();
    Fire.$on("reloadUsers", () => {
      this.loadUsers();
    });
  },
  data() {
    //  Save variabel object or array 'ex: users{}'
    return {
      editmode: false,
      GetTransaksiPelanggan: {},
      GetDetail: {},
      pelanggans: [],
      invoice: "",
      filter: "",
      pelanggan: "",
      form: new Form({
        tanggal: "",
        bulan: "",
        nama: "",
      }),
    };
  },
  methods: {
    loadUsers() {
      axios
        .get("api/GetTransaksiPelanggan", {
          params: {
            tanggal: this.form.tanggal,
            bulan: this.form.bulan,
            nama: this.form.nama,
          },
        })
        .then((res) => {
          $("#example").DataTable().destroy();
          this.GetTransaksiPelanggan = res.data;
          this.hideselect();
          setTimeout(function () {
            $("#example").DataTable();
          }, 1000);
        });

      axios.get("api/pelanggan").then((res) => {
        this.pelanggans = res.data;
      });
    },

    ShowModal() {
      $("#modelId").modal("show");
    },

    detail(nomor_invoice) {
      this.ShowModal();
      axios.get("api/GetDetail/" + nomor_invoice).then((res) => {
        $("#example2").DataTable().destroy();
        this.GetDetail = res.data;
        setTimeout(function () {
          $("#example2").DataTable();
        }, 1000);
      });
    },

    hideselect() {
      $("#filter")
        .on("change", function () {
          if (this.value == "") {
            $("#tanggal").hide();
            $("#bulan").hide();
            $("#cari").hide();
            $("#nama").hide();
          } else if (this.value == "tanggal") {
            $("#tanggal").show();
            $("#bulan").hide();
            $("#nama").hide();
            $("#cari").show();
          } else if (this.value == "bulan") {
            $("#bulan").show();
            $("#tanggal").hide();
            $("#nama").hide();
            $("#cari").show();
          } else if (this.value == "pelanggan") {
            $("#bulan").hide();
            $("#tanggal").hide();
            $("#nama").show();
            $("#cari").show();
          }
        })
        .trigger("change");
    },
    refresh() {
      this.form.reset();
      axios.get("api/GetTransaksiPelanggan").then((res) => {
        $("#example").DataTable().destroy();
        this.GetTransaksiPelanggan = res.data;
        this.hideselect();
        setTimeout(function () {
          $("#example").DataTable();
        }, 1000);
      });
    },
    setmultiselect(value) {
      this.form.nama = value.nama;
    },
  },
};
</script>