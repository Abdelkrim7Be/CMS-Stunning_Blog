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
  <link href="CSS/Styles.css?v=2.0" rel="stylesheet" type="text/css" />
  <script src="https://kit.fontawesome.com/d2a0a9da83.js" crossorigin="anonymous"></script>
  <style>
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
    }

    .top-bar {
      height: 10px;
      background: linear-gradient(90deg, #27aae1 0%, #1e8bb8 100%);
    }

    .blog-header {
      background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
      padding: 3rem 0;
      margin-bottom: 2rem;
      border-radius: 0 0 15px 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .blog-header h1 {
      color: white;
      font-weight: 700;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .blog-header .lead {
      color: #ecf0f1;
      font-size: 1.1rem;
    }

    .post-card {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      margin-bottom: 2rem;
    }

    .post-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .post-card img {
      max-height: 350px;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .post-card:hover img {
      transform: scale(1.1);
    }

    .post-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 1rem;
    }

    .post-meta a {
      color: #27aae1;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .post-meta a:hover {
      color: #1e8bb8;
    }

    .search-form {
      position: relative;
    }

    .search-form .form-control {
      border-radius: 50px;
      padding-right: 100px;
    }

    .search-form .btn {
      position: absolute;
      right: 5px;
      top: 50%;
      transform: translateY(-50%);
      border-radius: 50px;
    }
  </style>
  <title>Blog - ABDELKRIMBELLAGNECH.COM</title>
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
            <a href="Blog.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
          </li>
          <li class="nav-item m-1">
            <a href="#" class="nav-link"><i class="fas fa-info-circle"></i> About</a>
          </li>
          <li class="nav-item m-1">
            <a href="Blog.php" class="nav-link"><i class="fas fa-newspaper"></i> Blog</a>
          </li>
          <li class="nav-item m-1">
            <a href="#" class="nav-link"><i class="fas fa-envelope"></i> Contact</a>
          </li>
          <li class="nav-item m-1">
            <a href="#" class="nav-link"><i class="fas fa-star"></i> Features</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <form class="form-inline d-none d-sm-block search-form" action="Blog.php">
            <div class="form-group mb-0">
              <input class="form-control" type="text" name="Search" placeholder="Search articles..." value="">
              <button class="btn btn-primary btn-sm" name="SearchButton"><i class="fas fa-search"></i></button>
            </div>
          </form>
        </ul>
      </div>
    </div>
  </nav>
  <div class="top-bar"></div>
  <!-- NAVBAR END -->

  <!-- HEADER -->
  <div class="blog-header">
    <div class="container text-center">
      <h1><i class="fas fa-blog"></i> Complete Responsive CMS Blog</h1>
      <p class="lead">Explore articles and insights powered by modern PHP</p>
    </div>
  </div>

  <div class="container">
    <div class="row mt-4 mb-4">
      <!-- MAIN AREA -->
      <div class="col-lg-8">
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
          <div class="card post-card">
            <img src="Upload/<?php echo htmlentities($Image); ?>" alt="<?php echo htmlentities($postTitle); ?>" class="img-fluid card-img-top">
            <div class="card-body">
              <h4 class="card-title">
                <?php echo htmlentities($postTitle); ?>
              </h4>
              <div class="post-meta">
                <small class="text-muted">
                  <i class="fas fa-folder"></i> 
                  <a href="Blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a>
                  <i class="fas fa-user ml-2"></i>
                  <a href="Profil.php?username=<?php echo htmlentities($Admin); ?>"><?php echo htmlentities($Admin); ?></a>
                  <i class="fas fa-calendar ml-2"></i> <?php echo htmlentities($DateTime); ?>
                </small>
                <span class="badge badge-primary">
                  <i class="fas fa-comments"></i> <?php echo ApproveCommentsAccordingToPosts($PostId); ?>
                </span>
              </div>
              <hr>
              <p class="card-text">
                <?php if (strlen($PostDescription) > 150) {
                  $PostDescription = substr($PostDescription, 0, 150) . "...";
                } ?>
                <?php echo htmlentities($PostDescription); ?>
              </p>
              <a href="FullPost.php?id=<?php echo $PostId; ?>" class="btn btn-info float-right">
                Read More <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
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
  <footer class="bg-dark text-white py-4">
    <div class="container">
      <div class="row">
        <div class="col text-center">
          <p class="lead mb-2">
            <i class="fas fa-code"></i> Developed by Abdelkrim Bellagnech | <span id="year"></span> &copy; All Rights Reserved
          </p>
          <p class="small mb-0">
            Modern CMS Blog System built with PHP, MySQL & Bootstrap
          </p>
        </div>
      </div>
    </div>
  </footer>
  <div class="top-bar"></div>
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