<template>
	<div>
		<div class="card">
			<div class="card-header">
				<button class="btn btn-primary btn-sm" @click="form.reset();" data-toggle="modal" data-target="#pengumumanInputModal"><i class="bx bx-plus"></i>Tambah</button>
			</div>
			<div class="card-body">
				<div class="col-lg-12 table-responsive">
					<table id="tablePengumumanDataAll" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>Pengumuman</th>
								<th>Aktif Hingga</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(u,i) in pengumuman" :key="u.uuid">
								<td>{{i+1}}</td>
								<td>{{u.pengumuman}}</td>
								<td>{{u.aktif_hingga}}</td>
								<td>
									<button type="button" class="btn btn-sm btn-danger" @click="deletedata(u.uuid)"><i class="bx bx-trash"></i></button>
									<button type="button" class="btn btn-sm btn-warning" @click="seteditvalue(u)" data-toggle="modal" data-target="#pengumumanEditModal"><i class="bx bx-edit"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<!-- User Input Modal -->
		<div class="modal fade" id="pengumumanInputModal" tabindex="-1" role="dialog" aria-labelledby="pengumumanInputModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="simpandata()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="pengumumanEditModalLabel">Simpan</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div>
								<div class="form-group">
									<label for="txtIPengumuman">Pengumuman</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.pengumuman" id="txtIPengumuman" required>
								</div>
								<div class="form-group">
									<label for="txtIType">Type</label>
									<select class="form-control" v-model="form.type" id="txtIType" required>
										<option value="0">Info</option>
										<option value="1">Peringatan</option>
										<option value="2">Bahaya</option>
									</select>
									<span v-if="form.type==0" class="text-info"><i class="bx bx-info-circle"></i></span>
									<span v-if="form.type==1" class="text-warning"><i class="bx bx-error-circle"></i></span>
									<span v-if="form.type==2" class="text-danger"><i class="bx bx-x-circle"></i></span>
								</div>
								<div class="form-group">
									<label for="txtIAktifHingga">Aktif Hingga</label>
									<input class="form-control" autocomplete="off" type="date" v-model="form.aktif_hingga" id="txtIAktifHingga" required>
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
		<div class="modal fade" id="pengumumanEditModal" tabindex="-1" role="dialog" aria-labelledby="pengumumanEditModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<form @submit.prevent="editdata()" @keydown="form.onKeydown($event)">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="pengumumanEditModalLabel">Edit</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div>
								<div class="form-group">
									<label for="txtIPengumuman">Pengumuman</label>
									<input class="form-control" autocomplete="off" type="text" v-model="form.pengumuman" id="txtIPengumuman" required>
								</div>
								<div class="form-group">
									<label for="txtIType">Type</label>
									<select class="form-control" v-model="form.type" id="txtIType" required>
										<option value="0">Info</option>
										<option value="1">Peringatan</option>
										<option value="2">Bahaya</option>
									</select>
									<span v-if="form.type==0" class="text-info"><i class="bx bx-info-circle"></i></span>
									<span v-if="form.type==1" class="text-warning"><i class="bx bx-error-circle"></i></span>
									<span v-if="form.type==2" class="text-danger"><i class="bx bx-x-circle"></i></span>
								</div>
								<div class="form-group">
									<label for="txtIAktifHingga">Aktif Hingga</label>
									<input class="form-control" autocomplete="off" type="date" v-model="form.aktif_hingga" id="txtIAktifHingga" required>
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
		pengumuman:[],
		form: new Form({
			uuid:null,
			pengumuman:null,
			type:null,
			aktif_hingga:null,
		}),
	}},
	methods:{
		loadData(){
			$("#tablePengumumanDataAll").DataTable().destroy();
			$('.modal').modal('hide');
			axios.get('/api/pengumuman').then(({data})=>{
				this.form.reset();
				this.avatarPreview = null;
				this.pengumuman = data;
				setTimeout(function () {
				$("#tablePengumumanDataAll").DataTable();
				}, 1000);
			});
		},
		seteditvalue(d){
			this.form.reset();
			this.form.uuid = d.uuid;
			this.form.pengumuman = d.pengumuman;
			this.form.type = d.type;
			this.form.aktif_hingga = d.aktif_hingga;
		},
		simpandata(){
			this.form.post('/api/pengumuman').then(({data})=>{
				Swal.fire(data);
				this.loadData();
			})
		},
		editdata(){
			this.form._method = "PUT";
			this.form.post('/api/pengumuman/'+this.form.uuid).then(({data})=>{
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
					this.form.delete('/api/pengumuman/'+id).then(({data})=>{
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