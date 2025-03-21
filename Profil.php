<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php");
?>
<!-- Fetching Data -->
<?php
$SearchQueryParameter = $_GET['username'];
global $connectingDB;
$sql = "SELECT aname, aheadline, abio, aimage FROM admins where username = :userName";
$stmt = $connectingDB->prepare($sql);
$stmt->bindValue(':userName', $SearchQueryParameter);
$stmt->execute();
$result = $stmt->rowcount();
if ($result == 1) {
  while ($DataRows = $stmt->fetch()) {
    $ExistingName = $DataRows['aname'];
    $ExistingBio = $DataRows['abio'];
    $ExistingImage = $DataRows['aimage'];
    $ExistingHeadLine = $DataRows['aheadline'];
  }
}else{
  $_SESSION['ErrorMessage'] = "bad request!!";
  Redirect_to("Blog.php?page=1");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
  <link rel="stylesheet" href="CSS/Styles.css" />
  <script src="https://kit.fontawesome.com/d2a0a9da83.js" crossorigin="anonymous"></script>
  <title>Profil</title>
</head>

<body>
  <!-- Display the heading in different forms h1, h2, h3, h4...
    <h1 class="display-1">Hello World</h1>
    <h1 class="display-2">Hello World</h1>
    <h1 class="display-3">Hello World</h1>
    <h1 class="display-4">Hello World</h1>
    <h1 class="display-5">Hello World</h1> -->

  <!-- NAVBAR -->
  <div style="height: 10px; background-color: #27aae1"></div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand"> ABDELKRIMBELLAGNECH.COM</a>
      <!-- So here we used some javascript oriented to bootstrap, so when data-toggle is called
        we go to data-target that should have the same content as the content in the id in the div wanted to be collapsed (navbarCollapseCMS)-->
      <!-- shows and hides the navigation links when the window is small. When the toggle button is clicked, the data-toggle attribute triggers the collapse of the navbar-collapse element with the ID navbarcollapsecms using the data-target attribute. -->
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
        <ul class="navbar-nav mr-auto">

          <li class="nav-item m-1">
            <a href="Blog.php" class="nav-link">Home</a>
          </li>
          <li class="nav-item m-1">
            <a href="#" class="nav-link">About Us</a>
          </li>
          <li class="nav-item m-1">
            <a href="Blog.php" class="nav-link">Blog</a>
          </li>
          <li class="nav-item m-1">
            <a href="#" class="nav-link">Contact Us</a>
          </li>
          <li class="nav-item m-1">
            <a href="#" class="nav-link">features</a>
          </li>

        </ul>
        <ul class="navbar-nav ml-auto">
          <form class="form-inline d-none d-sm-block" action="Blog.php">
            <div class="form-group">
              <input class="form-control mr-2" type="text" name="Search" placeholder="Search here" id="" value="">
              <button class="btn btn-primary" name="SearchButton">Go</button>
            </div>
          </form>
        </ul>
      </div>
    </div>
  </nav>
  <div style="height: 10px; background-color: #27aae1"></div>
  <!-- NAVBAR END -->

  <!-- HEADER -->
  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1><i class="fas fa-user text-success mr-2" style="color: #27aae1;"></i>
            <?php echo $ExistingName; ?>
          </h1>
          <h3>
            <?php echo $ExistingHeadLine; ?>
          </h3>
        </div>
      </div>
    </div>
  </header>
  <br />

  <!-- END HEADER -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="col-md-3">
        <img src="images/<?php echo $ExistingImage; ?>" class="d-block img-fluide mb-3 rounded-circle" width="260"
          height="260" alt="">
      </div>
      <div class="col-md-9" style="min-height: 361px;">
        <div class="card">
          <div class="card-body">
            <p class="lead">
              <?php echo $ExistingBio; ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- div..container and div.row are indispensable for any elements , tb9a tzidhom dima -->
  <!-- FOOTER -->
  <footer class="bg-dark text-white">
    <div class="container">
      <!-- row means occupying all the length of our container -->
      <div class="row">
        <!-- to fully work with row, we need to specify which columns -->
        <div class="col">
          <p class="lead text-center">
            Theme by | Abdelkrim Bellagnech | <span id="year"></span> $copy;
            ----All right Reserved.
          </p>
          <p class="text-center small">
            <a style="color: white; text-decoration: none; cursor: pointer" href="http://jazebakram.com/coupons/"
              target="_blank"></a>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Totam
            dolorum error nihil voluptas quidem necessitatibus consequatur
            maiores fugit, ab dolores tempora vitae laboriosam non et natus
            recusandae ipsam
          </p>
        </div>
      </div>
    </div>
  </footer>
  <div style="height: 10px; background-color: #27aae1"></div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js"
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
    crossorigin="anonymous"></script>
  <script>
    $("#year").text(new Date().getFullYear());
  </script>
</body>

</html>