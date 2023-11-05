
<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>
		
        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/v4-font-face.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{URL::asset('assets/js/updateInvoice.js')}}"></script>
        <link href="{{URL::asset('assets/css/addInvoice.css')}}" rel="stylesheet">
        
	</head>
	
	<body>
        <x-vendor>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight no-border">
                {{ __('Update Invoice') }}
                </h2>
            </x-slot>


            <form method="POST" action="{{  route('addInvoice.edit' , ['id' => $invoice->id])}}" enctype="multipart/form-data">
                @csrf
                <div class="container1">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                        <div class="container mt-4 paper left-div">
                            <div class="row mt-4">
                                <div class="col-7 form-group">
                                    <img id="uploaded-image" src="{{ old('image') ? asset('storage/' . old('image')) : '' }}" alt="Uploaded Image" class="uploaded-image">
                                    <div class="dropzone" id="dropzone">
                                        <label for="upload-input" id="upload-label">+ change your logo</label>
                                        <input type="file" class="form-control upload-input" id="upload-input" name="image">
                                            <!-- Display the current image -->
                                            @if ($invoice->image)
                                                <img src="{{ url('images/'.$invoice->image)}}" style="max-height: 50px;" >
                                            @endif
                                            @error('image')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-5 form-group">
                                    <h1 style="font-size: 35px;margin-bottom: 1px"><span class="selected-value">{{$invoice->type}}</span></h1>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">#</span>
                                        <x-text-input type="text" class="form-control" aria-describedby="basic-addon1" value="{{ $invoice->id}}"/>
                                    </div>
                                </div>
                            </div>
                            

                            

                            <div class="row mt-4">
                                <div class="col-6">
                                    
                                    <h2 style="font-size: 16px;font-weight: bold;margin-bottom: 1px">From {{ Auth::user()->name }},</h2>
                                    <div class="row" style="padding-top: 50px;">
                                        <div class="col-6">
                                            <label for="receiver" class="form-label">&nbsp;&nbsp;&nbsp;Bill to (Email)</label>
                                            <select class="form-control" name="receiver" id="receiver" style="font-size: 14px;" value="{{ Auth::user()->name }}">
                                                @foreach ($emails as $email)
                                                    <option value="{{ $email }}" label="{{ $email }}"  {{ $clientEmails == $email ? 'selected' : '' }}>{{ $email }}</option>
                                                @endforeach
                                            </select>
                                            @error('receiver')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="adresse" class="form-label">&nbsp;&nbsp;&nbsp;Ship to</label>
                                            <textarea class="form-control" style="resize: none;" rows="2" id="adresse" placeholder="(optional)" name="shipping_address">{{$invoice->shipping_address}}</textarea>
                                            @error('shipping_address')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- /////////////////////////////////// -->
                                <div class="col-6" style="direction: rtl;">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto" style="width: 200px;">
                                            <x-text-input type="date" id="inputDate" class="form-control" name="date" value="{{$invoice->date}}"  />
                                        </div>
                                        <div class="col-auto">
                                            <label for="inputDate" class="col-form-label">Date</label>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-items-center"  style="padding-top:2px;">
                                        <div class="col-auto" style="width: 200px;">
                                            <x-text-input type="text" id="inputPayTerm" class="form-control" name="payment_terms" value="{{$invoice->payment_terms}}"  />
                                        </div>
                                        <div class="col-auto">
                                            <label for="inputPayTerm" class="col-form-label">Payment Terms</label>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-items-center" style="padding-top:2px;">
                                        <div class="col-auto" style="width: 200px;">
                                            <x-text-input type="date" id="inputDueDate" class="form-control" name="due_date" value="{{$invoice->due_date}}"  />
                                        </div>
                                        <div class="col-auto">
                                            <label for="inputDueDate" class="col-form-label">Due Date</label>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-items-center" style="padding-top:2px;">
                                        <div class="col-auto" style="width: 200px;">
                                            <x-text-input id="inputPO" class="form-control" name="po_number" value="{{$invoice->po_number}}"  />
                                        </div>
                                        <div class="col-auto">
                                            <label for="inputPO" class="col-form-label">PO Number</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /////////////////////////////////// -->
                            <div class="form-row mt-4">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table class="table table-hover smaller-cells" id="invoiceItem">
                                    <thead class="table-dark">
                                    <th width="2%"><input id="checkAll" class="itemRow" type="checkbox" /></th>
                                    <th width="38%">Item</th>
                                    <th width="15%">Quantity</th>
                                    <th width="15%">Rate</th>
                                    <th width="15%">Amount</th>
                                    </thead>
                                    @foreach ($items as $item)
                                    <tr>
                                    <td><input class="itemRow" type="checkbox"/></td>
                                    <td><input name="productName[]" id="productName_1" class="form-control smaller-cells" autocomplete="off" value="{{$item->label}}"/></td>
                                    <td><input name="quantity[]" id="quantity_1" class="form-control quantity smaller-cells" autocomplete="off" value="{{$item->quantity}}"/></td>
                                    <td><input name="price[]" id="price_1" class="form-control price smaller-cells" autocomplete="off" value="{{$item->rate}}"/></td>
                                    <td><input name="totalI[]" id="total_1" class="form-control total smaller-cells" autocomplete="off" value="{{$item->amount}}"/></td>
                                    </tr>
                                    @endforeach
                                </table>
                                </div>
                                <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">
                                    <button class="btn btn-danger delete" id="removeRows" style="height: 30px; padding: 4px 8px; font-size: 14px;margin-right: 20px;background-color: #DA1D1A;" type="button">- Delete</button>
                                    <button class="btn btn-success" style="height: 30px; padding: 4px 8px; font-size: 14px;background-color: green;" id="addRows" type="button">+ Add More</button>
                                </div>
                                </div>
                            </div>
                    <!-- /////////////////////////////////// -->
                            <div class="row mt-4">	
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="notes" class="form-label">&nbsp;&nbsp;&nbsp;Notes</label>
                                            <textarea class="form-control" style="resize: none;" rows="2" id="notes" placeholder="Notes - any relevant information not already covered" name="notes">{{$invoice->notes}}</textarea>
                                        <br>
                                        <label for="terms" class="form-label">&nbsp;&nbsp;&nbsp;Terms</label>
                                            <textarea class="form-control" style="resize: none;" rows="2" id="terms" placeholder="Terms and conditions - late fees, payment methods, delivery schedule" name="terms">{{$invoice->terms}}</textarea>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="direction: rtl;">
                                        
                                            <div class="row g-3 align-items-center">
                                                <div class="input-group mb-3" style="direction: ltr; width:250px;">
                                                    <span class="input-group-text" id="basic-addon1"><span class="selected-currency">$</span></span>
                                                    <x-text-input class="form-control" name="subTotal" id="subTotal" aria-describedby="basic-addon1" value="{{$invoice->subtotal}}"/>
                                                </div>
                                                <div class="col-auto">
                                                <label for="subTotal" class="col-form-label">: Subtotal</label>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-items-center">
                                                <div class="input-group mb-3" style="direction: ltr; width:250px;">
                                                    <x-text-input class="form-control" name="taxRate" id="taxRate" aria-describedby="basic-addon2" value="{{$invoice->tax_rate}}"/>
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                                <div class="col-auto">
                                                <label for="taxRate" class="col-form-label">: Tax Rate</label>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-items-center">
                                                <!-- Tax Amount -->
                                                <div class="input-group mb-3" style="direction: ltr; width: 250px;">
                                                    <span class="input-group-text" id="basic-addon1"><span class="selected-currency">$</span></span>
                                                    <x-text-input class="form-control" name="taxAmount" id="taxAmount" aria-describedby="basic-addon1" value="{{$invoice->tax_amount}}"/>
                                                </div>
                                                <div class="col-auto">
                                                    <label for="taxAmount" class="col-form-label">: Tax Amount</label>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 align-items-center">
                                                <!-- Total -->
                                                <div class="input-group mb-3" style="direction: ltr; width: 250px;">
                                                    <span class="input-group-text" id="basic-addon2"><span class="selected-currency">$</span></span>
                                                    <x-text-input class="form-control" name="totalAftertax" id="totalAftertax" aria-describedby="basic-addon2" name="total" value="{{$invoice->total}}"/>
                                                </div>
                                                <div class="col-auto">
                                                    <label for="totalAftertax" class="col-form-label">: Total</label>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 align-items-center payment-related-section">
                                                <!-- Amount Paid -->
                                                <div class="input-group mb-3" style="direction: ltr; width: 250px;">
                                                    <span class="input-group-text" id="basic-addon3"><span class="selected-currency">$</span></span>
                                                    <x-text-input class="form-control" name="amountPaid" id="amountPaid" aria-describedby="basic-addon3" value="{{$invoice->amount_paid}}"/>
                                                </div>
                                                <div class="col-auto">
                                                    <label for="amountPaid" class="col-form-label">: Amount Paid</label>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 align-items-center payment-related-section">
                                                <!-- Amount Due -->
                                                <div class="input-group mb-3" style="direction: ltr; width: 250px;">
                                                    <span class="input-group-text" id="basic-addon4"><span class="selected-currency">$</span></span>
                                                    <x-text-input class="form-control" name="amountDue" id="amountDue" aria-describedby="basic-addon4" value="{{$invoice->balance_due}}"/>
                                                </div>
                                                <div class="col-auto">
                                                    <label for="amountDue" class="col-form-label">: Balance Due</label>
                                                </div>
                                            </div>
                                            
                                        
                                    </div>		      	
                            </div>
                            <br>
                        </div>
                        
                        <div class="right-div">
                            <div>
                            <button type="submit" style="align-self: center; margin-bottom:20px; background-color: green;padding-left: 50px;padding-right: 50px;" class="btn btn-success"><i class="fas fa-download"></i>&nbsp; Save invoice</button>
                            </div>
                            <hr><br>
                            <label for="currencyList">CURRENCY</label>
                            <select class="form-select" id="currencyList" name="currency">
                                <option value="AED" label="AED (د.إ)" {{ $invoice->currency == 'AED' ? 'selected' : '' }}>AED (د.إ)</option>
                                <option value="AFN" label="AFN" {{ $invoice->currency == 'AFN' ? 'selected' : '' }}>AFN</option>
                                <option value="ALL" label="ALL (Lek)" {{ $invoice->currency == 'ALL' ? 'selected' : '' }}>ALL (Lek)</option>
                                <option value="AMD" label="AMD" {{ $invoice->currency == 'AMD' ? 'selected' : '' }}>AMD</option>
                                <option value="ANG" label="ANG (ƒ)" {{ $invoice->currency == 'ANG' ? 'selected' : '' }}>ANG (ƒ)</option>
                                <option value="AOA" label="AOA (Kz)" {{ $invoice->currency == 'AOA' ? 'selected' : '' }}>AOA (Kz)</option>
                                <option value="ARS" label="ARS ($)" {{ $invoice->currency == 'ARS' ? 'selected' : '' }}>ARS ($)</option>
                                <option value="AUD" label="AUD ($)" {{ $invoice->currency == 'AUD' ? 'selected' : '' }}>AUD ($)</option>
                                <option value="AWG" label="AWG (ƒ)" {{ $invoice->currency == 'AWG' ? 'selected' : '' }}>AWG (ƒ)</option>
                                <option value="AZN" label="AZN (ман)" {{ $invoice->currency == 'AZN' ? 'selected' : '' }}>AZN (ман)</option>
                                <option value="BAM" label="BAM (KM)" {{ $invoice->currency == 'BAM' ? 'selected' : '' }}>BAM (KM)</option>
                                <option value="BBD" label="BBD ($)" {{ $invoice->currency == 'BBD' ? 'selected' : '' }}>BBD ($)</option>
                                <option value="BDT" label="BDT (Tk)" {{ $invoice->currency == 'BDT' ? 'selected' : '' }}>BDT (Tk)</option>
                                <option value="BGN" label="BGN (лв)" {{ $invoice->currency == 'BGN' ? 'selected' : '' }}>BGN (лв)</option>
                                <option value="BHD" label="BHD" {{ $invoice->currency == 'BHD' ? 'selected' : '' }}>BHD</option>
                                <option value="BIF" label="BIF" {{ $invoice->currency == 'BIF' ? 'selected' : '' }}>BIF</option>
                                <option value="BMD" label="BMD ($)" {{ $invoice->currency == 'BMD' ? 'selected' : '' }}>BMD ($)</option>
                                <option value="BND" label="BND ($)" {{ $invoice->currency == 'BND' ? 'selected' : '' }}>BND ($)</option>
                                <option value="BOB" label="BOB ($b)" {{ $invoice->currency == 'BOB' ? 'selected' : '' }}>BOB ($b)</option>
                                <option value="BOV" label="BOV" {{ $invoice->currency == 'BOV' ? 'selected' : '' }}>BOV</option>
                                <option value="BRL" label="BRL (R$)" {{ $invoice->currency == 'BRL' ? 'selected' : '' }}>BRL (R$)</option>
                                <option value="BSD" label="BSD ($)" {{ $invoice->currency == 'BSD' ? 'selected' : '' }}>BSD ($)</option>
                                <option value="BTN" label="BTN" {{ $invoice->currency == 'BTN' ? 'selected' : '' }}>BTN</option>
                                <option value="BWP" label="BWP (P)" {{ $invoice->currency == 'BWP' ? 'selected' : '' }}>BWP (P)</option>
                                <option value="BYN" label="BYN (Br)" {{ $invoice->currency == 'BYN' ? 'selected' : '' }}>BYN (Br)</option>
                                <option value="BZD" label="BZD (BZ$)" {{ $invoice->currency == 'BZD' ? 'selected' : '' }}>BZD (BZ$)</option>
                                <option value="CAD" label="CAD ($)" {{ $invoice->currency == 'CAD' ? 'selected' : '' }}>CAD ($)</option>
                                <option value="CDF" label="CDF" {{ $invoice->currency == 'CDF' ? 'selected' : '' }}>CDF</option>
                                <option value="CHE" label="CHE" {{ $invoice->currency == 'CHE' ? 'selected' : '' }}>CHE</option>
                                <option value="CHF" label="CHF" {{ $invoice->currency == 'CHF' ? 'selected' : '' }}>CHF</option>
                                <option value="CHW" label="CHW" {{ $invoice->currency == 'CHW' ? 'selected' : '' }}>CHW</option>
                                <option value="CLF" label="CLF" {{ $invoice->currency == 'CLF' ? 'selected' : '' }}>CLF</option>
                                <option value="CLP" label="CLP ($)" {{ $invoice->currency == 'CLP' ? 'selected' : '' }}>CLP ($)</option>
                                <option value="CNY" label="CNY (¥)" {{ $invoice->currency == 'CNY' ? 'selected' : '' }}>CNY (¥)</option>
                                <option value="COP" label="COP (p.)" {{ $invoice->currency == 'COP' ? 'selected' : '' }}>COP (p.)</option>
                                <option value="COU" label="COU" {{ $invoice->currency == 'COU' ? 'selected' : '' }}>COU</option>
                                <option value="CRC" label="CRC (₡)" {{ $invoice->currency == 'CRC' ? 'selected' : '' }}>CRC (₡)</option>
                                <option value="CUC" label="CUC" {{ $invoice->currency == 'CUC' ? 'selected' : '' }}>CUC</option>
                                <option value="CUP" label="CUP (₱)" {{ $invoice->currency == 'CUP' ? 'selected' : '' }}>CUP (₱)</option>
                                <option value="CVE" label="CVE" {{ $invoice->currency == 'CVE' ? 'selected' : '' }}>CVE</option>
                                <option value="CZK" label="CZK (Kč)" {{ $invoice->currency == 'CZK' ? 'selected' : '' }}>CZK (Kč)</option>
                                <option value="DJF" label="DJF (CHF)" {{ $invoice->currency == 'DJF' ? 'selected' : '' }}>DJF (CHF)</option>
                                <option value="DKK" label="DKK (kr)" {{ $invoice->currency == 'DKK' ? 'selected' : '' }}>DKK (kr)</option>
                                <option value="DOP" label="DOP (RD$)" {{ $invoice->currency == 'DOP' ? 'selected' : '' }}>DOP (RD$)</option>
                                <option value="DZD" label="DZD" {{ $invoice->currency == 'DZD' ? 'selected' : '' }}>DZD</option>
                                <option value="EGP" label="EGP (E£)" {{ $invoice->currency == 'EGP' ? 'selected' : '' }}>EGP (E£)</option>
                                <option value="ERN" label="ERN" {{ $invoice->currency == 'ERN' ? 'selected' : '' }}>ERN</option>
                                <option value="ETB" label="ETB" {{ $invoice->currency == 'ETB' ? 'selected' : '' }}>ETB</option>
                                <option value="EUR" label="EUR (€)" {{ $invoice->currency == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                <option value="FJD" label="FJD ($)" {{ $invoice->currency == 'FJD' ? 'selected' : '' }}>FJD ($)</option>
                                <option value="FKP" label="FKP (£)" {{ $invoice->currency == 'FKP' ? 'selected' : '' }}>FKP (£)</option>
                                <option value="GBP" label="GBP (£)" {{ $invoice->currency == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                <option value="GEL" label="GEL" {{ $invoice->currency == 'GEL' ? 'selected' : '' }}>GEL</option>
                                <option value="GHS" label="GHS (GH¢)" {{ $invoice->currency == 'GHS' ? 'selected' : '' }}>GHS (GH¢)</option>
                                <option value="GIP" label="GIP (£)" {{ $invoice->currency == 'GIP' ? 'selected' : '' }}>GIP (£)</option>
                                <option value="GMD" label="GMD" {{ $invoice->currency == 'GMD' ? 'selected' : '' }}>GMD</option>
                                <option value="GNF" label="GNF" {{ $invoice->currency == 'GNF' ? 'selected' : '' }}>GNF</option>
                                <option value="GTQ" label="GTQ (Q)" {{ $invoice->currency == 'GTQ' ? 'selected' : '' }}>GTQ (Q)</option>
                                <option value="GYD" label="GYD ($)" {{ $invoice->currency == 'GYD' ? 'selected' : '' }}>GYD ($)</option>
                                <option value="HKD" label="HKD (HK$)" {{ $invoice->currency == 'HKD' ? 'selected' : '' }}>HKD (HK$)</option>
                                <option value="HNL" label="HNL (L)" {{ $invoice->currency == 'HNL' ? 'selected' : '' }}>HNL (L)</option>
                                <option value="HRK" label="HRK (kn)" {{ $invoice->currency == 'HRK' ? 'selected' : '' }}>HRK (kn)</option>
                                <option value="HTG" label="HTG" {{ $invoice->currency == 'HTG' ? 'selected' : '' }}>HTG</option>
                                <option value="HUF" label="HUF (Ft)" {{ $invoice->currency == 'HUF' ? 'selected' : '' }}>HUF (Ft)</option>
                                <option value="IDR" label="IDR (Rp)" {{ $invoice->currency == 'IDR' ? 'selected' : '' }}>IDR (Rp)</option>
                                <option value="ILS" label="ILS (₪)" {{ $invoice->currency == 'ILS' ? 'selected' : '' }}>ILS (₪)</option>
                                <option value="INR" label="INR (Rs)" {{ $invoice->currency == 'INR' ? 'selected' : '' }}>INR (Rs)</option>
                                <option value="IQD" label="IQD" {{ $invoice->currency == 'IQD' ? 'selected' : '' }}>IQD</option>
                                <option value="IRR" label="IRR" {{ $invoice->currency == 'IRR' ? 'selected' : '' }}>IRR</option>
                                <option value="ISK" label="ISK (kr)" {{ $invoice->currency == 'ISK' ? 'selected' : '' }}>ISK (kr)</option>
                                <option value="JMD" label="JMD (J$)" {{ $invoice->currency == 'JMD' ? 'selected' : '' }}>JMD (J$)</option>
                                <option value="JOD" label="JOD" {{ $invoice->currency == 'JOD' ? 'selected' : '' }}>JOD</option>
                                <option value="JPY" label="JPY (¥)" {{ $invoice->currency == 'JPY' ? 'selected' : '' }}>JPY (¥)</option>
                                <option value="KES" label="KES (KSh)" {{ $invoice->currency == 'KES' ? 'selected' : '' }}>KES (KSh)</option>
                                <option value="KGS" label="KGS (лв)" {{ $invoice->currency == 'KGS' ? 'selected' : '' }}>KGS (лв)</option>
                                <option value="KHR" label="KHR (៛)" {{ $invoice->currency == 'KHR' ? 'selected' : '' }}>KHR (៛)</option>
                                <option value="KMF" label="KMF" {{ $invoice->currency == 'KMF' ? 'selected' : '' }}>KMF</option>
                                <option value="KPW" label="KPW (₩)" {{ $invoice->currency == 'KPW' ? 'selected' : '' }}>KPW (₩)</option>
                                <option value="KRW" label="KRW (₩)" {{ $invoice->currency == 'KRW' ? 'selected' : '' }}>KRW (₩)</option>
                                <option value="KWD" label="KWD (ك)" {{ $invoice->currency == 'KWD' ? 'selected' : '' }}>KWD (ك)</option>
                                <option value="KYD" label="KYD ($)" {{ $invoice->currency == 'KYD' ? 'selected' : '' }}>KYD ($)</option>
                                <option value="KZT" label="KZT (лв)" {{ $invoice->currency == 'KZT' ? 'selected' : '' }}>KZT (лв)</option>
                                <option value="LAK" label="LAK (₭)" {{ $invoice->currency == 'LAK' ? 'selected' : '' }}>LAK (₭)</option>
                                <option value="LBP" label="LBP (£)" {{ $invoice->currency == 'LBP' ? 'selected' : '' }}>LBP (£)</option>
                                <option value="LKR" label="LKR (Rs)" {{ $invoice->currency == 'LKR' ? 'selected' : '' }}>LKR (Rs)</option>
                                <option value="LRD" label="LRD ($)" {{ $invoice->currency == 'LRD' ? 'selected' : '' }}>LRD ($)</option>
                                <option value="LSL" label="LSL" {{ $invoice->currency == 'LSL' ? 'selected' : '' }}>LSL</option>
                                <option value="LYD" label="LYD (LD)" {{ $invoice->currency == 'LYD' ? 'selected' : '' }}>LYD (LD)</option>
                                <option value="MAD" label="MAD" {{ $invoice->currency == 'MAD' ? 'selected' : '' }}>MAD</option>
                                <option value="MDL" label="MDL" {{ $invoice->currency == 'MDL' ? 'selected' : '' }}>MDL</option>
                                <option value="MGA" label="MGA" {{ $invoice->currency == 'MGA' ? 'selected' : '' }}>MGA</option>
                                <option value="MKD" label="MKD (ден)" {{ $invoice->currency == 'MKD' ? 'selected' : '' }}>MKD (ден)</option>
                                <option value="MMK" label="MMK (K)" {{ $invoice->currency == 'MMK' ? 'selected' : '' }}>MMK (K)</option>
                                <option value="MNT" label="MNT (₮)" {{ $invoice->currency == 'MNT' ? 'selected' : '' }}>MNT (₮)</option>
                                <option value="MOP" label="MOP (P)" {{ $invoice->currency == 'MOP' ? 'selected' : '' }}>MOP (P)</option>
                                <option value="MRU" label="MRU" {{ $invoice->currency == 'MRU' ? 'selected' : '' }}>MRU</option>
                                <option value="MUR" label="MUR (₨)" {{ $invoice->currency == 'MUR' ? 'selected' : '' }}>MUR (₨)</option>
                                <option value="MVR" label="MVR (Rf)" {{ $invoice->currency == 'MVR' ? 'selected' : '' }}>MVR (Rf)</option>
                                <option value="MWK" label="MWK (MK)" {{ $invoice->currency == 'MWK' ? 'selected' : '' }}>MWK (MK)</option>
                                <option value="MXN" label="MXN ($)" {{ $invoice->currency == 'MXN' ? 'selected' : '' }}>MXN ($)</option>
                                <option value="MXV" label="MXV" {{ $invoice->currency == 'MXV' ? 'selected' : '' }}>MXV</option>
                                <option value="MYR" label="MYR (RM)" {{ $invoice->currency == 'MYR' ? 'selected' : '' }}>MYR (RM)</option>
                                <option value="MZN" label="MZN (MT)" {{ $invoice->currency == 'MZN' ? 'selected' : '' }}>MZN (MT)</option>
                                <option value="NAD" label="NAD (N$" {{ $invoice->currency == 'NAD' ? 'selected' : '' }}>NAD (N$)</option>
                                <option value="NGN" label="NGN (₦)" {{ $invoice->currency == 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                                <option value="NIO" label="NIO (C$)" {{ $invoice->currency == 'NIO' ? 'selected' : '' }}>NIO (C$)</option>
                                <option value="NOK" label="NOK (kr)" {{ $invoice->currency == 'NOK' ? 'selected' : '' }}>NOK (kr)</option>
                                <option value="NPR" label="NPR (₨)" {{ $invoice->currency == 'NPR' ? 'selected' : '' }}>NPR (₨)</option>
                                <option value="NZD" label="NZD ($)" {{ $invoice->currency == 'NZD' ? 'selected' : '' }}>NZD ($)</option>
                                <option value="OMR" label="OMR (ر.ع.)" {{ $invoice->currency == 'OMR' ? 'selected' : '' }}>OMR (ر.ع.)</option>
                                <option value="PAB" label="PAB (B/.)" {{ $invoice->currency == 'PAB' ? 'selected' : '' }}>PAB (B/.)</option>
                                <option value="PEN" label="PEN (S/.)" {{ $invoice->currency == 'PEN' ? 'selected' : '' }}>PEN (S/.)</option>
                                <option value="PGK" label="PGK (K)" {{ $invoice->currency == 'PGK' ? 'selected' : '' }}>PGK (K)</option>
                                <option value="PHP" label="PHP (₱)" {{ $invoice->currency == 'PHP' ? 'selected' : '' }}>PHP (₱)</option>
                                <option value="PKR" label="PKR (₨)" {{ $invoice->currency == 'PKR' ? 'selected' : '' }}>PKR (₨)</option>
                                <option value="PLN" label="PLN (zł)" {{ $invoice->currency == 'PLN' ? 'selected' : '' }}>PLN (zł)</option>
                                <option value="PYG" label="PYG (₲)" {{ $invoice->currency == 'PYG' ? 'selected' : '' }}>PYG (₲)</option>
                                <option value="QAR" label="QAR (ر.ق)" {{ $invoice->currency == 'QAR' ? 'selected' : '' }}>QAR (ر.ق)</option>
                                <option value="RON" label="RON (L)" {{ $invoice->currency == 'RON' ? 'selected' : '' }}>RON (L)</option>
                                <option value="RSD" label="RSD (Дин.)" {{ $invoice->currency == 'RSD' ? 'selected' : '' }}>RSD (Дин.)</option>
                                <option value="RUB" label="RUB (₽)" {{ $invoice->currency == 'RUB' ? 'selected' : '' }}>RUB (₽)</option>
                                <option value="RWF" label="RWF" {{ $invoice->currency == 'RWF' ? 'selected' : '' }}>RWF</option>
                                <option value="SAR" label="SAR (ر.س)" {{ $invoice->currency == 'SAR' ? 'selected' : '' }}>SAR (ر.س)</option>
                                <option value="SBD" label="SBD ($)" {{ $invoice->currency == 'SBD' ? 'selected' : '' }}>SBD ($)</option>
                                <option value="SCR" label="SCR (₨)" {{ $invoice->currency == 'SCR' ? 'selected' : '' }}>SCR (₨)</option>
                                <option value="SDG" label="SDG" {{ $invoice->currency == 'SDG' ? 'selected' : '' }}>SDG</option>
                                <option value="SEK" label="SEK (kr)" {{ $invoice->currency == 'SEK' ? 'selected' : '' }}>SEK (kr)</option>
                                <option value="SGD" label="SGD ($)" {{ $invoice->currency == 'SGD' ? 'selected' : '' }}>SGD ($)</option>
                                <option value="SHP" label="SHP (£)" {{ $invoice->currency == 'SHP' ? 'selected' : '' }}>SHP (£)</option>
                                <option value="SLL" label="SLL" {{ $invoice->currency == 'SLL' ? 'selected' : '' }}>SLL</option>
                                <option value="SOS" label="SOS (S)" {{ $invoice->currency == 'SOS' ? 'selected' : '' }}>SOS (S)</option>
                                <option value="SRD" label="SRD ($)" {{ $invoice->currency == 'SRD' ? 'selected' : '' }}>SRD ($)</option>
                                <option value="SSP" label="SSP" {{ $invoice->currency == 'SSP' ? 'selected' : '' }}>SSP</option>
                                <option value="STN" label="STN (Db)" {{ $invoice->currency == 'STN' ? 'selected' : '' }}>STN (Db)</option>
                                <option value="SVC" label="SVC ($)" {{ $invoice->currency == 'SVC' ? 'selected' : '' }}>SVC ($)</option>
                                <option value="SYP" label="SYP (£)" {{ $invoice->currency == 'SYP' ? 'selected' : '' }}>SYP (£)</option>
                                <option value="SZL" label="SZL" {{ $invoice->currency == 'SZL' ? 'selected' : '' }}>SZL</option>
                                <option value="THB" label="THB (฿)" {{ $invoice->currency == 'THB' ? 'selected' : '' }}>THB (฿)</option>
                                <option value="TJS" label="TJS (ЅМ)" {{ $invoice->currency == 'TJS' ? 'selected' : '' }}>TJS (ЅМ)</option>
                                <option value="TMT" label="TMT" {{ $invoice->currency == 'TMT' ? 'selected' : '' }}>TMT</option>
                                <option value="TND" label="TND" {{ $invoice->currency == 'TND' ? 'selected' : '' }}>TND</option>
                                <option value="TOP" label="TOP (T$)" {{ $invoice->currency == 'TOP' ? 'selected' : '' }}>TOP (T$)</option>
                                <option value="TRY" label="TRY (₺)" {{ $invoice->currency == 'TRY' ? 'selected' : '' }}>TRY (₺)</option>
                                <option value="TTD" label="TTD (TT$)" {{ $invoice->currency == 'TTD' ? 'selected' : '' }}>TTD (TT$)</option>
                                <option value="TWD" label="TWD (NT$)" {{ $invoice->currency == 'TWD' ? 'selected' : '' }}>TWD (NT$)</option>
                                <option value="TZS" label="TZS (TSh)" {{ $invoice->currency == 'TZS' ? 'selected' : '' }}>TZS (TSh)</option>
                                <option value="UAH" label="UAH (₴)" {{ $invoice->currency == 'UAH' ? 'selected' : '' }}>UAH (₴)</option>
                                <option value="UGX" label="UGX (USh)" {{ $invoice->currency == 'UGX' ? 'selected' : '' }}>UGX (USh)</option>
                                <option value="USD" label="USD ($)" {{ $invoice->currency == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="USN" label="USN" {{ $invoice->currency == 'USN' ? 'selected' : '' }}>USN</option>
                                <option value="UYI" label="UYI" {{ $invoice->currency == 'UYI' ? 'selected' : '' }}>UYI</option>
                                <option value="UYU" label="UYU ($U)" {{ $invoice->currency == 'UYU' ? 'selected' : '' }}>UYU ($U)</option>
                                <option value="UZS" label="UZS (лв)" {{ $invoice->currency == 'UZS' ? 'selected' : '' }}>UZS (лв)</option>
                                <option value="VES" label="VES" {{ $invoice->currency == 'VES' ? 'selected' : '' }}>VES</option>
                                <option value="VND" label="VND (₫)" {{ $invoice->currency == 'VND' ? 'selected' : '' }}>VND (₫)</option>
                                <option value="VUV" label="VUV (VT)" {{ $invoice->currency == 'VUV' ? 'selected' : '' }}>VUV (VT)</option>
                                <option value="WST" label="WST (T)" {{ $invoice->currency == 'WST' ? 'selected' : '' }}>WST (T)</option>
                                <option value="XAF" label="XAF" {{ $invoice->currency == 'XAF' ? 'selected' : '' }}>XAF</option>
                                <option value="XCD" label="XCD ($)" {{ $invoice->currency == 'XCD' ? 'selected' : '' }}>XCD ($)</option>
                                <option value="XOF" label="XOF" {{ $invoice->currency == 'XOF' ? 'selected' : '' }}>XOF</option>
                                <option value="XPF" label="XPF (₣)" {{ $invoice->currency == 'XPF' ? 'selected' : '' }}>XPF (₣)</option>
                                <option value="YER" label="YER" {{ $invoice->currency == 'YER' ? 'selected' : '' }}>YER</option>
                                <option value="ZAR" label="ZAR (R)" {{ $invoice->currency == 'ZAR' ? 'selected' : '' }}>ZAR (R)</option>
                                <option value="ZMW" label="ZMW (ZK)" {{ $invoice->currency == 'ZMW' ? 'selected' : '' }}>ZMW (ZK)</option>
                                <option value="ZWL" label="ZWL ($)" {{ $invoice->currency == 'ZWL' ? 'selected' : '' }}>ZWL ($)</option>
                            </select>

                            <br>
                            <label for="typeList">TYPE</label>
                            <select class="form-select" id="typeList" name="type">
                                <option value="Invoice" label="Invoice" {{ $invoice->type == 'Invoice' ? 'selected' : '' }}>Invoice</option>
                                <option value="Credit Note" label="Credit Note" {{ $invoice->type == 'Credit Note' ? 'selected' : '' }}>Credit Note</option>
                                <option value="Quote" label="Quote" {{ $invoice->type == 'Quote' ? 'selected' : '' }}>Quote</option>
                                <option value="Purchase Order" label="Purchase Order" {{ $invoice->type == 'Purchase Order' ? 'selected' : '' }}>Purchase Order</option>
                                <option value="Receipt" label="Receipt" {{ $invoice->type == 'Receipt' ? 'selected' : '' }}>Receipt</option>
                            </select>
                            <br>
                            <label for="payment_status">Payment satus</label>
                            <select class="form-select" id="payment_status" name="payment_status">
                                <option value="Completed" label="Completed" {{ $invoice->payment_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Pending" label="Pending" {{ $invoice->payment_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            <br>
                            <label for="payment_type">Payment type</label>
                            <select class="form-select" id="payment_type" name="payment_type">
                                <option value="Credit Card" label="Credit Card" {{ $invoice->payment_type == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="Debit Card" label="Debit Card" {{ $invoice->payment_type == 'Debit Card' ? 'selected' : '' }}>Debit Card</option>
                                <option value="PayPal" label="PayPal" {{ $invoice->payment_type == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                                <option value="COD" label="COD" {{ $invoice->payment_type == 'COD' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                                <option value="Google Pay" label="Google Pay" {{ $invoice->payment_type == 'Google Pay' ? 'selected' : '' }}>Google Pay</option>
                            </select>
                            <br><hr><br>
                            <a href="" class="link-title">&nbsp;<i class="fa-solid fa-clock-rotate-left"></i> History</a>
                        
                        </div>
                    
                </div>
            
            </form>
            
        </x-vendor>

		
	</body>
</html>