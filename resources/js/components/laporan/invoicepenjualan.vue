<template>
  <div>
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="example">
            <thead>
              <tr>
                <th width="1%">No</th>
                <th>No. invoice</th>
                <th>Tanggal</th>
                <th>Pembeli</th>
                <th width="1%">Qty</th>
                <th>Barang</th>
                <th>Total Tagihan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in laporans" :key="index">
                <td class="text-center">{{ index + 1 }}</td>
                <td>{{ item.nomor_invoice }}</td>
                <td>
                  {{
                    new Date(item.jatuh_tempo).toLocaleDateString("id-ID", {
                      dateStyle: "full",
                    })
                  }}
                </td>
                <td>{{ item.nama }}</td>
                <td>{{ item.total_satuan_jual }} {{ item.satuan_jual }}</td>
                <td>{{ item.barang }}</td>
                <td>
                  {{
                    new Intl.NumberFormat("id-ID", {
                      style: "currency",
                      currency: "IDR",
                    }).format(item.total * 1000)
                  }}
                </td>
                <td>
                  <div
                    class="d-flex align-items-center text-success"
                    v-if="item.status_bayar == 1"
                  >
                    <i
                      class="
                        bx bx-radio-circle-marked bx-burst bx-rotate-90
                        align-middle
                        font-18
                        me-1
                      "
                    ></i>
                    <span>Lunas</span>
                  </div>
                  <div class="d-flex align-items-center text-warning" v-else>
                    <i
                      class="
                        bx bx-radio-circle-marked bx-burst bx-rotate-90
                        align-middle
                        font-18
                        me-1
                      "
                    ></i>
                    <span>Belum Lunas</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
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
      laporans: {},
      form: new Form({
        uuid: "",
      }),
    };
  },
  methods: {
    loadUsers() {
      axios.get("api/GetlaporanInvoice").then((res) => {
        $("#example").DataTable().destroy();
        this.laporans = res.data;
        setTimeout(function () {
          $("#example").DataTable();
        }, 1000);
      });
      // axios.get("api/getAllDataSale").then((res) => {
      //   this.laporans = res.data;
      // });
    },
  },
};
</script>