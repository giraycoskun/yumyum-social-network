<?php

$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'components/auth_check.php';
require_once 'db/conn.php';

$sessionID = $_SESSION['uID'];
$userID = $sessionID;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = $_POST['search'];
    $type = $_POST['type'];
    $_SESSION['search'] = $search;
    $_SESSION['type'] = $type;
} else {
    $search = $_SESSION['search'];
    $type = $_SESSION['type'];
}


if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

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
                    <?php $userName = $row['uName']; ?>
                    <?php $userFirstName = $row['name']; ?>
                    <?php $userLastName = $row['surname']; ?>
                    <?php $userBio = $row['bioContent']; ?>
                    <?php $userID = $row['uID']; ?>
                    <?php $userFollowingCount = $row['followCt']; ?>
                    <?php $userFollowerCount = $row['followerCt']; ?>
                    <?php $isFollowing = $crud->isFollowing($userID, $sessionID); ?>
                    <?php $pp = $row['pp']; ?>

                    <div class="col-md-8 bg-light rounded">
                        <div class="p-2"><img src=<?php echo $pp ?> alt="user" width="50" class="rounded-circle"></div>
                        <img class="card-body">
                        <p class="card-text"><b>Username: </b><?php echo $userName ?></p>
                        <p class="card-text"><b>Name Surname: </b><?php echo $userFirstName . " " . $userLastName ?></p>
                        <p class="card-text"><b>Bio: </b><?php echo $userBio ?></p>
                        <a href="profile.php?id=<?php echo $userID ?>" class="btn btn-primary">View</a>
                        <a class="btn btn-success" href="showFollow.php?id=<?php echo $userID ?>&action=following"><b>Following: </b><?php echo $userFollowingCount ?> </a>
                        <a class="btn btn-warning" href="showFollow.php?id=<?php echo $userID ?>&action=follower"><b>Follower: </b><?php echo $userFollowerCount ?></a>
                        <a class="btn btn-info" href="showFollow.php?id=<?php echo $userID ?>&action=locs"><b>Locations</b></a>
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
    <!--container div  -->
    <div class="container mb-4">
        <h2>Search Results</h2>

        <div class="row row-cols-1 row-cols-md-2 mb-4 g-4">

            <?php
            #$userID = $_GET['id'];
            $posts = $crud->getPostsForSearch($search);
            $startIndex = ($page - 1) * 6;
            $countP = 6;
            for (; $startIndex < count($posts); $startIndex++) {
                $post = $posts[$startIndex];
                if ($countP == 0) {
                    break;
                }
                $countP = $countP - 1; ?>
                <?php if ($post['isHidden'] == 0) : ?>
                    <?php $checkLike = $crud->isPostLikedByUser($sessionID, $post['pID']); ?>
                    <div class="col align-items-stretch rounded">
                        <div class="card h-100">
                            <div class="card-header">
                                <div class="d-flex align-content center justify-content-between ">
                                    <div class="d-flex justify-content-start align-items-center ">
                                        <img src="<?php echo $post['pp'] ?>" alt="user" width="50" class="float-left">

                                        <a class="text-dark " href="profile.php?id=<?php echo $post['uID'] ?>">
                                            <h5 class="mx-2 center card-title "><?php echo $post['uName'] ?></h5>
                                        </a>
                                    </div>

                                    <?php $loc = $crud->getLocationForPost($post['pID']);
                                    if (count($loc) == 1) {
                                        $locName = $loc[0]['locName'];
                                        $locID = $loc[0]['locID'];
                                    }
                                    if (isset($locName)) : ?>
                                        <?php $href = "location.php?id=$sessionID&locID=$locID"; ?>
                                        <?php echo "<a href=$href class='badge badge-warning text-dark h5 align-items-center'>  $locName </a>"; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card-body">


                                <a href="post.php?id=<?php echo $post['pID'] ?>">
                                    <img src="<?php echo $post['mediaPath'] ?>" class="card-img-top" alt="...">
                                </a>
                                <p class="card-text "><?php echo $post['timeSt'] ?></p>
                                <p class="card-text mt-4"><?php echo $post['txt'] ?></p>
                                <?php $comments = $crud->getCommentsforPost($post['pID']); ?>
                                <p class="card-text"><b>Likes:</b> <?php echo $post['likeCt'] ?> - <b>Comments:</b> <?php echo count($comments) ?></p>

                                <div class="d-flex text-left mt-4">
                                    <b>Tags:</b>
                                    <?php $tags = $crud->getTagsforPost($post['pID']);
                                    foreach ($tags as $tag) {
                                        $tagName = $tag['tagName'];
                                        $tagID = $tag['tagID'];
                                        $href = "tag.php?id=$sessionID&tagID=$tagID";
                                        echo "<a href=$href class='badge badge-warning text-dark'>$tagName</a>";
                                    } ?>
                                </div>
                                <div class="container p-3 my-3 bg-info text-white rounded">
                                    <a href="post.php?id=<?php echo $post['pID'] ?>" , class="card-text text-dark"><b>Comments:</b></a>
                                    <?php $count = 3;
                                    foreach ($comments as $comment) {
                                        if ($count == 0) {
                                            break;
                                        }
                                        $count = $count - 1; ?>
                                        <p class="card-text"><b> <?php echo $comment['uName'] ?> </b>: <?php echo $comment['content'] ?> - <?php echo $comment['timeSt'] ?> </p>
                                    <?php } ?>
                                </div>


                                <?php if (!$checkLike) : ?>
                                    <form action="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=search" method="post" class="form-control mb-2">
                                        <input type="text" name="content" class="form-control mb-2">
                                        <button type="submit" class="btn btn-primary" href="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" role="button">Comment</button>
                                    </form>
                                    <a class="btn btn-primary" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=like&search" role="button">Like</a>
                                    <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>" role="button&search">Report</a>
                                <?php elseif ($checkLike) : ?>
                                    <form action="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=search" method="post" class="form-control mb-2">
                                        <input type="text" name="content" class="form-control mb-2">
                                        <button type="submit" class="btn btn-primary" href="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" role="button">Comment</button>
                                    </form>
                                    <a class="btn btn-warning" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=dislike&search" role="button">Dislike</a>
                                    <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>" role="button&search">Report</a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php } ?>
        </div>
        <nav aria-label="...">
            <ul class="pagination pagination-lg justify-content-center">
                <?php
                $countP = 6;
                $postCount = count($posts);
                $pageCount = ceil((float)$postCount / $countP);
                for ($i = 0; $i < $pageCount; $i++) {
                    if($i >10)
                    {
                        break;
                    }
                ?>
                    <?php if ($page == $i + 1) : ?>
                        <li class="page-item active" aria-current="page">
                            <span class="page-link"><?php echo ($i + 1) ?></span>
                        </li>
                    <?php else : ?>
                        <li class="page-item"><a class="page-link" href="search.php?page=<?php echo ($i + 1) ?>"><?php echo ($i + 1) ?></a></li>
                    <?php endif; ?>
                <?php } ?>
            </ul>
        </nav>
    </div>
    <!--container div  -->
<?php } ?>

