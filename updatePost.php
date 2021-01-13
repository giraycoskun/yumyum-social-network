<?php
include_once 'components/session.php';
require_once 'db/conn.php';

$userID = $_SESSION['uID'];


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['back'])){
        header("Location: profile.php?id=$userID");
    }
    else
    {   
        $postID = $_POST['postID'];
        $content = $_POST['content'];

        $crud->deleteTagsFromPost($postID);
        $crud->updatePostTxt($postID, $content);
        $tagText = "";
            if(strlen($content)>0) {
                $ary = explode(" ",$content);
                foreach($ary as $word) {
                    if ($word[0] == '#') {
                        $tagText .= $word;
                    }
                }
                if (strlen($tagText)>0) {
                    $tagArr = explode("#",$tagText);
                    foreach($tagArr as $tag) {
                        $tagResult = $crud->getTagID($tag);
                        if (!$tagResult) {
                            $newTagResult = $crud->insertTag($tag);
                            $tagID = $newTagResult['tagID'];
                            $crud->insertPostsHasTags($postID, $tagID);
                        }
                        else {
                            $tagID = $tagResult['tagID'];
                            $crud->insertPostsHasTags($postID, $tagID);
                        }
                    }
                }
            }

        header("Location: profile.php?id=$userID");
    }
}
else
{
    header("Location: profile.php?id=$userID");
}



?>