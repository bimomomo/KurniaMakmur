<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css" />
	<!-- provide the csrf token -->
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<!--favicon-->
			<!-- @if($gen_sttng) -->
				<!-- <link rel="icon" href="{{ URL::asset($gen_sttng->logo)}}" type="image/*" /> -->
			<!-- @else -->
				<link rel="icon" href="{{ URL::asset('favicon.png')}}" type="image/png" />
			<!-- @endif -->
	<!--plugins-->
	<link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css" />
	{{-- <link href="{{ URL:: asset( 'admin/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet')}}" /> --}}
	<link href="{{ URL:: asset( 'admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
	<link href="{{ URL:: asset( 'admin/assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
	<link href="{{ URL:: asset( 'admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ URL:: asset( 'admin/assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{ URL:: asset( 'admin/assets/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ URL:: asset( 'admin/assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ URL:: asset( 'admin/assets/css/app.css')}}" rel="stylesheet">
	<link href="{{ URL:: asset( 'admin/assets/css/icons.css')}}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{ URL:: asset( 'admin/assets/css/dark-theme.css')}}" />
	<link rel="stylesheet" href="{{ URL:: asset( 'admin/assets/css/semi-dark.css')}}" />
	<link rel="stylesheet" href="{{ URL:: asset( 'admin/assets/css/header-colors.css')}}" />

	<script type='text/javascript'>
		var CSRF_TOKEN = "{{ csrf_token() }}";
		var API_TOKEN = "{{ $api_token }}";
	</script>
	<title>Kurnia Makmur</title>
</head>

<body>
	<!-- wrapper -->
	<div id="app" class="wrapper">