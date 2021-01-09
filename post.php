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


  $post = $crud->getPostByID($id);
}
?>




<div class="container mb-4">
  <h1>Welcome to Home</h1>

  <div class="row row-cols-1 row-cols-md-2 mb-4 g-4">

    <?php
    $userID = $post['uID']; { ?>
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

            <form action="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=feed" method="post" class="form-control mb-2">
              <input type="text" name="content" class="form-control mb-2">
              <button type="submit" class="btn btn-primary" href="comment.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=profile" role="button">Comment</button>
            </form>
            <a class="btn btn-warning" href="like.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>&action=dislike&feed" role="button">Dislike</a>
            <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&pid=<?php echo $post['pID'] ?>" role="button&feed">Report</a>


          </div>
        </div>
      </div>

    <?php } ?>
  </div>
</div>

<?php require_once 'components/footer.php'; ?>