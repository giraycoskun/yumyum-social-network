<?php 
include_once 'components/session.php';
require_once 'db/conn.php';

if(!isset($_GET['id']))
{
    echo "bir sıkıntı var";
    
} 
else
{
    $id = $_GET['id'];
    //echo $id;
    try{
        $sql_statement = "UPDATE Posts SET isHidden = 1 WHERE Posts.pID=:id";
        $stmt = $pdo->prepare($sql_statement);
        $stmt->bindparam(':id', $id);
        $stmt->execute();
        echo $id . " post hid"  . "<br>";
    }
    catch (PDOException $e){
        echo "Something went wrong"  . "<br>";
    }
    if(isset($_GET['action']))
    {
        $sql_statement = "DELETE FROM Posts  WHERE Posts.pID=:id";
        $stmt = $pdo->prepare($sql_statement);
        $stmt->bindparam(':id', $id);
        $stmt->execute();

        $userID = $_SESSION['uID'];
        header ("Location: profile.php?id=$userID");
    }
    else
    {
        header ("Location: admin.php");
    }
    
}
?>