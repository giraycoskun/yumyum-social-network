<?php 

$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'components/auth_check.php';
require_once 'db/conn.php';

$userID = $_GET['id'];
$sessionID = $_SESSION['uID'];
$isFollowing = $crud->isFollowing($userID, $sessionID);
$result = $crud->getUserInfo($userID);

if(!$result['isActive'])
{
    header("Location: userNotFound.php");
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
    <h1>Hello,  <?php echo $_SESSION['username'] ?></h1>
    <div class="card mb-3" style="max-width: 640px;">
    <div class="row g-0">
        <div class=" col-md-4">
            <img class="img-thumbnail img-fluid rounded mx-auto d-block" src="<?php echo $userPP?>" alt="Image Not Found">
        </div>
        <div class="col-md-8">
        <div class="card-body">
            <h5 class="card-title">Profile</h5>
            <p class="card-text"><b>Name: </b><?php echo $userFirstName." ".$userLastName ?></p>
            <p class="card-text"><b>Age: </b><?php echo $userAge?> - <b>Sex: </b><?php echo $userSex?></p>
            <p class="card-text"><b>Bio: </b><?php echo $userBio ?></p>
            <a class="btn btn-success" href="showFollow.php?id=<?php echo $userID ?>&action=following"><b>Following: </b><?php echo $userFollowingCount ?> </a>
            <a class="btn btn-warning" href="showFollow.php?id=<?php echo $userID ?>&action=follower"><b>Follower: </b><?php echo $userFollowerCount ?></a>
            <a class="btn btn-info" href="showFollow.php?id=<?php echo $userID ?>&action=showlocs"><b>Locations</b></a>
            <!-- <p class="card-text"><b>Following: </b><?php echo $userFollowingCount ?>  -  <b>Follower: </b><?php echo $userFollowerCount ?></p>-->
            <p class="card-text"><small class="text-muted"><?php echo $userName." - ".$userMail ?></small></p>
            <!-- Button trigger modal -->
            <?php if ($sessionID == $userID): ?>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#deactivateModal">Deactivate</button>
            <?php elseif ($isFollowing): ?>
            <!--<button type="submit" class="btn btn-secondary" href="newpost.php">Unfollow</button>-->
            <a class="btn btn-secondary" href="following.php?id=<?php echo $userID ?>&action=unfollow" role="button">Unfollow</a>
            <a class="btn btn-danger" href="report.php?id=<?php echo $userID ?>&action=follow" role="button">Report</a>
            <?php else: ?>
                <a class="btn btn-primary" href="following.php?id=<?php echo $userID ?>&action=follow" role="button">Follow</a>
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
                <?php include('form.php')?>
                </div>
                
            </div>
        </div>
    </div>
</form>

<form action="deactivate.php" method="get" class="d-flex px-2">
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
                            <h2>Goodbye, <?php echo $_SESSION['username']?></h2>
                            <div class="row mt-auto">
                                <div class="col">
                                <label for="date">Until:</label>
                                <input type="date" class="form-control" placeholder="Date" name="date" min="<?php echo date("Y-m-d"); ?>" >
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col container">
                                    <button class="btn btn-lg btn-primary " name="submit" type="submit">Submit</button>
                                    <button class="btn btn-lg btn-secondary " name="back" type="submit" onClick="removeRequired(this.form)">Close</button>
                                    
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
    
    <div class="row row-cols-1 row-cols-md-3 mb-4 g-4">
        <!-- my php code which uses x-path to get results from xml query. -->
        
        <?php $results = $crud->getPostsbyUser($userID);
            while($post = $results->fetch(PDO::FETCH_ASSOC)){?>
            <div class="col">
                <div class="card">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <?php }?>
    </div>
</div> <!--container div  -->


<?php require_once 'components/footer.php'; ?>