//insert products 
$(document).on('click', '.add-to-cart', function(e)
{
	var prod_id = $(this).data('prodid');
	// alert(prod_id);

	$.ajax({
		type:'POST',
		url:'includes/ajax_event.php',
		data:
		{
			action: "insert_product",
			product_id: prod_id
		},
		success: function(html)
		{
			document.getElementById("demo").innerHTML= "Added to Cart";
		},
		error: function(errormesssage)
		{
			alert(errormesssage.responseText);
		}
	});

	$(this).removeClass("add-to-cart btn btn-success");
	$(this).addClass("rem-from-cart btn btn-danger");
	$(this).html("Remove");
});