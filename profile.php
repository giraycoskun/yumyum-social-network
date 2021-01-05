<?php 

$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'components/auth_check.php';
require_once 'db/conn.php'

?>


<div class="container">
    <h1>Hello,  <?php echo $_SESSION['username'] ?></h1>
    <div class="d-flex">
        <div class="column-fluid ">
        <!-- my php code which uses x-path to get results from xml query. -->
        
        <?php $results = $crud->getPostsbyUser($_SESSION['uID']);
            while($post = $results->fetch(PDO::FETCH_ASSOC)){?>
            <div class="col-sm-4 ">
                <div class="card-columns-fluid mt-4">
                    <div class="card  bg-light" style = "width: 22rem; " >
                        <img class="card-img-top"  src=" <?php echo $post['mediaPath']; ?> " alt="Card image cap">

                        <div class="card-body">
                            <h5 class="card-title"><b><?php echo $post['txt'] ?></b></h5>
                            <p class="card-text"><b><?php echo $post['txt'] ?></b></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</div> <!--container div  -->

<?php require_once 'components/footer.php'; ?>