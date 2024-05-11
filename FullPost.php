<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php");

$SearchQueryParameter = $_GET['id'];

if (isset($_POST['Submit'])) {
  $Name = $_POST['CommenterName'];
  $Email = $_POST['CommenterEmail'];
  $Comment = $_POST['CommenterThoughts'];

  date_default_timezone_set("Africa/Casablanca");

  $current = time(); //returns you the current time 
// echo $current;
  $DateTemp = new DateTime();
  $DateTemp->setTimestamp($current);
  $DateTime = $DateTemp->format("F-d-Y H:i:s");


  if (empty($Name) || empty($Email) || empty($Comment)) {
    $_SESSION["ErrorMessage"] = "All the field must be filled";
    Redirect_to("FullPost.php?id={$SearchQueryParameter}");
  } elseif (strlen($Comment) > 500) {
    $_SESSION["ErrorMessage"] = "Comment length should be less than 500 characters";
    Redirect_to("FullPost.php?id={$SearchQueryParameter}");
  } else {
    // Query to add comment in db when its fine
    global $connectingDB;

    $sql = "INSERT INTO comments(datetime, name, email, comment, approvedby, status, post_id) ";
    // We pass the values inderactly to prevent sql injection possibilities
    // $sql .= "values(?, ?, ?)";
    $sql .= "VALUES(:dateTime, :name, :email, :comment, 'Pending', 'OFF', :postIdFromURL)"; // they are dummy names, but the order of them are important tho

    // this arrow notation -> means that you are working with PDO object notation
    // $connectingDB is created as an object
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':dateTime', $DateTime);
    $stmt->bindValue(':name', $Name);
    $stmt->bindValue(':email', $Email);
    $stmt->bindValue(':comment', $Comment);
    $stmt->bindValue(':postIdFromURL', $SearchQueryParameter);
    // the order of binding values is not important
    $Execute = $stmt->execute();

    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Successful operation, Comment submitted successfully";
      // $connectingDB->lastInsertId() is a PDO method that show us the id of the added category in the database
      Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong, Try Again!";
      Redirect_to("FullPost.php?id={$SearchQueryParameter}");
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
  <!-- <link rel="stylesheet" href="CSS/Styles.css" /> -->
  <link href="CSS/Styles.css?v=1.0" rel="stylesheet" type="text/css" />
  <script src="https://kit.fontawesome.com/d2a0a9da83.js" crossorigin="anonymous"></script>
  <title>Full Post Page</title>
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
  <div class="container">
    <div class="row mt-4 mb-4">

      <!-- MAIN AREA -->
      <div class="col-sm-8">
        <h1>The complete Responsive CMS Blog</h1>
        <h1 class="lead">The complete blog by using PHP by Jazeb Akram</h1>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <?php
        global $connectingDB;
        // SQL Query when Search button is active
        if (isset($_GET['SearchButton'])) {
          $Search = $_GET['Search'];
          $sql = "SELECT * FROM posts WHERE datetime LIKE :search OR category LIKE :search OR title LIKE :search OR post LIKE :search";
          $stmt = $connectingDB->prepare($sql);
          $stmt->bindValue(':search', '%' . $Search . '%');
          $stmt->execute(); //stmt is used here as a fetch
        }
        // The default sql query
        else {
          $PostIdURL = $_GET['id'];
          if (!isset($PostIdURL)) {
            $_SESSION['ErrorMessage'] = "Bad Request!!";
            Redirect_to("Blog.php");
          }
          $sql = "SELECT * FROM posts WHERE id = '$PostIdURL'";
          $stmt = $connectingDB->query($sql);
          $Result = $stmt->rowcount();
          if ($Result !== 1) {
            $_SESSION['ErrorMessage'] = "Bad Request!";
            Redirect_to("Blog.php?page=1");
          }
        }
        while ($DataRows = $stmt->fetch()) {
          $PostId = $DataRows['id'];
          $DateTime = $DataRows['datetime'];
          $postTitle = $DataRows['title'];
          $Category = $DataRows['category'];
          $Admin = $DataRows['author'];
          $Image = $DataRows['image'];
          $PostDescription = $DataRows['post'];
          ?>
          <div class="card">
            <img src="Upload/<?php echo $Image; ?>" style="max-height: 350px;" alt="" class="img-fluid card-img-top">
            <!-- img-fluid for responsice effect -->
            <div class="card-body">
              <h4 class="card-title">
                <?php echo htmlentities($postTitle); ?>
              </h4>
              <small class="text-muted">category : <span class="text-dark">
                  <a href="Blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a>
                </span> & Written By
                <a href="Profil.php?username=<?php echo htmlentities($Admin); ?>"> <?php echo htmlentities($Admin); ?>
                </a> On
                <?php echo htmlentities($DateTime); ?>
              </small>
              <span style="float: right;" class="badge badge-dark text-light">Comments
                <?php
                echo ApproveCommentsAccordingToPosts($PostId);
                ?>
              </span>
              <hr>
              <p class="card-text">

                <?php echo nl2br($PostDescription); ?>
              </p>

            </div>
          </div>

        <?php } ?>
        <!-- COMMENT PART START -->

        <!-- Fetching our existing comment start -->
        <span class="FieldInfo">Comments</span>
        <br><br>
        <?php
        global $connectingDB;
        $sql = "SELECT * FROM comments WHERE post_id = '$SearchQueryParameter' AND status='ON'";
        $stmt = $connectingDB->query($sql);
        while ($DataRows = $stmt->fetch()) {
          $CommentDate = $DataRows['datetime'];
          $CommenterName = $DataRows['name'];
          $CommentContent = $DataRows['comment'];
          ?>
          <div>
            <div class="media CommentBlock">
              <img class="d-block img-fluid align-self-start" src="Images/comment.png" alt="" width="80px" height="80px">
              <div class="media-body ml-2">
                <h6 class="lead">
                  <?php echo $CommenterName; ?>
                </h6>
                <p class="small">
                  <?php echo $CommentDate ?>
                </p>
                <p>
                  <?php echo $CommentContent; ?>
                </p>
              </div>
            </div>
          </div>
          <hr>
        <?php } ?>
        <!-- Fetching our existing comment end -->
        <div class="">
          <form action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post">
            <div class="card mb-3">
              <div class="card-header">
                <h3 class="FieldInfo">
                  Share your thoughts about this posts
                </h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input class="form-control" type="text" name="CommenterName" placeholder="Name" id="">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input class="form-control" type="text" name="CommenterEmail" placeholder="Email" id="">
                  </div>
                </div>
                <div class="form-group">
                  <textarea name="CommenterThoughts" class="form-control" id="" placeholder="Type here" cols="80"
                    rows="6"></textarea>
                </div>
                <div class="">
                  <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- COMMENT PART END -->
      </div>
      <!-- END MAIN AREA -->
      <!-- SIDE AREA -->
      <!-- Side Area Start -->
      <?php require_once("SideArea.php"); ?>
      <!-- SIDE AREA END -->

    </div>
  </div>
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