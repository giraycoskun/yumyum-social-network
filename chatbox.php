<?php

$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'components/auth_check.php';
require_once 'db/conn.php';

$userID = $_GET['id'];
if ($userID != $_SESSION['uID']) {
    header("Location: logout.php");
}

$chats = $crud->getChats($userID);

?>




<div class="container mb-4">
    <h1>Welcome to Chatbox</h1>

    <div class="row row-cols-1 row-cols-md-2 mb-4 g-4">

        <!-- Comment Row -->
        <?php foreach ($chats as $chat) { ?>
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title">Message Box: <?php echo $chat['uName'] ?></h4>
                    <div class="p-2"><img src="<?php echo $chat['pp'] ?>" alt="user" width="50" class="rounded-circle"></div>

                </div>
                <div class="ms-4 comment-widgets">
                    <?php
                    $messages = $crud->getMessages($userID, $chat['uID']);
                    foreach ($messages as $message) { ?>
                        <div class="d-flex flex-row comment-row m-t-0">
                            <div class="comment-text w-100">
                                <span class="m-b-15 d-block"> <b><?php echo $message['uName'] ?></b> <?php echo $message['content'] ?></span>
                                <div class="comment-footer"> <span class="text-muted float-right"><?php echo $message['timeSt'] ?></span> </div>
                            </div>
                        </div> <!-- Comment Row -->

                    <?php }; ?>
                    <form action="sendMessage.php" method="post" class="form-control mb-2">
                        <input type="text" name="message" class="form-control mb-2">
                        <input type="hidden" name="responseID" value=<?php echo $chat['uID'] ?>>
                        <button type="submit" class="btn btn-primary" role="button">Send</button>
                    </form>
                    <div class="card-footer text-center">
                        <a href="sendMessage.php?id=<?php echo $chat['uID'] ?>&delete" class="btn btn-danger mb-2" role="button">DELETE CHAT</a>
                    </div>
                </div>
            </div><!-- Card -->
        <?php }; ?>
    </div>
</div>







<?php require_once 'components/footer.php'; ?>