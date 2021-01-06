<?php 
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
        $sql_statement = "DELETE FROM Posts WHERE Posts.pID = :id;";
        $stmt = $pdo->prepare($sql_statement);
        $stmt->bindparam(':id', $id);
        $stmt->execute();
        echo $id . " post deleted"  . "<br>";
    }
    catch (PDOException $e){
        echo "Something went wrong"  . "<br>";
    }
    header ("Location: admin.php");
}
?>