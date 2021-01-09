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
      <div class="col align-items-stretch rounded">
        <div class="card h-100">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <a href="profile.php?id=<?php echo $post['uID'] ?>">
              <h5 class="card-title"><?php echo $post['uName'] ?></h5>
            </a>
            <p class="card-text"><?php echo $post['mediaPath'] ?></p>
            <p class="card-text"><?php echo $post['txt'] ?></p>
            <p class="card-text"><b>Likes:</b> <?php echo $post['likeCt'] ?></p>
            <div class="container p-3 my-3 bg-info text-white rounded">
              <p class="card-text text-dark"><b>Comments:</b></p>
              <?php
              $comments = $crud->getCommentsforPost($post['pID']);
              foreach ($comments as $comment) { ?>
                <div class="d-flex flex-row comment-row m-t-0 bg-success rounded">
                  <div class="p-2"><img src=<?php echo $comment['pp'] ?>  alt="user" width="50" class="rounded-circle"></div>
                  <div class="comment-text w-100">
                    <h6 class="font-medium"><?php echo $comment['uName'] ?></h6> <span class="m-b-15 d-block"><?php echo $comment['content'] ?></span>
                    <div class="comment-footer"> <span class="text-dark float-right"> <?php echo $comment['timeSt']?> </span> 
                  </div>
                </div>
              <?php } ?>
            </div>
            <p class="card-text"><?php echo $post['timeSt'] ?></p>
            

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