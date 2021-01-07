<?php 

$title = 'Yum-Yum Home';
require_once 'components/header.php'; 
require_once 'components/auth_check.php';
require_once 'db/conn.php';

$sessionID = $_SESSION['uID'];
$userID = $sessionID;
$search = $_POST['search'];
#echo "User ID: ".$userID;
#echo " Session ID: ".$_SESSION['uID'];
#$posts = $crud->getPostsForSeach($search);
#$temp = $posts[0]['pID'];
#echo "<h2>$temp</h2>";
?>

<div class="container mb-4">
    <h2>Search Results</h2>
    
    <div class="row row-cols-1 row-cols-md-2 mb-4 g-4">
        
        <?php 
            $posts = $crud->getPostsForSeach($search);
            echo "<h1>$posts</h1>";
            #foreach( $posts as $post ) {
                echo $post['pID']?>
            <?php if ($post['isHidden']== 0 ):?>
            <?php $checkLike = $crud->isPostLikedByUser($sessionID, $post['pID']); ?>
            <div class="col align-items-stretch">
                <div class="card h-100">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="profile.php?id=<?php echo $post['uID']?>"><h5 class="card-title"><?php echo $post['uName']?></h5></a>
                        <p class="card-text"><?php echo $post['txt']?></p>
                        <p class="card-text"><b>Likes:</b>  <?php echo $post['likeCt']?></p>
                        <p class="card-text"><b>Comments:</b></p>
                        <?php
                        $comments = $crud->getCommentsforPost($post['pID']);
                        foreach( $comments as $comment ) {?>
                        <p class="card-text"><b> <?php echo $comment['uName']?> </b>: <?php echo $comment['content']?> - <?php echo $comment['timeSt']?> </p>
                        <?php }?>
                        <p class="card-text"><?php echo $post['timeSt']?></p>
                        <p class="card-text"><?php echo $post['mediaPath']?></p> 
                        <?php if(!$checkLike): ?>
                            <form action="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID']?>&action=feed" method="post" class="form-control mb-2">
                                <input type="text" name="content" class="form-control mb-2">
                                <button type="submit" class="btn btn-primary" href="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID']?>&action=profile" role="button">Comment</button>
                            </form>
                            <a class="btn btn-primary" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID']?>&action=like&feed" role="button">Like</a>
                            <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>" role="button&feed">Report</a>
                        <?php elseif($checkLike): ?>
                            <form action="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID']?>&action=feed" method="post" class="form-control mb-2">
                                <input type="text" name="content" class="form-control mb-2">
                                <button type="submit" class="btn btn-primary" href="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID']?>&action=profile" role="button">Comment</button>
                            </form>
                            <a class="btn btn-warning" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID']?>&action=dislike&feed" role="button">Dislike</a>
                            <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>" role="button&feed">Report</a>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php# }?>
    </div>
</div> <!--container div  -->



<?php require_once 'components/footer.php'; ?>