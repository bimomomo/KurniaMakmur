<template>
	<div>
		<div class="card">
			<div class="card-header">
				<button class="btn btn-primary btn-sm" @click="form.reset();" data-toggle="modal" data-target="#metodebayarInputModal"><i class="bx bx-plus"></i>Tambah</button>
			</div>
			<div class="card-body">
				<div class="col-lg-12 table-responsive">
					<table id="tableMetodeBayarDataAll" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>Rekening</th>
								<th>Atas Nama</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(u,i) in metodebayar" :key="u.uuid">
								<td>{{i+1}}</td>
								<td>{{u.nama_bank}} - ({{u.nomor_rekening}})</td>
								<td>{{u.atas_nama}}</td>
								<td>
									<button type="button" class="btn btn-sm btn-danger" @click="deletedata(u.uuid)"><i class="bx bx-trash"></i></button>
									<button type="button" class="btn btn-sm btn-warning" @click="seteditvalue(u)" data-toggle="modal" data-target="#metodebayarEditModal"><i class="bx bx-edit"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<!-- User Input Modal -->
		<div class="modal fade" id="metodebayarInputModal" tabindex="-1" role="dialog" aria-labelledby="metodebayarInputModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="simpandata()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="metodebayarInputModalLabel">Simpan</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div>
								<div class="form-group">
									<label for="txtINamaBank">Nama Bank</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.nama_bank" id="txtINamaBank" required>
								</div>
								<div class="form-group">
									<label for="txtINomorRekening">Nomor Rekening</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.nomor_rekening" id="txtINomorRekening" required>
								</div>
								<div class="form-group">
									<label for="txtIAtasNama">Atas Nama</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.atas_nama" id="txtIAtasNama" required>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<!-- User Edit Modal -->
		<div class="modal fade" id="metodebayarEditModal" tabindex="-1" role="dialog" aria-labelledby="metodebayarEditModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<form @submit.prevent="editdata()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="metodebayarEditModalLabel">Edit User</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div>
								<div class="form-group">
									<label for="txtINamaBank">Nama Bank</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.nama_bank" id="txtINamaBank" required>
								</div>
								<div class="form-group">
									<label for="txtINomorRekening">Nomor Rekening</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.nomor_rekening" id="txtINomorRekening" required>
								</div>
								<div class="form-group">
									<label for="txtIAtasNama">Atas Nama</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.atas_nama" id="txtIAtasNama" required>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</div>
				</form>
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
	created(){
		this.loadData();
	},
	data(){return{
		metodebayar:[],
		form: new Form({
			uuid:null,
			nama_bank:null,
			nomor_rekening:null,
			atas_nama:null,
		}),
	}},
	methods:{
		loadData(){
			$("#tableMetodeBayarDataAll").DataTable().destroy();
			$('.modal').modal('hide');
			axios.get('/api/metodebayar').then(({data})=>{
				this.form.reset();
				this.avatarPreview = null;
				this.metodebayar = data;
				setTimeout(function () {
				$("#tableMetodeBayarDataAll").DataTable();
				}, 1000);
			});
		},
		seteditvalue(d){
			this.form.reset();
			this.form.uuid = d.uuid;
			this.form.nama_bank = d.nama_bank;
			this.form.nomor_rekening = d.nomor_rekening;
			this.form.atas_nama = d.atas_nama;
		},
		simpandata(){
			this.form.post('/api/metodebayar').then(({data})=>{
				Swal.fire(data);
				this.loadData();
			})
		},
		editdata(){
			this.form._method = "PUT";
			this.form.post('/api/metodebayar/'+this.form.uuid).then(({data})=>{
				Swal.fire(data);
				this.loadData();
			})
		},
		deletedata(id){
			Swal.fire({
				title: "Apakah anda yakin?",
				text: "Data yang dihapus tidak bisa dikembalikan!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya, Hapus!",
			}).then((result) => {
				if (result.value) {
					this.form.delete('/api/metodebayar/'+id).then(({data})=>{
						Swal.fire(data);
						this.loadData();
					})
				}else{
					Swal.fire('Data Batal Dihapus');
				}
			});
		},
	},
}
</script>