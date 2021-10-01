<template>
	<div>
		<div class="card">
			<div class="card-header">
				<button class="btn btn-primary btn-sm" @click="form.reset();avatarPreview=null;" data-toggle="modal" data-target="#userInputModal"><i class="bx bx-plus"></i>Tambah</button>
			</div>
			<div class="card-body">
				<div class="col-lg-12 table-responsive">
					<table id="tableUserDataAll" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(u,i) in user" :key="u.uuid">
								<td>{{i+1}}</td>
								<td>{{u.name}}</td>
								<td>{{u.email}}</td>
								<td>
									<button type="button" class="btn btn-sm btn-danger" @click="deletedata(u.uuid)"><i class="bx bx-trash"></i></button>
									<button type="button" class="btn btn-sm btn-warning" @click="seteditvalue(u)" data-toggle="modal" data-target="#userEditModal"><i class="bx bx-edit"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<!-- User Input Modal -->
		<div class="modal fade" id="userInputModal" tabindex="-1" role="dialog" aria-labelledby="userInputModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<form @submit.prevent="simpandata()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="userEditModalLabel">Simpan</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-6">
									<label for="txtIName">Name</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.name" id="txtIName">
								</div>
								<div class="col-lg-6">
									<label for="txtIEmail">Email</label>
									<input class="form-control" autocomplete="off" type="email" v-model="form.email" id="txtIEmail">
								</div>
								<div class="col-lg-6">
									<label for="txtIPassword">Password</label>
									<input class="form-control" autocomplete="off" type="password" v-model="form.password" id="txtIPassword">
								</div>
								<div class="col-lg-6">
									<label for="txtIHakAkses">Hak Akses</label>
									<select class="form-control" v-model="form.hak_akses_id" id="txtIHakAkses" required>
										<option value="" selected disabled>Hak Akses</option>
										<option v-for="h in hakakses" :key="h.uuid" :value="h.uuid">{{h.nama}}</option>
									</select>
								</div>
								<div class="col-lg-3">
									<label for="txtIAvatar">Avatar</label>
									<input accept="image/*" class="form-control" autocomplete="off" type="file" @change="avatarChanged" id="txtIAvatar">
									<span class="text-warning">Kosongi apabila tidak mengganti avatar</span>
								</div>
							</div>
							<div>
								<img :src="avatarPreview" alt="AVATAR" style="width:150px;height150px;">
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
		<div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<form @submit.prevent="editdata()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="userEditModalLabel">Edit</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-6">
									<label for="txtIName">Name</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.name" id="txtIName">
								</div>
								<div class="col-lg-6">
									<label for="txtIEmail">Email</label>
									<input class="form-control" autocomplete="off" type="email" v-model="form.email" id="txtIEmail">
								</div>
								<div class="col-lg-6">
									<label for="txtIPassword">Password</label>
									<input class="form-control" autocomplete="off" type="password" v-model="form.password" id="txtIPassword">
									<span class="text-warning">Kosongi apabila tidak mengganti password</span>
								</div>
								<div class="col-lg-6">
									<label for="txtIHakAkses">Hak Akses</label>
									<select class="form-control" v-model="form.hak_akses_id" id="txtIHakAkses" required>
										<option value="" selected disabled>Hak Akses</option>
										<option v-for="h in hakakses" :key="h.uuid" :value="h.uuid">{{h.nama}}</option>
									</select>
								</div>
								<div class="col-lg-3">
									<label for="txtIAvatar">Avatar</label>
									<input accept="image/*" class="form-control" autocomplete="off" type="file" @change="avatarChanged" id="txtIAvatar">
									<span class="text-warning">Kosongi apabila tidak mengganti avatar</span>
								</div>
							</div>
							<div>
								<img v-if="avatarPreview" :src="avatarPreview" alt="AVATAR" style="width:150px;height:150px;">
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
		user:[],
		hakakses:[],
		form: new Form({
			uuid:null,
			name:null,
			email:null,
			avatar:null,
			password:null,
			hak_akses_id:null,
		}),
		avatarPreview: null,
	}},
	methods:{
		loadData(){
        	$("#tableUserDataAll").DataTable().destroy();
			$('.modal').modal('hide');
			axios.get('/api/user').then(({data})=>{
				this.form.reset();
				this.avatarPreview = null;
				this.user = data;
				setTimeout(function () {
				$("#tableUserDataAll").DataTable();
				}, 1000);
			});
			axios.get('/api/hakakses').then(({data})=>{
				this.hakakses = data;
			});
		},
		seteditvalue(d){
			this.form.reset();
			this.form.uuid = d.uuid;
			this.form.name = d.name;
			this.form.email = d.email;
			this.form.hak_akses_id = d.hak_akses_id;
			this.avatarPreview = d.avatar;
		},
		simpandata(){
			this.form.post('/api/user').then(({data})=>{
				Swal.fire(data);
				this.loadData();
			})
		},
		editdata(){
			this.form._method = "PUT";
			this.form.post('/api/user/'+this.form.uuid).then(({data})=>{
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
					this.form.delete('/api/user/'+id).then(({data})=>{
						Swal.fire(data);
						this.loadData();
					})
				}else{
					Swal.fire('Data Batal Dihapus');
				}
			});
		},
		avatarChanged(event) {
			this.form.avatar = event.target.files[0];
			this.avatarPreview = URL.createObjectURL(event.target.files[0]);
		},
	},
}
</script>