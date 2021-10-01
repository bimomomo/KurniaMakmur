		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>

					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center">


							<li class="nav-item dropdown dropdown-large">

								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">

									</a>
									<div class="header-notifications-list">
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
									</div>
									<a href="javascript:;">
									</a>
								</div>
							</li>
							<li class="nav-item dropdown dropdown-large">

								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">

									</a>
									<div class="header-message-list">
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
										<a class="dropdown-item" href="javascript:;">

										</a>
									</div>
									<a href="javascript:;">
									</a>
								</div>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							@if(Auth::user()->avatar)
							<img src="{{asset(Auth::user()->avatar)}}" class="user-img" alt="user avatar">
							@else
							<img src="{{asset('admin/assets/images/avatars/avatar.png')}}" class="user-img" alt="user avatar">
							@endif
							<div class="user-info ps-3">
								<p class="user-name mb-0">{{ Auth::user()->name }}</p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
							</li>
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li>
								<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"><i class='bx bx-log-out-circle'></i><span>{{ __('Logout') }}</span></a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<!--end header -->