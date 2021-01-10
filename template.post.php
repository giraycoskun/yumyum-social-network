<div class="container mb-4">
    <h2>Posts with Tag: <?php echo $tagName ?></h2>

    <div class="row row-cols-1 row-cols-md-2 mb-4 g-4">

        <?php
        $posts = $crud->getPostsForTag($tagID);
        $countP = 8;
        foreach ($posts as $post) {
            if ($countP == 0) {
                break;
            }
            $countP = $countP - 1; ?>
            <?php if ($post['isHidden'] == 0) : ?>
                <?php $checkLike = $crud->isPostLikedByUser($sessionID, $post['pID']); ?>
                <div class="col align-items-stretch rounded">
                    <div class="card h-100">
                        <a href="post.php?id=<?php echo $post['pID'] ?>">
                            <img src="files/posts/images.jpeg" class="card-img-top" alt="...">
                        </a>
                        <div class="card-body">
                            <a class="text-dark" href="profile.php?id=<?php echo $post['uID'] ?>">
                                <h5 class="card-title"><?php echo $post['uName'] ?></h5>
                            </a>
                            <p class="card-text"><?php echo $post['mediaPath'] ?></p>
                            <p class="card-text"><?php echo $post['txt'] ?></p>
                            <?php $comments = $crud->getCommentsforPost($post['pID']); ?>
                            <p class="card-text"><b>Likes:</b> <?php echo $post['likeCt'] ?> - <b>Comments:</b> <?php echo count($comments) ?></p>
                            <?php $loc = $crud->getLocationForPost($post['pID']);
                            if (count($loc) == 1) {
                                $locName = $loc[0]['locName'];
                                $locID = $loc[0]['locID'];
                                $href = "location.php?id=$sessionID&locID=$locID";
                            }
                            if (isset($locName)) : ?>
                                <a href=<?php echo $href ?> class="mt-2 mb-2 card-text text-dark"><b><b>Location:</b> </b> <?php echo $locName ?></a>
                            <?php endif; ?>
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
                            <p class="card-text"><?php echo $post['timeSt'] ?></p>

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