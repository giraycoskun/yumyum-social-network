<?php 
require_once 'db/conn.php';

if(!isset($_GET['id']))
{
    echo "bir sıkıntı var";
    
} 
else
{
    $id = $_GET['id'];
    $userID = $_GET['uID'];
    //echo $id;
    #$userID = $_SESSION['uID'];
    try{
        $sql_statement = "DELETE FROM Notification WHERE Notification.nID= :id;";
        $stmt = $pdo->prepare($sql_statement);
        $stmt->bindparam(':id', $id);
        $stmt->execute();
        echo $id . " notification deleted "  . "<br>";
    }
    catch (PDOException $e){
        echo "Something went wrong"  . "<br>";
    }
    header ("Location: notifications.php?id=$userID");
}
?>