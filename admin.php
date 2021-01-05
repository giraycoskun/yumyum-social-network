<?php 

$title = 'Yum-Yum Home';
require_once 'components/header.php'; 
require_once 'components/auth_check.php';
require_once 'db/conn.php'

?>



<p>Welcome to Admin DashBoard <?php echo $_SESSION['mail']." - ".$_SESSION['uID'] ?></p>
<br> <br>

<div class="container">
  <div class="row">
    <div class="col-12">
        <p class="lead" >Reported Users</p>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">User ID</th>
            <th scope="col">User Name</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          
          <?php
            $results = $crud->getReportedUsers();
            while($row = $results->fetch(PDO::FETCH_ASSOC))
                {
                  $uid = $row['uID'];
                  $userName = $row['uName'];             
                echo "<tr><th scope='row'>".$uid."</th>" . 
                "<td>".$userName." </td>". 
                '<td>
              <button type="button" class="btn btn-primary"><i class="far fa-eye">Show</i></button>
              <button type="button" class="btn btn-warning"><i class="fas fa-edit">Suspend</i></button>
            <button type="button" class="btn btn-danger"><i class="far fa-trash-alt">Delete</i></button>
            </td></tr>';
                }
          ?>
            
         
          
        </tbody>
      </table>
    </div>
    
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-12">
        <p class="lead" >Reported Posts</p>
        <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">User ID</th>
            <th scope="col">Post ID</th>
            <th scope="col">User Name</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          
          <?php
            $results = $crud->getReportedPosts();
            while($row = $results->fetch(PDO::FETCH_ASSOC))
                {
                  $uid = $row['uID'];
                  $pID = $row['pID'];  
                  $userName = $row['uName'];           
                echo "<tr>
                <th scope='row'>".$uid."</th>" . 
                "<td>".$pID." </td>".
                "<td>".$userName." </td>". 
                '<td>
                    <button type="button" class="btn btn-primary"><i class="far fa-eye">Show</i></button>
                    <button type="button" class="btn btn-warning"><i class="fas fa-edit">Suspend</i></button>
                    <button type="button" class="btn btn-danger"><i class="far fa-trash-alt">Delete</i></button>
                </td>
                </tr>';
                }
          ?>
            
         
          
        </tbody>
      
    </div>
    
  </div>
</div>


<?php require_once 'components/footer.php'; ?>