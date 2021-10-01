	<template>
  <div class="card">
    <div class="card-body">
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
                <i class="bx bx-home font-18 me-1"></i>
              </div>
              <div class="tab-title">Data Invoice</div>
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
                <i class="bx bx-user-pin font-18 me-1"></i>
              </div>
              <div class="tab-title">Data Return</div>
            </div>
          </a>
        </li>
      </ul>
      <div class="tab-content py-3">
        <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
          <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal pembuatan</th>
                  <th>No. invoice</th>
                  <th>Pelanggan</th>
                  <th>No. PO</th>
                  <th>Jatuh tempo</th>
                  <th>Total</th>
                  <th>Status bayar</th>
                  <th>Status kirim</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in sales" :key="item.index">
                  <td class="text-center">{{ index + 1 }}</td>
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
                  <td>
                    <div
                      class="d-flex align-items-center text-danger"
                      v-if="item.status_bayar == 0"
                      @click="updatebayar(item.nomor_invoice, 1)"
                      style="cursor: pointer"
                    >
                      <i
                        class="
                          bx bx-radio-circle-marked bx-burst bx-rotate-90
                          align-middle
                          font-18
                          me-1
                        "
                      ></i>
                      <span>Bayar Sekarang</span>
                    </div>
                    <div
                      class="d-flex align-items-center text-warning"
                      v-else-if="item.status_bayar == 9"
                    >
                      <i
                        class="
                          bx bx-radio-circle-marked bx-burst bx-rotate-90
                          align-middle
                          font-18
                          me-1
                        "
                      ></i>
                      <span>Barang Di Retur</span>
                    </div>
                    <div class="d-flex align-items-center text-success" v-else>
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
                  </td>
                  <td>
                    <div
                      class="d-flex align-items-center text-warning"
                      v-if="item.status_pengiriman == 0"
                    >
                      <i
                        class="
                          bx bx-radio-circle-marked bx-burst bx-rotate-90
                          align-middle
                          font-18
                          me-1
                        "
                        @click="updatekirim(item.nomor_invoice, 1)"
                        style="cursor: pointer"
                      ></i>
                      <span>Pending</span>
                    </div>
                    <div
                      class="d-flex align-items-center text-danger"
                      v-else-if="item.status_pengiriman == 9"
                    >
                      <i
                        class="
                          bx bx-radio-circle-marked bx-burst bx-rotate-90
                          align-middle
                          font-18
                          me-1
                        "
                      ></i>
                      <span>Batal</span>
                    </div>
                    <div class="d-flex align-items-center text-success" v-else>
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
                  </td>
                  <td>
                    <button
                      class="btn btn-danger btn-sm"
                      v-if="
                        item.status_bayar == 0 || item.status_pengiriman == 0
                      "
                      @click="cancelOrder(item.uuid)"
                    >
                      <i class="bx bx-x"></i>
                    </button>
                    <button
                      class="btn btn-warning btn-sm"
                      v-if="
                        item.status_bayar != 9 || item.status_pengiriman != 9
                      "
                      @click="edit(item.nomor_invoice)"
                    >
                      <i class="bx bx-edit"></i>
                    </button>
                    <button
                      class="btn btn-info btn-sm"
                      @click="detail(item.nomor_invoice)"
                    >
                      <i class="bx bx-detail"></i>
                    </button>
                    <button
                      class="btn btn-primary btn-sm"
                      @click="
                        suratjalan(
                          item.nomor_invoice,
                          item.driver_id,
                          item.nama
                        )
                      "
                    >
                      <i class="bx bx-printer"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
          <table id="tabelReturn" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th width="1%">No</th>
                <th>Tanggal Stok Keluar</th>
                <th>Nomor Invoice</th>
                <th>Nomor PO</th>
                <th>Nomor Surat Jalan</th>
                <th>Nama Barang dan Gudang</th>
                <th>Total Satuan Jual</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="datas in dataReturn" :key="datas.index">
                <td>{{ index }}</td>
                <td>{{ datas.tgl_sale }}</td>
                <td>{{ datas.nomor_invoice }}</td>
                <td>{{ datas.nomor_po }}</td>
                <td>{{ datas.nomor_surat_jalan }}</td>
                <td>{{ datas.nama + " - " + datas.gudang }}</td>
                <td>
                  {{ datas.total_satuan_jual + " - " + datas.satuan_jual }}
                </td>
                <td>
                  <button
                    class="btn btn-info btn-sm"
                    @click="detailDataReturn(datas.nomor_invoice)"
                  >
                    <i class="bx bx-detail"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Modal -->
          <div
            class="modal fade"
            id="modalDataReturn"
            data-backdrop="static"
            data-keyboard="false"
            tabindex="-1"
            aria-labelledby="staticBackdropLabel"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">
                    Data Return
                  </h5>
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
                    <div class="form-group col-md-6">
                      <label>Data Invoice</label>
                      <multiselect
                        v-model="form.idsale"
                        label="namaPelanggan"
                        track-by="namaPelanggan"
                        :custom-label="nameWithLang"
                        :options="dataReturn"
                        :class="{ 'is-invalid': form.errors.has('return') }"
                      >
                      </multiselect>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Jumlah Satuan Jual</label>
                      <input
                        v-model="form.jumlah_satuan_jual"
                        class="form-control"
                      />
                    </div>
                    <div class="form-group col-md-3">
                      <label>Jumlah Satuan Isi</label>
                      <input
                        v-model="form.jumlah_satuan_isi"
                        class="form-control"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>No Invoice</label>
                      <input
                        v-model="form.no_invoice"
                        class="form-control"
                        readonly
                      />
                    </div>
                    <div class="form-group col-md-3">
                      <label>No Surat Jalan</label>
                      <input
                        v-model="form.no_surat_jalan"
                        class="form-control"
                        readonly
                      />
                    </div>
                    <div class="form-group col-md-3">
                      <label>Nama Driver</label>
                      <input
                        v-model="form.nama_driver"
                        class="form-control"
                        readonly
                      />
                    </div>
                    <div class="form-group col-md-3">
                      <label>Nomer HP Driver no_hp</label>
                      <input
                        v-model="form.no_hp_driver"
                        class="form-control"
                        readonly
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>Nama Barang nama</label>
                      <input
                        v-model="form.nama_barang"
                        class="form-control"
                        readonly
                      />
                    </div>
                    <div class="form-group col-md-3">
                      <label>Gudang</label>
                      <input
                        v-model="form.gudang"
                        class="form-control"
                        readonly
                      />
                    </div>
                    <div class="form-group col-md-3">
                      <label>Total</label>
                      <input
                        v-model="form.total"
                        class="form-control"
                        readonly
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
                  <button type="button" class="btn btn-primary">
                    Understood
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal edit -->
    <div
      class="modal fade"
      id="modalEdit"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Invoice</h5>
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
            <div v-for="(forms, index) in dataDetail" :key="index">
              <div class="row mb-2">
                <div class="col-lg-6">
                  <label for="form-control">Pilih Barang</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="forms.namaBarang"
                    :class="{ 'is-invalid': form.errors.has('harga') }"
                    readonly
                  />
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-lg-2">
                  <label for="form-control">Sisa Stock</label>
                  <div class="input-group">
                    <input
                      type="text"
                      class="form-control"
                      v-model="forms.sisa"
                      readonly
                    />
                    <input
                      type="text"
                      class="form-control"
                      v-model="forms.satuan_isi"
                      readonly
                    />
                  </div>
                </div>
                <div class="col-lg-2">
                  <label for="form-control">Harga</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="forms.harga"
                    placeholder="Harga Barang"
                    :class="{ 'is-invalid': form.errors.has('harga') }"
                    @input="blurharga"
                  />
                  <small> {{ formatRupiah(forms.harga) }} </small>
                </div>
                <div class="col-lg-2">
                  <label for="form-control">Jumlah Jual</label>
                  <div class="input-group">
                    <input
                      type="text"
                      class="form-control"
                      v-model="forms.jumlah_satuan_dijual"
                      :class="{
                        'is-invalid': form.errors.has('jumlah_satuan_dijual'),
                      }"
                      @input="blurharga"
                    />
                    <input
                      type="text"
                      v-model="forms.satuan_jual"
                      class="form-control"
                      readonly
                    />
                  </div>
                </div>
                <div class="col-lg-2">
                  <label for="form-control">Jumlah Satuan</label>
                  <div class="input-group">
                    <input
                      type="text"
                      class="form-control"
                      v-model="forms.jumlah_satuan_isi"
                      :class="{
                        'is-invalid': form.errors.has('jumlah_satuan_isi'),
                      }"
                      @input="blurharga"
                    />
                    <input
                      type="text"
                      class="form-control"
                      v-model="forms.satuan_isi"
                      readonly
                    />
                  </div>
                </div>
                <div class="col-lg-2">
                  <label for="form-control">Total Stock Dijual</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="forms.total_satuan_jual"
                    readonly
                    placeholder="Total Stock Dijual"
                  />
                </div>
                <div class="col-lg-2">
                  <label for="form-control">Total Bayar</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="forms.harga_akhir"
                    readonly
                    placeholder="Total Bayar"
                  />
                  <small> {{ formatRupiah(forms.harga_akhir) }} </small>
                </div>
                <!-- {{ totalbayars() }} -->
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
            <button class="btn btn-primary" @click="simpanReturn">
              <i class="bx bx-save"></i>Simpan
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal edit -->

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
                      <!-- <div class="row contacts">
                        <div class="col invoice-to">
                          <div class="text-gray-light">Dari</div>
                          <h3 class="to">KurniaMakmur</h3>
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
                          <h3 class="to">{{ item.nama }}</h3>
                          <div class="address">
                            {{ item.alamat }}
                          </div>
                        </div>
                      </div> -->
                      <div class="row contacts mb-4">
                        <div class="col-lg-8">
                          <div class="text-gray-light">Dari</div>
                          <h2 class="font-weight-bold">KurniaMakmur</h2>
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
                        <div class="col-lg-4">
                          <div class="text-gray-light">Kepada</div>
                          <h2 class="font-weight-bold">{{ item.nama }}</h2>
                          <div class="address">
                            {{ item.alamat }}
                          </div>
                        </div>
                      </div>
                      <table>
                        <thead>
                          <tr>
                            <th>SATUAN</th>
                            <th>QTY</th>
                            <th>TOTAL QTY</th>
                            <th>PRODUK</th>
                            <th>HARGA/ITEM</th>
                            <th>TOTAL HARGA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(items, index) in gols" :key="index">
                            <td>
                              {{ items.jumlah_satuan_isi }}
                              {{ items.satuan_isi }}
                            </td>
                            <td>
                              {{ items.jumlah_satuan_dijual }}
                              {{ items.satuan_isi }}
                            </td>
                            <td>
                              {{ items.total_satuan_jual }}
                              {{ items.satuan_jual }}
                            </td>
                            <td>{{ items.produk }}</td>
                            <td>
                              {{
                                new Intl.NumberFormat("id-ID", {
                                  style: "currency",
                                  currency: "IDR",
                                }).format(items.harga * 1000)
                              }}
                            </td>
                            <td>
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
                            <td colspan="3">SUBTOTAL</td>
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
                            <td colspan="3">DISKON ({{ item.diskon }})%</td>
                            <td>
                              {{ hasildiskon }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="3">PPN ({{ item.ppn }})%</td>
                            <td>{{ hasilppn }}</td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="3">BIAYA KIRIM</td>
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
                            <td colspan="3" class="text-dark">TOTAL</td>
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

    <!-- Modal -->
    <div
      class="modal fade"
      id="openmodal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ this.text }}</h5>
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
              <main>
                <div v-for="(item, index) in details" :key="index">
                  <div class="row contacts mb-2">
                    <div class="col invoice-to">
                      <div class="text-gray-light">Dari</div>
                      <h3 class="to">KurniaMakmur</h3>
                      <div class="address">
                        <div>455 Foggy Heights, AZ 85004, US</div>
                        <div>(123) 456-789</div>
                        <div>company@example.com</div>
                        <div>No. Invoice : {{ item.nomor_invoice }}</div>
                        <div>No. Faktur Pajak : {{ item.faktur_pajak }}</div>
                        <div>No. PO : {{ item.nomor_po }}</div>
                        <div>Jatuh Tempo: {{ item.jatuh_tempo }}</div>
                      </div>
                    </div>
                    <div class="col invoice-details">
                      <div class="text-gray-light">Kepada</div>
                      <h3 class="to">{{ item.nama }}</h3>
                      <div class="address">
                        {{ item.alamat }}
                      </div>
                    </div>
                  </div>
                  <table class="table table-bordered table-responsive">
                    <tr>
                      <th width="5%" class="text-center">SATUAN</th>
                      <th width="5%" class="text-center">QTY</th>
                      <th width="11%" class="text-center">TOTAL QTY</th>
                      <th class="text-center">PRODUK</th>
                    </tr>
                    <tbody>
                      <tr v-for="(items, index) in gols" :key="index">
                        <td class="text-center">
                          {{ items.jumlah_satuan_isi }}
                          {{ items.satuan_isi }}
                        </td>
                        <td class="text-center">
                          {{ items.jumlah_satuan_dijual }}
                          {{ items.satuan_isi }}
                        </td>
                        <td class="text-center">
                          {{ items.total_satuan_jual }}
                          {{ items.satuan_jual }}
                        </td>
                        <td class="text-center">{{ items.produk }}</td>
                      </tr>
                    </tbody>
                  </table>

                  <div class="row mt-3">
                    <div class="col-lg-6">
                      <div class="text-gray-light">Tanda Terima</div>
                      <br />
                      <div class="font-weight-bold">
                        {{ item.nama }}
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="text-gray-light text-center">Hormat Kami</div>
                      <br />
                      <multiselect
                        v-model="form.driver"
                        label="driver"
                        track-by="driver"
                        :options="drivers"
                        :searchable="true"
                        :close-on-select="false"
                        :show-labels="true"
                        :preselect-first="true"
                        :preserve-search="true"
                        :class="{ 'is-invalid': form.errors.has('driver') }"
                      >
                      </multiselect>
                    </div>
                    <div class="col-lg-2">
                      <label for="form-control"></label>
                      <br />
                      <br />
                      <button
                        type="submit"
                        class="btn btn-primary btn-sm"
                        @click="updatehormatkami"
                      >
                        <i class="bx bx-save"></i>
                        Save
                      </button>
                    </div>
                  </div>
                </div>
              </main>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              v-on:click="cetaksuratjalan"
            >
              <i class="bx bx-printer"></i>
              Print
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal -->

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
          ref="html2Pdfi"
        >
          <section slot="pdf-content">
            <div id="invoice">
              <div class="invoice overflow-auto">
                <div>
                  <main>
                    <div v-for="(item, index) in details" :key="index">
                      <div class="row mb-4" style="font-size: small">
                        <div class="col-lg-8">
                          <div class="text-gray-light">Dari</div>
                          <h2 class="font-weight-bold">KurniaMakmur</h2>
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
                        <div class="col-lg-4">
                          <div class="text-gray-light">Kepada</div>
                          <h2 class="font-weight-bold">{{ item.nama }}</h2>
                          <div class="address">
                            {{ item.alamat }}
                          </div>
                        </div>
                      </div>
                      <table style="font-size: x-small">
                        <thead>
                          <tr>
                            <th>SATUAN</th>
                            <th>QTY</th>
                            <th>TOTAL QTY</th>
                            <th>PRODUK</th>
                            <th>HARGA/ITEM</th>
                            <th>TOTAL HARGA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(items, index) in gols" :key="index">
                            <td>
                              {{ items.jumlah_satuan_isi }}
                              {{ items.satuan_isi }}
                            </td>
                            <td>
                              {{ items.jumlah_satuan_dijual }}
                              {{ items.satuan_isi }}
                            </td>
                            <td>
                              {{ items.total_satuan_jual }}
                              {{ items.satuan_jual }}
                            </td>
                            <td>{{ items.produk }}</td>
                            <td>
                              {{
                                new Intl.NumberFormat("id-ID", {
                                  style: "currency",
                                  currency: "IDR",
                                }).format(items.harga * 1000)
                              }}
                            </td>
                            <td>
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
                            <td colspan="3">SUBTOTAL</td>
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
                            <td colspan="3">DISKON ({{ item.diskon }})%</td>
                            <td>
                              {{ hasildiskon }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="3">PPN ({{ item.ppn }})%</td>
                            <td>{{ hasilppn }}</td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="3">BIAYA KIRIM</td>
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
                            <td colspan="3" class="text-dark">TOTAL</td>
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

    <!-- print surat jalan -->
    <template>
      <div>
        <vue-html2pdf
          :show-layout="false"
          :enable-download="true"
          :float-layout="true"
          :preview-modal="true"
          :paginate-elements-by-height="1100"
          filename="Surat Jalan"
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
            <div class="invoice overflow-auto">
              <main>
                <div v-for="(item, index) in details" :key="index">
                  <div class="row mb-4">
                    <div class="col-lg-8">
                      <div class="text-gray-light">Dari</div>
                      <h2 class="font-weight-bold">KurniaMakmur</h2>
                      <div class="address">
                        <div>455 Foggy Heights, AZ 85004, US</div>
                        <div>(123) 456-789</div>
                        <div>company@example.com</div>
                        <div>No. Invoice : {{ item.nomor_invoice }}</div>
                        <div>No. Faktur Pajak : {{ item.faktur_pajak }}</div>
                        <div>No. PO : {{ item.nomor_po }}</div>
                        <div>Jatuh Tempo: {{ item.jatuh_tempo }}</div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="text-gray-light">Kepada</div>
                      <h2 class="font-weight-bold">{{ item.nama }}</h2>
                      <div class="address">
                        {{ item.alamat }}
                      </div>
                    </div>
                  </div>
                  <table class="table table-bordered">
                    <tr>
                      <th width="5%" class="text-center">SATUAN</th>
                      <th width="10%" class="text-center">QTY</th>
                      <th width="11%" class="text-center">TOTAL QTY</th>
                      <th class="text-center">PRODUK</th>
                    </tr>
                    <tbody>
                      <tr v-for="(items, index) in gols" :key="index">
                        <td class="text-center">
                          {{ items.jumlah_satuan_isi }}
                          {{ items.satuan_isi }}
                        </td>
                        <td class="text-center">
                          {{ items.jumlah_satuan_dijual }}
                          {{ items.satuan_isi }}
                        </td>
                        <td class="text-center">
                          {{ items.total_satuan_jual }}
                          {{ items.satuan_jual }}
                        </td>
                        <td class="text-center">{{ items.produk }}</td>
                      </tr>
                    </tbody>
                  </table>

                  <div class="row mt-3">
                    <div class="col-lg-6 text-left">
                      <div class="text-gray-light">Tanda Terima</div>
                      <br />
                      <br />
                      <div class="font-weight-bold">
                        {{ item.nama }}
                      </div>
                    </div>
                    <div class="col-lg-6 text-right">
                      <div class="text-gray-light">Hormat Kami</div>
                      <br />
                      <br />
                      <div class="font-weight-bold">
                        {{ item.driver }}
                      </div>
                    </div>
                  </div>
                </div>
              </main>
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
      dataReturn: [],
      all_select: false,
      deleteItems: [],
      // Save input for modal form
      formDataReturn: new Form({
        uuid: "",
        tgl_sale: "",
        nomor_invoice: "",
        nomor_po: "",
        nomor_surat_jalan: "",
        faktur_pajak: "",
        nama: "",
        gudang: "",
        total_satuan_jual: "",
        harga_akhir: "",
        namaBarang: "",
        satuan_jual: "",
      }),
      hasildiskon: "",
      nilaidiskon: "",
      hasilppn: "",
      total: "",
      totaldefault: "",
      terbilangs: "",
      sales: {},
      details: {},
      gols: {},
      dataDetail: [],
      drivers: [],
      driver_id: "",
      text: "Print Surat Jalan",
      PT: "",
      form: new Form({
        driver: "",
        nomor_invoice: "",
        uuidInvJual: "",
        uuidSale: "",
        uuidBarang: "",
        uuidDriver: "",
        uuidPelanggan: "",
        namaBarang: "",
        sisa: "",
        satuan_isi: "",
        harga: "",
        jumlah_satuan_dijual: "",
        satuan_jual: "",
        jumlah_satuan_isi: "",
        satuan_isi: "",
        harga_akhir: "",
        total_satuan_jual: "",
        total_satuan_juals: "",
        total: "",
        tgl_sale: "",
        jatuh_tempo: "",
        nomor_invoice: "",
        nomor_po: "",
        nomor_surat_jalan: "",
        biaya_kirim: "",
        diskon: "",
        ppn: "",
        faktur_pajak: "",
      }),
    };
  },
  methods: {
    cancelOrder(uuid) {
      Swal.fire({
        title: "Batal Pesanan?",
        // text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oke!",
      }).then((result) => {
        if (result.value) {
          axios
            .post(`api/cancel-order/` + uuid)
            .then(() => {
              Fire.$emit("reloadUsers");
              Swal.fire("Batal!", "Batal Pesanan Berhasil", "success");
            })
            .catch(() => {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Ada Yang Salah!",
                // footer: "<a href>Why do I have this issue?</a>",
              });
            });
        }
      });
    },
    noUrut(index) {
      return index;
    },
    nameWithLang({ namaPelanggan, nama }) {
      return `${namaPelanggan} | [${nama}]`;
    },
    getDataReturn() {
      // axios.get("api/getAllDataSale").then((res) => {
      //   this.dataReturn = res.data.data;
      // });
    },
    showModalDataReturn() {
      this.getDataReturn();
      $("#modalDataReturn").modal("show");
    },
    closeModalDataReturn() {
      $("#modalDataReturn").modal("show");
    },
    detailDataReturn(
      tgl_sale,
      nomor_invoice,
      nomor_po,
      nomor_surat_jalan,
      faktur_pajak,
      nama,
      gudang,
      total_satuan_jual,
      harga_akhir,
      namaBarang,
      satuan_jual
    ) {
      this.showModal();
      this.form.tgl_sale = tgl_sale;
      this.form.nomor_invoice = nomor_invoice;
      this.form.nomor_po = nomor_po;
      this.form.nomor_surat_jalan = nomor_surat_jalan;
      this.form.faktur_pajak = faktur_pajak;
      this.form.nama = nama;
      this.form.gudang = gudang;
      this.form.total_satuan_jual = total_satuan_jual;
      this.form.harga_akhir = harga_akhir;
      this.form.namaBarang = namaBarang;
      this.form.satuan_jual = satuan_jual;
    },
    // Load data pada tabel with axios
    loadUsers() {
      axios.get("api/sale").then((res) => {
        $("#example").DataTable().destroy();
        this.sales = res.data;
        setTimeout(function () {
          $("#example").DataTable();
        }, 1000);
      });
      axios.get("api/data-return").then((res) => {
        $("#tabelReturn").DataTable().destroy();
        this.dataReturn = res.data;
        setTimeout(function () {
          $("#tabelReturn").DataTable();
        }, 1000);
      });
    },
    totalbayars() {
      var harga = this.form.hargas;
      var jumlahsatuan = this.form.jumlah_satuan_dijual;
      var totalbayar = harga * jumlahsatuan;
      var jumlahjual = this.form.jumlah_satuan_dijual;
      var satuan_jual = this.form.jumlah_satuan_isi;
      var totalstockterjual = satuan_jual * jumlahjual;
      this.form.total_satuan_jual = totalstockterjual;
      this.form.harga_akhir = this.formatRupiah(totalbayar);
    },
    // Hitung total bayar
    totalbayar() {
      if (this.dataDetail.length > 0) {
        this.dataDetail.forEach((element) => {
          element.total_satuan_jual =
            element.jumlah_satuan_dijual * element.jumlah_satuan_isi;
          element.harga_akhir = element.harga * element.jumlah_satuan_dijual;
        });
      }
    },
    clickharga() {
      this.form.harga = this.form.hargas;
    },
    blurharga() {
      this.totalbayar();
    },
    simpanReturn() {
      var dataArray = [];
      if (this.dataDetail.length) {
        this.dataDetail.forEach((element) => {
          var namaBarang = element.namaBarang;
          var hargaBarang = element.harga / 1000;
          var totalSatuanJualS = element.total_satuan_juals;
          var totalSatuanJual = element.jumlah_satuan_dijual;
          var satuanJual = element.satuan_jual;
          var hargaAkhir = element.harga_akhir / 1000;
          var x = {
            nama: namaBarang,
            harga: hargaBarang,
            total_satuan_jual: totalSatuanJual,
            total_satuan_juals: totalSatuanJualS,
            satuan_jual: satuanJual,
            harga_akhir: hargaAkhir,
          };
          dataArray.push(x);
        });
      }
      var dataForm = this.dataDetail;
      this.closeEditModal();
      this.$router.push({
        name: "checkout-invoice",
        params: {
          dataInvoiceJual: dataArray,
          dataReturn: dataForm,
        },
      });
    },
    showEditModal() {
      $("#modalEdit").modal("show");
    },
    closeEditModal() {
      $("#modalEdit").modal("hide");
    },
    edit(uuid) {
      this.showEditModal();
      this.dataDetail = null;
      axios.get("api/sale", { params: { uuid: uuid } }).then((res) => {
        this.dataDetail = res.data;
        this.dataDetail.forEach((element) => {
          element.harga = element.harga * 1000;
          element.harga_akhir = element.harga_akhir * 1000;
          element.qty_lama = element.total_satuan_jual;
          element.jumlah_satuan_dijual_lama = element.jumlah_satuan_dijual;
          element.jumlah_satuan_isi_lama = element.jumlah_satuan_isi;
        });
        // this.form.uuidInvJual = res.data.uuidInvJual;
        // this.form.uuidSale = res.data.uuidSale;
        // this.form.uuidBarang = res.data.barang_id;
        // this.form.namaBarang = res.data.namaBarang;
        // this.form.sisa = res.data.sisa;
        // this.form.satuan_isi = res.data.satuan_isi;
        // this.form.jumlah_satuan_isi = res.data.jumlah_satuan_isi;
        // this.form.harga = res.data.harga * 1000;
        // this.form.jumlah_satuan_dijual = res.data.jumlah_satuan_dijual;
        // this.form.satuan_jual = res.data.satuan_jual;
        // this.form.jumlah_satuan_isi = res.data.jumlah_satuan_isi;
        // this.form.satuan_isi = res.data.satuan_isi;
        // this.form.harga_akhir = res.data.harga_akhir * 1000;
        // this.form.total_satuan_jual = res.data.total_satuan_jual;
        // this.form.total_satuan_juals = res.data.total_satuan_jual;
        // this.form.uuidDriver = res.data.driver_id;
        // this.form.uuidPelanggan = res.data.pelanggan_id;
        // this.form.tgl_sale = res.data.tgl_sale;
        // this.form.jatuh_tempo = res.data.jatuh_tempo;
        // this.form.nomor_invoice = res.data.nomor_invoice;
        // this.form.nomor_po = res.data.nomor_po;
        // this.form.nomor_surat_jalan = res.data.nomor_surat_jalan;
        // this.form.biaya_kirim = res.data.biaya_kirim * 1000;
        // this.form.diskon = res.data.diskon;
        // this.form.ppn = res.data.ppn;
        // this.form.faktur_pajak = res.data.faktur_pajak;
        // this.form.total = res.data.total * 1000;
        // this.form.biaya_kirim = res.data.biaya_kirim * 1000;
        // this.form.diskon = res.data.diskon;
        // this.form.pph = res.data.pph;
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
    },
    cetak: function (event) {
      this.printinvoice(event);
      $("#modelId").modal("hide");
    },
    printinvoice() {
      this.$refs.html2Pdfi.generatePdf();
    },
    cetaksuratjalan: function (event) {
      this.printsuratjalan(event);
      $("#openmodal").modal("hide");
    },
    printsuratjalan() {
      this.$refs.html2Pdf.generatePdf();
    },

    suratjalan(nomor_invoice, driver_id, nama) {
      $("#openmodal").modal("show");
      this.text;
      this.PT = nama;
      this.form.nomor_invoice = nomor_invoice;
      this.driver_id = driver_id;
      axios.get("api/detail/" + nomor_invoice).then(({ data }) => {
        this.gols = data;
      });
      axios.get("api/test/" + nomor_invoice).then(({ data }) => {
        this.details = data;
      });

      axios
        .get("api/drivers", {
          params: { driver_id: this.driver_id },
        })
        .then((res) => {
          this.drivers = res.data;
          this.form.driver = res.data;
        });
      axios.get("api/driver").then((res) => {
        this.drivers = res.data;
        // this.form.driver = res.data;
      });
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
    updatekirim(nomor_invoice, status_pengiriman) {
      axios
        .post("/api/kirim/" + nomor_invoice, {
          status_pengiriman: status_pengiriman,
        })
        .then(() => {
          Fire.$emit("reloadUsers");
          // $("#merchantssModal").modal("hide");
          Swal.fire({ icon: "success", title: "Barang Telah Dikirim" });
          this.loading = false;
          this.disabled = false;
        })
        .catch(() => {
          Swal.fire({ icon: "error", title: "Data Gagal Tersimpan" });
          this.loading = false;
          this.disabled = false;
        });
    },

    updatehormatkami() {
      this.form
        .put("api/updatehormatkami/" + this.form.nomor_invoice)
        .then(() => {
          Fire.$emit("reloadUsers");
          // $("#exampleModal").modal("hide");
          Swal.fire({ icon: "success", title: "Data Berhasil Di Update" });
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
