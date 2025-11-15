<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php");
$_SESSION['TrackingURL'] = $_SERVER["PHP_SELF"];

Confirm_Login();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
  <link rel="stylesheet" href="CSS/Styles.css?v=2.0" />
  <script src="https://kit.fontawesome.com/d2a0a9da83.js" crossorigin="anonymous"></script>
  <style>
    body {
      background-color: #f4f6f9;
    }
    .top-bar {
      height: 10px;
      background: linear-gradient(90deg, #27aae1 0%, #1e8bb8 100%);
    }
    .admin-header {
      background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
      padding: 2rem 0;
      margin-bottom: 2rem;
      border-radius: 0 0 10px 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
  </style>
  <title>Manage Comments - Admin Panel</title>
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
          <h1><i class="fas fa-comments" style="color: #27aae1;"></i> Manage Comments</h1>
        </div>
      </div>
    </div>
  </header>
  <br />

  <!-- END HEADER -->

  <section class="container py-2 mb-4">
    <div class="row" style="min-height :30px;">
      <div class="col-lg-12" style="min-height :400px;">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <h2 class="mb-3">Un-Approved Comments</h2>
        <table class="table table-stripped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No. </th>
              <th>Name</th>
              <th>Date&Time</th>
              <th>Comment</th>
              <th>Approve</th>
              <th>Delete</th>
              <th>Details</th>
            </tr>
          </thead>
          <?php
          global $connectingDB;
          $sql = "SELECT * FROM comments where status='OFF' ORDER BY id desc";
          $Execute = $connectingDB->query($sql);
          $SrNo = 0;
          while ($DataRows = $Execute->fetch()) {
            $CommentId = $DataRows['id'];
            $DateTimeOfComments = $DataRows['datetime'];
            $CommenterName = $DataRows['name'];
            $CommentContent = $DataRows['comment'];
            $CommentPostId = $DataRows['post_id'];
            $SrNo++;
            // if (strlen($CommenterName) > 10) {
            //   $CommenterName = substr($CommenterName, 0, 10) . "...";
            // }
            // if (strlen($DateTimeOfComments) > 10) {
            //   $DateTimeOfComments = substr($DateTimeOfComments, 0, 10) . "...";
            // }
            ?>
            <tbody>
              <tr>
                <td>
                  <?php echo htmlentities($SrNo); ?>
                </td>
                <td>
                  <?php echo htmlentities($CommenterName); ?>
                </td>
                <td>
                  <?php echo htmlentities($DateTimeOfComments); ?>
                </td>
                <td>
                  <?php echo htmlentities($CommentContent); ?>
                </td>
                <td><a class="btn btn-success" href="ApproveComment.php?id=<?php echo $CommentId; ?>">Approve</a></td>
                <td><a class="btn btn-danger" href="DeleteComment.php?id=<?php echo $CommentId; ?>">Delete</a></td>
                <td style="min-width: 140px;"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live
                    Preview</a></td>
              </tr>
            </tbody>
          <?php } ?>
        </table>
        <h2 class="mb-3">Approved Comments</h2>
        <table class="table table-stripped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No. </th>
              <th>Name</th>
              <th>Date&Time</th>
              <th>Comment</th>
              <th>Revert</th>
              <th>Delete</th>
              <th>Details</th>
            </tr>
          </thead>
          <?php
          global $connectingDB;
          $sql = "SELECT * FROM comments where status='ON' ORDER BY id desc";
          $Execute = $connectingDB->query($sql);
          $SrNo = 0;
          while ($DataRows = $Execute->fetch()) {
            $CommentId = $DataRows['id'];
            $DateTimeOfComments = $DataRows['datetime'];
            $CommenterName = $DataRows['name'];
            $CommentContent = $DataRows['comment'];
            $CommentPostId = $DataRows['post_id'];
            $SrNo++;
            // if (strlen($CommenterName) > 10) {
            //   $CommenterName = substr($CommenterName, 0, 10) . "...";
            // }
            // if (strlen($DateTimeOfComments) > 10) {
            //   $DateTimeOfComments = substr($DateTimeOfComments, 0, 10) . "...";
            // }
            ?>
            <tbody>
              <tr>
                <td>
                  <?php echo htmlentities($SrNo); ?>
                </td>
                <td>
                  <?php echo htmlentities($CommenterName); ?>
                </td>
                <td>
                  <?php echo htmlentities($DateTimeOfComments); ?>
                </td>
                <td>
                  <?php echo htmlentities($CommentContent); ?>
                </td>
                <td style="min-width: 140px;"><a class="btn btn-warning" href="DisapproveComment.php?id=<?php echo $CommentId; ?>">Disapprove</a></td>
                <td><a class="btn btn-danger" href="DeleteComment.php?id=<?php echo $CommentId; ?>">Delete</a></td>
                <td style="min-width: 140px;"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live
                    Preview</a></td>
              </tr>
            </tbody>
          <?php } ?>
        </table>
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