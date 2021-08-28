<template>
  <div class="card">
    <div class="card-header">
      <button class="btn btn-primary btn-sm" @click="showModal">
        <i class="bx bx-plus"></i>Tambah
      </button>
      <button class="btn btn-danger btn-sm" @click="alldeleteUser">
        <i class="bx bx-trash"></i> Delete All
      </button>
    </div>
    <div class="card-body">
      <table id="example" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th width="1%">
              <input
                type="checkbox"
                @click="select_all_via_check_box"
                v-model="all_select"
              />
            </th>
            <th>Nama</th>
            <th>No. Telp</th>
            <th>Alamat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in pelanggans" :key="index">
            <td>
              <input
                type="checkbox"
                v-model="deleteItems"
                :value="`${item.uuid}`"
              />
            </td>
            <td>{{ item.nama }}</td>
            <td>{{ item.nohp }}</td>
            <td>{{ item.alamat }}</td>
            <td>
              <button
                class="btn btn-danger btn-sm"
                @click="deleteUser(item.uuid)"
              >
                <i class="bx bx-trash"></i>
              </button>
              <button
                class="btn btn-warning btn-sm"
                @click="edit(item.uuid, item.nama, item.nohp, item.alamat)"
              >
                <i class="bx bx-edit"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- MODAL CREATE -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pelanggan</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form
            @submit.prevent="simpandata()"
            @keydown="form.onKeydown($event)"
          >
            <div class="modal-body">
              <div class="row" v-for="(kg, mn) in DataPelanggan" :key="mn">
                <div class="col-lg-6">
                  <label for="form-control">Nama Pelanggan</label>
                  <input
                    class="form-control"
                    v-model="kg.nama"
                    type="text"
                    placeholder="Nama Pelanggan"
                    :class="{ 'is-invalid': form.errors.has('nama') }"
                    required
                  />
                </div>
                <div class="col-lg-6 mb-2">
                  <label for="form-control">No. Hp Pelanggan</label>
                  <input
                    class="form-control"
                    v-model="kg.nohp"
                    type="text"
                    placeholder="Nomor Handphone"
                    :class="{ 'is-invalid': form.errors.has('nohp') }"
                    required
                  />
                </div>
                <div class="col-lg-12">
                  <label for="form-control">Alamat Pelanggan</label>
                  <textarea
                    v-model="kg.alamat"
                    class="form-control"
                    id=""
                    cols="30"
                    rows="10"
                    placeholder="Alamat Lengkap Pelanggan"
                    required
                  ></textarea>
                </div>
                <div class="row" id="plus">
                  <div class="col-md-3">
                    <span id="span">
                      <i
                        class="bx bx-plus"
                        @click="addpelatihan(mn)"
                        v-show="mn == DataPelanggan.length - 1"
                      ></i>
                      <i
                        class="bx bx-trash"
                        @click="removepelatihan(mn)"
                        v-show="mn || (!mn && DataPelanggan.length > 1)"
                      ></i>
                    </span>
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
              <button type="submit" class="btn btn-primary">
                Save changes
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- END MODAL -->
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
      editmode: false,
      pelanggans: {},
      grades: {},
      all_select: false,
      deleteItems: [],
      select: "",
      DataPelanggan: [
        {
          nama: "",
          nohp: "",
          alamat: "",
        },
      ],
      // tableShow: { showdata: true },
      // Save input for modal form
      form: new Form({
        uuid: "",
        kt: [],
      }),
    };
  },
  methods: {
    // Load data pada tabel with axios
    loadUsers() {
      // axios.get("api/golongan").then(({ data }) => (this.golongans = data));
      axios.get("api/pelanggan").then((res) => {
        $("#example").DataTable().destroy();
        this.pelanggans = res.data;
        setTimeout(function () {
          $("#example").DataTable();
        }, 1000);
      });
    },

    // Trigger button modal
    showModal() {
      this.resetVariable();
      $("#exampleModal").modal("show");
    },
    closeModal() {
      this.resetVariable();
      $("#exampleModal").modal("hide");
    },
    resetVariable() {
      this.form.reset();
      this.DataPelanggan = [
        {
          nama: "",
          nohp: "",
          alamat: "",
        },
      ];
    },
    // CREATE
    simpandata() {
      this.loading = true;
      this.disabled = true;
      this.form.kt = this.DataPelanggan;
      if (this.form.uuid == "") {
        this.form
          .post("api/pelanggan")
          .then(() => {
            Fire.$emit("reloadUsers");
            $("#exampleModal").modal("hide");
            Swal.fire({ icon: "success", title: "Data Berhasil Tersimpan" });
            this.loading = false;
            this.disabled = false;
          })
          .catch(() => {
            this.loading = false;
            this.disabled = false;
          });
      } else {
        this.form
          .put("api/pelanggan/" + this.form.uuid)
          .then(() => {
            Fire.$emit("reloadUsers");
            $("#exampleModal").modal("hide");
            Swal.fire({ icon: "success", title: "Data Berhasil Di Update" });
            this.loading = false;
            this.disabled = false;
          })
          .catch(() => {
            this.loading = false;
            this.disabled = false;
          });
      }
    },
    hide() {
      $("#plus").hide();
    },
    // UPDATE
    edit(uuid, nama, nohp, alamat) {
      this.showModal();
      this.hide();
      this.DataPelanggan = [
        {
          nama: nama,
          nohp: nohp,
          alamat: alamat,
        },
      ];
      this.form.uuid = uuid;
    },
    // DELETE ONE ITEMS
    deleteUser(uuid) {
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
            .delete(`api/pelanggan/` + uuid)
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
    // DELETE SELECT ALL
    alldeleteUser() {
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
            .post(`api/deletepelanggan/` + this.deleteItems)
            .then(() => {
              Fire.$emit("reloadUsers");
              Swal.fire("Deleted!", "User deleted successfully", "success");
              // this.getUser();
              this.deleteItems = [];
              this.all_select == true
                ? (this.all_select = false)
                : (this.all_select = true);
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
    // SELECT CHECKBOX
    select_all_via_check_box() {
      if (this.all_select == false) {
        this.all_select = true;
        this.pelanggans.forEach((item) => {
          this.deleteItems.push(item.uuid);
        });
      } else {
        this.all_select = false;
        this.deleteItems = [];
      }
    },
    addpelatihan(index) {
      this.DataPelanggan.push({
        nama: "",
        nohp: "",
        alamat: "",
      });
    },
    removepelatihan(index) {
      this.DataPelanggan.splice(index, 1);
    },
  },
};
</script>