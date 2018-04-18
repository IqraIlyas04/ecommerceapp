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

   //shopping cart based on user
   else if($_POST['action'] == "fetch_user_prod")
   {
      extract($_POST);

      $cart=$db_handler->get_user_prod($user_id);
      
      ?>

      <div class="cart-head" style="border-bottom: 1px solid #dddddd40;">
        Shopping Cart 
        <button type="button" class="close" data-dismiss="modal">&times;</button>  
      </div>
      <div class="cart-body">
        <?php 
        for($i=0; $i<count($cart); $i++)
          {?>     
            <li>
              <div class="row">
                <div class="col-xs-2 col-md-4">
                  <img class="img-responsive" style="height: 35px; width:35px;" src="<?php echo $cart[$i]['product_image'];?>" alt="prewiew">
                </div>
                <div class="col-xs-4 col-md-5">
                  <h5 class="product-name"><strong><?php echo $cart[$i]['product_name']; ?></strong></h5><h5 class="truncate"><small><?php echo $cart[$i]['product_desc']; ?></small></h5>
                  <h6><strong>$<?php echo $cart[$i]['product_price']; ?></strong></h6>
                </div>
                <div class="col-xs-2 col-md-3">
                  <button type="button" class="btn btn-outline-danger btn-xs" id="cart_del"  data-prodid="<?php echo $cart[$i]['product_id'];?>">
                   <i class="fa fa-trash" aria-hidden="true"></i>
                 </button>
               </div>  
             </div>
           </li>
           <hr>
           <?php
         }
         ?>  
    </div>                               
      <?php 
    }

  //remove from shopping cart
    else if($_POST['action'] == "del_from_cart")
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


  //fetch prods based on brandID(filter by brand)
    else if($_POST['action'] == 'fetch_prod_by_brand')
    {
        extract($_POST);

        $display =$db_handler->get_prod_userid($user_id);
        $brands = $db_handler->get_prod_by_brand($brand_id);

        ?>
          <div class="col-md-12">
            <h5 style="font-weight: 600;">Brand: <?php echo $brands[0]['brand_name'];?></h5>
            <hr>
          </div>
          <div class="container">
            <div class="row">
              <?php
              for($i=0; $i<count($brands); $i++)
              {
               ?>
                 <div class="col-md-3">
                   <div class="card">
                    <div class="card-image">
                     <img class="img-responsive" src="<?php echo $brands[$i]['product_image'];?>">
                   </div>
                   <div class="card-content">
                     <p style=" margin-bottom: 20px;"><b><?php echo $brands[$i]['product_name'];?></b></p>
                     <p style=" margin-bottom: 20px;"><?php echo $brands[$i]['product_desc'];?></p>
                   </div>
                   <div class="col-md-6">
                     <p><b>$</b><?php echo $brands[$i]['product_price'];?></p>
                   </div>
                   <div class="col-md-6" style="margin-top: -8px;">
                     <?php
                     $cart=0;

                     for($j=0; $j<count($display); $j++)
                     {
                      if($brands[$i]['product_id'] == $display[$j]['product_id'])
                      {

                        $cart=1;
                        break;
                      }
                    }
                    switch($cart)
                    {
                      case 0:
                      echo '<button class="add-to-cart btn btn-success" style="float: right;" data-toggle="modal" data-target="#buttonmodal" data-prodid='.$brands[$i]['product_id'].'>Add</button>';
                      break;

                      case 1:
                      echo '<button class="rem-from-cart btn btn-danger" style="float: right;" data-toggle="modal" data-target="#buttonmodal" data-prodid='.$brands[$i]['product_id'].'>Remove</button>';
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
  ?>

<!-- styles for shopping cart -->
   <style type="text/css">

     .cart-head{
      padding: 7px;
      background-color: #fff;
      border-radius: 3px;
      margin-bottom: 20px;
      text-align: center;
      font-size: 15px;
      line-height: 1.5;
     }

     .cart-body{
      padding: 5px;
      overflow-y:scroll; 
      overflow-x:hidden;
      height:250px;
     }

     .btn-outline-danger{
      color: #dc3545;
      background-color: transparent;
      background-image: none;
      border-color: #dc3545;
     }

     .truncate{
      white-space: nowrap; 
      width: 90px; 
      overflow: hidden;
      text-overflow: ellipsis;
     }
     
   </style>

 