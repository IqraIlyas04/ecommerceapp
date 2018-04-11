<?php
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/utility.php');

$db = new DB_CONNECT();
$conn = $db->connect();

$db_handler = new DB_HANDLER($conn);

//Get all products from database
$products=$db_handler->get_all_prods();

if(isset($_POST['submit']))
{
  extract($_POST);

  //Check if the user exists
  if($db_handler->check_user_exists($username))
  {
      //If yes, validate user and pass
      $result = $db_handler->validate_user($username, $password);

      if($result)
      {

        $user=$db_handler->get_user($username, $password);
        $_SESSION['username'] = $user[0]['username'];
        $_SESSION['user_id'] = $user[0]['user_id'];
         header('Location: index.php');
         exit;
      }
      else
      {
         echo "Wrong username or password";
      }
  }
  else
  {
      echo "This user doesn't exist";
  }
} 
?>

<!DOCTYPE html>
<html>
   <head>
      <title>Mini Ecommerce App</title>
      <link rel="stylesheet" type="text/css" href="css/styles.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
   </head>
   <body>
      <nav class="navbar navbar-inverse">
         <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="#">Mini Ecommerce</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">Logout</a></li>
                <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                      <span class="nav-line-1">Hello, <?php
                      if(isset($_SESSION['username']))
                      {
                       echo $_SESSION['username'];
                      }
                      else
                      {
                        echo "Sign IN";
                      }
                      ?></span>
                      
                
                      <span class="nav-line-2"><i class="fa faw fa-user"></i></span>
                      <span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <li><a href="user.php">Sign Up</a></li>
                        <li><a href="#modal-body" data-toggle="modal" data-target="#myModal" >Log In</a></li>
                     </ul>
                  </li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa faw fa-shopping-cart"></i><span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                     </ul>
                  </li>
               </ul>
            </div>
            <!-- /.navbar-collapse -->
         </div>
         <!-- /.container-fluid -->
      </nav>

       <div class="paralax">
         <div class="container">
            <div class="col-md-12 text-center">
               <h1 class="digitallink">Looking for mobile phones?</h1>
               <div class="row">
                  <div class="input-group search">
                     <input type="text" class="form-control" placeholder="Search for..." style="padding: 20px;">
                     <span class="input-group-btn">
                     <button class="btn btn-default" type="button" style="padding: 10px;"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                     </span>
                  </div>
                  <!-- /input-group -->
               </div>
            </div>
         </div>
      </div>
       <div class="container">
        <div class="head">
          <h1>Special Offers</h1><hr>
        </div>
    </div>
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
                    <?php echo $products[$i]['product_id'];?>
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
                      <button class="add-to-cart btn btn-success" style="float: right;" data-toggle="modal" data-target="#myModal"/>Add</button>
                    </div>
                  </div>
                </div>
                <?php 
              } 

              ?>
              </div>
            </div>
          
     

<br><br><br><br>
    
<footer id="footer">
  <div class="foot">
  <p>© Copyright Mini Ecommerce. All Rights Reserved</p>
</div>
</footer>
<!-- 
 //Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div id="modal-body" class="modal-body">
          <p id="demo"></p>

          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                      </div>
                    </div>
                </div>
              <div class="col-md-6">
                <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <input class="form-control" placeholder="Password" name="password" type="password">
                      </div>
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-3" style="float: right; margin-top: 10px;">
                    <div class="form-group">
                      <input type="submit" class="btn btn-md btn-primary btn-block" name="submit" value="Sign in">
                    </div>
              </div>
         </div>

      </div>
    </form>
    </div>
  </div>
</div>
   </body>
</html>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      
      <script>
        //This code is for add/remove buttons in cart
        $(document).on('click', ".add-to-cart", function(e)
        {
          $(this).removeClass("add-to-cart btn btn-success");
          $(this).addClass("rem-from-cart btn btn-danger");
          $(this).html("Remove");
          document.getElementById("demo").innerHTML= "Added to Cart";

        });
        $(document).on('click', ".rem-from-cart", function(e)
        {
          $(this).removeClass("rem-from-cart btn btn-danger");
          $(this).addClass("add-to-cart btn btn-success");
          $(this).html("Add");
          document.getElementById("demo").innerHTML= "Removed from Cart";

        });

      </script>