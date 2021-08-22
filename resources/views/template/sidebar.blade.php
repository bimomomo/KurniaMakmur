<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
	<div class="sidebar-header">
		<div>
			<img src="{{asset('admin/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
		</div>
		<div>
			<h4 class="logo-text">KurniaMakmur</h4>
		</div>
		<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
		</div>
	</div>
	<!--navigation-->
	<ul class="metismenu" id="menu">
		<li>
			<router-link to="home">
				<div class="parent-icon"><i class='bx bx-home-circle'></i>
				</div>
				<div class="menu-title">Dashboard</div>
			</router-link>
		</li>
		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class='bx bx-cog'></i>
				</div>
				<div class="menu-title">Master</div>
			</a>
			<ul>
				<li>
					<router-link to="master-kategori"><i class="bx bx-right-arrow-alt"></i>Data Kategori</router-link>
				</li>
				<li>
					<router-link to="master-brand"><i class="bx bx-right-arrow-alt"></i>Data Brand</router-link>
				</li>
				<li>
					<router-link to="master-gudang"><i class="bx bx-right-arrow-alt"></i>Data Gudang</router-link>
				</li>
				<li>
					<router-link to="master-satuan"><i class="bx bx-right-arrow-alt"></i>Data Satuan</router-link>
				</li>
				<li>
					<router-link to="master-barang"><i class="bx bx-right-arrow-alt"></i>Data Barang</router-link>
				</li>
			</ul>
		</li>
		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class='bx bx-archive'></i>
				</div>
				<div class="menu-title">Mutasi</div>
			</a>
			<ul>
				<li>
					<router-link to="mutasi-stock-masuk"><i class="bx bx-right-arrow-alt"></i>Mutasi Stock Masuk</router-link>
				</li>

			</ul>
		</li>
	</ul>
	<!--end navigation-->
</div>
<!--end sidebar wrapper -->