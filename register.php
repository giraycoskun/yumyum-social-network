<?php 
$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'db/conn.php';
#TODO: Ptohoto URL is not added to entry
?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['submit'])) 
    {
        $mail = trim($_POST['mail']);
        $pass = trim($_POST['password']);
        $age = strtolower(trim($_POST['age']));
        $username = trim($_POST['username']);
        $bio = $_POST['bio'];
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);

        
        $check = 0;
        if($mail == "" or $pass==""  or $username=="")
        {
            $result = false;
            $check = 1;
        }
        else
        {
            $result = $crud->insertUser($username, $pass, $fname, $mail, $lname, $bio, $age);
            $check = 2;

        }        

        if(!$result){
            if($check==1)
            {
                echo '<div class="alert alert-danger">Fields are Empty or Username</div>';
            }
            else
            {
                echo '<div class="alert alert-danger">Username is already used!!</div>';
            }
            
        }else{

            $result = $crud->getUser($mail, $pass);
            $userID = $result['uID'];

            $orig_file = $_FILES["photo"]["tmp_name"];
            $ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
            $target_dir = 'files/users/';
            $destination = "$target_dir$userID.$ext";
            move_uploaded_file($orig_file,$destination);
            
           

            $_SESSION['mail'] = $result['mail'];
            $_SESSION['uID'] = $result['uID'];
            $_SESSION['username'] = $result['uName'];
            $userID = $_SESSION['uID'];
            $_SESSION['isAdmin'] = $result['isAdmin'];
            if($result['isAdmin']== false)
            {   
                #echo '<div class="alert alert-danger">Checkpoint 2 </div>';
                header("Location: feed.php?id=$userID");
            }   
            else
            {
                header("Location: admin.php?id=$userID");
            }
        }

    } 
    else if (isset($_POST['back'])) 
    {
      header('Location: index.php');
    } 
    else 
    {
        //no button pressed
        header('Location: register.php');
    }
}
?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" >
    <div class="d-flex container row mt-auto">
    <h2>Register</h2>
        <div class="row mt-auto">
            <div class="col">
            <input type="email" class="form-control" placeholder="Email" name="mail" >
            </div>
            <div class="col">
            <input type="password" class="form-control" placeholder="Password" name="password" >
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
            <input type="number" min="1" max="120" class="form-control" placeholder="Age" name="age">
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                <input type="text" class="form-control" placeholder="Username" name="username" >
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="First name" name="fname" >
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Last name" name="lname" >
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
            <input type="text" class="form-control" placeholder="Bio" name="bio">
            </div>
        </div>
     

        <div class="row mt-2">
            <div class="col">
                <div class="input-group mb-3">
                    <input type="file" placeholder="Profile Photo" accept="image/*" class="form-control" id="inputGroupFile01" name="photo">
                </div>
            </div>
        </div>


        <div class="row mt-2">
            <div class="col container">
                <button class="btn btn-lg btn-primary " name="submit" type="submit">Submit</button>
                <button class="btn btn-lg btn-secondary " name="back" type="submit">Sign In</button>
                
            </div>
        </div>

  </div>
</form>

<?php require_once 'components/footer.php'; ?>