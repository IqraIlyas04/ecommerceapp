<?php
   session_start();
   include_once('includes/db_connect.php');
   include_once('includes/db_handler.php');
   include_once('includes/utility.php');
   
   $db = new DB_CONNECT();
   $conn = $db->connect();
   
   $db_handler = new DB_HANDLER($conn);
   
   //Get all products from database
   
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
          header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
    else
    {
        echo "This user doesn't exist";
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
   } 
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Mini Ecommerce App</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="css/styles.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
                  <?php
                     if(isset($_SESSION['user_id']) == -1)
                     {
                     ?>
                  <li><a href="logout.php">Logout</a></li>
                  <?php
                     }
                     ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                     <span class="nav-line-1"><?php
                        if(isset($_SESSION['username']))
                        {
                         echo $_SESSION['username'];
                         ?>
                     <input type="hidden" value="<?php echo $_SESSION['user_id']; ?>" id="user_id">
                     <?php
                        }
                        else
                        {
                          echo "Sign IN";
                          ?>
                     <input type="hidden" value="-1" id="user_id">
                     <?php
                        }
                        ?></span>
                     <span class="nav-line-2"><i class="fa faw fa-user"></i></span>
                     <span class="caret"></span></a>
                     <?php
                        if(isset($_SESSION['user_id']) <=0)
                        {
                        ?>
                     <ul class="dropdown-menu">
                        <li><a href="user.php">Sign Up</a></li>
                        <li><a href="#modal-body" data-toggle="modal" data-target="#myModal" class="login">Log In</a></li>
                     </ul>
                     <?php
                        }
                        ?>
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
                     <input type="text" class="form-control" placeholder="Search for..." style="padding: 20px;" name="search_text" id="search_text" >
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="head">
            <h1>Special Offers</h1>
            <hr>
         </div>
      </div>
      <div id="prod_grid"></div>
      <br><br><br><br>
      <footer id="footer">
         <div class="foot">
            <p>© Copyright Mini Ecommerce. All Rights Reserved</p>
         </div>
      </footer>
      <!-- 
         //Modal for login-->
      <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <p>Product Details</p>
               </div>
               <div id="modal-body" class="modal-body">
                  <div id="add">
                     <br>
                     <center> <i class="fa fa-check-circle fa-3x" style="color: green;"></i></center>
                     <center>
                        <h4>
                           <p id="demo" style="margin-top: 20px;"></p>
                           You have added this product to Cart !
                        </h4>
                     </center>
                     <br> 
                     <hr/>
                     <br>
                     <center>
                        <h4><b>Suggested Products</b></h4>
                     </center>
                  </div>
                  <div id="remove">
                     <br>
                     <center> <i class="fa fa-times-circle fa-3x" style="color: red;"></i></center>
                     <center>
                        <h4>
                           <p id="demo" style="margin-top: 20px;"></p>
                           You have removed this product from Cart !
                        </h4>
                     </center>
                     <br> 
                     <hr/>
                     <br>
                     <center>
                        <h4><b>Suggested Products</b></h4>
                     </center>
                  </div>
                  <div id="random_products"></div>
                  <div id="products_view">
                  </div>
                  <div id="login">
                     <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/ajax_event.js"></script>