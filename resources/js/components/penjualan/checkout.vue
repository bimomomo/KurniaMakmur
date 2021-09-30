<template>
  <div>
    <form @submit.prevent="simpandata()" @keydown="form.onKeydown($event)">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Jual</th>
                    <th>Terjual</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in checkouts" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.nama }}</td>
                    <td>
                      {{
                        new Intl.NumberFormat("id-ID", {
                          style: "currency",
                          currency: "IDR",
                        }).format(item.harga * 1000)
                      }}
                      * {{ item.total_satuan_jual }} {{ item.satuan_jual }}
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
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Tanggal Transaksi</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="date"
                v-model="form.tgl_sale"
                :class="{
                  'is-invalid': form.errors.has('tgl_sale'),
                }"
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Jatuh Tempo</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="date"
                v-model="form.jatuh_tempo"
                :class="{
                  'is-invalid': form.errors.has('jatuh_tampo'),
                }"
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Nomor Invoice</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="text"
                placeholder="Nomor invoice"
                v-model="form.nomor_invoice"
                :class="{
                  'is-invalid': form.errors.has('nomor_invoice'),
                }"
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Faktur Pajak</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="text"
                placeholder="Faktur pajak"
                v-model="form.faktur_pajak"
                :class="{
                  'is-invalid': form.errors.has('faktur_pajak'),
                }"
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Nomor PO</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="text"
                placeholder="Nomor PO"
                v-model="form.nomor_po"
                :class="{
                  'is-invalid': form.errors.has('nomor_po'),
                }"
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Nomor Surat Jalan</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="text"
                placeholder="Nomor Surat Jalan"
                v-model="form.nomor_surat_jalan"
                :class="{
                  'is-invalid': form.errors.has('nomor_surat_jalan'),
                }"
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Pelanggan</label>
            </div>
            <div class="col-lg-9">
              <multiselect
                v-model="form.pelanggan_id"
                label="nama"
                track-by="nama"
                :searchable="true"
                :options="pelanggans"
                placeholder="Pilih Pelanggan"
                :class="{ 'is-invalid': form.errors.has('pelanggan_id') }"
                required
              >
                <template slot="singleLabel" slot-scope="{ option }"
                  >Pelanggan : <strong>{{ option.nama }}</strong></template
                >
              </multiselect>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Pegawai</label>
            </div>
            <div class="col-lg-9">
              <multiselect
                v-model="form.driver_id"
                label="driver"
                track-by="driver"
                :searchable="true"
                :options="drivers"
                placeholder="Pilih Pegawai"
                :class="{ 'is-invalid': form.errors.has('driver_id') }"
                required
              >
                <template slot="singleLabel" slot-scope="{ option }"
                  >Pegawai : <strong>{{ option.driver }}</strong></template
                >
              </multiselect>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Sub Total</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="text"
                placeholder="Sub Total"
                v-model="subtotals"
                readonly
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Diskon (%)</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="number"
                min="0"
                max="70"
                v-model="form.diskon"
                :class="{
                  'is-invalid': form.errors.has('diskon'),
                }"
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Harga Setelah Diskon</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="text"
                placeholder="Harga Setelah Diskon"
                v-model="form.hargastlhdiskon"
                readonly
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">PPN (%)</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="number"
                min="0"
                max="20"
                v-model="form.ppn"
                :class="{
                  'is-invalid': form.errors.has('ppn'),
                }"
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Harga Setelah PPN</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="text"
                v-model="form.hargastlhppn"
                readonly
              />
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Biaya Kirim</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="text"
                v-model="form.biaya_kirim"
                :class="{
                  'is-invalid': form.errors.has('biaya_kirim'),
                }"
                @click="clickbiayakirim"
                @blur="blurbiayakirim"
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Total</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="text"
                placeholder="Total"
                v-model="form.total"
                readonly
              />
            </div>
            {{ this.hitungtotal() }}
          </div>
          <div class="row float-end">
            <div class="col-lg-12">
              <table>
                <tr>
                  <td>
                    <button class="btn btn-info btn-sm" type="submit">
                      Simpan
                      <i class="bx bx-save"></i>
                    </button>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import Multiselect from "vue-multiselect";

