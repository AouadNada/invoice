$(document).ready(function() {
    function handleImageChange() {
        var fileInput = $('.upload-input')[0]; // Get the file input element
        if (fileInput.files && fileInput.files[0]) {
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onload = function(event) {
                $('#dropzone').css('display', 'none');
                $('#uploaded-image').attr('src', event.target.result);
                $('#uploaded-image').css('display', 'block');
            };

            reader.readAsDataURL(file);
        }
    }

    // Call the function when the page is loaded or reloaded
    handleImageChange();

    // Call the function when the file input changes
    $('.upload-input').on('change', function(e) {
        handleImageChange();
    });
    
    
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
                <td><input name="productName[]" id="productName_${rowCount + 1}" class="form-control smaller-cells" autocomplete="off"></td>
                <td><input name="quantity[]" id="quantity_${rowCount + 1}" class="form-control quantity smaller-cells" autocomplete="off"></td>
                <td><input name="price[]" id="price_${rowCount + 1}" class="form-control price smaller-cells" autocomplete="off"></td>
                <td><input name="totalI[]" id="total_${rowCount + 1}" class="form-control total smaller-cells" autocomplete="off"></td>
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

    // Initial check on page load
    togglePaymentFields();

    // Listen for changes in the "Payment Status" dropdown
    $('#payment_status').change(function() {
        togglePaymentFields();
    });

    function togglePaymentFields() {
        // Get the selected value of "Payment Status"
        var paymentStatus = $('#payment_status').val();

        // Check if "Payment Status" is "Completed" to show/hide the fields
        if (paymentStatus === 'Completed') {
            $('.payment-related-section').show();
        } else {
            $('.payment-related-section').hide();
        }
    }

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

document.addEventListener("DOMContentLoaded", function() {
    const typeList = document.getElementById("typeList");
    const selectedValueDisplays = document.querySelectorAll(".selected-value");

    typeList.addEventListener("change", function() {
        const selectedOption = typeList.options[typeList.selectedIndex];
        const selectedValue = selectedOption.getAttribute("label") || "$";

        selectedValueDisplays.forEach(display => {
            display.textContent = selectedValue.toUpperCase();
        });
    });
});

