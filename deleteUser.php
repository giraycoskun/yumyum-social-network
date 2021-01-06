<?php 
require_once 'db/conn.php';
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
        $sql_statement = "DELETE FROM Users WHERE Users.uID = :id;";
        $stmt = $pdo->prepare($sql_statement);
        $stmt->bindparam(':id', $id);
        $stmt->execute();
        echo $id . " user deleted"  . "<br>";
    }
    catch (PDOException $e){
        echo "Something went wrong"  . "<br>";
    }
    header ("Location: admin.php");
}
?>