<?php 

$title = 'Post';
require_once 'components/header.php';
require_once 'components/auth_check.php'; 
require_once 'db/conn.php'
//echo "hi";
?>
<?php 
if(!isset($_GET['id']))
{
    echo "bir sıkıntı var";
    
} 
else
{

    echo "cildircam<br>";
    
    $id = $_GET['id'];
    echo "cildircam<br>";
    
    $results = $crud->getPostByID($id);
    echo "cildircam<br>";
    $results = $results->fetch();

    echo "cildircam<br>";
    echo "<br>". $results['pID']. "<br>";

    echo "cildircam<br>";
}
?>




<div class="container posts-content">
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
              <div class="card-body">
                <div class="media mb-3">
                  <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="d-block ui-w-40 rounded-circle" alt=""> <?php   #profil fotosu bizim directory?> 
                  <div class="media-body ml-3">
                    Kenneth Frazier 
                    <?php $willScreened = $results["uName"];?>
                    <?php echo $willScreened; ?>
                    <div class="text-muted small">3 days ago</div>
                  </div>
                </div>
            
                <p> <?php   #php kodu yaz buraya post.content?> 
                  Sen Abdulhamiti savundun!
                </p>
                <a href="javascript:void(0)" class="ui-rect ui-bg-cover" style="background-image: url('https://bootdey.com/img/Content/avatar/avatar3.png');"></a>
              </div>
              <div class="card-footer">
                <a href="javascript:void(0)" class="d-inline-block text-muted">
                    <strong>123</strong> Likes</small> <?php   #post.likeNumber?> 
                </a>
                <a href="javascript:void(0)" class="d-inline-block text-muted ml-3">
                    <strong>12</strong> Comments</small> <?php   #post.commentNumber?> 
                </a>
              </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'components/footer.php'; ?> 