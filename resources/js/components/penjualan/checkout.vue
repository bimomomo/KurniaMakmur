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
                v-model="form.jatuh_tampo"
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
              <select
                class="form-control"
                v-model="form.pelanggan_id"
                :class="{
                  'is-invalid': form.errors.has('pelanggan_id'),
                }"
              >
                <option value="">Pilih Pelanggan</option>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Supir</label>
            </div>
            <div class="col-lg-9">
              <select
                class="form-control"
                v-model="form.driver_id"
                :class="{
                  'is-invalid': form.errors.has('driver_id'),
                }"
              >
                <option value="">Pilih Supir</option>
              </select>
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
              <label for="form-control">PPN (%)</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="number"
                placeholder="PPN"
                min="0"
                max="60"
                v-model="form.ppn"
                :class="{
                  'is-invalid': form.errors.has('ppn'),
                }"
              />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-3">
              <label for="form-control">Potongan</label>
            </div>
            <div class="col-lg-9">
              <input
                class="form-control"
                type="text"
                placeholder="Potongan"
                v-model="form.potongan"
                :class="{
                  'is-invalid': form.errors.has('potongan'),
                }"
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
                placeholder="Biaya Kirim"
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
export default {
  created() {
    this.loadUsers();
    Fire.$on("reloadUsers", () => {
      this.loadUsers();
    });
  },
  data() {
    return {
      checkouts: {},
      subtotals: "",
      subtotalfunc: "",
      form: new Form({
        ppn: "",
        total: "",
        potongan: "",
        invoivejual_id: [],
        pelanggan_id: "",
        tgl_sale: "",
        jatuh_tempo: "",
        nomor_invoice: "",
        faktur_pajak: "",
        nomor_po: "",
        nomor_surat_jalan: "",
        total: "",
        diskon: "",
        biaya_kirim: "",
        driver_id: "",
        biaya_kirims: "",
      }),
    };
  },

  methods: {
    loadUsers() {
      axios.get("api/invoicejual").then(({ data }) => (this.checkouts = data));
      axios
        .get("api/subtotal")
        .then(({ data }) => (this.subtotals = this.formatRupiah(data * 1000)));
      axios.get("api/subtotal").then(({ data }) => (this.subtotalfunc = data));
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
      var ppn = this.form.ppn;
      var hasilppn = (subtotal * ppn) / 100;
      var biayakirim = this.form.biaya_kirims / 1000;
      var hasil = hasilppn + biayakirim;
      // console.log(hasil);
      this.form.potongan = this.formatRupiah(hasilppn * 1000);
      this.form.total = this.formatRupiah(hasil * 1000);
    },

    // CREATE
    simpandata() {
      this.loading = true;
      this.disabled = true;
      this.form.invoivejual_id = this.checkouts;
      this.form
        .post("api/sale")
        .then(() => {
          Fire.$emit("reloadUsers");
          // $("#exampleModal").modal("hide");
          Swal.fire({ icon: "success", title: "Data Berhasil Tersimpan" });
          this.loading = false;
          this.disabled = false;
        })
        .catch(() => {
          this.loading = false;
          this.disabled = false;
        });
    },
  },
};
</script>