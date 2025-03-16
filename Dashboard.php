<?php
require_once("Includes/DB.php");
require_once("Includes/Functions2.php");
require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION['TrackingURL'] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <title>Dashboard | Admin Panel</title>
  <style>
    :root {
      --primary: #27aae1;
      --secondary: #2c3e50;
      --success: #2ecc71;
      --warning: #f39c12;
      --danger: #e74c3c;
      --light: #f8f9fa;
      --dark: #343a40;
    }

    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .top-bar {
      height: 10px;
      background: linear-gradient(to right, var(--primary), var(--secondary));
    }

    .navbar {
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .nav-link {
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .nav-link:hover {
      transform: translateY(-2px);
    }

    .dashboard-header {
      background: linear-gradient(120deg, var(--dark), var(--secondary));
      padding: 2rem 0;
      margin-bottom: 2rem;
      border-radius: 0 0 10px 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .dashboard-header h1 {
      font-weight: 700;
      letter-spacing: 1px;
    }

    .btn-action {
      border-radius: 50px;
      font-weight: 600;
      padding: 0.6rem 1.5rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .btn-action:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .welcome-card {
      background: linear-gradient(to right, var(--primary), #36d1dc);
      color: white;
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .welcome-card h3 {
      font-weight: 600;
      margin-bottom: 0;
    }

    .stat-card {
      background-color: white;
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      text-align: center;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-card .icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      display: inline-block;
      padding: 15px;
      border-radius: 50%;
      color: white;
    }

    .stat-card.posts .icon {
      background-color: var(--primary);
    }

    .stat-card.categories .icon {
      background-color: var(--warning);
    }

    .stat-card.admins .icon {
      background-color: var(--danger);
    }

    .stat-card.comments .icon {
      background-color: var(--success);
    }

    .stat-card h3 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .stat-card p {
      color: #6c757d;
      font-weight: 500;
      margin-bottom: 0;
    }

    .top-posts-section {
      background-color: white;
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .top-posts-section h2 {
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: var(--secondary);
      border-bottom: 2px solid var(--primary);
      padding-bottom: 0.5rem;
    }

    .table thead th {
      background-color: var(--secondary);
      color: white;
      font-weight: 600;
      border: none;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: rgba(0, 0, 0, 0.02);
    }

    .table td,
    .table th {
      vertical-align: middle;
    }

    .badge {
      font-size: 85%;
      font-weight: 600;
      padding: 0.35em 0.65em;
    }

    .btn-preview {
      background-color: var(--primary);
      color: white;
      border-radius: 50px;
      padding: 0.25rem 1rem;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-preview:hover {
      background-color: var(--secondary);
      color: white;
      transform: translateY(-2px);
    }

    footer {
      background-color: var(--dark);
      color: white;
      padding: 2rem 0;
      margin-top: 2rem;
    }

    footer p {
      margin-bottom: 0.5rem;
    }

    footer .small {
      opacity: 0.8;
    }
  </style>
</head>

<body>
  <!-- Top Bar -->
  <div class="top-bar"></div>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand font-weight-bold">ABDELKRIMBELLAGNECH.COM</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item m-1">
            <a href="MyProfil.php" class="nav-link"><i class="fa-solid fa-user"></i> My Profile</a>
          </li>
          <li class="nav-item m-1">
            <a href="Dashboard.php" class="nav-link active"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
          </li>
          <li class="nav-item m-1">
            <a href="Posts.php" class="nav-link"><i class="fa-solid fa-blog"></i> Posts</a>
          </li>
          <li class="nav-item m-1">
            <a href="Categories.php" class="nav-link"><i class="fa-solid fa-folder"></i> Categories</a>
          </li>
          <li class="nav-item m-1">
            <a href="Admins.php" class="nav-link"><i class="fa-solid fa-users-gear"></i> Manage Admins</a>
          </li>
          <li class="nav-item m-1">
            <a href="Comments.php" class="nav-link"><i class="fa-solid fa-comments"></i> Comments</a>
          </li>
          <li class="nav-item m-1">
            <a href="Blog.php?page=1" class="nav-link"><i class="fa-solid fa-globe"></i> Live Blog</a>
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

  <!-- Dashboard Header -->
  <header class="dashboard-header text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mb-4">
          <h1><i class="fas fa-tachometer-alt" style="color: var(--primary);"></i> Dashboard</h1>
          <p class="lead">Manage your blog content and monitor activity</p>
        </div>
        <div class="col-lg-3 col-md-6 mb-2">
          <a href="AddNewPost.php" class="btn btn-primary btn-action btn-block">
            <i class="fas fa-edit"></i> Add New Post
          </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-2">
          <a href="Categories.php" class="btn btn-warning btn-action btn-block">
            <i class="fas fa-folder-plus"></i> Add New Category
          </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-2">
          <a href="Admins.php" class="btn btn-danger btn-action btn-block">
            <i class="fas fa-user-plus"></i> Add New Admin
          </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-2">
          <a href="Comments.php" class="btn btn-success btn-action btn-block">
            <i class="fas fa-check"></i> Approve Comments
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Area -->
  <section class="container py-2 mb-4">
    <div class="row">
      <?php
      echo ErrorMessage();
      echo SuccessMessage();
      ?>

      <!-- Welcome Card -->
      <div class="col-12">
        <div class="welcome-card">
          <h3><i class="fas fa-hand-wave"></i> Welcome, <?php echo $_SESSION["AdminName"]; ?>!</h3>
          <p class="mb-0">Here's what's happening on your blog today</p>
        </div>
      </div>

      <!-- Statistics Cards -->
      <div class="col-lg-3 col-md-6">
        <div class="stat-card posts">
          <div class="icon">
            <i class="fas fa-book"></i>
          </div>
          <h3><?php TotalPosts(); ?></h3>
          <p>Total Posts</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card categories">
          <div class="icon">
            <i class="fas fa-folder"></i>
          </div>
          <h3><?php TotalCategories(); ?></h3>
          <p>Categories</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card admins">
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <h3><?php TotalAdmins(); ?></h3>
          <p>Admins</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card comments">
          <div class="icon">
            <i class="fas fa-comments"></i>
          </div>
          <h3><?php TotalComments(); ?></h3>
          <p>Comments</p>
        </div>
      </div>

      <!-- Top Posts Table -->
      <div class="col-12">
        <div class="top-posts-section">
          <h2>Recent Posts</h2>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="thead-dark">
                <tr>
                  <th width="5%">No.</th>
                  <th width="35%">Title</th>
                  <th width="15%">Date & Time</th>
                  <th width="15%">Author</th>
                  <th width="15%">Comments</th>
                  <th width="15%">Actions</th>
                </tr>
              </thead>
              <tbody>
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

                  // Format the date nicely
                  $formattedDate = date("F j, Y g:i A", strtotime($DateTime));
                ?>
                  <tr>
                    <td><?php echo $SrNo; ?></td>
                    <td>
                      <a href="FullPost.php?id=<?php echo $PostId; ?>" class="text-dark font-weight-bold">
                        <?php echo $Title; ?>
                      </a>
                    </td>
                    <td><?php echo $formattedDate; ?></td>
                    <td><?php echo $Author; ?></td>
                    <td>
                      <?php
                      $TotalApproved = ApproveCommentsAccordingToPosts($PostId);
                      $TotalUnapproved = DisApproveCommentsAccordingToPosts($PostId);
                      $TotalComments = $TotalApproved + $TotalUnapproved;

                      if ($TotalApproved > 0) {
                        echo '<span class="badge badge-success mr-1">' . $TotalApproved . ' Approved</span>';
                      }

                      if ($TotalUnapproved > 0) {
                        echo '<span class="badge badge-danger">' . $TotalUnapproved . ' Pending</span>';
                      }

                      if ($TotalComments == 0) {
                        echo '<span class="badge badge-secondary">No Comments</span>';
                      }
                      ?>
                    </td>
                    <td>
                      <a target="_blank" href="FullPost.php?id=<?php echo $PostId; ?>" class="btn btn-preview">
                        <i class="fas fa-eye"></i> Preview
                      </a>
                    </td>
                  </tr>
                <?php } ?>

                <?php if ($SrNo == 0) { ?>
                  <tr>
                    <td colspan="6" class="text-center">
                      <div class="alert alert-info">
                        No posts found. <a href="AddNewPost.php">Add your first post now!</a>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="text-right">
            <a href="Posts.php" class="btn btn-primary btn-sm">View All Posts <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-dark text-white">
    <div class="container">
      <div class="row">
        <div class="col">
          <p class="lead text-center mb-2">
            Theme by | Abdelkrim Bellagnech | <span id="year"></span> &copy;
            All rights Reserved.
          </p>
          <p class="text-center small">
            Created with <i class="fas fa-heart text-danger"></i> for content creators who want to share their knowledge with the world
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