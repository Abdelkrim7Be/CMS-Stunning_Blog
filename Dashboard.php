<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION['TrackingURL'] = $_SERVER["PHP_SELF"];
// echo $_SESSION['TrackingURL'];
Confirm_Login(); ?>
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
  <title>Dashboard</title>
  <!-- It is an Admin Page where he shows all the posts  -->
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
            <a href="MyProfil.php" class="nav-link"><i class="fa-solid fa-user"></i> My Profil</a>
          </li>
          <li class="nav-item m-1">
            <a href="Dashboard.php" class="nav-link">Dashboard</a>
          </li>
          <li class="nav-item m-1">
            <a href="Posts.php" class="nav-link">Posts</a>
          </li>
          <li class="nav-item m-1">
            <a href="Categories.php" class="nav-link">Categories</a>
          </li>
          <li class="nav-item m-1">
            <a href="Admins.php" class="nav-link">Manage admins</a>
          </li>
          <li class="nav-item m-1">
            <a href="Comments.php" class="nav-link">Comments</a>
          </li>
          <li class="nav-item m-1">
            <a href="Blog.php?page=1" class="nav-link">Live Blogs</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="Logout.php" class="nav-link text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
          </li>
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
        <div class="col-md-12">
          <h1><i class="fas fa-cog" style="color: #27aae1;"></i> Dashboard</h1>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="AddNewPost.php" class="btn btn-primary btn-block">
            <i class="fas fa-edit"></i>Add New Post
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Categories.php" class="btn btn-info btn-block">
            <i class="fas fa-folder-plus"></i>Add New Category
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Admins.php" class="btn btn-warning btn-block">
            <i class="fas fa-user-plus"></i>Add New Admin
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Comments.php" class="btn btn-success btn-block">
            <i class="fas fa-check mb-2"></i>Approve Comments
          </a>
        </div>
      </div>
    </div>
  </header>
  <br />

  <!-- Main Area -->
  <section class="container py-2 mb-4">
    <div class="row">
      <?php
      echo ErrorMessage();
      echo SuccessMessage();
      ?>
      <!-- Left Side Area Start -->
      <div class="col-lg-2 d-none d-md-block">
        <!-- here means when i am collapsing to the smaller screens , the cards will not show up -->
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Posts</h1>
            <h4 class="display-5">
              <i class="fas fa-book"></i>
              <?php
              TotalPosts()
                ?>
            </h4>
          </div>
        </div>
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Categories</h1>
            <h4 class="display-5">
              <i class="fas fa-folder"></i>
              <?php
              TotalCategories();
              ?>
            </h4>
          </div>
        </div>
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Admins</h1>
            <h4 class="display-5">
              <i class="fas fa-users"></i>
              <?php
              TotalAdmins();
              ?>
            </h4>
          </div>
        </div>
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Comments</h1>
            <h4 class="display-5">
              <i class="fas fa-comments"></i>
              <?php
              TotalComments();
              ?>
            </h4>
          </div>
        </div>
      </div>
      <!-- Left Side Area End -->
      <!-- Right Area Start -->
      <div class="col-lg-10">
        <h1>Top Posts</h1>
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No. </th>
              <th>Title</th>
              <th>Date&Time</th>
              <th>Author</th>
              <th>Comments</th>
              <th>Details</th>
            </tr>
          </thead>
          <?php
          $SrNo = 0;
          global $connectingDB;
          $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
          $stmt = $connectingDB->query($sql);
          while ($DataRows = $stmt->fetch()) {
            $PostId = $DataRows["id"];
            $DateTime = $DataRows["datetime"];
            $Author = $DataRows["author"];
            $Title = $DataRows["title"];
            $SrNo++;
            ?>
            <tbody>
              <tr>
                <td>
                  <?php echo $SrNo; ?>
                </td>
                <td>
                  <?php echo $Title; ?>
                </td>
                <td>
                  <?php echo $DateTime; ?>
                </td>
                <td>
                  <?php echo $Author; ?>
                </td>
                <td>
                  <?php
                  $TotalRows = ApproveCommentsAccordingToPosts($PostId);
                  if ($TotalRows > 0) {
                    ?>
                    <span class="badge badge-success">
                      <?php
                      echo $TotalRows;
                      ?>
                    </span>
                  <?php } ?>
                  <?php
                  $TotalRows = DisApproveCommentsAccordingToPosts($PostId);
                  if ($TotalRows > 0) {
                    ?>
                    <span class="badge badge-danger">
                      <?php
                      echo $TotalRows;
                      ?>
                    </span>
                  <?php } ?>
                  <?php
                  $TotalRows2 = DisApproveCommentsAccordingToPosts($PostId) + ApproveCommentsAccordingToPosts($PostId);
                  if ($TotalRows2 == 0) {
                    ?>
                    <span class="badge badge-dark">
                      <?php
                      echo $TotalRows2;
                      ?>
                    </span>
                  <?php } ?>
                </td>
                <td><a target="_blank" href="FullPost.php?id=<?php echo $PostId; ?>"><span
                      class="btn btn-info">Preview</span></a></td>
              </tr>
            </tbody>
          <?php } ?>

        </table>
      </div>
      <!-- Right Area End -->
    </div>
  </section>



  <!-- END Main Area -->


  <!-- END HEADER -->

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