<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
      integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
  <link href="CSS/Styles.css?v=1.0" rel="stylesheet" type="text/css" />
  <script src="https://kit.fontawesome.com/d2a0a9da83.js" crossorigin="anonymous"></script>
  <!-- <style media="screen">
    .heading {
      font-family: Bitter, Georgia, "Times New Roman", Times, Sherif;
      font-weight: bold;
      color: #005E90;
    }

    .heading:hover {
      color: #0090DB;
    }
  </style> -->
  <title>Blog Page</title>
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
        } elseif (isset($_GET["page"])) {
          // $Page = $_GET["page"];
          $Page = isset($_GET["page"]) && is_numeric($_GET["page"]) ? (int) $_GET["page"] : 1;
          if ($Page == 0 || $Page < 1) {
            $ShowPostFrom = 0;
          } else {
            $ShowPostFrom = ($Page * 5) - 5;
          }
          $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
          $stmt = $connectingDB->query($sql);
        } elseif (isset($_GET["category"])) {
          $category = $_GET['category'];
          $sql = "SELECT * FROM posts where category=:categoryName ORDER BY id desc";
          $stmt = $connectingDB->prepare($sql);
          $stmt->bindValue(':categoryName', $category);
          $stmt->execute();
        }
        // The default sql query
        else {
          $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
          $stmt = $connectingDB->query($sql);
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
                <?php if (strlen($PostDescription) > 150) {
                  $PostDescription = substr($PostDescription, 0, 150) . "...";
                } ?>
                <?php echo htmlentities($PostDescription); ?>
              </p>
              <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float: right;">
                <span class="btn btn-info">read More >></span>
              </a>
            </div>
          </div>
          <br>
        <?php } ?>
        <!-- Pagination dynamicaly -->
        <nav>
          <ul class="pagination pagination-lg">
            <!-- Creating a backward button -->
            <?php
            if (isset($Page)) {
              if ($Page > 1) { ?>
                <li class="page-item">
                  <a href="Blog.php?page=<?php echo $Page - 1; ?>" class="page-link">&laquo;</a>
                </li>
              <?php }
            } ?>
            <!-- <li class="page-item">
              <a href="Blog.php?page=1" class="page-link">1</a>
            </li>
            <li class="page-item active">
              <a href="Blog.php?page=1" class="page-link">1</a>
            </li> -->
            <?php
            global $connectingDB;
            $sql = "SELECT COUNT(*) FROM posts";
            $stmt = $connectingDB->query($sql);
            $RowPagination = $stmt->fetch();
            $TotalPosts = array_shift($RowPagination);
            // echo $TotalPosts . "<br>";
            $PostPagination = $TotalPosts / 5;
            $PostPagination = ceil($PostPagination);
            // echo $PostPagination;
            for ($i = 1; $i <= $PostPagination; $i++) {
              if (isset($_GET['page'])) {
                if ($i == $Page) { ?>
                  <li class="page-item active">
                    <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                  </li>

                <?php } else { ?>
                  <li class="page-item">
                    <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                  </li>
                <?php }
              }
            } ?>
            <!-- creating a forward button -->
            <?php
            if (isset($Page) && !empty($Page)) {
              if ($Page + 1 <= $PostPagination) { ?>
                <li class="page-item">
                  <a href="Blog.php?page=<?php echo $Page + 1; ?>" class="page-link">&raquo;</a>
                </li>
              <?php }
            } ?>


          </ul>
        </nav>
        <!-- Pagination End  -->
      </div>
      <!-- END MAIN AREA -->
      <!-- Side Area Start -->
      <?php require_once("SideArea.php"); ?>
      <!-- Side Area End -->
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