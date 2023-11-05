@extends('layouts.masterV')
@section('content')
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
        <script src="{{URL::asset('assets/js/addInvoice.js')}}"></script>
        <link href="{{URL::asset('assets/css/addInvoice.css')}}" rel="stylesheet">
        
	</head>
	
	<body>
        


            <form method="POST" action="{{  route('addInvoice.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="container1">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                        <div class="container mt-4 paper left-div" style=" padding: 20px;">
                            <div class="row mt-4">
                                <div class="col-7 form-group">
                                    <img id="uploaded-image" src="{{ old('image') ? asset('storage/' . old('image')) : '' }}" alt="Uploaded Image" class="uploaded-image">
                                    <div class="dropzone" id="dropzone">
                                        <label for="upload-input" id="upload-label">+ add your logo</label>
                                        <input type="file" class="form-control upload-input" id="upload-input" name="image" :value="old('image')">
                                        @error('image')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-5 form-group">
                                    <h1 style="font-size: 35px;margin-bottom: 1px"><span class="selected-value">INVOICE</span></h1>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">#</span>
                                        <x-text-input type="text" class="form-control" aria-describedby="basic-addon1" value="{{ Auth::user()->invoices->count()+1;}}" />
                                    </div>
                                </div>
                            </div>
                            

                            

                            <div class="row mt-4">
                                <div class="col-6">
                                    
                                    <h2 style="font-size: 16px;font-weight: bold;margin-bottom: 1px">From {{ Auth::user()->name }},</h2>
                                    <div class="row" style="padding-top: 50px;">
                                        <div class="col-6">
                                            <label for="receiver" class="form-label">&nbsp;&nbsp;&nbsp;Bill to (Email)</label>
                                            <select class="form-control" name="receiver" id="receiver" style="font-size: 14px;">
                                                @foreach ($emails as $email)
                                                    <option value="{{ $email }}" label="{{ $email }}">{{ $email }}</option>
                                                @endforeach
                                            </select>
                                            @error('receiver')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="adresse" class="form-label">&nbsp;&nbsp;&nbsp;Ship to</label>
                                            <textarea class="form-control" style="resize: none;" rows="2" id="adresse" :value="old('shipping_address')" placeholder="(optional)" name="shipping_address"></textarea>
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
                                            <x-text-input type="date" id="inputDate" class="form-control" name="date" :value="old('date')"  />
                                        </div>
                                        <div class="col-auto">
                                            <label for="inputDate" class="col-form-label">Date</label>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-items-center"  style="padding-top:2px;">
                                        <div class="col-auto" style="width: 200px;">
                                            <x-text-input type="text" id="inputPayTerm" class="form-control" name="payment_terms" :value="old('payment_terms')"  />
                                        </div>
                                        <div class="col-auto">
                                            <label for="inputPayTerm" class="col-form-label">Payment Terms</label>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-items-center" style="padding-top:2px;">
                                        <div class="col-auto" style="width: 200px;">
                                            <x-text-input type="date" id="inputDueDate" class="form-control" name="due_date" :value="old('due_date')"  />
                                        </div>
                                        <div class="col-auto">
                                            <label for="inputDueDate" class="col-form-label">Due Date</label>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-items-center" style="padding-top:2px;">
                                        <div class="col-auto" style="width: 200px;">
                                            <x-text-input id="inputPO" class="form-control" name="po_number" :value="old('po_number')"  />
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
                                    <th width="38%" style="color:white;">Item</th>
                                    <th width="15%" style="color:white;">Quantity</th>
                                    <th width="15%"  style="color:white;">Rate</th>
                                    <th width="15%"  style="color:white;">Amount</th>
                                    </thead>
                                    <tr>
                                    <td><input class="itemRow" type="checkbox"/></td>
                                    <td><input name="productName[]" id="productName_1" class="form-control smaller-cells" autocomplete="off"/></td>
                                    <td><input name="quantity[]" id="quantity_1" class="form-control quantity smaller-cells" autocomplete="off"/></td>
                                    <td><input name="price[]" id="price_1" class="form-control price smaller-cells" autocomplete="off"/></td>
                                    <td><input name="totalI[]" id="total_1" class="form-control total smaller-cells" autocomplete="off"/></td>
                                    </tr>
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
                                            <textarea class="form-control" style="resize: none;" rows="2" id="notes" placeholder="Notes - any relevant information not already covered" name="notes" :value="old('notes')"></textarea>
                                        <br>
                                        <label for="terms" class="form-label">&nbsp;&nbsp;&nbsp;Terms</label>
                                            <textarea class="form-control" style="resize: none;" rows="2" id="terms" placeholder="Terms and conditions - late fees, payment methods, delivery schedule" name="terms" :value="old('terms')"></textarea>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="direction: rtl;">
                                        
                                            <div class="row g-3 align-items-center">
                                                <div class="input-group mb-3" style="direction: ltr; width:250px;">
                                                    <span class="input-group-text" id="basic-addon1"><span class="selected-currency">$</span></span>
                                                    <x-text-input class="form-control" name="subTotal" id="subTotal" aria-describedby="basic-addon1"/>
                                                </div>
                                                <div class="col-auto">
                                                <label for="subTotal" class="col-form-label">: Subtotal</label>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-items-center">
                                                <div class="input-group mb-3" style="direction: ltr; width:250px;">
                                                    <x-text-input class="form-control" name="taxRate" id="taxRate" aria-describedby="basic-addon2"/>
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
                                                    <x-text-input class="form-control" name="taxAmount" id="taxAmount" aria-describedby="basic-addon1"/>
                                                </div>
                                                <div class="col-auto">
                                                    <label for="taxAmount" class="col-form-label">: Tax Amount</label>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 align-items-center">
                                                <!-- Total -->
                                                <div class="input-group mb-3" style="direction: ltr; width: 250px;">
                                                    <span class="input-group-text" id="basic-addon2"><span class="selected-currency">$</span></span>
                                                    <x-text-input class="form-control" name="totalAftertax" id="totalAftertax" aria-describedby="basic-addon2" name="total"/>
                                                </div>
                                                <div class="col-auto">
                                                    <label for="totalAftertax" class="col-form-label">: Total</label>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 align-items-center payment-related-section">
                                                <!-- Amount Paid -->
                                                <div class="input-group mb-3" style="direction: ltr; width: 250px;">
                                                    <span class="input-group-text" id="basic-addon3"><span class="selected-currency">$</span></span>
                                                    <x-text-input class="form-control" name="amountPaid" id="amountPaid" aria-describedby="basic-addon3"/>
                                                </div>
                                                <div class="col-auto">
                                                    <label for="amountPaid" class="col-form-label">: Amount Paid</label>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 align-items-center payment-related-section">
                                                <!-- Amount Due -->
                                                <div class="input-group mb-3" style="direction: ltr; width: 250px;">
                                                    <span class="input-group-text" id="basic-addon4"><span class="selected-currency">$</span></span>
                                                    <x-text-input class="form-control" name="amountDue" id="amountDue" aria-describedby="basic-addon4"/>
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
                            <button type="submit" style="align-self: center; margin-bottom:20px; background-color: green;padding-left: 35px;padding-right: 35px;" class="btn btn-success"><i class="fas fa-download"></i>&nbsp; Save invoice</button>
                            </div>
                            <hr><br>
                            <label for="currencyList">CURRENCY</label>
                            <select class="form-select" id="currencyList" name="currency">
                                    <option value="AED" label="AED (د.إ)">AED (د.إ)</option>
                                    <option value="AFN" label="AFN">AFN</option>
                                    <option value="ALL" label="ALL (Lek)">ALL (Lek)</option>
                                    <option value="AMD" label="AMD">AMD</option>
                                    <option value="ANG" label="ANG (ƒ)">ANG (ƒ)</option>
                                    <option value="AOA" label="AOA (Kz)">AOA (Kz)</option>
                                    <option value="ARS" label="ARS ($)">ARS ($)</option>
                                    <option value="AUD" label="AUD ($)">AUD ($)</option>
                                    <option value="AWG" label="AWG (ƒ)">AWG (ƒ)</option>
                                    <option value="AZN" label="AZN (ман)">AZN (ман)</option>
                                    <option value="BAM" label="BAM (KM)">BAM (KM)</option>
                                    <option value="BBD" label="BBD ($)">BBD ($)</option>
                                    <option value="BDT" label="BDT (Tk)">BDT (Tk)</option>
                                    <option value="BGN" label="BGN (лв)">BGN (лв)</option>
                                    <option value="BHD" label="BHD">BHD</option>
                                    <option value="BIF" label="BIF">BIF</option>
                                    <option value="BMD" label="BMD ($)">BMD ($)</option>
                                    <option value="BND" label="BND ($)">BND ($)</option>
                                    <option value="BOB" label="BOB ($b)">BOB ($b)</option>
                                    <option value="BOV" label="BOV">BOV</option>
                                    <option value="BRL" label="BRL (R$)">BRL (R$)</option>
                                    <option value="BSD" label="BSD ($)">BSD ($)</option>
                                    <option value="BTN" label="BTN">BTN</option>
                                    <option value="BWP" label="BWP (P)">BWP (P)</option>
                                    <option value="BYN" label="BYN (Br)">BYN (Br)</option>
                                    <option value="BZD" label="BZD (BZ$)">BZD (BZ$)</option>
                                    <option value="CAD" label="CAD ($)">CAD ($)</option>
                                    <option value="CDF" label="CDF">CDF</option>
                                    <option value="CHE" label="CHE">CHE</option>
                                    <option value="CHF" label="CHF">CHF</option>
                                    <option value="CHW" label="CHW">CHW</option>
                                    <option value="CLF" label="CLF">CLF</option>
                                    <option value="CLP" label="CLP ($)">CLP ($)</option>
                                    <option value="CNY" label="CNY (¥)">CNY (¥)</option>
                                    <option value="COP" label="COP (p.)">COP (p.)</option>
                                    <option value="COU" label="COU">COU</option>
                                    <option value="CRC" label="CRC (₡)">CRC (₡)</option>
                                    <option value="CUC" label="CUC">CUC</option>
                                    <option value="CUP" label="CUP (₱)">CUP (₱)</option>
                                    <option value="CVE" label="CVE">CVE</option>
                                    <option value="CZK" label="CZK (Kč)">CZK (Kč)</option>
                                    <option value="DJF" label="DJF (CHF)">DJF (CHF)</option>
                                    <option value="DKK" label="DKK (kr)">DKK (kr)</option>
                                    <option value="DOP" label="DOP (RD$)">DOP (RD$)</option>
                                    <option value="DZD" label="DZD">DZD</option>
                                    <option value="EGP" label="EGP (E£)">EGP (E£)</option>
                                    <option value="ERN" label="ERN">ERN</option>
                                    <option value="ETB" label="ETB">ETB</option>
                                    <option value="EUR" label="EUR (€)">EUR (€)</option>
                                    <option value="FJD" label="FJD ($)">FJD ($)</option>
                                    <option value="FKP" label="FKP (£)">FKP (£)</option>
                                    <option value="GBP" label="GBP (£)">GBP (£)</option>
                                    <option value="GEL" label="GEL">GEL</option>
                                    <option value="GHS" label="GHS (GH¢)">GHS (GH¢)</option>
                                    <option value="GIP" label="GIP (£)">GIP (£)</option>
                                    <option value="GMD" label="GMD">GMD</option>
                                    <option value="GNF" label="GNF">GNF</option>
                                    <option value="GTQ" label="GTQ (Q)">GTQ (Q)</option>
                                    <option value="GYD" label="GYD ($)">GYD ($)</option>
                                    <option value="HKD" label="HKD (HK$)">HKD (HK$)</option>
                                    <option value="HNL" label="HNL (L)">HNL (L)</option>
                                    <option value="HRK" label="HRK (kn)">HRK (kn)</option>
                                    <option value="HTG" label="HTG">HTG</option>
                                    <option value="HUF" label="HUF (Ft)">HUF (Ft)</option>
                                    <option value="IDR" label="IDR (Rp)">IDR (Rp)</option>
                                    <option value="ILS" label="ILS (₪)">ILS (₪)</option>
                                    <option value="INR" label="INR (Rs)">INR (Rs)</option>
                                    <option value="IQD" label="IQD">IQD</option>
                                    <option value="IRR" label="IRR">IRR</option>
                                    <option value="ISK" label="ISK (kr)">ISK (kr)</option>
                                    <option value="JMD" label="JMD (J$)">JMD (J$)</option>
                                    <option value="JOD" label="JOD">JOD</option>
                                    <option value="JPY" label="JPY (¥)">JPY (¥)</option>
                                    <option value="KES" label="KES (KSh)">KES (KSh)</option>
                                    <option value="KGS" label="KGS (лв)">KGS (лв)</option>
                                    <option value="KHR" label="KHR (៛)">KHR (៛)</option>
                                    <option value="KMF" label="KMF">KMF</option>
                                    <option value="KPW" label="KPW (₩)">KPW (₩)</option>
                                    <option value="KRW" label="KRW (₩)">KRW (₩)</option>
                                    <option value="KWD" label="KWD (ك)">KWD (ك)</option>
                                    <option value="KYD" label="KYD ($)">KYD ($)</option>
                                    <option value="KZT" label="KZT (лв)">KZT (лв)</option>
                                    <option value="LAK" label="LAK (₭)">LAK (₭)</option>
                                    <option value="LBP" label="LBP (£)">LBP (£)</option>
                                    <option value="LKR" label="LKR (Rs)">LKR (Rs)</option>
                                    <option value="LRD" label="LRD ($)">LRD ($)</option>
                                    <option value="LSL" label="LSL">LSL</option>
                                    <option value="LYD" label="LYD (LD)">LYD (LD)</option>
                                    <option value="MAD" label="MAD">MAD</option>
                                    <option value="MDL" label="MDL">MDL</option>
                                    <option value="MGA" label="MGA">MGA</option>
                                    <option value="MKD" label="MKD (ден)">MKD (ден)</option>
                                    <option value="MMK" label="MMK">MMK</option>
                                    <option value="MNT" label="MNT (₮)">MNT (₮)</option>
                                    <option value="MOP" label="MOP">MOP</option>
                                    <option value="MRU" label="MRU">MRU</option>
                                    <option value="MUR" label="MUR (Rs)">MUR (Rs)</option>
                                    <option value="MVR" label="MVR">MVR</option>
                                    <option value="MWK" label="MWK">MWK</option>
                                    <option value="MXN" label="MXN ($)">MXN ($)</option>
                                    <option value="MXV" label="MXV">MXV</option>
                                    <option value="MYR" label="MYR (RM)">MYR (RM)</option>
                                    <option value="MZN" label="MZN (MT)">MZN (MT)</option>
                                    <option value="NAD" label="NAD (N$)">NAD (N$)</option>
                                    <option value="NGN" label="NGN (₦)">NGN (₦)</option>
                                    <option value="NIO" label="NIO (C$)">NIO (C$)</option>
                                    <option value="NOK" label="NOK (kr)">NOK (kr)</option>
                                    <option value="NPR" label="NPR (Rs)">NPR (Rs)</option>
                                    <option value="NZD" label="NZD ($)">NZD ($)</option>
                                    <option value="OMR" label="OMR">OMR</option>
                                    <option value="PAB" label="PAB (B/.)">PAB (B/.)</option>
                                    <option value="PEN" label="PEN (S/.)">PEN (S/.)</option>
                                    <option value="PGK" label="PGK">PGK</option>
                                    <option value="PHP" label="PHP (₱)">PHP (₱)</option>
                                    <option value="PKR" label="PKR (Rs)">PKR (Rs)</option>
                                    <option value="PLN" label="PLN (zł)">PLN (zł)</option>
                                    <option value="PYG" label="PYG (Gs)">PYG (Gs)</option>
                                    <option value="QAR" label="QAR">QAR</option>
                                    <option value="RON" label="RON (lei)">RON (lei)</option>
                                    <option value="RSD" label="RSD (Дин.)">RSD (Дин.)</option>
                                    <option value="RUB" label="RUB (руб)">RUB (руб)</option>
                                    <option value="RWF" label="RWF">RWF</option>
                                    <option value="SAR" label="SAR">SAR</option>
                                    <option value="SBD" label="SBD ($)">SBD ($)</option>
                                    <option value="SCR" label="SCR (Rs)">SCR (Rs)</option>
                                    <option value="SDG" label="SDG">SDG</option>
                                    <option value="SEK" label="SEK (kr)">SEK (kr)</option>
                                    <option value="SGD" label="SGD ($)">SGD ($)</option>
                                    <option value="SHP" label="SHP (£)">SHP (£)</option>
                                    <option value="SLL" label="SLL">SLL</option>
                                    <option value="SOS" label="SOS (S)">SOS (S)</option>
                                    <option value="SRD" label="SRD ($)">SRD ($)</option>
                                    <option value="SSP" label="SSP">SSP</option>
                                    <option value="STN" label="STN">STN</option>
                                    <option value="SVC" label="SVC ($)">SVC ($)</option>
                                    <option value="SYP" label="SYP (£)">SYP (£)</option>
                                    <option value="SZL" label="SZL">SZL</option>
                                    <option value="THB" label="THB (฿)">THB (฿)</option>
                                    <option value="TJS" label="TJS">TJS</option>
                                    <option value="TMT" label="TMT">TMT</option>
                                    <option value="TND" label="TND (DT)">TND (DT)</option>
                                    <option value="TOP" label="TOP">TOP</option>
                                    <option value="TRY" label="TRY">TRY</option>
                                    <option value="TTD" label="TTD (TT$)">TTD (TT$)</option>
                                    <option value="TWD" label="TWD (NT$)">TWD (NT$)</option>
                                    <option value="TZS" label="TZS (TSh)">TZS (TSh)</option>
                                    <option value="UAH" label="UAH (₴)">UAH (₴)</option>
                                    <option value="UGX" label="UGX (USh)">UGX (USh)</option>
                                    <option value="USD" selected="selected" label="USD ($)">USD ($)</option>
                                    <option value="USN" label="USN">USN</option>
                                    <option value="UYI" label="UYI">UYI</option>
                                    <option value="UYU" label="UYU ($U)">UYU ($U)</option>
                                    <option value="UYW" label="UYW">UYW</option>
                                    <option value="UZS" label="UZS (лв)">UZS (лв)</option>
                                    <option value="VES" label="VES">VES</option>
                                    <option value="VND" label="VND (₫)">VND (₫)</option>
                                    <option value="VUV" label="VUV">VUV</option>
                                    <option value="WST" label="WST">WST</option>
                                    <option value="XAF" label="XAF">XAF</option>
                                    <option value="XAG" label="XAG">XAG</option>
                                    <option value="XAU" label="XAU">XAU</option>
                                    <option value="XBA" label="XBA">XBA</option>
                                    <option value="XBB" label="XBB">XBB</option>
                                    <option value="XBC" label="XBC">XBC</option>
                                    <option value="XBD" label="XBD">XBD</option>
                                    <option value="XCD" label="XCD ($)">XCD ($)</option>
                                    <option value="XDR" label="XDR">XDR</option>
                                    <option value="XOF" label="XOF">XOF</option>
                                    <option value="XPD" label="XPD">XPD</option>
                                    <option value="XPF" label="XPF">XPF</option>
                                    <option value="XPT" label="XPT">XPT</option>
                                    <option value="XSU" label="XSU">XSU</option>
                                    <option value="XTS" label="XTS">XTS</option>
                                    <option value="XUA" label="XUA">XUA</option>
                                    <option value="XXX" label="XXX">XXX</option>
                                    <option value="YER" label="YER">YER</option>
                                    <option value="ZAR" label="ZAR (R)">ZAR (R)</option>
                                    <option value="ZMW" label="ZMW (ZK)">ZMW (ZK)</option>
                                    <option value="ZWL" label="ZWL">ZWL</option>
                            </select>
                            <br>
                            <label for="typeList">TYPE</label>
                            <select class="form-select" id="typeList" name="type">
                                <option value="Invoice" label="Invoice" selected="selected">Invoice</option>
                                <option value="Credit Note" label="Credit Note">Credit Note</option>
                                <option value="Quote" label="Quote">Quote</option>
                                <option value="Purchase Order" label="Purchase Order">Purchase Order</option>
                                <option value="Receipt" label="Receipt">Receipt</option>
                            </select>
                            <br>
                            <label for="payment_status">Payment satus</label>
                            <select class="form-select" id="payment_status" name="payment_status">
                                <option value="Completed" label="Completed">Completed</option>
                                <option value="Pending" label="Pending" selected="selected">Pending</option>
                            </select>
                            <br>
                            <label for="payment_type">Payment type</label>
                            <select class="form-select" id="payment_type" name="payment_type">
                                <option value="Credit Card" label="Credit Card" selected="selected">Credit Card</option>
                                <option value="Debit Card" label="Debit Card">Debit Card</option>
                                <option value="PayPal" label="PayPal">PayPal</option>
                                <option value="COD" label="COD">Cash on Delivery (COD)</option>
                                <option value="Google Pay" label="Google Pay">Google Pay</option>
                            </select>
                            <br><hr><br>
                            <a href="" class="link-title">&nbsp;<i class="fa-solid fa-clock-rotate-left"></i> History</a>
                        
                        </div>
                    
                </div>
            
            </form>
            
     
		
	</body>
</html>
@endsection
