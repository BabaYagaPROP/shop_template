<?php
session_start();

if(empty($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

if(!empty($_GET['ID']))
  array_push($_SESSION['cart'], $_GET['ID']);

$mysqli = mysqli_connect("localhost", "root", "", "sklep");

if(!empty($_GET['empty'])){
    $_SESSION['cart'] = array();
}

?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sklep</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body class="d-flex flex-column min-vh-100">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            <a class="nav-link" href="contact.php">Contact</a>        
          </div>
        </div>
        <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#cartPopUp">
          <img src="img/cart.svg" class="filter_white" alt="cart" width="30" height="24">
          Cart
      </button>
      </div>
    </nav>

    <!--main-->
    <main>
    <!--shopping cart pop up-->
    <div class="modal fade" id="cartPopUp" tabindex="-1" aria-labelledby="cartPopUpLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cartPopUpLabel">Shopping cart</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Your products:
            <?php
              $where_in = implode(',', $_SESSION['cart']);
              $sql = "SELECT * FROM produkty WHERE ID IN ($where_in)";
              $result = mysqli_query($mysqli, $sql);
              $total = 0;
              $count = array_count_values($_SESSION['cart']);
              if($result)
              while($row = mysqli_fetch_array($result)){
                $countId = $count[$row['id']];
                if($row['promocja'] == null)
                {
                echo "<p>". $countId . "x " . $row['nazwa']." - ".$countId * $row['cena']."zł</p>";
                $total += $countId * $row['cena']; 
                }
                else
                {
                echo "<p>". $countId . "x " . $row['nazwa']." - ".$row['cena'] * ($row['promocja'] /100)."zł</p>";
                $total += $countId * $row['cena'] * ($row['promocja'] /100); 
                }
              }
              echo "Razem: " . $total . "zł";
            ?>
          </div>
          <div class="modal-footer">
          <a href="index.php?empty=1" class="btn btn-secondary">Empty cart</a>
            <a href="checkout.php" class="btn btn-primary">Go to checkout</a>
          </div>
        </div>
      </div>
    </div>
    <div class="contactIMG">
        <img src="img/test.jpg"  alt="test1">
        <div class="contactRight">
            <h1>Kontakt</h1>
            <p>email: testemail@gmail.com</p>
            <p>tel: 123456789</p>
        </div>
    </div>
<div class="container py-4">

  <!-- Bootstrap 5 starter form -->
  <form id="contactForm">

    <!-- Name input -->
    <div class="mb-3">
      <label class="form-label" for="name">Name</label>
      <input class="form-control" id="name" type="text" placeholder="Name" />
    </div>

    <!-- Email address input -->
    <div class="mb-3">
      <label class="form-label" for="emailAddress">Email Address</label>
      <input class="form-control" id="emailAddress" type="email" placeholder="Email Address" />
    </div>

    <!-- Message input -->
    <div class="mb-3">
      <label class="form-label" for="message">Message</label>
      <textarea class="form-control" id="message" type="text" placeholder="Message" style="height: 10rem;"></textarea>
    </div>

    <!-- Form submit button -->
    <div class="d-grid">
      <button class="btn btn-primary btn-lg" type="submit">Submit</button>
    </div>

  </form>

</div>
    
     
    </main>

    <!-- Footer -->
      <footer class=" text-center text-white mt-auto" style="background-color:#212529;">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
          © 2022 Copyright: Launch demo modal
        </div>
      </footer>
      <!-- Footer -->
    
    <!--bootstrap js-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>