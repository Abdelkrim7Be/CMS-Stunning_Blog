<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php");
?>
<?php
if(isset($_SESSION['User_ID'])){
  Redirect_to("Dashboard.php");
}
// if you are already logged in, you cannot access or go to your login page


if (isset($_POST['Submit'])) {
  $Username = $_POST['Username'];
  $Password = $_POST['Password'];
  if (empty($Username) || empty($Password)) {
    $_SESSION['ErrorMessage'] = "All the fields must be filled out";
    Redirect_to("Login.php");
  } else {
    $Found_Account = Login_Attempt($Username, $Password);
    if ($Found_Account) {
      $_SESSION["User_ID"] = $Found_Account['id'];
      $_SESSION["Username"] = $Found_Account['username'];
      $_SESSION["AdminName"] = $Found_Account['aname'];
      // Fetch these 3 columns and put it in this session

      $_SESSION['SuccessMessage'] = "Welcome " . $_SESSION["Username"] . "!";
      if (isset($_SESSION['TrackingURL'])) {
        Redirect_to($_SESSION['TrackingURL']);
      } else {
        Redirect_to("Dashboard.php");
      }
    } else {
      $_SESSION['ErrorMessage'] = "Incorrect Username/Password";
      Redirect_to("Login.php");
    }
  }
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
  <title>Login</title>
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

      </div>
    </div>
  </nav>
  <div style="height: 10px; background-color: #27aae1"></div>
  <!-- NAVBAR END -->

  <!-- HEADER -->
  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1></h1>
        </div>
      </div>
    </div>
  </header>
  <br />

  <!-- END HEADER -->

  <!-- MAIN AREA START -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="offset-sm-3 col-sm-6" style="min-height: 458px;">
        <br><br>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <div class="card bg-secondary text-light">
          <div class="card-header">
            <h4>Welcome Back!!</h4>
          </div>
          <div class="card-body bg-dark">
            <form class="" action="Login.php" method="post">
              <div class="form-group">
                <label for="username"><span class="FieldInfo">Username</span></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="Username" id="username">
                </div>
              </div>
              <div class="form-group">
                <label for="password"><span class="FieldInfo">Password</span></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" name="Password" id="password">
                </div>
              </div>
              <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MAIN AREA END -->

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