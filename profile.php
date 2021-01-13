<?php

$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'components/auth_check.php';
require_once 'db/conn.php';

$userID = $_GET['id'];
$sessionID = $_SESSION['uID'];
$isFollowing = $crud->isFollowing($userID, $sessionID);
$result = $crud->getUserInfo($userID);


if (!$result['isActive']) {
    header("Location: userNotFound.php");
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$userName = $result['uName'];
$userFirstName = $result['name'];
$userLastName = $result['surname'];
$userAge = $result['age'];
$userSex = $result['sex'];
$userBio = $result['bioContent'];
$userMail = $result['mail'];
$userPP = $result['pp'];
$userFollowerCount = $result['followerCt'];
$userFollowingCount = $result['followCt'];

?>



<div class="container mt-2">
    <h1>Hello, <?php echo $_SESSION['username'] ?></h1>
    <div class="card mb-3">
        <div class="row g-0">
            <div class=" col-md-4">
                <img class="img-thumbnail img-fluid rounded mx-auto d-block" style="width: 20rem; height: 15rem;" src="<?php echo $userPP ?>" alt="Image Not Found">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text"><b>Name: </b><?php echo $userFirstName . " " . $userLastName ?></p>
                    <p class="card-text"><b>Bio: </b><?php echo $userBio ?> - <b>Age:</b><?php echo $userAge ?></p>
                    <a class="btn btn-success" href="showFollow.php?id=<?php echo $userID ?>&action=following"><b>Following: </b><?php echo $userFollowingCount ?> </a>
                    <a class="btn btn-warning" href="showFollow.php?id=<?php echo $userID ?>&action=follower"><b>Follower: </b><?php echo $userFollowerCount ?></a>
                    <a class="btn btn-info" href="showFollow.php?id=<?php echo $userID ?>&action=locs"><b>Locations</b></a>
                    <a class="btn btn-dark" href="showFollow.php?id=<?php echo $userID ?>&action=tags"><b>Tags</b></a>
                    <!-- <p class="card-text"><b>Following: </b><?php echo $userFollowingCount ?>  -  <b>Follower: </b><?php echo $userFollowerCount ?></p>-->
                    <p class="card-text"><small class="text-muted"><?php echo $userName . " - " . $userMail ?></small></p>
                    <!-- Button trigger modal -->
                    <?php if ($sessionID == $userID) : ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#deactivateModal">Deactivate</button>
                    <?php elseif ($isFollowing) : ?>
                        <!--<button type="submit" class="btn btn-secondary" href="newpost.php">Unfollow</button>-->
                        <a class="btn btn-secondary" href="following.php?id=<?php echo $userID ?>&action=unfollow&from=profile" role="button">Unfollow</a>
                        <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&action=follow" role="button">Report</a>
                    <?php else : ?>
                        <a class="btn btn-primary" href="following.php?id=<?php echo $userID ?>&action=follow&from=profile" role="button">Follow</a>
                        <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&action=follow" role="button">Report</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="updateProfile.php" method="post" class="d-flex px-2" enctype="multipart/form-data">
    <!-- Modal Edit-->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Profile Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php include('form.php') ?>
                </div>

            </div>
        </div>
    </div>
</form>

<form action="deactivate.php?id=<?php echo $sessionID ?>" method="post" class="d-flex px-2">
    <!-- Modal Deactivate-->
    <div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deactivateModalLabel">Deactivate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="d-flex container row mt-auto">
                            <h2>Goodbye, <?php echo $_SESSION['username'] ?></h2>
                            <div class="row mt-auto">
                                <div class="col">
                                    <label for="date">Until:</label>
                                    <input type="date" class="form-control" placeholder="Date" name="date" min="<?php echo date("Y-m-d"); ?>">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col container">
                                    <button class="btn btn-lg btn-primary " name="submit" type="submit">Submit</button>
                                    <button class="btn btn-lg btn-danger " name="delete" type="submit">Delete</button>
                                    <button class="btn btn-lg btn-secondary " name="close" type="submit" onClick="removeRequired(this.form)">Close</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</form>


<div class="container mb-4">

    <div class="row row-cols-1 row-cols-md-2 mb-4 g-4">

        <?php
        $userID = $_GET['id'];
        $posts = $crud->getPostsbyUser($userID);
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
                <div class="col align-items-stretch">
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

                            <?php if ($sessionID == $userID) : ?>
                                <form action="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" method="post" class="form-control mb-2">
                                    <input type="text" name="content" class="form-control mb-2">
                                    <button type="submit" class="btn btn-primary" href="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" role="button">Comment</button>
                                </form>
                                <?php if (!$checkLike) : ?>
                                    <a class="btn btn-primary" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=like&profile" role="button">Like</a>
                                <?php elseif ($checkLike) : ?>
                                    <a class="btn btn-warning" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=dislike&profile" role="button">Dislike</a>
                                <?php endif; ?>
                                <a class="btn btn-danger align-item-end" href="hidePost.php?id=<?php echo $post['pID'] ?>&action=delete" role="button">Delete</a>
                                <button type="button" class="btn btn-warning align-item-end" data-whatever="<?php echo $post['pID'] ?>" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>
                            <?php elseif (!$checkLike) : ?>
                                <form action="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" method="post" class="form-control mb-2">
                                    <input type="text" name="content" class="form-control mb-2">
                                    <button type="submit" class="btn btn-primary" href="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" role="button">Comment</button>
                                </form>
                                <a class="btn btn-primary" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=like&profile" role="button">Like</a>
                                <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>" role="button&profile">Report</a>
                            <?php elseif ($checkLike) : ?>
                                <form action="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" method="post" class="form-control mb-2">
                                    <input type="text" name="content" class="form-control mb-2">
                                    <button type="submit" class="btn btn-primary" href="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" role="button">Comment</button>
                                </form>
                                <a class="btn btn-warning" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=dislike&profile" role="button">Dislike</a>
                                <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>" role="button&profile">Report</a>
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
                    <li class="page-item"><a class="page-link" href="profile.php?id=<?php echo $userID ?>&page=<?php echo ($i + 1) ?>"><?php echo ($i + 1) ?></a></li>
                <?php endif; ?>
            <?php } ?>
        </ul>
    </nav>
</div>
<!--container div  -->

<form action="updatePost.php" method="post" class="d-flex px-2" enctype="multipart/form-data">
    <!-- Modal Edit-->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Post Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mt-2">
                        <div class="col">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="post-id" name="postID" value="">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Content:</label>
                                <textarea class="form-control" id="content" name="content"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col container">
                            <button class="btn btn-lg btn-primary " name="update" type="submit">Update</button>
                            <button class="btn btn-lg btn-secondary " name="close" type="submit">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



<script type='text/javascript'>
    $('#updateModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var postID = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        //modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input').val(postID)
    })
</script>

<?php require_once 'components/footer.php'; ?>