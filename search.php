<?php

$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'components/auth_check.php';
require_once 'db/conn.php';

$sessionID = $_SESSION['uID'];
$userID = $sessionID;
$search = $_POST['search'];
$type = $_POST['type'];
#echo "User ID: ".$userID;
#echo " Session ID: ".$_SESSION['uID'];
#$posts = $crud->getPostsForSeach($search);
#$temp = $posts[0]['pID'];
#echo "<h2>$temp</h2>";
?>

<?php if ($type == '1') { ?>
    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <p class="lead">Search Result For: <?php echo $search; ?></p>


                <?php
                $results = $crud->getUsersBySearch($search);
                foreach ($results as $row) { ?>
                    <?php $userName = $row['uName'];?> 
                    <?php $userFirstName = $row['name'];?> 
                    <?php $userLastName = $row['surname'];?> 
                    <?php $userBio = $row['bioContent'];?> 
                    <?php $userID = $row['uID'];?> 
                    <?php $userFollowingCount = $row['followCt'];?> 
                    <?php $userFollowerCount = $row['followerCt'];?> 
                    <?php $isFollowing = $crud->isFollowing($userID, $sessionID); ?>
                    <?php $pp = $row['pp'];?> 

                    <div class="col-md-8 bg-light rounded">
                    <div class="p-2"><img src=<?php echo $pp ?>  alt="user" width="50" class="rounded-circle"></div>
                        <img class="card-body">
                            <p class="card-text"><b>Username: </b><?php echo $userName ?></p>
                            <p class="card-text"><b>Name Surname: </b><?php echo $userFirstName . " " . $userLastName ?></p>
                            <p class="card-text"><b>Bio: </b><?php echo $userBio ?></p>
                            <a href="profile.php?id=<?php echo $userID ?>" class="btn btn-primary">View</a>
                            <a class="btn btn-success" href="showFollow.php?id=<?php echo $userID ?>&action=following"><b>Following: </b><?php echo $userFollowingCount ?> </a>
                            <a class="btn btn-warning" href="showFollow.php?id=<?php echo $userID ?>&action=follower"><b>Follower: </b><?php echo $userFollowerCount ?></a>
                            <a class="btn btn-info" href="showFollow.php?id=<?php echo $userID ?>&action=showlocs"><b>Locations</b></a>
                            <a class="btn btn-info" href="showTags.php?id=<?php echo $userID ?>&action=tags"><b>Tags</b></a>
                            <!-- <p class="card-text"><b>Following: </b><?php echo $userFollowingCount ?>  -  <b>Follower: </b><?php echo $userFollowerCount ?></p>-->
                            
                            
                            
                            <?php if ($isFollowing) : ?>
                                <!--<button type="submit" class="btn btn-secondary" href="newpost.php">Unfollow</button>-->
                                <a class="btn btn-secondary" href="following.php?id=<?php echo $userID ?>&action=unfollow" role="button">Unfollow</a>
                                <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&action=follow" role="button">Report</a>
                            <?php else : ?>
                                <a class="btn btn-primary" href="following.php?id=<?php echo $userID ?>&action=follow" role="button">Follow</a>
                                <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&action=follow" role="button">Report</a>
                            <?php endif; ?>
                        </img>
                    </div>
                    <br><br>
                <?php } ?>

            </div>

        </div>
    </div>



<?php } ?>



<?php if ($type == '2') { ?>
    <div class="container mb-4">
        <h2>Search Results</h2>

        <div class="row row-cols-1 row-cols-md-2 mb-4 g-4">

            <?php
            $posts = $crud->getPostsForSearch($search);
            foreach ($posts as $post) {
                #echo $post['pID']. "<br>";
            ?>
                <?php if ($post['isHidden'] == 0) : ?>
                    <?php $checkLike = $crud->isPostLikedByUser($sessionID, $post['pID']); ?>
                    <div class="col align-items-stretch">
                        <div class="card h-100">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <a href="profile.php?id=<?php echo $post['uID'] ?>">
                                    <h5 class="card-title"><?php echo $post['uName'] ?></h5>
                                </a>
                                <p class="card-text"><?php echo $post['txt'] ?></p>
                                <p class="card-text"><b>Likes:</b> <?php echo $post['likeCt'] ?></p>
                                <p class="card-text"><b>Comments:</b></p>
                                <?php
                                $comments = $crud->getCommentsforPost($post['pID']);
                                foreach ($comments as $comment) { ?>
                                    <p class="card-text"><b> <?php echo $comment['uName'] ?> </b>: <?php echo $comment['content'] ?> - <?php echo $comment['timeSt'] ?> </p>
                                <?php } ?>
                                <p class="card-text"><?php echo $post['timeSt'] ?></p>
                                <p class="card-text"><?php echo $post['mediaPath'] ?></p>
                                <?php if (!$checkLike) : ?>
                                    <form action="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=feed" method="post" class="form-control mb-2">
                                        <input type="text" name="content" class="form-control mb-2">
                                        <button type="submit" class="btn btn-primary" href="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" role="button">Comment</button>
                                    </form>
                                    <a class="btn btn-primary" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=like&feed" role="button">Like</a>
                                    <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>" role="button&feed">Report</a>
                                <?php elseif ($checkLike) : ?>
                                    <form action="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=feed" method="post" class="form-control mb-2">
                                        <input type="text" name="content" class="form-control mb-2">
                                        <button type="submit" class="btn btn-primary" href="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" role="button">Comment</button>
                                    </form>
                                    <a class="btn btn-warning" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=dislike&feed" role="button">Dislike</a>
                                    <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>" role="button&feed">Report</a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php } ?>
        </div>
    </div>
    <!--container div  -->
<?php } ?>


<?php require_once 'components/footer.php'; ?>
