	<template>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal Pembuatan</th>
              <th>No. Invoice</th>
              <th>Pelanggan</th>
              <th>No. PO</th>
              <th>Jatuh Tempo</th>
              <th>Total</th>
              <th>Status Bayar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in sales" :key="index">
              <td>{{ index + 1 }}</td>
              <td>
                {{
                  new Date(item.tgl_sale).toLocaleDateString("id-ID", {
                    dateStyle: "full",
                  })
                }}
              </td>
              <td>{{ item.nomor_invoice }}</td>
              <td>{{ item.nama }}</td>
              <td>{{ item.nomor_po }}</td>
              <td>
                {{
                  new Date(item.jatuh_tempo).toLocaleDateString("id-ID", {
                    dateStyle: "full",
                  })
                }}
              </td>
              <td>
                {{
                  new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                  }).format(item.total * 1000)
                }}
              </td>
              <td class="text-center">
                <span
                  class="badge bg-gradient-burning"
                  style="cursor: pointer"
                  v-if="item.status_bayar == 0"
                  @click="updatebayar(item.nomor_invoice, 1)"
                  >Bayar Sekarang</span
                >
                <span
                  class="badge bg-gradient-burning"
                  style="cursor: pointer"
                  v-else-if="item.status_bayar == 1"
                  >Lunas</span
                >
              </td>
              <td>
                <button class="btn btn-danger btn-sm">
                  <i class="bx bx-x"></i>
                </button>
                <button
                  class="btn btn-info btn-sm"
                  @click="detail(item.nomor_invoice)"
                >
                  <i class="bx bx-detail"></i>
                </button>
                <button class="btn btn-primary btn-sm">
                  <i class="bx bx-printer"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal detail -->
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
            <h5 class="modal-title">Detail pembelian</h5>
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
            <div id="invoice">
              <div class="invoice overflow-auto">
                <div>
                  <main>
                    <div v-for="(item, index) in details" :key="index">
                      <div class="row contacts">
                        <div class="col invoice-to">
                          <div class="text-gray-light">Dari</div>
                          <h2 class="to">KurniaMakmur</h2>
                          <div class="address">
                            <div>455 Foggy Heights, AZ 85004, US</div>
                            <div>(123) 456-789</div>
                            <div>company@example.com</div>
                            <div>No. Invoice : {{ item.nomor_invoice }}</div>
                            <div>
                              No. Faktur Pajak : {{ item.faktur_pajak }}
                            </div>
                            <div>No. PO : {{ item.nomor_po }}</div>
                            <div>Jatuh Tempo: {{ item.jatuh_tempo }}</div>
                          </div>
                        </div>
                        <div class="col invoice-details">
                          <div class="text-gray-light text-center">Kepada</div>
                          <h2 class="to">{{ item.nama }}</h2>
                          <div class="address">
                            {{ item.alamat }}
                          </div>
                        </div>
                      </div>
                      <table>
                        <thead>
                          <tr>
                            <th>#</th>
                            <th class="text-left">SATUAN</th>
                            <th class="text-right">QTY</th>
                            <th class="text-right">TOTAL QTY</th>
                            <th class="text-right">PRODUK</th>
                            <th class="text-right">HARGA/ITEM</th>
                            <th class="text-right">TOTAL HARGA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(items, index) in gols" :key="index">
                            <td class="no">{{ index + 1 }}</td>
                            <td class="text-left">
                              {{ items.jumlah_satuan_isi }}
                              {{ items.satuan_isi }}
                            </td>
                            <td class="unit">
                              {{ items.jumlah_satuan_dijual }}
                              {{ items.satuan_isi }}
                            </td>
                            <td class="qty">
                              {{ items.total_satuan_jual }}
                              {{ items.satuan_jual }}
                            </td>
                            <td class="total">{{ items.produk }}</td>
                            <td class="total">
                              {{
                                new Intl.NumberFormat("id-ID", {
                                  style: "currency",
                                  currency: "IDR",
                                }).format(items.harga * 1000)
                              }}
                            </td>
                            <td class="total">
                              {{
                                new Intl.NumberFormat("id-ID", {
                                  style: "currency",
                                  currency: "IDR",
                                }).format(items.harga_akhir * 1000)
                              }}
                            </td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="4">SUBTOTAL</td>
                            <td>
                              {{
                                new Intl.NumberFormat("id-ID", {
                                  style: "currency",
                                  currency: "IDR",
                                }).format(item.subtotal * 1000)
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="4">DISKON ({{ item.diskon }})%</td>
                            <td>
                              {{ hasildiskon }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="4">PPN ({{ item.ppn }})%</td>
                            <td>{{ hasilppn }}</td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="4">BIAYA KIRIM</td>
                            <td>
                              {{
                                new Intl.NumberFormat("id-ID", {
                                  style: "currency",
                                  currency: "IDR",
                                }).format(item.biaya_kirim * 1000)
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="4" class="text-dark">TOTAL</td>
                            <td class="text-dark">{{ total }}</td>
                          </tr>
                        </tfoot>
                      </table>
                      <div class="row float-end">
                        <div class="col-lg-12">
                          <h5>TERBILANG : {{ terbilangs }} rupiah</h5>
                        </div>
                      </div>
                    </div>
                  </main>
                </div>
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
            <button class="btn btn-primary" v-on:click="cetak">
              <i class="bx bx-printer"></i>Print
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal detail -->
    <template>
      <div>
        <vue-html2pdf
          :show-layout="false"
          :enable-download="true"
          :float-layout="true"
          :preview-modal="true"
          :paginate-elements-by-height="1100"
          filename="Data Invoice"
          :pdf-quality="2"
          :manual-pagination="false"
          pdf-format="a4"
          pdf-orientation="landscape"
          pdf-content-width="1100px"
          @hasStartedGeneration="hasStartedGeneration()"
          @hasGenerated="hasGenerated($event)"
          ref="html2Pdf"
        >
          <section slot="pdf-content">
            <div id="invoice">
              <div class="invoice overflow-auto">
                <div>
                  <main>
                    <div v-for="(item, index) in details" :key="index">
                      <div class="row contacts" style="font-size: small">
                        <div class="col invoice-to">
                          <div class="text-gray-light">Dari</div>
                          <h2 class="to">KurniaMakmur</h2>
                          <div class="address">
                            <div>455 Foggy Heights, AZ 85004, US</div>
                            <div>(123) 456-789</div>
                            <div>company@example.com</div>
                            <div>No. Invoice : {{ item.nomor_invoice }}</div>
                            <div>
                              No. Faktur Pajak : {{ item.faktur_pajak }}
                            </div>
                            <div>No. PO : {{ item.nomor_po }}</div>
                            <div>Jatuh Tempo: {{ item.jatuh_tempo }}</div>
                          </div>
                        </div>
                        <div class="col invoice-details">
                          <div class="text-gray-light text-center">Kepada</div>
                          <h2 class="to">{{ item.nama }}</h2>
                          <div class="address">
                            {{ item.alamat }}
                          </div>
                        </div>
                      </div>
                      <table style="font-size: x-small">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th class="text-left">SATUAN</th>
                            <th class="text-right">QTY</th>
                            <th class="text-right">TOTAL QTY</th>
                            <th class="text-right">PRODUK</th>
                            <th class="text-right">HARGA/ITEM</th>
                            <th class="text-right">TOTAL HARGA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(items, index) in gols" :key="index">
                            <td class="no">{{ index + 1 }}</td>
                            <td class="text-left">
                              {{ items.jumlah_satuan_isi }}
                              {{ items.satuan_isi }}
                            </td>
                            <td class="unit">
                              {{ items.jumlah_satuan_dijual }}
                              {{ items.satuan_isi }}
                            </td>
                            <td class="qty">
                              {{ items.total_satuan_jual }}
                              {{ items.satuan_jual }}
                            </td>
                            <td class="total">{{ items.produk }}</td>
                            <td class="total">
                              {{
                                new Intl.NumberFormat("id-ID", {
                                  style: "currency",
                                  currency: "IDR",
                                }).format(items.harga * 1000)
                              }}
                            </td>
                            <td class="total">
                              {{
                                new Intl.NumberFormat("id-ID", {
                                  style: "currency",
                                  currency: "IDR",
                                }).format(items.harga_akhir * 1000)
                              }}
                            </td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="4">SUBTOTAL</td>
                            <td>
                              {{
                                new Intl.NumberFormat("id-ID", {
                                  style: "currency",
                                  currency: "IDR",
                                }).format(item.subtotal * 1000)
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="4">DISKON ({{ item.diskon }})%</td>
                            <td>
                              {{ hasildiskon }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="4">PPN ({{ item.ppn }})%</td>
                            <td>{{ hasilppn }}</td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="4">BIAYA KIRIM</td>
                            <td>
                              {{
                                new Intl.NumberFormat("id-ID", {
                                  style: "currency",
                                  currency: "IDR",
                                }).format(item.biaya_kirim * 1000)
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="4" class="text-dark">TOTAL</td>
                            <td class="text-dark">{{ total }}</td>
                          </tr>
                        </tfoot>
                      </table>
                      <div class="row float-end">
                        <div class="col-lg-12">
                          <h5>TERBILANG : {{ terbilangs }} rupiah</h5>
                        </div>
                      </div>
                    </div>
                  </main>
                </div>
              </div>
            </div>
          </section>
        </vue-html2pdf>
      </div>
    </template>
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
const angka = require("@dimaskiddo/angka-terbilang-nodejs");

import VueHtml2pdf from "vue-html2pdf";

export default {
  components: {
    VueHtml2pdf,
  },
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
      hasildiskon: "",
      nilaidiskon: "",
      hasilppn: "",
      total: "",
      totaldefault: "",
      terbilangs: "",
      sales: {},
      details: {},
      gols: {},
    };
  },
  methods: {
    // Load data pada tabel with axios
    loadUsers() {
      axios.get("api/sale").then((res) => {
        $("#example").DataTable().destroy();
        this.sales = res.data;
        setTimeout(function () {
          $("#example").DataTable();
        }, 1000);
      });
    },
    showmodal() {
      $("#modelId").modal("show");
    },
    detail(nomor_invoice) {
      this.showmodal();
      axios.get("api/detail/" + nomor_invoice).then(({ data }) => {
        this.gols = data;
      });
      axios.get("api/test/" + nomor_invoice).then(({ data }) => {
        this.details = data;
        this.hitungdiskon();
        this.hitungppn();
        this.terbilangs = angka.toTerbilang("" + this.totaldefault + "");
      });
      // setTimeout(() => {
      //   this.printinvoice();
      // }, 1000);
    },
    cetak: function (event) {
      this.printinvoice(event);
      $("#modelId").modal("hide");
    },
    printinvoice() {
      this.$refs.html2Pdf.generatePdf();
    },
    hitungdiskon() {
      var a = this.details;
      for (let i = 0; i < a.length; i++) {
        const elm = a[i];
        var diskons = elm.diskon;
        var subtotals = elm.subtotal;
        var hasildiskons = (subtotals * diskons) / 100;
        this.hasildiskon = this.formatRupiah(hasildiskons * 1000);
        this.nilaidiskon = hasildiskons;
      }
    },
    hitungppn() {
      var b = this.nilaidiskon;
      var a = this.details;
      for (let i = 0; i < a.length; i++) {
        const elm = a[i];
        var ppns = elm.ppn;
        var biayakirims = elm.biaya_kirim;
        var subtotals = elm.subtotal;
        var nilai = subtotals - b;
        var hitungppns = (nilai * ppns) / 100;
        var hasilsetelahppn = nilai + hitungppns;
        var totals = hasilsetelahppn + biayakirims;
        this.hasilppn = this.formatRupiah(hasilsetelahppn * 1000);
        this.total = this.formatRupiah(totals * 1000);
        this.totaldefault = totals * 1000;
      }
    },

    updatebayar(nomor_invoice, status) {
      axios
        .post("/api/bayar/" + nomor_invoice, {
          status_bayar: status,
        })
        .then(() => {
          Fire.$emit("reloadUsers");
          // $("#merchantssModal").modal("hide");
          Swal.fire({ icon: "success", title: "Pembayaran Berhasil" });
          this.loading = false;
          this.disabled = false;
        })
        .catch(() => {
          Swal.fire({ icon: "error", title: "Data Gagal Tersimpan" });
          this.loading = false;
          this.disabled = false;
        });
    },
  },
};
</script>