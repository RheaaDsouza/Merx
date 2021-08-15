<?php
require_once("configPet.php");

session_start();

if (isset($_POST['con_btn'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$message = $_POST['message'];

	$query = "INSERT INTO contact_us(name,email,phone,message)VALUES('$name', '$email', '$phone', '$message')";

	$result=mysqli_query($con, $query);
    if($result){
      header('Location:index.php');
    } else{
      echo 'Unsuccessful';
    }
   }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>MERX</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <!-- Font Awesome icons-->
    <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <!--Navigation-->
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="#">Merx</a>
          <ul class="navbar-nav text-uppercase ml-auto">
            <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
            <li class="nav-item"><a class="nav-link" href="#contact">Contact us</a></li>
            <li class="nav-item"><a class="nav-link" href="reg/index.php">Sign In/Register</a></li>
            <li><button type="button" id="cartBtn" class="btn btn-dark" data-toggle="modal" data-target="#cartModal"><i class="fa fa-cart-arrow-down fa-lg"></i></button></li>
          </ul>
      </div>
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="cartModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cartModalLabel">Shopping Cart</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          
            <!-- Cart ---->
            <div id="shopping-cart">
     <!--       <div class="txt-heading">Shopping Cart</div>-->

        
          <a id="btnEmpty" href="indexFood.php?action=empty">Empty Cart</a>
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>  


<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;" width="5%">Name</th>
<th style="text-align:left;" width="5%">Code</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr> 


<?php   
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
    ?>
        <tr>
        <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
        <td><?php echo $item["code"]; ?></td>
        <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
        <td  style="text-align:right;"><?php echo "₹ ".$item["price"]; ?></td>
        <td  style="text-align:right;"><?php echo "₹ ". number_format($item_price,2); ?></td>
        <td style="text-align:center;"><a href="indexFood.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><i class="fa fa-trash" style="color:black;" aria-hidden="true"></i></a></td>
        </tr>
        <?php
        $total_quantity += $item["quantity"];
        $total_price += ($item["price"]*$item["quantity"]);
    }
    ?>

    <tr>
      <td colspan="2" align="right">Total:</td>
      <td align="right"><?php echo $total_quantity; ?></td>
      <td align="right" colspan="2"><strong><?php echo "₹ ".number_format($total_price, 2); ?></strong></td>
      <td align="right"><a href="login/userlogin.php"><button class="btn btn-danger">Checkout</button></a></td>
    </tr>
</tbody>
</table>    

<?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}
?>
</div>
</div>
</div>
</div>
</div>
    
    <!--Header-->
    <header id="home" class="mainheader">
      <div class="container">
        <h1 class="mainheader-heading text-uppercase">Welcome To MERX!</h1><br>
        <h4 class="mainheader-subheading">A common platform for vendors and customers for ease of business. Whether you sell online, from home or out of a car trunk, we have your back</h4>
        <a class="btn btn-primary btn-xl text-uppercase" href="#services">Learn More</a>
      </div>
    </header>
    
    <!--Services-->
    <section class="page-section" id="services">
      <div class="container">
        <div class="text-center">
          <h2 class="section-heading text-uppercase">Services</h2>
        </div>
        <div class="row text-center">
          <div class="col-md-4">
            
            <!-- card part-->
            <div class="flip-card">
              <div class="flip-card-inner">
                <div class="flip-card-front">
                  <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary" ></i>
                    <i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i>
                  </span>
                  <h4 class="my-3">E-Commerce</h4>
                  <p class="text-muted">A common platform for vendors and customers for ease of business.</p>
                </div>
                <div class="flip-card-back">
                  <h1>Categories</h1> 
                  <button type="button" class="btn btn-secondary"><a style="color:white;" href="indexHomeApp.php">Home Appliances</a></button><br><br>
                  <button type="button" class="btn btn-secondary"><a style="color:white;" href="indexFood.php">Food</a></button><br><br>
                  <button type="button" class="btn btn-secondary"><a style="color:white;" href="indexPet.php">Pet Accessories</a></button>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="flip-card">
              <div class="flip-card-inner">
                <div class="flip-card-front">
                  <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fas fa-truck fa-stack-1x fa-inverse"></i>
                  </span>
                  <h4 class="my-3">Tracking</h4>
                  <p class="text-muted">Track your purchases.</p>
                </div>
                <div class="flip-card-back" id="track">
                  <br><br>
                  <button type="button" class="btn btn-secondary"><a style="color:white;" href="track.php">Track</a></button>
                </div>
              </div>
            </div>
          </div>  
          
          <div class="col-md-4">
            <div class="flip-card">
              <div class="flip-card-inner">
                <div class="flip-card-front">
                  <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fas fa-store fa-stack-1x fa-inverse"></i>
                  </span>
                <h4 class="my-3">Set up your own store</h4>
                <p class="text-muted">whether you sell online, from your home or out of a car trunk, we have your back.</p>
                </div>
                <div class="flip-card-back">
                  <br><br>
                  <a href="indexVendor.php"><button type="button" class="btn btn-secondary">Add Product</button></a>
                </div>
              </div>
            </div>
          </div>
        
        </div>
      </div>
    </section>

    <!-- Contact-->
    <section class="page-section" id="contact">
      <div class="container">
        <div class="text-center">
          <h3 class="section-heading text-uppercase">Contact Us</h3>
        </div>

        <form id="contactForm" name="sentMessage" method="post">
          <div class="row align-items-stretch mb-5">
            <div class="col-md-6">
              <div class="form-group">
                <input class="form-control" id="name" name="name" type="text" placeholder="Your Name *" required valu="">
              </div>
              <div class="form-group">
                <input class="form-control" id="email" name="email" type="email" placeholder="Your Email *" required="required" value="">
              </div>
              <div class="form-group mb-md-0">
                <input class="form-control" id="phone" name="phone" type="tel" placeholder="Your Phone *" required="required" value="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group form-group-textarea mb-md-0">
                <textarea class="form-control" id="message" name="message" placeholder="Your Message *" required="required" value=""></textarea>
              </div>
            </div>
          </div>
          <div class="text-center">
            <div id="success"></div>
              <button class="btn btn-primary btn-xl text-uppercase" id="sendMessageButton" type="submit" name="con_btn">Send Message</button>
          </div>
        </form>
      </div>
    </section>
  </body>
</html>