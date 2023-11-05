@extends('layouts.masterV')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('title')
{{ __('Invoices') }}
@endsection
@section('content')
        <!--div-->
        <div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table key-buttons text-md-nowrap" style="width:98%;">
									<thead>
											<tr>
												<th class="border-bottom-0">client</th>
												<th class="border-bottom-0">payment_terms</th>
												<th class="border-bottom-0">total</th>
												<th class="border-bottom-0">status</th>
												<th class="border-bottom-0">due_date</th>
												<th class="border-bottom-0">po_number</th>
												<th class="border-bottom-0">shipping_address</th>
												<th class="border-bottom-0">notes</th>
												<th class="border-bottom-0">terms</th>
												<th class="border-bottom-0">image</th>
												<th class="border-bottom-0"> </th>
												
											</tr>
										</thead>
										<tbody>
                                            @foreach ($invoices as $invoice)
                                                <tr>
													<td>{{ $invoice->userNames }}</td>
                                                    <td>{{ $invoice->payment_terms }}</td>
													<td>{{ $invoice->total }}</td>
													<td>{{ $invoice->payment_status }}</td>
                                                    <td>{{ $invoice->due_date }}</td>
                                                    <td>{{ $invoice->po_number }}</td>
                                                    <td>{{ $invoice->shipping_address }}</td>
                                                    <td>{{ $invoice->notes }}</td>
                                                    <td>{{ $invoice->terms }}</td>
													<td>
														@if($invoice->image)
															<img src="{{ url('images/'.$invoice->image) }}" style="max-height: 50px;">
														@else 
															<span>No image found!</span>
														@endif
													</td>
													<td>
													<div class="btn-icon-list">
														<button class="btn btn-danger btn-icon modal-effect" data-effect="effect-scale" data-toggle="modal" data-invoice_id="{{ $invoice->id }}" data-target="#modaldemo8"><i class="typcn typcn-trash"></i></button>
														<a class="btn btn-primary btn-icon" href="{{ route('invoicesV.printInvoice', ['invoiceP' => $invoice->id]) }}"><i class="typcn typcn-download"></i></a>
														<a class="btn btn-success btn-icon" href="{{ route('invoicesV.updateInvoice', ['invoiceU' => $invoice->id]) }}"><i class="typcn typcn-edit"></i></a>
														<!-- Modal effects -->
										<div class="modal" id="modaldemo8">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content modal-content-demo">
													
														<form action=" {{ route('invoicesV.destroy', ['invoice' => $invoice->id]) }}" method="post">
															{{ method_field('delete') }}
															{{ csrf_field() }}
														<div class="modal-header">
															<h6 class="modal-title">Delete</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
														</div>
														<div class="modal-body">
															<p>Confirm the deletion of this invoice. It wont exist anymore.</p>
															<input type="hidden" name="invoice_id" id="invoice_id" value="">
														</div>
														<div class="modal-footer">
															<button class="btn ripple btn-primary">Confirm</button>
															<button class="btn ripple btn-secondary" data-dismiss="modal">Cancel</button>
														</div>
														</form>
													</div>
												</div>
											</div>
										<!-- End Modal effects-->
													</div>
													</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
									</table>
									
								</div>
							</div>
						</div>
					</div>
					<!--/div-->
					
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
    $(document).ready(function () {
        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)

            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    });
</script>
@endsection