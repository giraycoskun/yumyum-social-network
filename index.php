<?php 
$title = 'Yum-Yum Home';
require_once 'components/header.php'; 
require_once 'db/conn.php';

if(isset($_SESSION['uID']))
{
  header('Location: logout.php');
}

?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['login'])) {
      $userMail = strtolower(trim($_POST['inputEmail']));
      $password = $_POST['inputPassword'];

      $result = $crud->getUser($userMail,$password);
      if(!$result){
        echo '<div class="alert alert-danger">Username or Password is incorrect! Please try again. </div>';
    }else{

      $_SESSION['mail'] = $userMail;
      $_SESSION['uID'] = $result['uID'];
      $userID = $result['uID'];
      $_SESSION['username'] = $result['uName'];
      $_SESSION['isAdmin'] = $result['isAdmin'];
      if($result['isAdmin']== false)
      {   
        header("Location: feed.php?id=$userID");
      }   
      else
      {
        header("Location: admin.php");
      }
    }

      
  } else if (isset($_POST['register'])) {
      header('Location: register.php');
  } else {
      //no button pressed
      header('Location: index.php');
  }
} else if (isset($_SESSION['uName'])) {
  if($result['isAdmin']== false)
      {   
        header("Location: feed.php");
      }   
      else
      {
        header("Location: admin.php");
      }
}
?>



<div class="text-center mx-sm-3 justify-content-center">
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" class="form-signin" >
      <img class="mb-4" src="https://drive.google.com/thumbnail?id=1LolaArK6Zwpb9r93fiVGC1GQ09Fjy6qs" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Welcome to Yum Yum</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="inputEmail" autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" name="inputPassword" placeholder="Password" >
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Sign in</button>
      <button class="btn btn-lg btn-secondary btn-block" name="register" type="submit">Register</button>
     
</form>
</div>


<?php require_once 'components/footer.php'; ?>

