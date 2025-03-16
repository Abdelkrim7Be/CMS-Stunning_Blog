<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php");
?>
<?php
if (isset($_SESSION['User_ID'])) {
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
  <style>
    :root {
      --theme-blue: #27aae1;
    }

    html,
    body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background-color: #f8f9fa;
    }

    .content {
      flex: 1 0 auto;
      display: flex;
      flex-direction: column;
    }

    .main-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    footer {
      flex-shrink: 0;
    }

    .login-card {
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
      max-width: 450px;
      width: 100%;
    }

    .login-card:hover {
      transform: translateY(-5px);
    }

    .card-header {
      border-radius: 10px 10px 0 0 !important;
      font-weight: bold;
    }

    .brand-blue-bg {
      background-color: var(--theme-blue) !important;
      border-color: var(--theme-blue) !important;
    }

    .btn-login {
      background-color: var(--theme-blue);
      border: none;
      border-radius: 5px;
      font-weight: bold;
      letter-spacing: 1px;
      box-shadow: 0 4px 8px rgba(39, 170, 225, 0.3);
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      background-color: #1f8dbe;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(39, 170, 225, 0.4);
    }

    .input-group-text {
      background-color: var(--theme-blue) !important;
    }

    .navbar-brand {
      font-weight: bold;
      letter-spacing: 1px;
    }

    .copyright {
      font-size: 0.9em;
    }

    hr.divider {
      width: 80%;
      margin: 15px auto;
      border-color: rgba(255, 255, 255, 0.3);
    }
  </style>
</head>

<body>
  <!-- NAVBAR -->
  <div style="height: 10px;" class="brand-blue-bg"></div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand">ABDELKRIMBELLAGNECH.COM</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
        <!-- You can add navigation items here if needed -->
      </div>
    </div>
  </nav>
  <div style="height: 10px;" class="brand-blue-bg"></div>
  <!-- NAVBAR END -->

  <!-- MAIN CONTENT -->
  <div class="content">
    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1>Admin Portal</h1>
          </div>
        </div>
      </div>
    </header>
    <!-- END HEADER -->

    <!-- MAIN AREA START -->
    <section class="container main-section py-5">
      <div class="login-card">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <div class="card bg-secondary text-light">
          <div class="card-header text-center py-3 brand-blue-bg">
            <h4 class="mb-0 text-white">Welcome Back!!</h4>
          </div>
          <div class="card-body bg-dark py-4">
            <form class="" action="Login.php" method="post">
              <div class="form-group">
                <label for="username"><span class="FieldInfo">Username</span></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-white brand-blue-bg"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="Username" id="username" placeholder="Enter your username">
                </div>
              </div>
              <div class="form-group">
                <label for="password"><span class="FieldInfo">Password</span></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-white brand-blue-bg"><i class="fas fa-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" name="Password" id="password" placeholder="Enter your password">
                </div>
              </div>
              <div class="form-group mt-4 mb-0">
                <input type="submit" name="Submit" class="btn btn-block brand-blue-bg py-2 text-white btn-login" value="Login">
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- MAIN AREA END -->
  </div>

  <!-- FOOTER -->
  <footer class="bg-dark text-white py-4">
    <div class="container">
      <div class="row">
        <div class="col text-center">
          <p class="mb-1 copyright">
            Theme by | Abdelkrim Bellagnech | <span id="year"></span> &copy;
            ----All right Reserved.
          </p>
          <hr class="divider">
          <p class="small px-md-5">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Totam
            dolorum error nihil voluptas quidem necessitatibus consequatur
            maiores fugit, ab dolores tempora vitae laboriosam non et natus
            recusandae ipsam
          </p>
        </div>
      </div>
    </div>
  </footer>
  <div style="height: 10px;" class="brand-blue-bg"></div>

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