<template>
  <div>
    <div class="card">
      <div class="card-body">
        <div class="table-responsive"></div>
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
      form: new Form({
        uuid: "",
      }),
    };
  },
  methods: {
    loadUsers() {
      axios.get("api/GetTransaksiPelanggan").then((res) => {
        $("#example").DataTable().destroy();
        this.GetTransaksiPelanggan = res.data;
        setTimeout(function () {
          $("#example").DataTable();
        }, 1000);
      });
    },
  },
};
</script>