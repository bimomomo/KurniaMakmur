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
                <th>Barang</th>
                <th>Biaya kirim</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in laporanpengiriman" :key="index">
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
                <td>{{ item.barang }}</td>
                <td>
                  {{
                    new Intl.NumberFormat("id-ID", {
                      style: "currency",
                      currency: "IDR",
                    }).format(item.biaya_kirim * 1000)
                  }}
                </td>
                <td>
                  <div
                    class="d-flex align-items-center text-success"
                    v-if="item.status_pengiriman == 1"
                  >
                    <i
                      class="
                        bx bx-radio-circle-marked bx-burst bx-rotate-90
                        align-middle
                        font-18
                        me-1
                      "
                    ></i>
                    <span>Terkirim</span>
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
                    <span>Belum Terkirim</span>
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
      laporanpengiriman: {},
      form: new Form({
        uuid: "",
      }),
    };
  },
  methods: {
    loadUsers() {
      axios.get("api/GetLaporanPengiriman").then((res) => {
        $("#example").DataTable().destroy();
        this.laporanpengiriman = res.data;
        setTimeout(function () {
          $("#example").DataTable();
        }, 1000);
      });
    },
  },
};
</script>