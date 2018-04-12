<?php
   session_start();
   include_once('db_connect.php');
   include_once('db_handler.php');
   include_once('utility.php');
   
   $db = new DB_CONNECT();
   $conn = $db->connect();
   
   $db_handler = new DB_HANDLER($conn);
   $utility_handler = new UTILITY();
   
   //fetch products frm db
    
   if($_POST['action'] == "fetch_products")
   {
    extract($_POST);
   
        $display =$db_handler->get_prod_userid($user_id);
    $products =$db_handler->get_all_prods();
   
   ?>
<div class="container">
   <div class="row">
      <?php
         for($i=0; $i<count($products); $i++)
         {
         ?>
      <!-- Card Projects -->
      <div class="col-md-3">
         <div class="card">
            <div class="card-image">
               <img class="img-responsive" src="<?php echo $products[$i]['product_image'];?>">
            </div>
            <div class="card-content">
               <p style=" margin-bottom: 20px;"><b><?php echo $products[$i]['product_name'];?></b></p>
               <p style=" margin-bottom: 20px;"><?php echo $products[$i]['product_desc'];?></p>
            </div>
            <div class="col-md-6">
               <p><b>$</b><?php echo $products[$i]['product_price'];?></p>
            </div>
            <div class="col-md-6" style="margin-top: -8px;">
               <?php
                  $cart=0;
                  for($j=0; $j<count($display); $j++)
                  {
                      if($products[$i]['product_id'] == $display[$j]['product_id'])
                      {
                  
                      $cart=1;
                      break;
                      }
                  }
                  switch($cart)
                  {
                      case 0:
                      echo '<button class="add-to-cart btn btn-success" style="float: right;" data-toggle="modal" data-target="#buttonmodal" data-prodid='.$products[$i]['product_id'].'>Add</button>';
                      break;
                              
                      case 1:
                      echo '<button class="rem-from-cart btn btn-danger" style="float: right;" data-toggle="modal" data-target="#buttonmodal" data-prodid='.$products[$i]['product_id'].'>Remove</button>';
                      break;
                  }
                  ?>                        
            </div>
         </div>
      </div>
      <?php 
         } 
         ?>
   </div>
</div>
<?php
   }
   //add to cart
   else if($_POST['action'] == "add_to_cart") 
   {
       extract($_POST);
   
       $result=$db_handler->add_user_prod($product_id, $user_id);
   
       if($result)
       {
           echo "Submitted";
       }
       else
       {
           echo "Error";
       }
       exit;
   }
    
   
   //remove from cart
   else if($_POST['action'] == "rem_from_cart")
   {
       extract($_POST);
   
       $result=$db_handler->del_user_prod($product_id, $user_id);
   
       if($result)
       {
           echo "Submitted";
       }
       else
       {
           echo "Error";
       }
       exit;
   }
   ?>