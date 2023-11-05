@extends('layouts.master')
@section('css')
<!-- Internal Morris Css-->
<link href="{{URL::asset('assets/plugins/morris.js/morris.css')}}" rel="stylesheet">
@endsection
@section('title')
{{ __('Dashboard') }}
@endsection
@section('content')
	
				<!-- row -->
				<div class="row row-sm">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient"  style="background-color:blue;">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0" style="background-color:blue;">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">TOTAL INVOICES :</h6>
								</div>
								<div class="pb-0 mt-0" >
									<div class="d-flex" >
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												${{number_format(\App\Models\invoice::sum('total'),2)}}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">Number of invoices : {{\App\Models\invoice::count() }}</p>
										</div>
										<span class="float-right my-auto mr-auto" style="margin-left:35px; ">
											<i class="fas fa-arrow-circle-up text-white" ></i>
											<span class="text-white op-7" > 100%</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline" class="pt-1" style="background-color:blue;">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0" style="background-color:red;">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">COMPLETED INVOICES :</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												${{ number_format(\App\Models\Invoice::where('payment_status', 'Completed')->sum('total'), 2) }}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">Number of invoices : {{\App\Models\invoice::where('payment_status', 'Completed')->count() }}</p>
										</div>
										<span class="float-right my-auto mr-auto" style="margin-left:35px;">
											<i class="fas fa-check-circle text-white"></i>
											<span class="text-white op-7"> 
												@if (\App\Models\invoice::count() > 0)
													{{ round(\App\Models\invoice::where('payment_status', 'Completed')->count() / \App\Models\invoice::count() * 100, 2) }}%
												@else
													0%
												@endif
											</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline2" class="pt-1" style="background-color:red;">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12" >
						<div class="card overflow-hidden sales-card bg-success-gradient" >
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0" style="background-color:green;">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">PENDING INVOICES :</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												${{ number_format(\App\Models\Invoice::where('payment_status', 'Pending')
												->where('due_date', '>', now())
												->sum('total'), 2) }}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">Number of invoices : {{\App\Models\invoice::where('payment_status', 'Pending')->where('due_date', '>', now())->count() }}</p>
										</div>
										<span class="float-right my-auto mr-auto" style="margin-left:35px;">
											<i class="fas fa-hourglass-half text-white"></i>
											<span class="text-white op-7"> 
												@if (\App\Models\invoice::count() > 0)
													{{round(\App\Models\invoice::where('payment_status', 'Pending')->where('due_date', '>', now())->count() / \App\Models\invoice::count() *100, 2)}}%
												@else
													0%
												@endif
											</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline3" class="pt-1" style="background-color:green;">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-warning-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0"  style="background-color:orange;">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">EXPIRED INVOICES :</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												${{ number_format(\App\Models\Invoice::where('payment_status', 'Pending')
												->where('due_date', '<', now())
												->sum('total'), 2) }}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">Number of invoices : {{\App\Models\invoice::where('payment_status', 'Pending')->where('due_date', '<', now())->count() }}</p>
										</div>
										<span class="float-right my-auto mr-auto" style="margin-left:35px;">
											<i class="fas fa-hourglass-end text-white"></i>
											<span class="text-white op-7"> 
												@if (\App\Models\invoice::count() > 0)
													{{round(\App\Models\invoice::where('payment_status', 'Pending')->where('due_date', '<', now())->count() / \App\Models\invoice::count() *100, 2)}}%
												@else
													0%
												@endif
											</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline4" class="pt-1" style="background-color:orange;">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
				</div>
				<!-- row closed -->

				
				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-xl-4 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header pb-0">
								<h2 class="card-title mb-2" style="color:#6d6ef3;">Invoices</h2>
								<p class="tx-12 mb-0 text-muted">There are {{ \App\Models\Invoice::count() }} invoices in our database with {{\App\Models\invoice::where('payment_status', 'Pending')->where('due_date', '<', now())->count() }} expired ones</p>
							</div>
							<div class="card-body sales-info ot-0 pt-0 pb-0">
								<br><hr><br><br>
								<div class="morris-donut-wrapper-demo" id="morrisDonut1"></div>
								<br><br><br><br>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-md-12 col-lg-6">
						<div class="card">
							<div class="card-header pb-0">
								<h2 class="card-title mb-2" style="color:#6d6ef3;">Users</h2>
								<p class="tx-12 mb-0 text-muted">There are {{ \App\Models\User::count() }} users in our database </p>
							</div>
							<div class="card-body sales-info ot-0 pt-0 pb-0">
								<br><hr><br>
								<canvas id="userRolesBarChart" width="400" height="400"></canvas>
								<br>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-md-12 col-lg-6">
						<div class="card">
							<div class="card-header pb-0">
								<h3 class="card-title mb-2">Recent Invoices</h3>
								<p class="tx-12 mb-0 text-muted">We have {{ \App\Models\Invoice::whereDate('created_at', now())->count() }} invoices created today</p>
								<br><hr>
								
							</div>
							<div class="card-body sales-info ot-0 pt-0 pb-0">
							<div  class="ht-150">
								<canvas id="circular-chart"></canvas>
							</div>
							<br><br><br><br><br>
								<div class="row sales-infomation pb-0 mb-0 mx-auto wd-100p">
									<div class="col-md-6 col">
										<p class="mb-0 d-flex" ><span class="legend bg-primary brround"></span>Completed</p>
										<h3 class="mb-1">
											${{ number_format(\App\Models\Invoice::whereDate('created_at', now())->where('payment_status', 'Completed')->sum('total'), 2) }}
										</h3>
										<div class="d-flex">
											<p class="text-muted ">Today</p>
										</div>
										<br>
									</div>
									<div class="col-md-6 col">
										<p class="mb-0 d-flex"><span class="legend bg-info brround"></span>Expired</p>
											<h3 class="mb-1">
													${{ number_format(\App\Models\Invoice::whereDate('created_at', now())->where('payment_status', 'Pending')
														->where('due_date', '<', now())
														->sum('total'), 2) }}
											</h3>
										<div class="d-flex">
											<p class="text-muted">Today</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card " >
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="d-flex align-items-center pb-2">
											<p class="mb-0">Invoices this month</p>
										</div>
										<h4 class="font-weight-bold mb-2">{{ \App\Models\Invoice::where('created_at', '>=', now()->subDays(30))->count() }}</h4>

										<div class="progress progress-style progress-sm">
											@if (\App\Models\invoice::count() > 0)
												@php
													$pendingPercentage = round(\App\Models\Invoice::where('created_at', '>=', now()->subDays(30))->count() / \App\Models\Invoice::count() * 100, 2);
												@endphp
											@else
												@php
													$pendingPercentage = '0%' ;
												@endphp
											@endif
											<div class="progress-bar bg-primary-gradient" role="progressbar" style="width: {{ $pendingPercentage }}%;" aria-valuenow="{{ $pendingPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
									<div class="col-md-6 mt-4 mt-md-0">
										<div class="d-flex align-items-center pb-2">
											<p class="mb-0">Users added this month</p>
										</div>
										<h4 class="font-weight-bold mb-2">{{ \App\Models\User::where('created_at', '>=', now()->subDays(30))->count() }}</h4>

										<div class="progress progress-style progress-sm">
											@php
												$pendingPercentage = round(\App\Models\User::where('created_at', '>=', now()->subDays(30))->count() / \App\Models\User::count() * 100, 2);
											@endphp

											<div class="progress-bar bg-danger-gradient" role="progressbar" style="width: {{ $pendingPercentage }}%;" aria-valuenow="{{ $pendingPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>

									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<!-- row close -->

				<!-- row opened -->
				<div class="row row-sm row-deck">
					<div class="col-md-12 col-lg-4 col-xl-4">
						<div class="card card-dashboard-eight pb-2">
							<h6 class="card-title">Your Top Countries</h6>
							<span class="d-block mg-b-10 text-muted tx-12">Most users of this websites are from these countries</span>
							<hr><br>
							<div class="list-group">
								@foreach ($topCountries as $country)
								<div class="list-group-item border-top-0">
									<i class="flag-icon flag-icon-{{ strtolower($country->code) }} flag-icon-squared"></i>
									<p>{{ $country->name }}</p>
									<span>{{ $country->user_count }} users</span>
								</div>
								@endforeach
							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-8 col-xl-8">
						<div class="card card-table-two">
							<div class="d-flex justify-content-between">
								<h4 class="card-title mb-1">Your Most Recent Invoices</h4>
								<i class="mdi mdi-dots-horizontal text-gray"></i>
							</div>
							<span class="tx-12 tx-muted mb-3 ">There are {{ \App\Models\Invoice::count() }} invoices in our database.</span>
							<div class="table-responsive country-table">
								<table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
									<thead>
										<tr class="bg-primary">
											<th class="wd-lg-25p text-white">Name</th>
											<th class="wd-lg-25p tx-right text-white">Total</th>
											<th class="wd-lg-25p tx-right text-white">Status</th>
											<th class="wd-lg-25p tx-right text-white">Payment type</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($lastFiveInvoices as $invoice)
										<tr>
											<td>{{ $invoice->name }}</td>
											<td class="tx-right tx-medium tx-inverse">{{ $invoice->total }}</td>
											<td class="tx-right tx-medium tx-inverse">{{ $invoice->payment_status }}</td>
											<td class="tx-right tx-medium tx-danger">{{ $invoice->payment_type }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<!-- /row -->
			</div>
		</div>
		<!-- Container closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<!--Internal  Flot js-->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<!--Internal Apexchart js-->
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>	
<!--Internal  Morris js -->
<script src="{{URL::asset('assets/plugins/morris.js/morris.min.js')}}"></script>
<!--Chart Morris js -->
<script>
	// Initialize the Morris.js donut chart
	new Morris.Donut({
		element: 'morrisDonut1', // ID of the chart container
		data: [
			{ label: 'Expired', value: {{\App\Models\invoice::where('payment_status', 'Pending')->where('due_date', '<', now())->count() }} },
			{ label: 'Pending', value: {{\App\Models\invoice::where('payment_status', 'Pending')->where('due_date', '>', now())->count() }} },
			{ label: 'Completed', value: {{ \App\Models\Invoice::where('payment_status', 'Completed')->count() }} }
		],
		colors: ['#E67E22', '#52BE80', '#f7557a'],
		resize: true,
		labelColor:"#8c9fc3"
	});
	// Initialize the Morris.js donut chart
	new Morris.Donut({
		element: '', // ID of the chart container
		data: [
			{ label: 'Admin', value: {{ \App\Models\User::where('role', 'admin')->count() }} },
			{ label: 'Vendor', value: {{ \App\Models\User::where('role', 'vendor')->count() }} },
			{ label: 'Client', value: {{ \App\Models\User::where('role', 'client')->count() }} }
		],
		colors: ['#E67E22', '#52BE80', '#f7557a'],
		resize: true,
		labelColor:"#8c9fc3"
	});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!--Canva Bar JS -->
<script>
	var ctx = document.getElementById('userRolesBarChart').getContext('2d');
	var userRolesBarChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ['Client', 'Vendor', 'Admin'],
			datasets: [{
				data: [
					// Replace these with actual counts
					{{ \App\Models\User::where('role', 'client')->count() }},
					{{ \App\Models\User::where('role', 'vendor')->count() }},
					{{ \App\Models\User::where('role', 'admin')->count() }}
				],
				backgroundColor: ['#9B59B6', '#285cf7', '#f7557a']
			}]
		},
		options: {
			plugins: {
				legend: {
					display: false, // Hide the legend
				}
			},
			scales: {
				y: {
					beginAtZero: true,
					stepSize: 1,
				}
			}
		}
	});
</script>

<!-- The chart about today -->
<script>
    $(function () {
        "use strict";

        // Circular Chart Data
        var circularChartData = {
            labels: ["Pending", "Completed"],
            datasets: [{
                data: [{{ $pendingPercentage }}, {{ 100 - $pendingPercentage }}],
                backgroundColor: ["#f1556c", "#f7b84b"],
                borderWidth: 0
            }]
        };

        // Circular Chart Options
        var circularChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 70
        };

        // Get the context of the canvas element we want to select
        var circularChartCanvas = $("#circular-chart").get(0).getContext("2d");

        // Create the circular chart
        var circularChart = new Chart(circularChartCanvas, {
            type: "doughnut",
            data: circularChartData,
            options: circularChartOptions
        });
    });
</script>

						
@endsection