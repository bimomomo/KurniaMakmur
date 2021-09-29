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
      <table id="tabelNotes" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th width="1%">
              <input
                type="checkbox"
                @click="select_all_via_check_box"
                v-model="all_select"
              />
            </th>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Judul</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="item.index">
            <td>
              <input
                type="checkbox"
                v-model="deleteItems"
                :value="`${item.uuid}`"
              />
            </td>
            <td>{{ index + 1 }}</td>
            <td>{{ item.nama }}</td>
            <td>{{ item.judul }}</td>
            <td>{{ item.tanggal }}</td>
            <td>{{ item.keterangan }}</td>
            <td>
              <button
                class="btn btn-danger btn-sm"
                @click="deleteUser(item.uuid)"
              >
                <i class="bx bx-trash"></i>
              </button>
              <button
                class="btn btn-warning btn-sm"
                @click="
                  edit(
                    item.uuid,
                    item.uuidBarang,
                    item.judul,
                    item.tanggal,
                    item.keterangan
                  )
                "
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
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">My Notes</h5>
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
            <div class="row">
              <div class="form-group">
                <label for="form-control">Nama Barang</label>
                <multiselect
                  v-model="form.nama_barang"
                  label="nama"
                  track-by="nama"
                  :options="dataBarang"
                  :custom-label="labelBarang"
                  :class="{ 'is-invalid': form.errors.has('nama_barang') }"
                  required
                >
                </multiselect>
              </div>
              <div class="form-group">
                <label for="form-control">Judul</label>
                <input
                  class="form-control"
                  v-model="form.judul"
                  type="text"
                  placeholder="Judul"
                  :class="{ 'is-invalid': form.errors.has('judul') }"
                  required
                />
              </div>
              <div class="form-group">
                <label for="form-control">Tanggal</label>
                <input
                  class="form-control"
                  v-model="form.tanggal"
                  type="date"
                  placeholder="Tanggal"
                  :class="{ 'is-invalid': form.errors.has('tanggal') }"
                  required
                />
              </div>
              <div class="form-group">
                <label for="form-control">Keterangan</label>
                <input
                  class="form-control"
                  v-model="form.keterangan"
                  type="text"
                  placeholder="Keterangan"
                  :class="{ 'is-invalid': form.errors.has('keterangan') }"
                  required
                />
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
            <button type="submit" class="btn btn-primary" @click="simpandata">
              Save changes
            </button>
          </div>
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
      data: {},
      dataBarang: [],
      all_select: false,
      deleteItems: [],
      // Save input for modal form
      form: new Form({
        uuid: "",
        nama_barang: "",
        judul: "",
        tanggal: "",
        keterangan: "",
      }),
    };
  },
  methods: {
    noUrut(index) {
      return index;
    },
    // Load data pada tabel with axios
    loadUsers() {
      // axios.get("api/golongan").then(({ data }) => (this.golongans = data));
      axios.get("api/notes").then((res) => {
        $("#tabelNotes").DataTable().destroy();
        this.data = res.data.data;
        setTimeout(function () {
          $("#tabelNotes").DataTable();
        }, 1000);
      });
    },

    labelBarang({ nama, keterangan }) {
      return `${nama} | ${keterangan}`;
    },
    getDataBarang() {
      axios.get("api/barang").then((res) => {
        this.dataBarang = res.data;
      });
    },

    // Trigger button modal
    showModal() {
      this.form.reset();
      this.getDataBarang();
      $("#exampleModal").modal("show");
    },
    closeModal() {
      $("#exampleModal").modal("hide");
    },
    // CREATE
    simpandata() {
      this.loading = true;
      this.disabled = true;
      if (this.form.uuid == "") {
        this.form
          .post("api/notes")
          .then(() => {
            Fire.$emit("reloadUsers");
            this.closeModal();
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
          .put("api/notes/" + this.form.uuid)
          .then(() => {
            Fire.$emit("reloadUsers");
            this.closeModal();
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
    // UPDATE
    edit(uuid, uuidBarang, judul, tanggal, keterangan) {
      this.showModal();

      this.form.uuid = uuid;
      axios.get("api/barang/" + uuidBarang).then((res) => {
        this.form.nama_barang = res.data;
      });
      this.form.judul = judul;
      this.form.tanggal = tanggal;
      this.form.keterangan = keterangan;
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
            .delete(`api/notes/` + uuid)
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
            .post(`api/multiDeleteNotes/` + this.deleteItems)
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
        this.data.forEach((item) => {
          this.deleteItems.push(item.uuid);
        });
      } else {
        this.all_select = false;
        this.deleteItems = [];
      }
    },
  },
};
</script>
