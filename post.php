<?php

$title = 'Post';
require_once 'components/header.php';
require_once 'components/auth_check.php';
require_once 'db/conn.php'
//echo "hi";
?>
<?php
if (!isset($_GET['id'])) {
    echo "bir sıkıntı var";
} else {



    $id = $_GET['id'];
    $sessionID = $_SESSION['uID'];


    $post = $crud->getPostByID($id);
    $userID = $post['uID'];
    $comments = $crud->getCommentsforPost($post['pID']);
    $checkLike = $crud->isPostLikedByUser($sessionID, $post['pID']);
    $loc = $crud->getLocationForPost($post['pID']);
    if (count($loc) == 1) {
        $locName = $loc[0]['locName'];
    }
    $tags = $crud->getTagsforPost($post['pID']);
    $likers = $crud->getLikersforPost($post['pID']);
}
?>

<div class="row d-flex justify-content-center mt-100 mb-100">
    <div class="col-lg-6">


        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title">Post</h4>
                <img src="files/posts/images.jpeg" class="card-img-top" alt="...">
                <h5 class="mt-2 mb-2 card-text"><b>Likes:</b> <?php echo $post['likeCt'] ?> - <b>Comments:</b> <?php echo count($comments) ?></h5>
                <?php if (isset($locName)) : ?>
                    <h5 class="mt-2 mb-2 card-text"><b>Location: </b> <?php echo $locName ?></h5>
                <?php endif; ?>

                <p class="card-text"><?php echo $post['timeSt'] ?></p>
                <div class="d-flex mb-2 ms-2">
                    <?php if ($checkLike) : ?>
                        <a class="btn btn-warning ms-2" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=dislike&post" role="button">Dislike</a>
                    <?php elseif (!$checkLike) : ?>
                        <a class="btn btn-primary ms-2" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=like&post" role="button">Like</a>
                    <?php endif; ?>
                    <a class="btn btn-danger ms-2" href="report.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>" role="button&feed">Report</a>
                </div>

                <div class="d-flex text-left mt-4">
                    <h5>Tags:</h5>
                    <?php foreach ($tags as $tag) {
                        $tagName = $tag['tagName'];
                        $tagID = $tag['tagID'];
                        $href = "tag.php?id=$tagID";
                        echo "<a href=$href class='badge badge-warning text-dark'>$tagName</a>";
                    } ?>
                </div>
                <div class="d-flex text-left mt-2">
                    <h5>Likes:</h5>
                    <?php foreach ($likers as $liker) {
                        $likerName = $liker['uName'];
                        $likerID = $liker['uID'];
                        $href = "profile.php?id=$likerID";
                        echo "<a href=$href class='badge badge-warning text-dark'>$likerName</a>";
                    } ?>
                </div>


            </div>
            <div class="ms-4 comment-widgets">
                <!-- Comment Row -->
                <?php foreach ($comments as $comment) { ?>
                    <div class="d-flex flex-row comment-row m-t-0">
                        <div class="p-2"><img src="<?php echo $comment['pp'] ?>" alt="user" width="50" class="rounded-circle"></div>
                        <div class="comment-text w-100">
                            <a href="profile.php?id=<?php echo $comment['uID'] ?>" class="h-5 font-medium"><?php echo $comment['uName'] ?></a> <span class="m-b-15 d-block"><?php echo $comment['content'] ?></span>
                            <div class="comment-footer"> <span class="text-muted float-right"><?php echo $comment['timeSt'] ?></span> </div>
                        </div>
                    </div> <!-- Comment Row -->
                <?php } ?>

                <form action="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=post" method="post" class="form-control mb-2">
                    <input type="text" name="content" class="form-control mb-2">
                    <button type="submit" class="btn btn-primary" href="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" role="button">Comment</button>
                </form>
            </div> <!-- Card -->
        </div>
    </div>
</div>


<?php require_once 'components/footer.php'; ?>