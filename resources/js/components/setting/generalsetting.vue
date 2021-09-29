<template>
	<div>
		<div class="card">
			<div class="card-header">
				<button class="btn btn-primary btn-sm" @click="form.reset();logoPreview=null;" data-toggle="modal" data-target="#metodebayarInputModal"><i class="bx bx-plus"></i>Tambah</button>
			</div>
			<div class="card-body">
				<div class="col-lg-12 table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="5%">Aktif</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(u,i) in generalsetting" :key="u.uuid">
								<td style="vertical-align:middle;">
									<i v-if="u.active==1" class="bx bx-sm bx-check-circle text-success"></i>
									<i v-else class="bx bx-sm bx-x-circle text-warning" style="cursor:pointer;" @click="activateGenset(u.uuid)"></i>
									{{i+1}}
								</td>
								<td>{{u.nama}} - ({{u.nama_pendek}})</td>
								<td>{{u.alamat}}</td>
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
								<img v-if="logoPreview" :src="logoPreview" alt="LOGO" style="width:150px;height:150px;">
								<div class="form-group">
									<label for="txtILogo">Logo</label>
									<input class="form-control" autocomplete="off" type="file" @change="logofilechanged" id="txtILogo" required>
								</div>
								<div class="form-group">
									<label for="txtINama">Nama</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.nama" id="txtINama" required>
									<label for="txtINamaPendek">Nama Pendek</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.nama_pendek" id="txtINamaPendek" required>
								</div>
								<div class="form-group">
									<label for="txtIAlamat">Alamat</label>
									<textarea class="form-control" autocomplete="off" v-model="form.alamat " id="txtIAlamat"></textarea>
								</div>
								<div class="form-group">
									<label for="txtINoTelp">No Telp</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.no_telp" id="txtINoTelp">
								</div>
								<div class="form-group">
									<label for="txtITagLine">Tag Line</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.tag_line" id="txtITagLine">
								</div>
								<div class="form-group">
									<label for="txtISignature">Signature</label>
									<textarea class="form-control" autocomplete="off" v-model="form.signature" id="txtISignature"></textarea>
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
			<div class="modal-dialog" role="document">
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
								<img v-if="logoPreview" :src="logoPreview" alt="LOGO" style="width:150px;height:150px;">
								<div class="form-group">
									<label for="txtILogo">Logo</label>
									<input class="form-control" autocomplete="off" @change="logofilechanged" type="file" id="txtILogo" required>
								</div>
								<div class="form-group">
									<label for="txtINama">Nama</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.nama" id="txtINama" required>
									<label for="txtINamaPendek">Nama Pendek</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.nama_pendek" id="txtINamaPendek" required>
								</div>
								<div class="form-group">
									<label for="txtIAlamat">Alamat</label>
									<textarea class="form-control" autocomplete="off" v-model="form.alamat " id="txtIAlamat"></textarea>
								</div>
								<div class="form-group">
									<label for="txtINoTelp">No Telp</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.no_telp" id="txtINoTelp">
								</div>
								<div class="form-group">
									<label for="txtITagLine">Tag Line</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.tag_line" id="txtITagLine">
								</div>
								<div class="form-group">
									<label for="txtISignature">Signature</label>
									<textarea class="form-control" autocomplete="off" v-model="form.signature" id="txtISignature"></textarea>
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
		activeGensetRadio:null,
		logoPreview:null,
		generalsetting:[],
		form: new Form({
			uuid:null,
			logo:null,
			nama: null,
			nama_pendek: null,
			alamat: null,
			no_telp: null,
			tag_line: null,
			signature: null,
		}),
	}},
	watch:{
		
	},
	methods:{
		loadData(){
			$('.modal').modal('hide');
			axios.get('/api/generalsetting').then(({data})=>{
				this.form.reset();
				this.logoPreview = null;
				this.generalsetting = data;
			});
		},
		seteditvalue(d){
			this.form.reset();
			this.form.uuid = d.uuid;
			this.form.nama = d.nama
			this.form.nama_pendek = d.nama_pendek
			this.form.alamat = d.alamat
			this.form.no_telp = d.no_telp
			this.form.tag_line = d.tag_line
			this.form.signature = d.signature
			this.logoPreview = d.logo;
		},
		simpandata(){
			this.form.post('/api/generalsetting').then(({data})=>{
				Swal.fire(data);
				this.loadData();
			})
		},
		editdata(){
			this.form._method = "PUT";
			this.form.post('/api/generalsetting/'+this.form.uuid).then(({data})=>{
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
					this.form.delete('/api/generalsetting/'+id).then(({data})=>{
						Swal.fire(data);
						this.loadData();
					})
				}else{
					Swal.fire('Data Batal Dihapus');
				}
			});
		},
		logofilechanged(event){
			this.form.logo = event.target.files[0];
			this.logoPreview = URL.createObjectURL(event.target.files[0]);
		},
		activateGenset(id){
			axios.post('/api/generalsettingsetactive/'+id).then(({data})=>{
				this.loadData();
			})
		},
	},
}
</script>