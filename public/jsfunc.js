
        $(document).ready(function() {
            $("#form1").submit(function() {
                $.ajax({
                 url: "quote.php",
                 data: { 
                  symbol: $("#symbol").val()
                 },
                 success: function(data) {
                   $("#price").html(data.price);
                   $("#high").html(data.high);
                   $("#low").html(data.low);
                   $("#qtime").html(data.qtime);
                 }
                });
                return false;
            });
        });


        function validate(f) {
	    if (f.firstname.value == "" || f.lastname.value == "" || f.email.value == "" || f.password1.value == "" || f.password2.value == "") {
	        alert("You must fill in all information!");
		    return false;
		}
            else if (!f.email.value.match(/\S+@\S+\.\S+/)) {
                alert("You must provide an valid email adddress.");
                return false;
            }
            else if (f.password1.value.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }
            else if (f.password1.value.match(/(^\d+$)|(^[A-z]+$)/)) {
                alert("Password must contain both letters and numbers.");
                return false;
            }
            else if (f.password1.value != f.password2.value) {
                alert("You must provide the same password twice.");
                return false;
            }
            return true;
        }
		
	$(document).ready(function() {
            $("#symbol_p").change(function() {
                $.ajax({
                 url: "quote.php",
                 data: { 
                  symbol: $("#symbol_p").val()
                 },
                 success: function(data) {
                   $("#price_p").html(data.price);
                   $("#cost").html(data.price * $("#quantity").val());
                 }
                });
            });
        });

	$(document).ready(function() {
            $("#quantity").change(function() {
                $("#cost").html($("#price_p").html() * $("#quantity").val());
            });
        });

	function tradeValidate(f) {
	    if (f.submit.value == "Submit") {
		if (f.quantity.value == "") {
	            alert("Quantity can not be 0");
		    return false;
		}
		if (f.select.value == "buy" && Number(f.quantity.value * f.price.value) > Number(f.balance.value)) {
		    alert("Not enough balance for this transaction!");
		    return false;
		} 
		else if (f.select.value == "sell" && Number(f.quantity.value) > Number(f.shares.value)) {
		    alert("You can not oversell!");
		    return false;
		}
		return true;				
	    }
	    else if (f.submit.value == "Buy") {
	        if (document.getElementById("price_p").innerHTML == "") {
		    alert("Please type the correct symbol!");
		    return false;
		}
		else if (f.quantity.value == 0) {
		    alert("Please spicify how many shares you want to buy.");
		    return false;
		}
		else {
		    var price1 = Number(document.getElementById("price_p").innerHTML);
		    if (f.quantity.value * price1 > Number(f.balance.value)) {
		        alert("Not enough balance for this transaction!");
			return false;
		    }
		    f.price.value = price1;
		    return true;
		}
	    }
	    alert("Something is very wrong!");
	    return false;            
        }
