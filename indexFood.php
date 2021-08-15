<?php
session_start();
require_once("configPet.php");

if(isset($_POST['checkout'])){
	if($_SESSION['loginstatusCustomer']==1) 
	{
		header('Location:login/userlogin.php');
	}
	else
	{
		header('Location:login/index.php');
	}
}

//code for Cart
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
  //code for adding product in cart
  case "add":
    if(!empty($_POST["quantity"])) {
      $pid=$_GET["pid"];
      $result=mysqli_query($con,"SELECT * FROM products WHERE id='$pid'");
            while($productByCode=mysqli_fetch_array($result)){
      $itemArray = array($productByCode["code"]=>array('name'=>$productByCode["name"], 'code'=>$productByCode["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode["price"], 'image'=>$productByCode["image"]));
      if(!empty($_SESSION["cart_item"])) {
        if(in_array($productByCode["code"],array_keys($_SESSION["cart_item"]))) {
          foreach($_SESSION["cart_item"] as $k => $v) {
              if($productByCode["code"] == $k) {
                if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                  $_SESSION["cart_item"][$k]["quantity"] = 0;
                }
                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
              }
          }
        } else {
          $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
        }
      }  else {
        $_SESSION["cart_item"] = $itemArray;
      }
    }
  }
  break;

  // code for removing product from cart
  case "remove":
    if(!empty($_SESSION["cart_item"])) {
      foreach($_SESSION["cart_item"] as $k => $v) {
          if($_GET["code"] == $k)
            unset($_SESSION["cart_item"][$k]);        
          if(empty($_SESSION["cart_item"]))
            unset($_SESSION["cart_item"]);
      }
    }
  break;
  // code for if cart is empty
  case "empty":
    unset($_SESSION["cart_item"]);
  break;  
}
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Food</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="M.jpeg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/stylef.css">
    <link rel="stylesheet" href="css/style_products.css" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <!--Navigation-->
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="index.php">MERX</a>
          <ul class="navbar-nav text-uppercase ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item">
            <div class="dropdown">
                <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown">Categories</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="indexHomeApp.php">Home Appliances</a>
                    <a class="dropdown-item" href="indexPet.php">Pet Accessories</a>
                    <a class="dropdown-item" href="indexFood.php">Food</a>
                </div>
            </div>
          </li>
          <li><button type="button" id="cartBtn" class="btn btn-dark" data-toggle="modal" data-target="#cartModal"><i class="fa fa-cart-arrow-down fa-lg"></i></button></li>
          </ul>
      </div>
    </nav>

     <!--FoodHeader-->
    <header class="mainheader">
      <div class="container">
        <h1 id="heading">Foods</h1>
      </div>
    </header>

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
   
<!--products displayed here-->
<div id="product-grid">
  <div class="txt-heading">Products</div>
  <div class="row">
  <?php
  $product= mysqli_query($con,"SELECT * FROM products WHERE category='Food' ORDER BY id ASC");
  if (!empty($product)) { 
    while ($row=mysqli_fetch_array($product)) {
    
  ?>
    <form method="post" action="indexFood.php?action=add&pid=<?php echo $row["id"]; ?>">
    <div class="card" style="width:18rem;">
      <img class="card-img-top"  style="height:18rem;" src="<?php echo $row["image"]; ?>" alt="High Speed Blender">
      <div class="card-body">
      <h5 class="card-title"><?php echo $row["name"]; ?></h5>
      <p class="card-text"><?php echo "₹".$row["price"]; ?></p>
      <div class="cart-action">Quantity<input type="text" class="product-quantity" name="quantity" value="1" size="2" />
      <input type="submit" value="Add to Cart" class="btnAddAction" /></div>
    </div>
    </div>
    </form>
  <?php
    }
  }  else {
 echo "No Records.";

  }
  ?>
</div>
</div>
</body>
</html>

