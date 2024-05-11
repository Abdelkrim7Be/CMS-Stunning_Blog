<div class="col-sm-4">
    <div class="card mt-4">
        <div class="card-body">
            <img src="images/startblog.jpg" class="d-block img-fluide mb-3" alt="" width="307px" height="500px">
            <div class="text-center">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum voluptas quos beatae obcaecati animi
                quisquam
                quae, explicabo, laudantium nemo id reiciendis expedita perferendis ipsum eaque! Lorem ipsum dolor sit
                amet consectetur, adipisicing elit. Nam quaerat aliquid ratione hic saepe repudiandae!
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header bg-dark text-light">
            <h2 class="lead">Sign Up!</h2>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button">Join The
                Forum</button>
            <button type="button" class="btn btn-danger btn-block text-center text-white mb-4"
                name="button">Login</button>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="" placeholder="Enter your email" value="">
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe
                        Now!!</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header bg-primary text-light">
            <h2 class="lead">
                Categories
            </h2>
        </div>
        <div class="card-body">
            <?php
            global $connectingDB;
            $sql = "SELECT * FROM category ORDER BY id desc";
            $stmt = $connectingDB->query($sql);
            while ($DataRows = $stmt->fetch()) {
                $CategoryId = $DataRows['id'];
                $CategoryName = $DataRows['title'];
                ?>
                <a href="Blog.php?category=<?php echo $CategoryName; ?>"> <span class="heading">
                        <?php echo $CategoryName; ?>
                    </span></a><br>
            <?php } ?>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h2 class="lead">Recent Posts</h2>
        </div>
        <div class="card-body">
            <?php
            global $connectingDB;
            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
            $stmt = $connectingDB->query($sql);
            while ($DataRows = $stmt->fetch()) {
                $Id = $DataRows['id'];
                $Title = $DataRows['title'];
                $DateTime = $DataRows['datetime'];
                $Image = $DataRows['image'];
                ?>
                <div class="media">
                    <img src="Upload/<?php echo htmlentities($Image); ?>" alt="" class="d-block img-fluide align-self-start"
                        width="90" height="94">
                    <div class="media-body ml-2">
                        <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank">
                            <h6 class="lead">
                                <?php echo htmlentities($Title); ?>
                            </h6>
                        </a>
                        <p class="small">
                            <?php echo htmlentities($DateTime); ?>
                        </p>
                    </div>
                </div>
                <hr>

            <?php } ?>
        </div>
    </div>
</div>