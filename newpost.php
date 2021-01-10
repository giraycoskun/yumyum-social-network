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
        $check = 0;
        $text = $_POST['text'];
        
        if(strlen($locationName)>0) {
            $locationName = ucwords((strtolower(trim($_POST['locationName'])))); #ucwords makes first char upper
            $locResult = $crud->getLocationID($locationName);
            if (!$locResult) {
                $newLocResult = $crud->insertLocation($locationName);
                $locationID = $newLocResult['locID'];
            }
            else {
                $locationID = $locResult['locID'];
            }
        }

        $media = 'empty';
        $crud->insertPost($userID, $media, $text, $locationID);

        $orig_file = $_FILES["media"]["tmp_name"];
        if(!is_uploaded_file($orig_file))
        {
            echo '<div class="alert alert-danger">You must upload a media file</div>';
        }
        else
        {
            $ext = pathinfo($_FILES["media"]["tmp_name"], PATHINFO_EXTENSION);
            $target_dir = 'files/users/';
            $media = "$target_dir$postId.$ext";
            move_uploaded_file($orig_file,$media);

            $crud->insertPost($userID, $media, $text, $locationID);
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