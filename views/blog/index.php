<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
    <link href="/assets/css/Styles.css?v=2.0" rel="stylesheet" type="text/css" />
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
    <title><?= $title ?? 'Blog - ABDELKRIMBELLAGNECH.COM' ?></title>
</head>

<body>
    <!-- NAVBAR -->
    <div class="top-bar"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="/" class="navbar-brand"><i class="fas fa-blog"></i> ABDELKRIMBELLAGNECH.COM</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item m-1">
                        <a href="/blog" class="nav-link"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item m-1">
                        <a href="#" class="nav-link"><i class="fas fa-info-circle"></i> About</a>
                    </li>
                    <li class="nav-item m-1">
                        <a href="/blog" class="nav-link"><i class="fas fa-newspaper"></i> Blog</a>
                    </li>
                    <li class="nav-item m-1">
                        <a href="#" class="nav-link"><i class="fas fa-envelope"></i> Contact</a>
                    </li>
                    <li class="nav-item m-1">
                        <a href="#" class="nav-link"><i class="fas fa-star"></i> Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <form class="form-inline d-none d-sm-block search-form" action="/blog">
                        <div class="form-group mb-0">
                            <input class="form-control" type="text" name="Search" placeholder="Search articles..." value="<?= htmlentities($searchQuery ?? '') ?>">
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
                // Display success/error messages if they exist in session
                if (isset($_SESSION['SuccessMessage'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo htmlentities($_SESSION['SuccessMessage']);
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                    echo '<span aria-hidden="true">&times;</span></button></div>';
                    unset($_SESSION['SuccessMessage']);
                }
                if (isset($_SESSION['ErrorMessage'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo htmlentities($_SESSION['ErrorMessage']);
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                    echo '<span aria-hidden="true">&times;</span></button></div>';
                    unset($_SESSION['ErrorMessage']);
                }
                ?>

                <?php if (empty($posts)): ?>
                    <div class="alert alert-info">
                        <h4><i class="fas fa-info-circle"></i> No Posts Found</h4>
                        <p class="mb-0">No posts match your search criteria. Try a different search or browse all posts.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <?php
                        $postId = $post['id'];
                        $dateTime = $post['datetime'];
                        $postTitle = $post['title'];
                        $category = $post['category'];
                        $author = $post['author'];
                        $image = $post['image'];
                        $postDescription = $post['post'];

                        // Get comment count using the Post model
                        $commentCount = \App\Models\Post::getApprovedCommentsCount($postId);
                        ?>
                        <div class="card post-card">
                            <img src="/uploads/<?= htmlentities($image) ?>" alt="<?= htmlentities($postTitle) ?>" class="img-fluid card-img-top">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?= htmlentities($postTitle) ?>
                                </h4>
                                <div class="post-meta">
                                    <small class="text-muted">
                                        <i class="fas fa-folder"></i>
                                        <a href="/blog?category=<?= htmlentities($category) ?>"><?= htmlentities($category) ?></a>
                                        <i class="fas fa-user ml-2"></i>
                                        <a href="/profile?username=<?= htmlentities($author) ?>"><?= htmlentities($author) ?></a>
                                        <i class="fas fa-calendar ml-2"></i> <?= htmlentities($dateTime) ?>
                                    </small>
                                    <span class="badge badge-primary">
                                        <i class="fas fa-comments"></i> <?= $commentCount ?>
                                    </span>
                                </div>
                                <hr>
                                <p class="card-text">
                                    <?php
                                    if (strlen($postDescription) > 150) {
                                        $postDescription = substr($postDescription, 0, 150) . "...";
                                    }
                                    echo htmlentities($postDescription);
                                    ?>
                                </p>
                                <a href="/post/<?= $postId ?>" class="btn btn-info float-right">
                                    Read More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <nav>
                            <ul class="pagination pagination-lg">
                                <!-- Backward button -->
                                <?php if ($currentPage > 1): ?>
                                    <li class="page-item">
                                        <a href="/blog?page=<?= $currentPage - 1 ?>" class="page-link">&laquo;</a>
                                    </li>
                                <?php endif; ?>

                                <!-- Page numbers -->
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <?php if ($i == $currentPage): ?>
                                        <li class="page-item active">
                                            <a href="/blog?page=<?= $i ?>" class="page-link"><?= $i ?></a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a href="/blog?page=<?= $i ?>" class="page-link"><?= $i ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <!-- Forward button -->
                                <?php if ($currentPage < $totalPages): ?>
                                    <li class="page-item">
                                        <a href="/blog?page=<?= $currentPage + 1 ?>" class="page-link">&raquo;</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                    <!-- Pagination End -->
                <?php endif; ?>
            </div>
            <!-- END MAIN AREA -->

            <!-- Side Area Start -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-list"></i> Categories</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($categories)): ?>
                            <ul class="list-group">
                                <?php foreach ($categories as $cat): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="/blog?category=<?= htmlentities($cat['title']) ?>" class="text-decoration-none">
                                            <?= htmlentities($cat['title']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">No categories available</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- Side Area End -->
        </div>
    </div>
    <!-- END HEADER -->

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