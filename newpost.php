<?php 
$title = 'Yum-Yum Home';
require_once 'components/header.php'; 
require_once 'components/auth_check.php';
require_once 'db/conn.php'
?>

<?php
$userID = $_SESSION['uID'];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['share'])) 
    {
        $orig_file = $_FILES["media"]["tmp_name"];
        if(!is_uploaded_file($orig_file))
        {
            echo '<div class="alert alert-danger">You must upload a media file</div>';
        }
        else {
            $text = $_POST['text'];
            $media = 'empty';
            
            $locationName = ucwords((strtolower(trim($_POST['locationName'])))); #ucwords makes first char upper
            if(strlen($locationName)>0) {
                $locResult = $crud->getLocationID($locationName);
                if (!$locResult) {
                    $newLocResult = $crud->insertLocation($locationName);
                    $locationID = $newLocResult['locID'];
                }
                else {
                    $locationID = $locResult['locID'];
                }
            }

            $postID = $crud->insertPost($userID, $media, $text, $locationID);

            $tagText = "";
            if(strlen($text)>0) {
                $ary = explode(" ",$text);
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

            $ext = pathinfo($_FILES["media"]["name"], PATHINFO_EXTENSION);
            $target_dir = 'files/posts/';
            $media = "$target_dir$postID.$ext";
            move_uploaded_file($orig_file,$media);

            $crud->updatePost($postID, $media);

            echo '<div class="alert alert-success">You Have Successfully Shared Your Post</div>';
        }
    }


    else if (isset($_POST['back'])) 
    {
      header('Location: newpost.php');
    } 

}


?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" >
    <div class="d-flex container row mt-auto">
    <h2>Share a New Post</h2>
        <div class="row mt-auto">
            <div class="col">
            <input type="text" class="form-control" placeholder="text up to 250 character" name="text" maxlength="250">
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
            <input type="text" class="form-control" placeholder="Location of this post" name="locationName">
            </div>
        </div>
     
        <div class="row mt-2">
            <div class="col">
                <div class="input-group mb-3">
                    <input type="file" placeholder="Media" accept="video/*,image/*" class="form-control" id="inputGroupFile01" name="media">
                </div>
            </div>
        </div>


        <div class="row mt-2">
            <div class="col container">
                <button class="btn btn-lg btn-primary " name="share" type="submit">Share</button>
                <button class="btn btn-lg btn-secondary " name="back" type="submit" onClick="removeRequired(this.form)">Discard</button>
                
            </div>
        </div>

  </div>
</form>


<?php require_once 'components/footer.php'; ?>