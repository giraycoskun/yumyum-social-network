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
        $sql_statement = "UPDATE Posts SET isHidden = 0 WHERE Posts.pID=:id";
        $stmt = $pdo->prepare($sql_statement);
        $stmt->bindparam(':id', $id);
        $stmt->execute();
        echo $id . " post hid"  . "<br>";
    }
    catch (PDOException $e){
        echo "Something went wrong"  . "<br>";
    }
    header ("Location: admin.php");
}
?>