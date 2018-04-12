// function for generating products on page
function generateProducts()
{
	var userid=$("#user_id").val();
	$.ajax({
		type:'POST',
		url:'includes/ajax_event.php',
		data:
		{
			action: "fetch_products",
			user_id: userid
		},
		success: function(html)
		{
			document.getElementById("prod_grid").innerHTML = html;
		},

		error: function(errormesssage)
		{
            alert(errormesssage.responseText);
        }
	});
}

window.onload=function()
{
	generateProducts();
}

// on click function add to cart
$(document).on('click', '.add-to-cart' , function(e)
{
	var prod_id=$(this).data('prodid');
	var userid=$("#user_id").val();

	$.ajax(
	{
		type:'POST',
		url: 'includes/ajax_event.php',
		data:
		{
			action: "add_to_cart",
			product_id: prod_id,
			user_id: userid
		},
		success: function(html)
		{
			
		},
		error: function(errormesssage)
		{
            alert(errormesssage.responseText);
        }

	});
	$(this).removeClass("add-to-cart btn btn-success");
    $(this).addClass("rem-from-cart btn btn-danger");
    $(this).html("Remove");
    document.getElementById("demo").innerHTML="Added to Cart";

});

//onclick function remove from cart

$(document).on('click', '.rem-from-cart' , function(e)
{
	var prod_id=$(this).data('prodid');
	var userid=$("#user_id").val();

	$.ajax(
	{
		type:'POST',
		url: 'includes/ajax_event.php',
		data:
		{
			action: "rem_from_cart",
			product_id: prod_id,
			user_id: userid
		},
		success: function(html)
		{
			
		},
		error: function(errormesssage)
		{
            alert(errormesssage.responseText);
        }

	});
	$(this).removeClass("rem-from-cart btn btn-danger");
    $(this).addClass("add-to-cart btn btn-success");
    $(this).html("Add");
    document.getElementById("demo").innerHTML= "Removed from Cart";

});


