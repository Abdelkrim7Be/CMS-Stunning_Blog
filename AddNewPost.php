<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php");
$_SESSION['TrackingURL'] = $_SERVER["PHP_SELF"];

Confirm_Login();

if (isset($_POST['submit'])) {
  $PostTitle = $_POST['PostTitle'];
  $Category = $_POST['Category'];
  $Image = $_FILES['Image']["name"]; //the argument of name to grap  the name of our image
  // in the database , we don't stock our image, but we onlly save the name of our image the database and
  // the actual image is placed somewhere in the project
  $Target = "Upload/" . basename($_FILES['Image']["name"]); //where our image is gonna be saved
  $PostText = $_POST['PostDescription'];
  $Admin = $_SESSION["Username"];
  // after making the registry of admin , we will add the admin dynamically to the database in the table category

  date_default_timezone_set("Africa/Casablanca");

  $current = time(); //returns you the current time 
// echo $current;
  $DateTemp = new DateTime();
  $DateTemp->setTimestamp($current);
  $DateTime = $DateTemp->format("F-d-Y H:i:s");


  if (empty($PostTitle)) {
    $_SESSION["ErrorMessage"] = "Title can't be empty";
    Redirect_to("AddNewPost.php");
  } elseif (strlen($PostTitle) < 3) {
    $_SESSION["ErrorMessage"] = "Post Tilte should be longer than 2 characters";
    Redirect_to("AddNewPost.php");
  } elseif (strlen($PostText) > 9999) {
    $_SESSION["ErrorMessage"] = "Post description should be less than 1000 character";
    Redirect_to("AddNewPost.php");
  } else {
    // Query to add the data to the database
    global $connectingDB;

    $sql = "INSERT INTO posts(datetime,title, category, author, image, post) ";
    // We pass the values inderactly to prevent sql injection possibilities
    // $sql .= "values(?, ?, ?)";
    $sql .= "VALUES(:dateTime, :postTitle, :categoryName, :adminName, :imageName, :postDescription)"; // they are dummy names, but the order of them are important tho

    // this arrow notation -> means that you are working with PDO object notation
    // $connectingDB is created as an object
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':dateTime', $DateTime);
    $stmt->bindValue(':postTitle', $PostTitle);
    $stmt->bindValue(':categoryName', $Category);
    $stmt->bindValue(':adminName', $Admin);
    $stmt->bindValue(':imageName', $Image);
    $stmt->bindValue(':postDescription', $PostText);
    // the order of binding values is not important
    $Execute = $stmt->execute();

    // by this function , i tell php to take the image with the name tmp_name given by you
    move_uploaded_file($_FILES['Image']['tmp_name'], $Target);
    // don't forget about enctype="multipartform-data" in your form as an argument

    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Successful operation, Post with id : " . $connectingDB->lastInsertId() . " added successfully";
      // $connectingDB->lastInsertId() is a PDO method that show us the id of the added category in the database
      Redirect_to("AddNewPost.php");
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong, Try Again!";
      Redirect_to("AddNewPost.php");
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
  <title>Add New Post</title>
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
          <h1><i class="fas fa-edit" style="color: #27aae1;"></i> Add New Post</h1>
        </div>
      </div>
    </div>
  </header>


  <!-- Main Area  -->
  <section class="container py-2 mb-4">
    <div class="row">
      <!-- style="min-height: 50px; background-color: red;" -->
      <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
        <!-- style="min-height: 400px;" to make the footer always stick to the bottom pour ne pas nous déranger -->
        <!-- style="min-height: 50px; background-color: yellow;" -->
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form action="AddNewPost.php" method="post" class="" enctype="multipart/form-data">
          <div class="card-body bg-dark">
            <div class="form-group">
              <label for="title"><span class="FieldInfo">Post Title : </span></label>
              <input class="form-control" type="text" name="PostTitle" id="title" value=""
                placeholder="type title here">
              <!-- form-control to set our field to be responsive -->
            </div>
            <div class="form-group">
              <label for="CategoryTitle"><span class="FieldInfo">Choose Category : </span></label>
              <select class="form-control" id="CategoryTitle" name="Category">
                <?php
                // fetching all the categories from category table
                
                global $connectingDB;
                $sql = "SELECT * FROM category";
                $stmt = $connectingDB->query($sql);
                while ($DataRows = $stmt->fetch()) {
                  // getting thr first 2 columns from our category table
                  $Id = $DataRows["id"];
                  $CategoryName = $DataRows["title"];
                  ?>
                  <option>
                    <?php echo $CategoryName ?>
                  </option>
                  <!-- html element option inside a php loop where the ending is after the option elemnt to loop it over -->
                  <?php
                }
                ?>
              </select>
              <!-- form-control to set our field to be responsive -->
            </div>
            <div class="form-group">
              <div class="custom-file">
                <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                <label for="imageSelect" class="custom-file-label">Select Image : </label>
              </div>
            </div>
            <div class="form-group">
              <label for="Post"><span class="FieldInfo">Post : </span></label>
              <textarea class="form-control" id="Post" name="PostDescription" cols="30" rows="10"></textarea>
            </div>
            <div class="row">
              <!-- style="min-height: 50px; background-color: yellow;" -->
              <div class="col-lg-6 mb-2">
                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to
                  Dashboard</a>
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="submit" class="btn btn-success btn-block">
                  <i class="fas fa-check"></i> Publish
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- END Main Area  -->

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