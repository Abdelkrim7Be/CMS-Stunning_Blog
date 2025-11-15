<?php require_once("Includes/DB.php");
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
    .admin-header h1 {
      font-weight: 700;
    }
    .btn-action {
      border-radius: 50px;
      font-weight: 600;
      padding: 0.6rem 1.5rem;
      transition: all 0.3s ease;
    }
    .btn-action:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
  </style>
  <title>Manage Posts - Admin Panel</title>
</head>

<body>
  <!-- NAVBAR -->
  <div class="top-bar"></div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand"><i class="fas fa-blog"></i> ABDELKRIMBELLAGNECH.COM</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item m-1">
            <a href="MyProfil.php" class="nav-link"><i class="fa-solid fa-user"></i> My Profile</a>
          </li>
          <li class="nav-item m-1">
            <a href="Dashboard.php" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          </li>
          <li class="nav-item m-1">
            <a href="Posts.php" class="nav-link active"><i class="fas fa-blog"></i> Posts</a>
          </li>
          <li class="nav-item m-1">
            <a href="Categories.php" class="nav-link"><i class="fas fa-folder"></i> Categories</a>
          </li>
          <li class="nav-item m-1">
            <a href="Admins.php" class="nav-link"><i class="fas fa-users-gear"></i> Manage Admins</a>
          </li>
          <li class="nav-item m-1">
            <a href="Comments.php" class="nav-link"><i class="fas fa-comments"></i> Comments</a>
          </li>
          <li class="nav-item m-1">
            <a href="Blog.php?page=1" class="nav-link"><i class="fas fa-globe"></i> Live Blog</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="Logout.php" class="nav-link btn btn-sm btn-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="top-bar"></div>
  <!-- NAVBAR END -->

  <!-- HEADER -->
  <header class="admin-header text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mb-3">
          <h1><i class="fas fa-blog" style="color: #27aae1;"></i> Manage Posts</h1>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="AddNewPost.php" class="btn btn-primary btn-action btn-block">
            <i class="fas fa-edit"></i> Add New Post
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Categories.php" class="btn btn-warning btn-action btn-block">
            <i class="fas fa-folder-plus"></i> Add Category
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Admins.php" class="btn btn-danger btn-action btn-block">
            <i class="fas fa-user-plus"></i> Add Admin
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Comments.php" class="btn btn-success btn-action btn-block">
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
      <div class="col-lg-12">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>category</th>
              <th>date&Time</th>
              <th>Author</th>
              <th>Banner</th>
              <th>Comments</th>
              <th>Action</th>
              <th>Live Preview</th>
            </tr>
          </thead>
          <?php
          global $connectingDB;
          $sql = "SELECT * FROM posts";
          $stmt = $connectingDB->query($sql);
          $Sr = 0;
          while ($DataRows = $stmt->fetch()) {
            $Id = $DataRows['id'];
            $DateTime = $DataRows['datetime'];
            $PostTitle = $DataRows['title'];
            $Category = $DataRows['category'];
            $Admin = $DataRows['author'];
            $Image = $DataRows['image'];
            $PostText = $DataRows['post'];
            $Sr++;
            ?>
            <tbody>
              <tr>
                <td>
                  <?php echo $Sr; ?>
                </td>
                <!-- <td class="table-danger">
                <?php echo $PostTitle; ?>
              </td>
              <td class="table-primary">
                <?php echo $PostTitle; ?>
              </td> -->
                <td>
                  <?php if (strlen($PostTitle) > 20) {
                    $PostTitle = substr($PostTitle, 0, 18) . "...";
                  } ?>
                  <?php echo $PostTitle; ?>
                </td>
                <td>
                  <?php if (strlen($Category) > 8) {
                    $Category = substr($Category, 0, 8) . "...";
                  } ?>
                  <?php echo $Category; ?>
                </td>
                <td>
                  <?php if (strlen($DateTime) > 11) {
                    $DateTime = substr($DateTime, 0, 11) . "...";
                  } ?>
                  <?php echo $DateTime; ?>
                </td>
                <td>
                  <?php if (strlen($Admin) > 6) {
                    $Admin = substr($Admin, 0, 6) . "..";
                  } ?>
                  <?php echo $Admin; ?>
                </td>
                <td>
                  <img src="Upload/<?php echo $Image; ?>" width="170px" height="50px">
                </td>
                <td>
                  <?php
                  $TotalRows = ApproveCommentsAccordingToPosts($Id);
                  if ($TotalRows > 0) {
                    ?>
                    <span class="badge badge-success">
                      <?php
                      echo $TotalRows;
                      ?>
                    </span>
                  <?php } ?>
                  <?php
                  $TotalRows = DisApproveCommentsAccordingToPosts($Id);
                  if ($TotalRows > 0) {
                    ?>
                    <span class="badge badge-danger">
                      <?php
                      echo $TotalRows;
                      ?>
                    </span>
                  <?php } ?>
                  <?php
                  $TotalRows2 = DisApproveCommentsAccordingToPosts($Id) + ApproveCommentsAccordingToPosts($Id);
                  if ($TotalRows2 == 0) {
                    ?>
                    <span class="badge badge-dark">
                      <?php
                      echo $TotalRows2;
                      ?>
                    </span>
                  <?php } ?>
                </td>
                <td>
                  <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                  <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                </td>
                <td> <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live
                      Preview</span></a>
                </td>
              </tr>
            </tbody>
          <?php } ?>
        </table>
      </div>
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