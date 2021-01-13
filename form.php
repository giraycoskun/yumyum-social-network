<?php
include_once 'components/session.php';

$userID = $_SESSION['uID'];

$user = $crud->getUserInfo($userID);

?>



<form>
    <div class="d-flex container row mt-auto">
        <h2><?php echo $_SESSION['username'] ?></h2>
        <div class="row mt-auto">
            <div class="col">
                <input type="text" class="form-control" value=<?php echo $user['uName'] ?> name="username">
            </div>
            <div class="col">
                <input type="password" class="form-control" value=<?php echo $user['pw'] ?> name="password">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <input type="text" class="form-control" value=<?php echo $user['name'] ?> name="fname">
            </div>
            <div class="col">
                <input type="text" class="form-control" value=<?php echo $user['surname'] ?> name="lname">
            </div>
            <div class="col">
                <input type="number" min="1" max="120" class="form-control" value=<?php echo $user['age'] ?> name="age">
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                <input type="text" class="form-control" value="<?php echo $user['bioContent'] ?>" name="bio">
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
                <button class="btn btn-lg btn-secondary " name="back" type="submit" onClick="removeRequired(this.form)">Close</button>

            </div>
        </div>

    </div>
</form>