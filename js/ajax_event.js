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


//on click function add to cart
$(document).on('click', '.add-to-cart' , function(e)
{
	var prod_id=$(this).data('prodid');
	var userid=$("#user_id").val();

	if(userid <= 0)
	{

		$("#remove").hide();
		$("#add").hide();
		$("#random_products").hide();
		$("#products_view").hide();
		$("#login").show();

	}
	else
	{

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

	$(this).removeClass("add-to-cart btn btn-outline-info");
    $(this).addClass("rem-from-cart btn btn-outline-danger");
    $(this).html("Remove");
    $("#remove").hide();
	$("#add").show();
	$("#random_products").show();
	$("#products_view").hide();
	$("#login").hide();
}
});

$(document).on('click', '.login' , function(e)
{
	var userid=$("#user_id").val();

	if(userid <= 0)
	{

	$("#remove").hide();
	$("#add").hide();
	$("#random_products").hide();
	$("#products_view").hide();
	$("#login").show();

	}

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

	$(this).removeClass("rem-from-cart btn btn-outline-danger");
    $(this).addClass("add-to-cart btn btn-outline-info");
    $(this).html("Add to cart");
    
$("#remove").show();
$("#add").hide();
$("#products_view").hide();
$("#random_products").show();
$("#login").hide();
});
//live search


//onclick function remove from cart

$(document).ready(function(e)
{
    $("#search_text").keyup(function(e)
    {
      
        var txt = $("#search_text").val();
        var userid=$("#user_id").val();

        if(txt != '')
		{

			 $.ajax({
	    		type: "POST",
	    		url: "includes/ajax_event.php",
	    		data: 
	    		{
	    			search: txt,
	    			user_id: userid,
	    			action: "live_search"	
	    		},

	    		success: function(data)
	    		{
	    			$("#prod_grid").html(data);
	    		
	    		}
	    	});
		}
		else
		{
			$("#prod_grid").html(data);
		}

    });
});


//load more button
$showFrom=0;
$showCount=4;
	
$(document).on('click', '.show-more' , function(e)

{
	var txt = $("#search_text").val();
	var userid=$("#user_id").val();
	$showFrom += $showCount;

	$.ajax({
		type:'POST',
		url: 'includes/ajax_event.php',
		data:{
			search: txt,
			action: "live_search_more",
			showFrom: $showFrom,
			showCount: $showCount,			
			user_id: userid

		},
		success: function(data)
		{
				$('.load-post').html("Show More");
 				$('.grid').append(data);
				$('.pgrid').append(data);
				
		},

		error: function(errormesssage)
		{
            alert(errormesssage.responseText);
        }
			
	});
});



// function for generating random products
$(document).on('click', '.rem-from-cart' , function(e)
{
	var userid=$("#user_id").val();
	$.ajax({
		type:'POST',
		url:'includes/ajax_event.php',
		data:
		{
			action: "gen_random_products",
			user_id: userid
		},
		success: function(html)
		{
			document.getElementById("random_products").innerHTML = html;
		},

		error: function(errormesssage)
		{
            alert(errormesssage.responseText);
        }
	});
});

$(document).on('click', '.add-to-cart' , function(e)
{
	var userid=$("#user_id").val();
	$.ajax({
		type:'POST',
		url:'includes/ajax_event.php',
		data:
		{
			action: "gen_random_products",
			user_id: userid
		},
		success: function(html)
		{
			document.getElementById("random_products").innerHTML = html;
		},

		error: function(errormesssage)
		{
            alert(errormesssage.responseText);
        }
	});
});

$(document).on('click', '.view_card' , function(e)
{
	var prod_id=$(this).data('productid');
 	var userid=$("#user_id").val();

 	$.ajax({

		type:'POST',
		url:'includes/ajax_event.php',
		data:
		{
			action: "view_products",
			user_id: userid,
			product_id: prod_id
		},
		success: function(html)
		{
			document.getElementById("products_view").innerHTML = html;
		},

		error: function(errormesssage)
		{
            alert(errormesssage.responseText);
        }




	});
$("#remove").hide();
$("#add").hide();
$("#random_products").hide();
$("#products_view").show();
$("#login").hide();


//on click function shoppingcart(cart_btn)
$(document).on('click', '#cart_btn' , function(e)
{
 	var userid= $('#user_id').val();

	$.ajax(
	{
		type:'POST',
		url:'includes/ajax_event.php',
		data:
		{
			action: "fetch_user_prod",
			user_id: userid
		},
		success: function(html)
		{	
		document.getElementById("carts").innerHTML = html;
		},

		error: function(errormesssage)
		{
            alert(errormesssage.responseText);
        }
	});
});


// on click function delete from shopping cart
$(document).on('click', '#cart_del' , function(e)
{
	 var userid= $('#user_id').val();
	 var prod_id=$(this).data('prodid');

	$.ajax(
	{
		type:'POST',
		url:'includes/ajax_event.php',
		data:
		{
			action: "del_from_cart",
			user_id: userid,
			product_id: prod_id
		},
		success: function(html)
		{	
		 		document.getElementById("carts").innerHTML = html;
		},

		error: function(errormesssage)
		{
            alert(errormesssage.responseText);
        }
	});
});

//product filter by brand
$("#brand_name").change(function(e)
{
	var brandID = $(this).val();
	var userid = $("#user_id").val();
	//alert($(this).val());

	if(brandID == "-- Select Brand --")
	{
		$.ajax(
		{
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
	else
	{
		$.ajax(
		{
			type:'POST',
			url: 'includes/ajax_event.php',
			data:
			{
				action: "fetch_prod_by_brand",
				brand_id: brandID,
				user_id: userid 
			},
			success:function(html){
				//alert(html);
				document.getElementById('prod_grid').innerHTML= html;
			},
			error: function(errormesssage)
			{
				alert(errormesssage.responseText);
			}
			
		});
	}
});




