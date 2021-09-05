<template>
  <div>
    <div class="card">
      <div class="card-body">
        <form @submit.prevent="simpandata()" @keydown="form.onKeydown($event)">
          <div class="row mb-2">
            <div class="col-lg-6">
              <label for="form-control">Pilih Barang</label>
              <multiselect
                v-model="form.produk"
                label="nama"
                track-by="nama"
                :options="barangs"
                :searchable="true"
                :close-on-select="false"
                :show-labels="true"
                :preselect-first="true"
                :preserve-search="true"
                :class="{ 'is-invalid': form.errors.has('produk') }"
                required
                @input="setmultiselect"
              >
                <template slot="singleLabel" slot-scope="{ option }"
                  >Nama Barang: <strong>{{ option.nama }}</strong> |
                  <strong>{{ option.gudang }}</strong></template
                >
              </multiselect>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-2">
              <label for="form-control">Sisa Stock</label>
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.sisa"
                  readonly
                />
                <input
                  type="text"
                  class="form-control"
                  v-model="form.satuan_isi"
                  readonly
                />
              </div>
            </div>
            <div class="col-lg-2">
              <label for="form-control">Harga</label>
              <input
                type="text"
                class="form-control"
                v-model="form.harga"
                placeholder="Harga Barang"
                :class="{ 'is-invalid': form.errors.has('harga') }"
                @click="clickharga"
                @blur="blurharga"
              />
            </div>
            <div class="col-lg-2">
              <label for="form-control">Jumlah Jual</label>
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.jumlah_satuan_dijual"
                  :class="{
                    'is-invalid': form.errors.has('jumlah_satuan_dijual'),
                  }"
                />
                <input
                  type="text"
                  v-model="form.satuan_jual"
                  class="form-control"
                  readonly
                />
              </div>
            </div>
            <div class="col-lg-2">
              <label for="form-control">Jumlah Satuan</label>
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.jumlah_satuan_isi"
                  :class="{
                    'is-invalid': form.errors.has('jumlah_satuan_isi'),
                  }"
                />
                <input
                  type="text"
                  class="form-control"
                  v-model="form.satuan_isi"
                  readonly
                />
              </div>
            </div>
            <div class="col-lg-2">
              <label for="form-control">Total Stock Dijual</label>
              <input
                type="text"
                class="form-control"
                v-model="form.total_satuan_jual"
                readonly
                placeholder="Total Stock Dijual"
              />
            </div>
            <div class="col-lg-2">
              <label for="form-control">Total Bayar</label>
              <input
                type="text"
                class="form-control"
                v-model="form.harga_akhir"
                readonly
                placeholder="Total Bayar"
              />
            </div>
            {{ this.totalbayar() }}
          </div>
          <div class="row">
            <button class="btn btn-primary btn-sm">
              <i class="bx bx-cart"></i>Tambah
            </button>
          </div>
        </form>
        <!-- Daftar Barang Di beli -->

        <div class="row mt-3">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Produk</th>
                  <th>Harga</th>
                  <th>Jumlah Jual</th>
                  <th>Total Bayar</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in invoicejuals" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ item.nama }}</td>
                  <td>
                    {{
                      new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR",
                      }).format(item.harga * 1000)
                    }}
                  </td>
                  <td>{{ item.total_satuan_jual }} {{ item.satuan_jual }}</td>
                  <td>
                    {{
                      new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR",
                      }).format(item.harga_akhir * 1000)
                    }}
                  </td>
                  <td>
                    <button
                      class="btn btn-danger btn-sm"
                      @click="deleteInvoice(item.uuid)"
                    >
                      <i class="bx bx-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row float-end">
          <div class="col-lg-12">
            <table>
              <tr>
                <td>
                  <button class="btn btn-info btn-sm" @click="checkout()">
                    Selanjutnya
                    <i class="bx bx-right-arrow-alt"></i>
                  </button>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Multiselect from "vue-multiselect";

// register globally
Vue.component("multiselect", Multiselect);
export default {
  created() {
    this.loadUsers();
    Fire.$on("reloadUsers", () => {
      this.loadUsers();
    });
  },
  data() {
    return {
      selected: "selected",
      barangs: [],
      invoicejuals: {},
      form: new Form({
        uuid: "",
        produk: "",
        harga: "",
        sisa: "",
        hargas: 0,
        satuan_jual: "",
        satuan_isi: "",
        jumlah_satuan_dijual: "",
        total_satuan_jual: "",
        jumlah_satuan_isi: "",
        harga_akhir: "",
      }),
    };
  },

  methods: {
    loadUsers() {
      axios.get("api/barang").then(({ data }) => (this.barangs = data));
      axios.get("api/invoicejual").then((res) => {
        this.invoicejuals = res.data;
      });
    },
    clickharga() {
      this.form.harga = this.form.hargas;
    },
    blurharga() {
      this.form.hargas = this.form.harga;
      this.form.harga = this.formatRupiah(this.form.hargas);
    },
    checkout() {
      this.$router.push({
        path: "/checkout-invoice",
      });
    },
    setmultiselect(value) {
      this.form.satuan_jual = value.satuan_jual;
      this.form.sisa = value.sisa;
      this.form.satuan_isi = value.satuan_isi;
    },
    // Hitung total bayar
    totalbayar() {
      var harga = this.form.hargas;
      var jumlahsatuan = this.form.jumlah_satuan_dijual;
      var totalbayar = harga * jumlahsatuan;
      var jumlahjual = this.form.jumlah_satuan_dijual;
      var satuan_jual = this.form.jumlah_satuan_isi;
      var totalstockterjual = satuan_jual * jumlahjual;
      this.form.total_satuan_jual = totalstockterjual;
      this.form.harga_akhir = this.formatRupiah(totalbayar);
    },

    // Proses Invoice
    simpandata() {
      this.loading = true;
      this.disabled = true;
      this.form
        .post("api/invoicejual")
        .then(() => {
          Fire.$emit("reloadUsers");
          this.form.reset();
          Swal.fire({ icon: "success", title: "Data Berhasil Tersimpan" });
          this.loading = false;
          this.disabled = false;
        })
        .catch(() => {
          this.loading = false;
          this.disabled = false;
        });
    },

    deleteInvoice(uuid) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.value) {
          axios
            .delete("api/invoicejual/" + uuid)
            .then(() => {
              Fire.$emit("reloadUsers");
              Swal.fire("Deleted!", "User deleted successfully", "success");
            })
            .catch(() => {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
                footer: "<a href>Why do I have this issue?</a>",
              });
            });
        }
      });
    },
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>