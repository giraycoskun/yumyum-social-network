<?php 
$title = 'Yum-Yum Home';
require_once 'components/header.php'; 
?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['sign'])) {
      header('Location: user.php');
  } else if (isset($_POST['register'])) {
      header('Location: register.php');
  } else {
      //no button pressed
      header('Location: index.php');
  }
}
?>

<div class="text-center mx-sm-3 justify-content-center">
<form method="post" class="form-signin"  action="">
      <img class="mb-4" src="https://drive.google.com/thumbnail?id=1LolaArK6Zwpb9r93fiVGC1GQ09Fjy6qs" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Welcome to Yum Yum</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Email address" autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Password">
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" name="sign" type="submit">Sign in</button>
      <button class="btn btn-lg btn-secondary btn-block" name="register" type="submit">Register</button>
     
</form>
</div>


<?php require_once 'components/footer.php'; ?>