<?php if ($type == '3') { ?>
    <div class="container mb-4">
        <div class="row mx-auto">
            <div class="row-12">
                <p class="lead">Search Result For: <?php echo $search; ?></p>


                <?php
                $results = $crud->getLocsBySearch($search);
                foreach ($results as $row) {
                    $locName = $row['locName'];
                    $locID = $row['locID'];
                    $postCount = $row['postCount'];
                    $isFollowing = $crud->isUserFollowLoc($userID, $locID); ?>


                    <div class="card text-center col-md-8 bg-light rounded mx-auto">
                        <p class="card-text h-3 dark-text"><b>Location: </b><?php echo $locName ?></p>
                        <p class="card-text"><b>Post Count: </b><?php echo $postCount  ?></p>
                        <a href="location.php?id=<?php echo $userID ?>&locID=<?php echo $locID ?>" class="btn btn-info">View</a>
                        <?php if ($isFollowing) : ?>
                            <!--<button type="submit" class="btn btn-secondary" href="newpost.php">Unfollow</button>-->
                            <a class="btn btn-secondary" href="following.php?id=<?php echo $locID ?>&action=unfollowLoc&from=search" role="button">Unfollow</a>
                        <?php else : ?>
                            <a class="btn btn-warning" href="following.php?id=<?php echo $locID ?>&action=followLoc&from=search" role="button">Follow</a>
                        <?php endif; ?>
                    </div>
                    <br><br>
                <?php } ?>

            </div>

        </div>
    </div>
    <!--container div  -->
<?php } ?>

<?php if ($type == '4') { ?>
    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <p class="lead">Search Result For: <?php echo $search; ?></p>


                <?php
                $results = $crud->getTagsBySearch($search);
                foreach ($results as $row) {
                    $tagName = $row['tagName'];
                    $tagID = $row['tagID'];
                    $postCount = $row['postCount'];
                    $isFollowing = $crud->isUserFollowTag($userID, $tagID);
                ?>

                    <div class="card text-center col-md-8 bg-light rounded mx-auto">
                        <p class="card-text h-3 dark-text"><b>Tag: </b><?php echo $tagName ?></p>
                        <p class="card-text"><b>Post Count: </b><?php echo $postCount  ?></p>
                        <a href="tag.php?id=<?php echo $userID ?>&tagID=<?php echo $tagID ?>" class="btn btn-info">View</a>
                        <?php if ($isFollowing) : ?>
                            <!--<button type="submit" class="btn btn-secondary" href="newpost.php">Unfollow</button>-->
                            <a class="btn btn-secondary" href="following.php?id=<?php echo $tagID ?>&action=unfollowTag&from=search" role="button">Unfollow</a>
                        <?php else : ?>
                            <a class="btn btn-warning" href="following.php?id=<?php echo $tagID ?>&action=followTag&from=search" role="button">Follow</a>
                        <?php endif; ?>
                    </div>
                    <br><br>

                <?php } ?>

            </div>

        </div>
    </div>
    <!--container div  -->
<?php } ?>


<?php require_once 'components/footer.php'; ?>