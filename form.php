<?php
include_once 'components/session.php'
?>



<form  >
    <div class="d-flex container row mt-auto">
    <h2><?php echo $_SESSION['username']?></h2>
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
            <div class="col">
                <select class="form-control" id="exampleFormControlSelect1" aria-placeholder="Sex" name="sex">
                    <option>Sex</option>
                    <option>M</option>
                    <option>F</option>
                </select>
            </div>
        </div>

        <div class="row mt-2">
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
                <button class="btn btn-lg btn-secondary " name="back" type="submit" onClick="removeRequired(this.form)">Close</button>
                
            </div>
        </div>

  </div>
</form>