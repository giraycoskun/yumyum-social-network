<?php 
//This includes the session_start() to resume the session on this page. It identifies the session that needs to be destroyed.
include_once 'components/session.php'?>
<?php
#TODO clear session info
session_destroy();
header("Location: index.php")
?>