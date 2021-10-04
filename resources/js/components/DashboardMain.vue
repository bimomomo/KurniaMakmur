<template>
	<div>
		<div>
			<marquee-text :repeat="10">
				<span v-for="p in pengumuman" :key="p.uuid">
					<b v-if="p.type==0" class="text-info"><i class="bx bx-info-circle"></i>{{p.pengumuman}}</b>
					<b v-else-if="p.type==1" class="text-warning"><i class="bx bx-error-circle"></i>{{p.pengumuman}}</b>
					<b v-else-if="p.type==2" class="text-danger"><i class="bx bx-x-circle"></i>{{p.pengumuman}}</b>
					&nbsp;|&nbsp;
				</span>
			</marquee-text>
		</div>
		<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Status sudah bayar</p>
								<h4 class="my-1">{{ this.statuslunas }}</h4>
							</div>
							<div class="text-info ms-auto font-35">
								<i class="bx bxs-user-check"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Total sudah bayar</p>
								<h4 class="my-1">
									{{
										new Intl.NumberFormat("id-ID", {
											style: "currency",
											currency: "IDR",
										}).format(this.totallunas * 1000)
									}}
								</h4>
							</div>
							<div class="text-success ms-auto font-35">
								<i class="bx bxs-badge-dollar"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Total belum bayar</p>
								<h4 class="my-1">
									{{
										new Intl.NumberFormat("id-ID", {
											style: "currency",
											currency: "IDR",
										}).format(this.totalbelumlunas * 1000)
									}}
								</h4>
							</div>
							<div class="text-warning ms-auto font-35">
								<i class="bx bxs-badge-dollar"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">yang akan diterima</p>
								<h4 class="my-1">
									{{
										new Intl.NumberFormat("id-ID", {
											style: "currency",
											currency: "IDR",
										}).format(this.YAD * 1000)
									}}
								</h4>
							</div>
							<div class="text-primary ms-auto font-35">
								<i class="bx bxs-wallet"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<h4>Pelanggan Paling Sering Membeli</h4>
						<apexchart type="bar" :options="csb.opt" :series="csb.srs"></apexchart>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<h4>Pelanggan Paling Sering Return</h4>
						<apexchart type="bar" :options="csr.opt" :series="csr.srs"></apexchart>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<h4>Sisa barang dengan persentase</h4>
						<perfect-scrollbar ref="scrollbar">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Barang</th>
										<th width="1%">Sisa</th>
										<th width="1%">Persentase</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(item, index) in allbarang" :key="index">
										<td>{{ item.nama }}</td>
										<td v-if="item.sisa == null">kosong</td>
										<td v-else>{{ item.sisa }}</td>
										<td v-html="persentase(item.sisa)"></td>
									</tr>
								</tbody>
							</table>
						</perfect-scrollbar>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<h4>Barang terjual dengan persentase</h4>
						<perfect-scrollbar ref="scrollbar">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Barang</th>
										<th width="1%">Terjual</th>
										<th width="1%">Persentase</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(item, index) in allbarangnya" :key="index">
										<td>{{ item.nama }}</td>
										<td v-if="item.terjual == null">kosong</td>
										<td v-else>{{ item.terjual }}</td>
										<td v-html="terjual(item.terjual)"></td>
									</tr>
								</tbody>
							</table>
						</perfect-scrollbar>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { PerfectScrollbar } from "vue2-perfect-scrollbar";
import MarqueeText from 'vue-marquee-text-component';

export default {
	components: {
		PerfectScrollbar,
		MarqueeText,
	},
	created() {
		this.loadUsers();
		Fire.$on("reloadUsers", () => {
			this.loadUsers();
		});
	},
	data: function () {
		return {
			totalbelumlunas: "",
			YAD: "",
			totallunas: "",
			statuslunas: "",
			allstock: "",
			allbarang: {},
			allbarangnya: {},
			allterjual: "",
			pengumuman:[],
			cstmr_beli:[],
			cstmr_rtrn:[],
			csb:{
				opt: {
					chart: {
						id: 'Pelanggan Sering Beli'
					},
					xaxis: {
						categories: []
					},
					theme: {
						palette: 'palette1'
					},
					plotOptions: {
						bar: {
							horizontal: true,
							distributed:true,
						}
					},
				},
				srs: [{
					name: 'kali',
					data: []
				}],
			},
			csr:{
				opt: {
					chart: {
						id: 'Pelanggan Sering Return'
					},
					xaxis: {
						categories: []
					},
					theme: {
						palette: 'palette1'
					},
					plotOptions: {
						bar: {
							horizontal: true,
							distributed:true,
						}
					},
				},
				srs: [{
					name: 'kali',
					data: []
				}],
			},
		};
	},
	watch:{
		cstmr_beli: function (v) {
			for (var i = 0; i < v.length; i++) {
				var e = v[i];
				this.csb.opt.xaxis.categories.push(e.pelanggan)
				this.csb.srs[0].data.push(e.jumlah)
			}
		},
		cstmr_rtrn: function (v) {
			for (var i = 0; i < v.length; i++) {
				var e = v[i];
				this.csr.opt.xaxis.categories.push(e.pelanggan)
				this.csr.srs[0].data.push(e.jumlah)
			}
		}
	},
	methods: {
		loadUsers() {
			axios.get('api/dashboarddata').then(({data})=>{
				this.pengumuman = data.pengumuman;
				this.cstmr_beli = data.cstmr_beli;
				this.cstmr_rtrn = data.cstmr_rtrn;
			});
			axios
				.get("api/totalbelumlunas")
				.then(({ data }) => (this.totalbelumlunas = data));
			axios.get("api/YAD").then(({ data }) => (this.YAD = data));

			axios.get("api/stockpalingbanyak").then(({ data }) => {
				this.allstock = data["hasil"];
				this.allbarang = data["barang"];
			});
			axios.get("api/barangterjualbanyak").then(({ data }) => {
				this.allterjual = data["hasilnya"];
				this.allbarangnya = data["barangnya"];
			});

			axios.get("api/totallunas").then(({ data }) => (this.totallunas = data));

			axios
				.get("api/statuslunas")
				.then(({ data }) => (this.statuslunas = data));
		},

		persentase(item) {
			var a = (item / this.allstock) * 100;
			return a.toFixed(2) + "%";
		},
		terjual(item) {
			var a = (item / this.allterjual) * 100;
			return a.toFixed(2) + "%";
		},
	},
};
</script>
<style src="vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css"/>
<style>
.ps {
	height: 250px;
}
</style>