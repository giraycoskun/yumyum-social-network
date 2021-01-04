<!DOCTYPE HTML>
<html>
<head>
    <title>AWS-PHP Application</title>
</head>
<body>
<h1>Hello World, Giray</h1>
<?php
    include 'db_test.php';
    $users = $conn->query("select * from Users");
    $result = $users->fetch_all();
    print_r($result);

    $conn->close();
?>
</body>
</html>