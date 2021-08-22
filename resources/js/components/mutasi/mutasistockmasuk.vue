<template>
  <div class="card">
    <div class="card-body">
      <table id="example" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal Masuk</th>
            <th>Barang</th>
            <th>Gudang</th>
            <th>keterangan</th>
            <!-- <th>Aksi</th> -->
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in mutasistockmasuks" :key="index">
            <td>{{ index + 1 }}</td>
            <td>
              {{
                new Date(item.created_at).toLocaleDateString("id-ID", {
                  dateStyle: "full",
                })
              }}
            </td>
            <td>{{ item.nama }}</td>
            <td>{{ item.gudang }}</td>
            <td>{{ item.keterangan }}</td>
          </tr>
        </tbody>
      </table>
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
      mutasistockmasuks: {},
    };
  },
  methods: {
    // Load data pada tabel with axios
    loadUsers() {
      // axios.get("api/golongan").then(({ data }) => (this.golongans = data));
      axios.get("api/mutasistockmasuk").then((res) => {
        $("#example").DataTable().destroy();
        this.mutasistockmasuks = res.data;
        setTimeout(function () {
          $("#example").DataTable();
        }, 1000);
      });
    },
  },
};
</script>