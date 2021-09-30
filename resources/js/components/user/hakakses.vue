<template>
	<div>
		<div class="card">
			<div class="card-header">
				<button class="btn btn-primary btn-sm" @click="newHakAkses=null" data-toggle="modal" data-target="#hakaksesInputModal"><i class="bx bx-plus"></i>Tambah</button>
			</div>
			<div class="card-body row">
				<div class="col-lg-6">
					<select v-model="hakAksesNow" class="form-control">
						<option value="" selected disabled>Hak Akses</option>
						<option v-for="h in hakakses" :key="h.uuid" :value="h.uuid">{{h.nama}}</option>
					</select>
				</div>
				<div class="col-lg-6">
					<button class="btn btn-primary" @click="editdata"><i class="bx bx-save bx-sm"></i> Simpan</button>
				</div>
				<div class="col-lg-12 table-responsive">
					<table class="table table-bordered" v-if="hakAksesNow">
						<tr>
							<th colspan="4"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;"><input type="checkbox" v-model="selectedModule" value="PENJUALAN"> &nbsp; PENJUALAN</label></th>
						</tr>
						<tr v-if="(selectedModule.indexOf('PENJUALAN') > -1)">
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">READ &nbsp; <input type="checkbox" v-model="slchakakses.PENJUALAN.get"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">CREATE &nbsp; <input type="checkbox" v-model="slchakakses.PENJUALAN.post"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">UPDATE &nbsp; <input type="checkbox" v-model="slchakakses.PENJUALAN.put"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">DELETE &nbsp; <input type="checkbox" v-model="slchakakses.PENJUALAN.delete"></label></td>
						</tr>
						<tr>
							<th colspan="4"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;"><input type="checkbox" v-model="selectedModule" value="MASTER"> &nbsp; MASTER</label></th>
						</tr>
						<tr v-if="(selectedModule.indexOf('MASTER') > -1)">
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">READ &nbsp; <input type="checkbox" v-model="slchakakses.MASTER.get"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">CREATE &nbsp; <input type="checkbox" v-model="slchakakses.MASTER.post"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">UPDATE &nbsp; <input type="checkbox" v-model="slchakakses.MASTER.put"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">DELETE &nbsp; <input type="checkbox" v-model="slchakakses.MASTER.delete"></label></td>
						</tr>
						<tr>
							<th colspan="4"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;"><input type="checkbox" v-model="selectedModule" value="MUTASI"> &nbsp; MUTASI</label></th>
						</tr>
						<tr v-if="(selectedModule.indexOf('MUTASI') > -1)">
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">READ &nbsp; <input type="checkbox" v-model="slchakakses.MUTASI.get"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">CREATE &nbsp; <input type="checkbox" v-model="slchakakses.MUTASI.post"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">UPDATE &nbsp; <input type="checkbox" v-model="slchakakses.MUTASI.put"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">DELETE &nbsp; <input type="checkbox" v-model="slchakakses.MUTASI.delete"></label></td>
						</tr>
						<tr>
							<th colspan="4"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;"><input type="checkbox" v-model="selectedModule" value="LAPORAN"> &nbsp; LAPORAN</label></th>
						</tr>
						<tr v-if="(selectedModule.indexOf('LAPORAN') > -1)">
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">READ &nbsp; <input type="checkbox" v-model="slchakakses.LAPORAN.get"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">CREATE &nbsp; <input type="checkbox" v-model="slchakakses.LAPORAN.post"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">UPDATE &nbsp; <input type="checkbox" v-model="slchakakses.LAPORAN.put"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">DELETE &nbsp; <input type="checkbox" v-model="slchakakses.LAPORAN.delete"></label></td>
						</tr>
						<tr>
							<th colspan="4"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;"><input type="checkbox" v-model="selectedModule" value="USER"> &nbsp; USER</label></th>
						</tr>
						<tr v-if="(selectedModule.indexOf('USER') > -1)">
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">READ &nbsp; <input type="checkbox" v-model="slchakakses.USER.get"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">CREATE &nbsp; <input type="checkbox" v-model="slchakakses.USER.post"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">UPDATE &nbsp; <input type="checkbox" v-model="slchakakses.USER.put"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">DELETE &nbsp; <input type="checkbox" v-model="slchakakses.USER.delete"></label></td>
						</tr>
						<tr>
							<th colspan="4"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;"><input type="checkbox" v-model="selectedModule" value="SETTING"> &nbsp; SETTING</label></th>
						</tr>
						<tr v-if="(selectedModule.indexOf('SETTING') > -1)">
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">READ &nbsp; <input type="checkbox" v-model="slchakakses.SETTING.get"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">CREATE &nbsp; <input type="checkbox" v-model="slchakakses.SETTING.post"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">UPDATE &nbsp; <input type="checkbox" v-model="slchakakses.SETTING.put"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">DELETE &nbsp; <input type="checkbox" v-model="slchakakses.SETTING.delete"></label></td>
						</tr>
						<tr>
							<th colspan="4"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;"><input type="checkbox" v-model="selectedModule" value="NOTE"> &nbsp; NOTE</label></th>
						</tr>
						<tr v-if="(selectedModule.indexOf('NOTE') > -1)">
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">READ &nbsp; <input type="checkbox" v-model="slchakakses.NOTE.get"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">CREATE &nbsp; <input type="checkbox" v-model="slchakakses.NOTE.post"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">UPDATE &nbsp; <input type="checkbox" v-model="slchakakses.NOTE.put"></label></td>
							<td width="25%"><label style="height: 100%;min-height: 100%;width: 100%;min-width: 100%;">DELETE &nbsp; <input type="checkbox" v-model="slchakakses.NOTE.delete"></label></td>
						</tr>
					</table>
					<span v-else class="text-warning">SILAHKAN PILIH HAK AKSES DIATAS TERLEBIH DAHULU</span>
				</div>
			</div>
		</div>
		
		<!-- User Input Modal -->
		<div class="modal fade" id="hakaksesInputModal" tabindex="-1" role="dialog" aria-labelledby="hakaksesInputModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="simpandata()">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="hakaksesInputModalLabel">Simpan</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input type="text" v-model="newHakAkses" class="form-control">
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
		selectedModule:[],
		hakakses:[],
		hakAksesNow:null,
		newHakAkses:null,
		hakAksesObject:{},
		slchakakses:{
			PENJUALAN:{
				get:true,post:true,put:true,delete:true,
			},
			MASTER:{
				get:true,post:true,put:true,delete:true,
			},
			MUTASI:{
				get:true,post:true,put:true,delete:true,
			},
			LAPORAN:{
				get:true,post:true,put:true,delete:true,
			},
			USER:{
				get:true,post:true,put:true,delete:true,
			},
			SETTING:{
				get:true,post:true,put:true,delete:true,
			},
			NOTE:{
				get:true,post:true,put:true,delete:true,
			},
		}
	}},
	watch:{
		hakAksesNow: function (v) {
			this.selectedModule = [];
			if (v) {
				var obj = this.hakakses.find(o => o.uuid === v);
				var hakses = JSON.parse(obj.hak_akses);
				for (const key in hakses) {
					this.selectedModule.push(key);
					this.slchakakses[key] = hakses[key];
				}
			}
		},
	},
	methods:{
		loadData(){
			$('.modal').modal('hide');
			axios.get('/api/hakakses').then(({data})=>{
				this.hakakses = data;
			});
		},
		seteditvalue(d){
			
		},
		simpandata(){
			axios.post('/api/hakakses',{nama:this.newHakAkses}).then(({data})=>{
				Swal.fire(data);
				this.loadData();
			})
		},
		editdata(){
			var hakses = {};
			for (var i = 0; i < this.selectedModule.length; i++) {
				var e = this.selectedModule[i];
				hakses[e] = this.slchakakses[e]
			}
			axios.put('/api/hakakses/'+this.hakAksesNow,{
				hak_akses:hakses
			}).then(({data})=>{
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
					axios.delete('/api/hakakses/'+id).then(({data})=>{
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