<?php

$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'components/auth_check.php';
require_once 'db/conn.php';

$userID = $_GET['id'];
if ($userID != $_SESSION['uID']) {
    header("Location: logout.php");
}
$sessionID = $_SESSION['uID'];
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
#echo "User ID: ".$userID;
#echo " Session ID: ".$_SESSION['uID'];

?>

<div class="container mb-4">
    <h1>Welcome to Home</h1>

    <div class="row row-cols-1 row-cols-md-2 mb-4 g-4">

        <?php
        $userID = $_GET['id'];
        $posts = $crud->getPostsForFeed($userID);
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
                                    $href = "tag.php?id=$userID&tagID=$tagID";
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
    <nav aria-label="...">
        <ul class="pagination pagination-lg justify-content-center">
            <?php
            $countP = 6;
            $postCount = count($posts);
            $pageCount = ceil((float)$postCount / $countP);
            for ($i = 0; $i < $pageCount; $i++) {
            ?>
                <?php if ($page == $i + 1) : ?>
                    <li class="page-item active" aria-current="page">
                        <span class="page-link"><?php echo ($i + 1) ?></span>
                    </li>
                <?php else : ?>
                    <li class="page-item"><a class="page-link" href="feed.php?id=<?php echo $userID ?>&page=<?php echo ($i + 1) ?>"><?php echo ($i + 1) ?></a></li>
                <?php endif; ?>
            <?php } ?>
        </ul>
    </nav>
</div>
<!--container div  -->



<?php require_once 'components/footer.php'; ?>