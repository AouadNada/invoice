<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/v4-font-face.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Invoices</title>

    <style>
        .container1 {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            font-size: 13px;
        }
        
        .paper {
            width: 90%;
            max-width: 900px;
            margin: 20px auto;
            border: 1px solid #ccc;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        
        .container1 {
            display: flex;
            align-items: flex-start;
            white-space: nowrap; /* Prevent line breaks */
        }
        
        .left-div, .right-div {
            display: inline-block;
        }

        .left-div {
            width: 70%; 
        }

        .right-div{
            width: 25%; 
            padding-top: 30px;
        }

        .dropzone {
            width: 200px;
            height: 100px;
            border: 1px solid #dbdada;
            background-color: #f4f4f4;
            border-radius: 3px;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center content vertically */
            align-items: center; /* Center content horizontally */
            text-align: center;
            font-family: "Inter", Arial, Helvetica, sans-serif;
            color: #999;
            position: relative; /* Add this */
        }

        .upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 200px;
            height: 100px;
            opacity: 0;
        }
        
        .uploaded-image {
            max-width: 100%;
            max-height: 100%;
            max-width: 200px;
            max-height: 200px;
            top: 0; /* Add this */
            left: 0; /* Add this */
            display: none;
        }

        /* Custom CSS to adjust cell height */
        .smaller-cells {
            padding: 4px 8px; /* Adjust the padding as needed */
            font-size: 14px; /* Adjust the font size as needed */
            line-height: 1; /* Adjust the line-height as needed */
        }

        /* Custom CSS to change the size of the placeholder text */
        .form-control::placeholder {
            font-size: 13px; /* Adjust the font size as needed */
            /* You can also add other styles, such as color and font-family */
            color: #999;
            font-family: Arial, sans-serif;
        }

        .link-title {
            display: block; /* Ensures the link takes up the full width */
            font-size: 24px; /* Adjust the font size as needed */
            color: #252525; /* Adjust the color as needed */
            text-decoration: none; /* Remove underline from the link */
            margin-bottom: 10px; /* Add spacing at the bottom */
        }

        .link-title:hover {
            color: darkgreen;
        }
          
  
    </style>

    <script>
        $(document).ready(function() {
            //get img input
            $('#upload-input').on('change', function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();
        
                reader.onload = function(event) {
                    
                    $('#dropzone').css('display', 'none');
                    $('#uploaded-image').attr('src', event.target.result);
                    $('#uploaded-image').css('display', 'block');

                };
        
                reader.readAsDataURL(file);
        
                $(this).val('');
            });
            //<label for="upload-input" id="upload-label">+ add your logo</label>
            //<input type="file" class="upload-input" id="upload-input" />
            //<img id="uploaded-image" src="" alt="Uploaded Image" class="uploaded-image">
            //check all rows
            $(document).on('click', '#checkAll', function() {          	
                $(".itemRow").prop("checked", this.checked);
            });	
            // verifier for 1 element check
            $(document).on('click', '.itemRow', function() {  	
                if ($('.itemRow:checked').length == $('.itemRow').length) {
                    $('#checkAll').prop('checked', true);
                } else {
                    $('#checkAll').prop('checked', false);
                }
            }); 
            // Add Row
            $(document).on('click', '#addRows', function() {
                var rowCount = $('#invoiceItem tbody tr').length;
                var newRow = `
                    <tr>
                        <td><input class="itemRow smaller-cells" type="checkbox"></td>
                        <td><input type="text" name="productName[]" id="productName_${rowCount + 1}" class="form-control smaller-cells" autocomplete="off"></td>
                        <td><input type="number" name="quantity[]" id="quantity_${rowCount + 1}" class="form-control quantity smaller-cells" autocomplete="off"></td>
                        <td><input type="number" name="price[]" id="price_${rowCount + 1}" class="form-control price smaller-cells" autocomplete="off"></td>
                        <td><input type="number" name="total[]" id="total_${rowCount + 1}" class="form-control total smaller-cells" autocomplete="off"></td>
                    </tr>
                `;
                $('#invoiceItem tbody').append(newRow);
            });

            // Remove Rows
            $(document).on('click', '#removeRows', function() {
                $('#invoiceItem tbody').find('.itemRow:checked').closest('tr').remove();
            });
            ////////// CALCUL
            $(document).on('blur', "[id^=quantity_]", function(){
                calculateTotal();
            });	
            $(document).on('blur', "[id^=price_]", function(){
                calculateTotal();
            });	
            $(document).on('blur', "#taxRate", function(){		
                calculateTotal();
            });	
            $(document).on('blur', "#amountPaid", function(){
                var amountPaid = $(this).val();
                var totalAftertax = $('#totalAftertax').val();	
                if(amountPaid && totalAftertax) {
                    totalAftertax = totalAftertax-amountPaid;			
                    $('#amountDue').val(totalAftertax);
                } else {
                    $('#amountDue').val(totalAftertax);
                }	
            });	
        });
        function calculateTotal(){
            var totalAmount = 0; 
            $("[id^='price_']").each(function() {
                var id = $(this).attr('id');
                id = id.replace("price_",'');
                var price = $('#price_'+id).val();
                var quantity  = $('#quantity_'+id).val();
                if(!quantity) {
                    quantity = 1;
                }
                var total = price*quantity;
                $('#total_'+id).val(parseFloat(total));
                totalAmount += total;			
            });
            $('#subTotal').val(parseFloat(totalAmount));	
            var taxRate = $("#taxRate").val();
            var subTotal = $('#subTotal').val();	
            if(subTotal) {
                var taxAmount = subTotal*taxRate/100;
                $('#taxAmount').val(taxAmount);
                subTotal = parseFloat(subTotal)+parseFloat(taxAmount);
                $('#totalAftertax').val(subTotal);		
                var amountPaid = $('#amountPaid').val();
                var totalAftertax = $('#totalAftertax').val();	
                if(amountPaid && totalAftertax) {
                    totalAftertax = totalAftertax-amountPaid;			
                    $('#amountDue').val(totalAftertax);
                } else {		
                    $('#amountDue').val(subTotal);
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const currencyList = document.getElementById("currencyList");
            const selectedCurrencyDisplays = document.querySelectorAll(".selected-currency");

            currencyList.addEventListener("change", function() {
                const selectedOption = currencyList.options[currencyList.selectedIndex];
                const selectedCurrency = selectedOption.getAttribute("label") || "$";

                selectedCurrencyDisplays.forEach(display => {
                    display.textContent = selectedCurrency;
                });
            });
        });

        
    </script>

</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
                <img src="{{ asset('assets/img/ocp.png') }}" alt="Logo" style="width:50px;height:55px;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" style="color:white;" href="{{ route('login') }}"><i class="fa-solid fa-user"></i>&nbsp; Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color:white;padding-left:20px;" href="{{ route('register') }}"> <i class="fa-solid fa-user-plus"></i> Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <div class="container1">
        <div class="container mt-4 paper left-div">
            <div class="row mt-4">
                <div class="col-7">
                    <img id="uploaded-image" src="" alt="Uploaded Image" class="uploaded-image">
                    <div class="dropzone" id="dropzone">
                        <label for="upload-input" id="upload-label">+ add your logo</label>
                        <input type="file" class="upload-input" id="upload-input" />
                    </div>
                </div>
                <div class="col-5">
                    <h1>INVOICE</h1>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">#</span>
                        <input type="text" class="form-control" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-6">
                    <textarea class="form-control" rows="2" style="position: absolute; width: 350px; resize: none;" id="sender" placeholder="Who is this invoice from? (required)"></textarea>        
                    <div class="row" style="padding-top: 70px;">
                        <div class="col-6">
                            <label for="receiver" class="form-label">&nbsp;&nbsp;&nbsp;Bill to</label>
                            <textarea class="form-control" style="resize: none;" rows="2" id="receiver" placeholder="Who is this invoice to? (required)"></textarea>
                        </div>
                        <div class="col-6">
                            <label for="receiver" class="form-label">&nbsp;&nbsp;&nbsp;Ship to</label>
                            <textarea class="form-control" style="resize: none;" rows="2" id="receiver" placeholder="(optional)"></textarea>
                        </div>
                    </div>
                </div>
     <!-- /////////////////////////////////// -->
                <div class="col-6" style="direction: rtl;">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto" style="width: 200px;">
                            <input type="date" id="inputDate" class="form-control">
                        </div>
                        <div class="col-auto">
                        <label for="inputDate" class="col-form-label">Date</label>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center"  style="padding-top:2px;">
                        <div class="col-auto" style="width: 200px;">
                            <input type="text" id="inputPayTerm" class="form-control">
                        </div>
                        <div class="col-auto">
                        <label for="inputPayTerm" class="col-form-label">Payment Terms</label>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center" style="padding-top:2px;">
                        <div class="col-auto" style="width: 200px;">
                            <input type="date" id="inputDueDate" class="form-control">
                        </div>
                        <div class="col-auto">
                        <label for="inputDueDate" class="col-form-label">Due Date</label>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center" style="padding-top:2px;">
                        <div class="col-auto" style="width: 200px;">
                            <input type="number" id="inputPO" class="form-control">
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
                    <th width="2%"><input id="checkAll" class="itemRow" type="checkbox"></th>
                    <th width="38%">Item</th>
                    <th width="15%">Quantity</th>
                    <th width="15%">Rate</th>
                    <th width="15%">Amount</th>
                    </thead>
                    <tr>
                    <td><input class="itemRow smaller-cells" type="checkbox"></td>
                    <td><input type="text" name="productName[]" id="productName_1" class="form-control smaller-cells" autocomplete="off"></td>
                    <td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity smaller-cells" autocomplete="off"></td>
                    <td><input type="number" name="price[]" id="price_1" class="form-control price smaller-cells" autocomplete="off"></td>
                    <td><input type="number" name="total[]" id="total_1" class="form-control total smaller-cells" autocomplete="off"></td>
                    </tr>
                </table>
                </div>
                <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">
                    <button class="btn btn-danger delete" id="removeRows" style="height: 30px; padding: 4px 8px; font-size: 14px;margin-right: 20px;" type="button">- Delete</button>
                    <button class="btn btn-success" style="height: 30px; padding: 4px 8px; font-size: 14px;" id="addRows" type="button">+ Add More</button>
                </div>
                </div>
            </div>
     <!-- /////////////////////////////////// -->
            <div class="row mt-4">	
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label for="notes" class="form-label">&nbsp;&nbsp;&nbsp;Notes</label>
                            <textarea class="form-control" style="resize: none;" rows="2" id="notes" placeholder="Notes - any relevant information not already covered"></textarea>
                        <br>
                        <label for="terms" class="form-label">&nbsp;&nbsp;&nbsp;Terms</label>
                            <textarea class="form-control" style="resize: none;" rows="2" id="terms" placeholder="Terms and conditions - late fees, payment methods, delivery schedule"></textarea>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="direction: rtl;">
                        
                            <div class="row g-3 align-items-center">
                                <div class="input-group mb-3" style="direction: ltr; width:200px;">
                                    <span class="input-group-text" id="basic-addon1"><span class="selected-currency">$</span></span>
                                    <input type="number" class="form-control" name="subTotal" id="subTotal" aria-describedby="basic-addon1">
                                </div>
                                <div class="col-auto">
                                <label for="subTotal" class="col-form-label">: Subtotal</label>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="input-group mb-3" style="direction: ltr; width:200px;">
                                    <input type="number" class="form-control" name="taxRate" id="taxRate" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                                <div class="col-auto">
                                <label for="taxRate" class="col-form-label">: Tax Rate</label>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <!-- Tax Amount -->
                                <div class="input-group mb-3" style="direction: ltr; width: 200px;">
                                    <span class="input-group-text" id="basic-addon1"><span class="selected-currency">$</span></span>
                                    <input type="number" class="form-control" name="taxAmount" id="taxAmount" aria-describedby="basic-addon1">
                                </div>
                                <div class="col-auto">
                                    <label for="taxAmount" class="col-form-label">: Tax Amount</label>
                                </div>
                            </div>
                            
                            <div class="row g-3 align-items-center">
                                <!-- Total -->
                                <div class="input-group mb-3" style="direction: ltr; width: 200px;">
                                    <span class="input-group-text" id="basic-addon2"><span class="selected-currency">$</span></span>
                                    <input type="number" class="form-control" name="totalAftertax" id="totalAftertax" aria-describedby="basic-addon2">
                                </div>
                                <div class="col-auto">
                                    <label for="totalAftertax" class="col-form-label">: Total</label>
                                </div>
                            </div>
                            
                            <div class="row g-3 align-items-center">
                                <!-- Amount Paid -->
                                <div class="input-group mb-3" style="direction: ltr; width: 200px;">
                                    <span class="input-group-text" id="basic-addon3"><span class="selected-currency">$</span></span>
                                    <input type="number" class="form-control" name="amountPaid" id="amountPaid" aria-describedby="basic-addon3">
                                </div>
                                <div class="col-auto">
                                    <label for="amountPaid" class="col-form-label">: Amount Paid</label>
                                </div>
                            </div>
                            
                            <div class="row g-3 align-items-center">
                                <!-- Amount Due -->
                                <div class="input-group mb-3" style="direction: ltr; width: 200px;">
                                    <span class="input-group-text" id="basic-addon4"><span class="selected-currency">$</span></span>
                                    <input type="number" class="form-control" name="amountDue" id="amountDue" aria-describedby="basic-addon4">
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
            <button type="button" style="align-self: center;" class="btn btn-success"><i class="fas fa-download"></i> Download invoice</button>
            <hr>
            <label for="currencyList">CURRENCY</label>
            <select class="form-select" id="currencyList">
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
            <select class="form-select" id="typeList">
                <option value="Invoice">Invoice</option>
                <option value="Credit Note">Credit Note</option>
                <option value="Quote">Quote</option>
                <option value="Purchase Order">Purchase Order</option>
                <option value="Receipt">Receipt</option>
            </select>
            <hr>
            <a href="" class="link-title">&nbsp;<i class="fa-solid fa-clock-rotate-left"></i> History</a>
        
        </div>
    </div>
    
</body>
</html>