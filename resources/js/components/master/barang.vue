<template>
  <div>
    <ul class="nav nav-tabs nav-primary" role="tablist">
      <li class="nav-item" role="presentation">
        <a
          class="nav-link active"
          data-bs-toggle="tab"
          href="#primaryhome"
          role="tab"
          aria-selected="true"
        >
          <div class="d-flex align-items-center">
            <div class="tab-icon">
              <i class="bx bx-package font-18 me-1"></i>
            </div>
            <div class="tab-title">Data Barang</div>
          </div>
        </a>
      </li>
      <li class="nav-item" role="presentation">
        <a
          class="nav-link"
          data-bs-toggle="tab"
          href="#primaryprofile"
          role="tab"
          aria-selected="false"
        >
          <div class="d-flex align-items-center">
            <div class="tab-icon">
              <i class="bx bxs-up-arrow-square font-18 me-1"></i>
            </div>
            <div class="tab-title">Data Stock Barang</div>
          </div>
        </a>
      </li>
    </ul>
    <div class="tab-content py-3">
      <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
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
            <div class="table-responsive">
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
                    <th>Satuan</th>
                    <th>Merek</th>
                    <th>Kategori</th>
                    <th>Gudang</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in barangs" :key="index">
                    <td>
                      <input
                        type="checkbox"
                        v-model="deleteItems"
                        :value="`${item.uuid}`"
                      />
                    </td>
                    <td>{{ item.nama }}</td>
                    <td>{{ item.satuan_isi }}</td>
                    <td>{{ item.brand }}</td>
                    <td>{{ item.kategori }}</td>
                    <td>{{ item.gudang }}</td>
                    <td v-if="item.keterangan == null">
                      <div class="d-flex align-items-center text-danger">
                        <i
                          class="
                            bx bx-radio-circle-marked bx-burst bx-rotate-90
                            align-middle
                            font-18
                            me-1
                          "
                        ></i>
                        <span>Tidak ada keterangan</span>
                      </div>
                    </td>
                    <td v-else>{{ item.keterangan }}</td>
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
                            item.nama,
                            item.brand_id,
                            item.kategori_id,
                            item.satuan_id,
                            item.gudang_id,
                            item.keterangan
                          )
                        "
                      >
                        <i class="bx bx-edit"></i>
                      </button>
                      <button
                        class="btn btn-primary btn-sm"
                        @click="
                          updatestock(
                            item.uuid,
                            item.nama,
                            item.satuan_id,
                            item.gudang_id,
                            item.sisa
                          )
                        "
                      >
                        <i class="bx bxs-up-arrow-square"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="example1" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Merek</th>
                    <th>Kategori</th>
                    <th>Gudang</th>
                    <th>Stock Keluar</th>
                    <th>Stock Masuk</th>
                    <th>Sisa Stock</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in barangs" :key="index">
                    <td>{{ item.nama }}</td>
                    <td>{{ item.brand }}</td>
                    <td>{{ item.kategori }}</td>
                    <td>{{ item.gudang }}</td>

                    <td v-if="item.terjual == null">
                      <div class="d-flex align-items-center text-danger">
                        <i
                          class="
                            bx bx-radio-circle-marked bx-burst bx-rotate-90
                            align-middle
                            font-18
                            me-1
                          "
                        ></i>
                        <span>Barang Belum Terjual</span>
                      </div>
                    </td>
                    <td v-else>{{ item.terjual }} {{ item.satuan_jual }}</td>

                    <td v-if="item.terbeli == null">
                      <div class="d-flex align-items-center text-danger">
                        <i
                          class="
                            bx bx-radio-circle-marked bx-burst bx-rotate-90
                            align-middle
                            font-18
                            me-1
                          "
                        ></i>
                        <span>Barang Baru</span>
                      </div>
                    </td>
                    <td v-else>{{ item.terbeli }} {{ item.satuan_isi }}</td>

                    <td v-if="item.sisa == null">
                      <div class="d-flex align-items-center text-danger">
                        <i
                          class="
                            bx bx-radio-circle-marked bx-burst bx-rotate-90
                            align-middle
                            font-18
                            me-1
                          "
                        ></i>
                        <span>Barang Baru</span>
                      </div>
                    </td>
                    <td v-else>{{ item.sisa }} {{ item.satuan_isi }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
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
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Barang</h5>
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
              <div class="row mb-2">
                <div class="col-md-4">
                  <label for="form-control">Nama Barang</label>
                  <input
                    class="form-control"
                    v-model="form.nama"
                    type="text"
                    placeholder="Nama Barang"
                    :class="{ 'is-invalid': form.errors.has('nama') }"
                    required
                  />
                </div>
                <div class="col-md-4">
                  <label for="form-control">Brand</label>
                  <select
                    class="form-control"
                    v-model="form.brand_id"
                    :class="{ 'is-invalid': form.errors.has('brand_id') }"
                  >
                    <option value>Pilih</option>
                    <option
                      v-for="item in brands"
                      :key="item.uuid"
                      :value="item.uuid"
                    >
                      {{ item.brand }}
                    </option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="form-control">Kategori</label>
                  <select
                    class="form-control"
                    v-model="form.kategori_id"
                    :class="{ 'is-invalid': form.errors.has('kategori_id') }"
                  >
                    <option value>Pilih</option>
                    <option
                      v-for="item in kategoris"
                      :key="item.uuid"
                      :value="item.uuid"
                    >
                      {{ item.kategori }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-md-5">
                  <label for="form-control">Satuan Isi Barang</label>
                  <multiselect
                    v-model="form.satuan_id"
                    label="satuan_isi"
                    track-by="satuan_isi"
                    :options="satuans"
                    :class="{ 'is-invalid': form.errors.has('satuan_id') }"
                    required
                  >
                    <template slot="singleLabel" slot-scope="{ option }"
                      >Satuan Isi:
                      <strong>{{ option.satuan_isi }}</strong> Dengan satuan
                      Jual: <strong>{{ option.satuan_jual }}</strong></template
                    >
                  </multiselect>
                </div>
                <div class="col-md-4">
                  <label for="form-control">Gudang</label>
                  <select
                    class="form-control"
                    v-model="form.gudang_id"
                    :class="{ 'is-invalid': form.errors.has('gudang_id') }"
                  >
                    <option value>Pilih</option>
                    <option
                      v-for="item in gudangs"
                      :key="item.uuid"
                      :value="item.uuid"
                    >
                      {{ item.gudang }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <label for="form-control">Keterangan Barang</label>
                  <textarea
                    class="form-control"
                    v-model="form.keterangan"
                    placeholder="Keterangan Barang"
                    :class="{ 'is-invalid': form.errors.has('keterangan') }"
                  ></textarea>
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

    <!-- MODAL STOCK -->
    <div
      class="modal fade"
      id="modelId"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Stock Masuk</h5>
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
            @submit.prevent="updatestockbarang()"
            @keydown="form.onKeydown($event)"
          >
            <div class="modal-body">
              <div class="row mb-2">
                <div class="col-lg-4">
                  <label for="form-control">Nama Barang</label>
                  <input
                    class="form-control"
                    v-model="form.nama"
                    type="text"
                    placeholder="Nama Barang"
                    :class="{ 'is-invalid': form.errors.has('nama') }"
                    readonly
                  />
                </div>
                <div class="col-lg-4">
                  <label for="form-control">Gudang</label>
                  <multiselect
                    v-model="form.gudang_id"
                    label="gudang_id"
                    track-by="gudang_id"
                    :options="gudangs"
                    :class="{ 'is-invalid': form.errors.has('gudang_id') }"
                    :disabled="true"
                  >
                    <template slot="singleLabel" slot-scope="{ option }">
                      <strong>{{ option.gudang }}</strong></template
                    >
                  </multiselect>
                </div>
                <div class="col-lg-4">
                  <label for="form-control">Satuan Isi Barang</label>
                  <multiselect
                    v-model="form.satuan_id"
                    label="satuan_isi"
                    track-by="satuan_isi"
                    :options="satuans"
                    :class="{ 'is-invalid': form.errors.has('satuan_id') }"
                    :disabled="true"
                  >
                    <template slot="singleLabel" slot-scope="{ option }">
                      <strong>{{ option.satuan_isi }}</strong></template
                    >
                  </multiselect>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4">
                  <label for="form-control">Stock Barang Saat Ini</label>
                  <input
                    class="form-control"
                    v-model="form.sisa"
                    type="text"
                    readonly
                    placeholder="Jumlah Barang Masuk"
                    :class="{ 'is-invalid': form.errors.has('sisa') }"
                  />
                </div>
                <div class="col-lg-4">
                  <label for="form-control">Jumlah Barang Masuk</label>
                  <input
                    class="form-control"
                    v-model="form.newstock"
                    type="number"
                    min="0"
                    placeholder="Jumlah Barang Masuk"
                    :class="{ 'is-invalid': form.errors.has('newstock') }"
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
import Multiselect from "vue-multiselect";

// register globally
Vue.component("multiselect", Multiselect);

export default {
  // Inisialisasi variable pada tabel
  created() {
    this.loadUsers();
    Fire.$on("reloadUsers", () => {
      this.loadUsers();
    });
    // this.getsatuan();
  },
  data() {
    //  Save variabel object or array 'ex: users{}'
    return {
      editmode: false,
      barangs: {},
      brands: {},
      kategoris: {},
      satuans: [],
      gudangs: [],
      satuanjuals: {},
      all_select: false,
      deleteItems: [],
      select: "",

      // tableShow: { showdata: true },
      // Save input for modal form
      form: new Form({
        uuid: "",
        nama: "",
        brand_id: "",
        satuan_id: "",
        gudang_id: "",
        kategori_id: "",
        keterangan: "",
        sisa: "",
        newstock: "",
      }),
    };
  },
  methods: {
    // Load data pada tabel with axios
    loadUsers() {
      // axios.get("api/golongan").then(({ data }) => (this.golongans = data));
      axios.get("api/barang").then((res) => {
        $("#example").DataTable().destroy();
        this.barangs = res.data;
        setTimeout(function () {
          $("#example").DataTable();
        }, 1000);
      });
      axios.get("api/brand").then(({ data }) => (this.brands = data));
      axios.get("api/kategori").then(({ data }) => (this.kategoris = data));
      axios.get("api/gudang").then(({ data }) => (this.gudangs = data));
      axios.get("api/satuan").then(({ data }) => (this.satuans = data));
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
    showModalstock() {
      this.resetVariable();
      $("#modelId").modal("show");
    },
    closeModalstock() {
      this.resetVariable();
      $("#modelId").modal("hide");
    },
    resetVariable() {
      this.form.reset();
    },

    // CREATE
    simpandata() {
      this.loading = true;
      this.disabled = true;

      if (this.form.uuid == "") {
        this.form
          .post("api/barang")
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
          .put("api/barang/" + this.form.uuid)
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
    updatestockbarang() {
      this.loading = true;
      this.disabled = true;
      this.form
        .put("api/updatestock/" + this.form.uuid)
        .then(() => {
          Fire.$emit("reloadUsers");
          $("#modelId").modal("hide");
          Swal.fire({
            icon: "success",
            title: "Berhasil Menambahkan Stock Barang",
          });
          this.loading = false;
          this.disabled = false;
        })
        .catch(() => {
          this.loading = false;
          this.disabled = false;
        });
    },

    // UPDATE
    edit(uuid, nama, brand_id, kategori_id, satuan_id, gudang_id, keterangan) {
      this.showModal();
      this.form.uuid = uuid;
      this.form.nama = nama;
      this.form.brand_id = brand_id;
      this.form.kategori_id = kategori_id;
      this.form.satuan_id = this.satuans;
      this.form.gudang_id = gudang_id;
      this.form.keterangan = keterangan;
    },
    updatestock(uuid, nama, satuan_id, gudang_id, sisa) {
      this.showModalstock();
      this.form.uuid = uuid;
      this.form.nama = nama;
      this.form.satuan_id = this.satuans;
      this.form.gudang_id = this.gudangs;
      this.form.sisa = sisa;
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
            .delete(`api/barang/` + uuid)
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
            .post(`api/deletebarang/` + this.deleteItems)
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
        this.barangs.forEach((item) => {
          this.deleteItems.push(item.uuid);
        });
      } else {
        this.all_select = false;
        this.deleteItems = [];
      }
    },
  },
};
$(document).ready(function () {
  $("#example1").DataTable();
});
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>