@extends('layouts.masterV')
@section('css')
       <style>
        @media print {
            #print_Button {
                display: none;
            }
        }

    </style>
@endsection
@section('title')
{{ __('Print Invoices') }}
@endsection
@section('content')
       <!-- row -->
				<div class="main-content-body-invoice"  id="print">
					<div class="card-invoice">
						<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">{{ $invoice->type }}</h1>
										<div class="billed-from">
											@foreach ($userVendor as $userVendor)
												<h6>{{$userVendor->name}}</h6>
												<p>{{$userVendor->name}}<br>
												@if ($invoice->shipping_address)
												{{ $invoice->shipping_address }},
												@endif
												{{\App\Models\Country::where('code', $userVendor->country)->first()->name;}}<br>
												Email: {{$userVendor->email}}</p>
											@endforeach
										</div><!-- billed-from -->
									</div><!-- invoice-header -->

									<div class="row mg-t-20">
										<div class="col-md">
											<label class="tx-gray-600">Billed To</label>
											<div class="billed-to">
											@foreach ($userClient as $userClient)
												<h6>{{$userClient->name}}</h6>
												<p>{{$userClient->name}}<br>
												@if ($invoice->shipping_address)
												{{ $invoice->shipping_address }},
												@endif
												{{\App\Models\Country::where('code', $userClient->country)->first()->name;}}<br>
												Email: {{$userClient->email}}</p>
											@endforeach
												
											</div>
										</div>
										<div class="col-md">
											<label class="tx-gray-600">Invoice Information</label>
											<p class="invoice-info-row"><span>Date:</span> <span>{{ $invoice->date }}</span></p>
											<p class="invoice-info-row"><span>Payment Terms:</span> <span>{{ $invoice->payment_terms }}</span></p>
											<p class="invoice-info-row"><span>Due Date:</span> <span>{{ $invoice->due_date }}</span></p>
											<p class="invoice-info-row"><span>Balance Due:</span> <span>{{ $invoice->balance_due }}</span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">Item </th>
													<th class="wd-40p">Quantity</th>
													<th class="tx-center">Rate</th>
													<th class="tx-right">Amount</th>
												</tr>
											</thead>
											<tbody>
                                                @foreach ($items as $item)
												<tr>
													<td>{{ $item->label }}</td>
													<td class="tx-12">{{ $item->quantity }}</td>
													<td class="tx-center">{{ $item->rate }}</td>
													<td class="tx-right">{{ $item->amount }}</td>
												</tr>
                                                @endforeach
												
											</tbody>
										</table>
										<br>
                                                                      <div class="row mg-t-20" style="max-width: 1130px;">	
                                                                             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                                                    
                                                                                    <div class="billed-to mg-4">
                                                                                           <h6>Notes :</h6>
                                                                                           <p>{{ $invoice->notes }}</p>
                                                                                           <br>
                                                                                           <h6>Terms :</h6>
                                                                                           <p>{{ $invoice->terms }}</p>
											       </div>
                                                                             </div>

                                                                             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                                                    <p class="invoice-info-row"><span>Subtotal:</span> <span>{{ $invoice->subtotal }}</span></p>
                                                                                    <p class="invoice-info-row"><span>Tax Rate:</span> <span>{{ $invoice->tax_rate }}</span></p>
                                                                                    <p class="invoice-info-row"><span>Tax Amount:</span> <span>{{ $invoice->tax_amount }}</span></p>
                                                                                    <p class="invoice-info-row"><span>Total:</span> <span>{{ $invoice->total }}</span></p>
                                                                                    <p class="invoice-info-row"><span>Amount Paid:</span> <span>{{ $invoice->amount_paid }}</span></p>
                                                                                    <p class="invoice-info-row"><span>Balance Due:</span> <span>{{ $invoice->balance_due }}</span></p>
                                                                             </div>
                                                                      </div>
									</div>
									<br>
									<hr class="mg-b-40">
                                                               <button class="btn btn-success float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                                                      <i class="fas fa-print"></i> Print invoice
                                                               </button>
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>

<script>
       
       function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
       }

</script>
@endsection