// register globally
Vue.component("multiselect", Multiselect);
export default {
  props: ["dataInvoiceJual", "dataReturn"],
  created() {
    this.loadUsers();
    Fire.$on("reloadUsers", () => {
      this.loadUsers();
    });
  },
  data() {
    return {
      return: false,
      checkouts: {},
      drivers: [],
      pelanggans: [],
      subtotals: "",
      subtotalfunc: "",
      form: new Form({
        dataBarang: [],
        invoivejual_id: [],
        pelanggan_id: "",
        driver_id: "",
        tgl_sale: "",
        jatuh_tempo: "",
        nomor_invoice: "",
        faktur_pajak: "",
        nomor_po: "",
        nomor_surat_jalan: "",
        subttl: "",
        biaya_kirims: "",
        diskon: "",
        hargastlhdiskon: "",
        ppn: "",
        hargastlhppn: "",
        biaya_kirim: "",
        total: "",
        uuidSale: "",
        uuidBarang: "",
      }),

      uuidInvoiceJual: "",
      uuidDriver: "",
      uuidPelanggan: "",
    };
  },

  methods: {
    cekDataReturn() {
      if (this.dataReturn) {
        this.uuidDriver = this.dataReturn.uuidDriver;
        this.uuidPelanggan = this.dataReturn.uuidPelanggan;
        this.form.uuidBarang = this.dataReturn.uuidBarang;
        this.form.uuidSale = this.dataReturn.uuidSale;
        this.form.tgl_sale = this.dataReturn.tgl_sale;
        this.form.jatuh_tempo = this.dataReturn.jatuh_tempo;
        this.form.nomor_invoice = this.dataReturn.nomor_invoice;
        this.form.faktur_pajak = this.dataReturn.faktur_pajak;
        this.form.nomor_po = this.dataReturn.nomor_po;
        this.form.nomor_surat_jalan = this.dataReturn.nomor_surat_jalan;
        this.form.diskon = this.dataReturn.diskon;
        this.form.ppn = this.dataReturn.ppn;
        this.form.biaya_kirims = this.dataReturn.biaya_kirim;
      }

      if (this.uuidPelanggan) {
        axios
          .get("api/pelanggan/" + this.uuidPelanggan)
          .then(({ data }) => (this.form.pelanggan_id = data));
      }
      if (this.uuidDriver) {
        axios
          .get("api/driver/" + this.uuidDriver)
          .then(({ data }) => (this.form.driver_id = data));
      }
    },
    loadUsers() {
      this.cekDataReturn();
      if (this.dataInvoiceJual) {
        this.return = true;
        this.form.dataBarang = this.dataInvoiceJual;
        this.checkouts = this.dataInvoiceJual;
        this.subtotals = this.dataInvoiceJual[0]["harga_akhir"] * 1000;
        this.subtotalfunc = this.dataInvoiceJual[0]["harga_akhir"];
      } else {
        axios
          .get("api/invoicejual")
          .then(({ data }) => (this.checkouts = data));
        axios
          .get("api/subtotal")
          .then(
            ({ data }) => (this.subtotals = this.formatRupiah(data * 1000))
          );
        axios
          .get("api/subtotal")
          .then(({ data }) => (this.subtotalfunc = data));
      }
      axios.get("api/driver").then(({ data }) => (this.drivers = data));
      axios.get("api/pelanggan").then(({ data }) => (this.pelanggans = data));
    },

    clickbiayakirim() {
      this.form.biaya_kirim = this.form.biaya_kirims;
    },
    blurbiayakirim() {
      this.form.biaya_kirims = this.form.biaya_kirim;
      this.form.biaya_kirim = this.formatRupiah(this.form.biaya_kirims);
    },

    hitungtotal() {
      var subtotal = this.subtotalfunc;
      // var ppns = this.form.ppn;
      var diskon = this.form.diskon;
      var hasildiskon = (subtotal * diskon) / 100;
      var hasil = subtotal - hasildiskon;
      var ppns = this.form.ppn;
      var ppn = (hasil * ppns) / 100;
      var hasilsetelahppn = hasil + ppn;
      var biayakirim = this.form.biaya_kirims / 1000;
      // console.log(biayakirim);
      var grandtotal = hasilsetelahppn + biayakirim;
      this.form.hargastlhdiskon = this.formatRupiah(hasil * 1000);
      this.form.hargastlhppn = this.formatRupiah(hasilsetelahppn * 1000);
      this.form.total = this.formatRupiah(grandtotal * 1000);
    },

    // CREATE
    simpandata() {
      this.loading = true;
      this.disabled = true;
      if (this.return) {
        this.form
          .post("api/salexxx")
          .then(() => {
            Fire.$emit("reloadUsers");
            // $("#exampleModal").modal("hide");
            Swal.fire({
              icon: "success",
              title: "Data Berhasil Tersimpan",
            }).then(function () {
              // Redirect the user
              window.location.href = "/data-invoice";
            });
          })
          .catch(() => {
            this.loading = false;
            this.disabled = false;
          });
      } else {
        this.form.invoivejual_id = this.checkouts;
        this.form.subttl = this.subtotals;
        this.form
          .post("api/sale")
          .then(() => {
            Fire.$emit("reloadUsers");
            // $("#exampleModal").modal("hide");
            Swal.fire({
              icon: "success",
              title: "Data Berhasil Tersimpan",
            }).then(function () {
              // Redirect the user
              window.location.href = "/data-invoice";
            });
          })
          .catch(() => {
            this.loading = false;
            this.disabled = false;
          });
      }
    },
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>