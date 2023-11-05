@extends('layouts.master')
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
{{ __('Clients Table') }}
@endsection
@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
        <!--div-->
        <div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-body">
							<h4 class="card-title mg-b-0">Clients info</h4>
							<br>
								<div class="table-responsive">
											
									<table id="example" class="table key-buttons text-md-nowrap" style="width:98%;">
										<thead>
											<tr>
												<th class="border-bottom-0">Name</th>
												<th class="border-bottom-0">email</th>
												<th class="border-bottom-0">country</th>
												<th class="border-bottom-0">role</th>
												<th class="border-bottom-0"></th>
											</tr>
										</thead>
										<tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->country }}</td>
                                                    <td>{{ $user->role }}</td>
                                                    <td>
														<div class="btn-icon-list">
															<button class="btn btn-danger btn-icon modal-effect" data-effect="effect-scale" data-toggle="modal" data-client_id="{{ $user->id }}" data-client_name="{{ $user->name }}" data-target="#modaldemo8"><i class="typcn typcn-trash"></i></button>
															<button class="btn btn-success btn-icon" data-container="body" data-popover-color="secondary" data-placement="bottom" title="" data-content="Created at :{{ $user->created_at }}. Has {{\App\Models\invoice_user::where('user_id', $user->id)->count(); }} Invoices." data-original-title="{{ $user->name }}"><i class="fas fa-info-circle"></i></button>
														</div>
													</td>
                                                </tr>
                                            @endforeach
                                        </tbody>

									</table>
									<!-- Modal effects -->
										<div class="modal" id="modaldemo8">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content modal-content-demo">
												
													<form action=" {{ route('clients.destroy', ['client' => $user->id]) }}" method="post">
														{{ method_field('delete') }}
														{{ csrf_field() }}
													<div class="modal-header">
														<h6 class="modal-title">Delete</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
													</div>
													<div class="modal-body">
														<p>Confirm the deletion of this client. Access to our website and their account will be revoked.</p>
														<input type="hidden" name="client_id" id="client_id" value="">
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
            var client_id = button.data('client_id')
            var client_name = button.data('client_name')
            var modal = $(this)

            modal.find('.modal-body #client_id').val(client_id);
            modal.find('.modal-body #client_name').val(client_name);
        })
    });
</script>
@endsection