<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php");
Confirm_Login();

$SearchQueryParameter = $_GET['id'];
global $connectingDB;
$sql = "SELECT * FROM posts where id = '$SearchQueryParameter'";
$stmt = $connectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
  // use a long  use names to add a meaning to them
  $TitletoBeDeleted = $DataRows['title'];
  $CategoryToBeDeleted = $DataRows['category'];
  $ImageToBeDeleted = $DataRows['image'];
  $PostToBeDeleted = $DataRows['post'];
}
// echo $ImageToBeDeleted;
if (isset($_POST['submit'])) {
  global $connectingDB;
  // Query to delete the post in DB
  $sql = "DELETE FROM posts where id='$SearchQueryParameter'";
  $Execute = $connectingDB->query($sql);

  if ($Execute) {
    $Target_Path_To_Delete_Image = "Upload/$ImageToBeDeleted";
    unlink($Target_Path_To_Delete_Image);
    $_SESSION["SuccessMessage"] = "Successful operation, Post with id : " . $SearchQueryParameter . " is deleted  successfully";
    // $connectingDB->lastInsertId() is a PDO method that show us the id of the added category in the database
    Redirect_to("Posts.php");
  } else {
    $_SESSION["ErrorMessage"] = "Something went wrong, Try Again!";
    Redirect_to("Posts.php");
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
  <title>Delete Post</title>
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
          <h1><i class="fas fa-edit" style="color: #27aae1;"></i> Delete Post</h1>
        </div>
      </div>
    </div>
  </header>
  <!-- END HEADER -->


  <!-- Main Area  -->
  <section class="container py-2 mb-4">
    <div class="row">
      <!-- style="min-height: 50px; background-color: red;" -->
      <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
        <!-- style="min-height: 400px;" to make the footer always stick to the bottom pour ne pas nous déranger -->
        <!-- style="min-height: 50px; background-color: yellow;" -->

        <form action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" class=""
          enctype="multipart/form-data">
          <?php
          echo ErrorMessage();
          ?>
          <div class="card-body bg-dark">
            <div class="form-group">
              <label for="title"><span class="FieldInfo">Post Title : </span></label>
              <input disabled class="form-control" type="text" name="PostTitle" id="title"
                value="<?php echo $TitletoBeDeleted; ?>" placeholder="type title here">
              <!-- form-control to set our field to be responsive -->
            </div>
            <div class="form-group">
              <span class="FieldInfo">Existing Category : </span>
              <?php echo $CategoryToBeDeleted; ?><br>

              <!-- form-control to set our field to be responsive -->
            </div>
            <div class="form-group">
              <span class="FieldInfo">Existing Image : </span>
              <img class="mb-1" src="Upload/<?php echo $ImageToBeDeleted; ?>" alt="" width="170px" height="70px">

            </div>
            <div class="form-group">
              <label for="Post"><span class="FieldInfo">Post : </span></label>
              <textarea disabled class="form-control" id="Post" name="PostDescription" cols="30"
                rows="10"><?php echo $PostToBeDeleted; ?></textarea>
            </div>
            <div class="row">
              <!-- style="min-height: 50px; background-color: yellow;" -->
              <div class="col-lg-6 mb-2">
                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to
                  Dashboard</a>
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="submit" class="btn btn-danger btn-block">
                  <i class="fas fa-trash"></i> delete
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- END Main Area  -->


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