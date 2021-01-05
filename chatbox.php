<?php 

$title = 'Yum-Yum Home';
require_once 'components/header.php';
require_once 'components/auth_check.php';
require_once 'db/conn.php'
?>


<h2>Welcome to ChatBox</h2>




<table class="table">
        <tr>
            <th>Name Surname</th>
            <th>Message</th>
        </tr>
        <?php 
        $result = $crud->getMessages($_SESSION["uID"]);
        while($r = $result->fetch(PDO::FETCH_ASSOC)) { ?>
           <tr>
                <td><?php echo $r['name']." ".$r['surname']  ?></td>   
                <td><?php echo $r['content'] ?></td>     
           </tr> 
        <?php }?>
    </table>

<br>
<br>
<br>



<?php require_once 'components/footer.php'; ?>