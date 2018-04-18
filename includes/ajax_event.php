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


    $user_products =$db_handler->get_prod_userid($user_id);
    $products =$db_handler->get_all_prods();
   
   ?>
<div class="container">
   <div class="row">
      <div class="grid">
         <?php
            for($i=0; $i<count($products); $i++)
            {
            ?>
         <!-- Card Projects -->
         <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="card">
               <div class="view_card" data-productid="<?php echo $products[$i]['product_id']; ?>">
                  <a class="fill-div" style="text-decoration: none;" data-toggle="modal" data-target="#myModal" >
                     <div class="card-image">
                        <img class="img-responsive" src="<?php echo $products[$i]['product_image'];?>">
                     </div>
                     <div class="card-content">
                        <p style=" margin-bottom: 20px;"><b><?php echo $products[$i]['product_name'];?></b></p>
                        <p class="desc" style=" margin-bottom: 20px;"><?php echo $products[$i]['product_desc'];?></p>
                     </div>
                  </a>
               </div>
               <div class="price col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <p><b>$</b><?php echo $products[$i]['product_price'];?></p>
               </div>
               <div class="button col-xs-6 col-sm-6 col-md-6 col-lg-6" style="margin-top: -8px;">
                  <?php
                     $cart=0;
                     for($j=0; $j<count($user_products); $j++)
                     {
                         if($products[$i]['product_id'] == $user_products[$j]['product_id'])
                         {
                     
                             $cart=1;
                             break;
                         }
                     }
                     
                     switch($cart)
                     {
                         case 0:
                         echo '<button class="add-to-cart btn btn-outline-info" style="float: right;" data-toggle="modal" data-target="#myModal" data-prodid='.$products[$i]['product_id'].'>Add to cart</button>';
                         break;
                               
                         case 1:
                         echo '<button class="rem-from-cart btn btn-outline-danger" style="float: right;" data-toggle="modal" data-target="#myModal" data-prodid='.$products[$i]['product_id'].'>Remove</button>';
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
</div>
<center>
   <button class="show-more"  type="button">
   <span class="load-post" title="More Posts">Show More</span>
   </button>  
</center>
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
  

 

 

   
   
   //live search
   else if($_POST['action'] == "live_search") 
   {
   
   extract($_POST);
   
   $q=$_POST['search'];
   
   
   
   $products=$db_handler->get_cust_cols("SELECT products.*, brand.* FROM products left join brand on brand.brand_id=products.brand_id WHERE products.product_name LIKE '%$q%' or brand.brand_name LIKE '%$q%' ORDER by products.product_id LIMIT 0,4");
   
   $user_products =$db_handler->get_prod_userid($user_id);
   ?>
<div class="container">
   <div class="row">
      <div class="pgrid">
         <?php
            for($i=0; $i<count($products); $i++)
            {
            ?>
         <!-- Card Projects -->
         <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="card">
               <div class="view_card" data-productid="<?php echo $products[$i]['product_id']; ?>">
                  <a href="#" class="fill-div" style="text-decoration: none;" data-toggle="modal" data-target="#myModal" >
                     <div class="card-image">
                        <img class="img-responsive" src="<?php echo $products[$i]['product_image'];?>">
                     </div>
                     <div class="card-content">
                        <p style=" margin-bottom: 20px;"><b><?php echo $products[$i]['product_name'];?></b></p>
                        <p class="desc" style=" margin-bottom: 20px;"><?php echo $products[$i]['product_desc'];?></p>
                     </div>
                  </a>
               </div>
               <div class="price col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <p><b>$</b><?php echo $products[$i]['product_price'];?></p>
               </div>
               <div class="button col-xs-6 col-sm-6 col-md-6 col-lg-6" style="margin-top: -8px;">
                  <?php
                     $cart=0;
                     for($j=0; $j<count($user_products); $j++)
                     {
                         if($products[$i]['product_id'] == $user_products[$j]['product_id'])
                         {
                     
                             $cart=1;
                             break;
                         }
                     }
                     
                     switch($cart)
                     {
                         case 0:
                         echo '<button class="add-to-cart btn btn-outline-info" style="float: right;" data-toggle="modal" data-target="#myModal" data-prodid='.$products[$i]['product_id'].'>Add to cart</button>';
                         break;
                               
                         case 1:
                         echo '<button class="rem-from-cart btn btn-outline-danger" style="float: right;" data-toggle="modal" data-target="#myModal" data-prodid='.$products[$i]['product_id'].'>Remove</button>';
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
</div>
<center>
   <button class="show-more" type="button">
   <span class="load-post" title="More Posts">Show More</span>
   </button>  
</center>
<?php
   exit;
   }
   
   
   //load more button
   else if($_POST['action'] == "live_search_more")
   {
     extract($_POST);
   
       $q=$_POST['search'];
       $showFrom=$_POST["showFrom"];
       $showCount=$_POST["showCount"];
   
   
   
     $products=$db_handler->get_cust_cols("SELECT products.*, brand.* FROM products left join brand on brand.brand_id=products.brand_id WHERE products.product_name LIKE '%$q%' or brand.brand_name LIKE '%$q%' ORDER by products.product_id LIMIT "  .$showFrom. "," .$showCount);
   
      $user_products =$db_handler->get_prod_userid($user_id);
      ?>
<div class="container">
<div class="row">
<?php
   for($i=0; $i<count($products); $i++)
   {
   ?>
<!-- Card Projects -->
<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
   <div class="card">
      <div class="view_card" data-productid="<?php echo $products[$i]['product_id']; ?>">
         <a href="#" class="fill-div" style="text-decoration: none;" data-toggle="modal" data-target="#myModal" >
            <div class="card-image">
               <img class="img-responsive" src="<?php echo $products[$i]['product_image'];?>">
            </div>
            <div class="card-content">
               <p style=" margin-bottom: 20px;"><b><?php echo $products[$i]['product_name'];?></b></p>
               <p class="desc" style=" margin-bottom: 20px;"><?php echo $products[$i]['product_desc'];?></p>
            </div>
         </a>
      </div>
      <div class="price col-xs-6 col-sm-6 col-md-6 col-lg-6">
         <p><b>$</b><?php echo $products[$i]['product_price'];?></p>
      </div>
      <div class="button col-xs-6 col-sm-6 col-md-6 col-lg-6" style="margin-top: -8px;">
         <?php
            $cart=0;
            for($j=0; $j<count($user_products); $j++)
            {
                if($products[$i]['product_id'] == $user_products[$j]['product_id'])
                {
            
                    $cart=1;
                    break;
                }
            }
            
            switch($cart)
            {
                case 0:
                echo '<button class="add-to-cart btn btn-outline-info" style="float: right;" data-toggle="modal" data-target="#myModal" data-prodid='.$products[$i]['product_id'].'>Add to cart</button>';
                break;
                      
                case 1:
                echo '<button class="rem-from-cart btn btn-outline-danger" style="float: right;" data-toggle="modal" data-target="#myModal" data-prodid='.$products[$i]['product_id'].'>Remove</button>';
                break;
            }
            ?>                        
      </div>
   </div>
</div>
<?php 
   } 
   }
   else if($_POST['action'] == "gen_random_products" )
   {
   
   extract($_POST);
   
   $products=$db_handler->get_cust_cols("SELECT * FROM products ORDER BY RAND() LIMIT 0,2");
   
   ?>
<div class="container">
   <div class="row">
      <?php
         for($i=0; $i<count($products); $i++)
         {
         ?>
      <!-- Card Projects -->
      <div class="col-xs-6 col-sm-5 col-md-3 col-lg-3">
         <div class="card">
            <div class="card-image">
               <img class="img-responsive" src="<?php echo $products[$i]['product_image'];?>">
            </div>
            <div class="card-content">
               <p style=" margin-bottom: 20px;"><b><?php echo $products[$i]['product_name'];?></b></p>
               <p class="desc" style=" margin-bottom: 20px;"><?php echo $products[$i]['product_desc'];?></p>
            </div>
            <div class="col-xs-6 col-sm-5 col-md-3 col-lg-3">
               <p><b>$</b><?php echo $products[$i]['product_price'];?></p>
            </div>
         </div>
      </div>
      <?php 
         } 
         ?>
   </div>
</div>
<?php
   exit;
   
   
   
   }
   else if($_POST['action'] == "view_products")
   {
       extract($_POST);
       $products=$db_handler->get_prod_id($product_id);
       $user_products =$db_handler->get_prod_userid($user_id);
   
       ?>
<div class="container">
   <div class="row">
      <?php
         for($i=0; $i<count($products); $i++)
         {
         
         ?>
      <div class="col-xs-6 col-sm-5 col-md-3 col-lg-3">
         <div class="card-image">
            <img  class="pics img-responsive" src="<?php echo $products[$i]['product_image'];?>" style="">
         </div>
      </div>
      <div class="col-xs-6 col-sm-5 col-md-3 col-lg-3">
         <div class="card-content">
            <p class="pro_name"><b><?php echo $products[$i]['product_name'];?></b></p>
            <p class="desc"><?php echo $products[$i]['product_desc'];?></p>
            <div class="row">
               <div class="price col-xs-6 col-sm-5 col-md-3 col-lg-3" style="">
                  <p class="p_price"><b>$</b><?php echo $products[$i]['product_price'];?></p>
               </div>
               <div class="button col-xs-6 col-sm-5 col-md-3 col-lg-3" style="margin-top: 49px;">
                  <?php
                     $cart=0;
                     for($j=0; $j<count($user_products); $j++)
                     {
                         if($products[$i]['product_id'] == $user_products[$j]['product_id'])
                         {
                     
                             $cart=1;
                             break;
                         }
                     }
                     
                     switch($cart)
                     {
                         case 0:
                         echo '<button class="a add-to-cart btn btn-outline-info" data-toggle="modal" data-target="#myModal" data-prodid='.$products[$i]['product_id'].'>Add to cart</button>';
                         break;
                               
                         case 1:
                         echo '<button class="r rem-from-cart btn btn-outline-danger" data-toggle="modal" data-target="#myModal" data-prodid='.$products[$i]['product_id'].'>Remove</button>';
                         break;
                     }
                     ?>                        
               </div>
            </div>
         </div>
      </div>
      <?php 
         } 
         ?>
   </div>
</div>
<?php
   exit;
   }
   
   ?>

