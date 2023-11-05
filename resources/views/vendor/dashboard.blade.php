@extends('layouts.masterV')

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
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0" style="background-color:blue;">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">TOTAL INVOICES :</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
                                            ${{ number_format(Auth::user()->invoices->sum('total'), 2) }}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">Number of invoices : {{Auth::user()->invoices->count() }}</p>
										</div>
										<span class="float-right my-auto mr-auto" style="margin-left:35px;">
											<i class="fas fa-arrow-circle-up text-white"></i>
											<span class="text-white op-7" style="background-color:blue;"> 100%</span>
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
                                                ${{ number_format(Auth::user()->invoices()->where('payment_status', 'Completed')->sum('total'), 2) }}

											</h4>
											<p class="mb-0 tx-12 text-white op-7">Number of invoices : {{Auth::user()->invoices()->where('payment_status', 'Completed')->count() }}</p>
										</div>
										<span class="float-right my-auto mr-auto" style="margin-left:35px;">
											<i class="fas fa-check-circle text-white"></i>
											<span class="text-white op-7"> 
												@if (\App\Models\invoice::count() > 0)
													{{ round(Auth::user()->invoices()->where('payment_status', 'Completed')->count() / \App\Models\invoice::count() * 100, 2) }}%
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
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-success-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0" style="background-color:green;">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">PENDING INVOICES :</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												${{  number_format(Auth::user()->invoices()->where('payment_status', 'Pending')
												->where('due_date', '>', now())
												->sum('total'), 2) }}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">Number of invoices : {{ Auth::user()->invoices()->where('payment_status', 'Pending')->where('due_date', '>', now())->count() }}</p>
										</div>
										<span class="float-right my-auto mr-auto" style="margin-left:35px;">
											<i class="fas fa-hourglass-half text-white"></i>
											<span class="text-white op-7"> 
												@if (\App\Models\invoice::count() > 0)
													{{round(Auth::user()->invoices()->where('payment_status', 'Pending')->where('due_date', '>', now())->count() / \App\Models\invoice::count() *100, 2)}}%
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
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0" style="background-color:orange;">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">EXPIRED INVOICES :</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												${{ number_format(Auth::user()->invoices()->where('payment_status', 'Pending')
												->where('due_date', '<', now())
												->sum('total'), 2) }}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">Number of invoices : {{Auth::user()->invoices()->where('payment_status', 'Pending')->where('due_date', '<', now())->count() }}</p>
										</div>
										<span class="float-right my-auto mr-auto" style="margin-left:35px;">
											<i class="fas fa-hourglass-end text-white"></i>
											<span class="text-white op-7"> 
												@if (\App\Models\invoice::count() > 0)
													{{round(Auth::user()->invoices()->where('payment_status', 'Pending')->where('due_date', '<', now())->count() / \App\Models\invoice::count() *100, 2)}}%
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
			<br>
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
							<span class="tx-12 tx-muted mb-3 ">You have {{ Auth::user()->invoices->count() }} invoices in your account.</span>
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
@endsection