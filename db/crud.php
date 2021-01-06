<?php

class crud{
    private $db;

    function __construct($conn)
    {
        $this->db = $conn;
    }

    public function getUsers(){
        try{
            $sql = "SELECT Users.mail, Users.pw, FROM Users";
            $result = $this->db->query($sql);
            return $result;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function getUser($mail, $password){
        try{
            $sql = "select * from Users where mail = :mail AND pw = :pw ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':mail', $mail);
            $stmt->bindparam(':pw', $password);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getReportedUsers(){
        try{
            $sql = "select * from Users where Users.isReported = 1 AND Users.isActive= 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt;
            return $result;
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getReportedPosts(){
        try{
            $sql = "select * from Posts, Users where Posts.isReported = 1 AND Posts.isHidden= 0 AND Posts.uID = Users.uID";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt;
            return $result;
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getMessages($userID){

        try{
            //$sql1 = "select * from Messages, Users where Messages.rID = Users.uID and Users.uID = :userID";
            $sql2 = "select Messages.content, Users.name, Users.surname from Messages, Users where Messages.sID = Users.uID and Users.uID != :userID";
            //$stmt = $this->db->prepare($sql1);
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->bindparam(':userID', $userID);
            //$stmt->execute();
            $stmt2->execute();
            $result = $stmt2;
            return $result;
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    


    public function insertUser($username, $pass, $fname, $mail, $lname, $bio, $age, $sex){
        try{
            $sql = "INSERT INTO Users (uName, pw, name, surname, mail, bioContent, age, sex ) VALUES(:username, :pass, :fname,  :lname,  :mail, :bio, :age, :sex ); ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':username', $username);
            $stmt->bindparam(':pass', $pass);
            $stmt->bindparam(':fname', $fname);
            $stmt->bindparam(':lname', $lname);
            $stmt->bindparam(':mail', $mail);
            $stmt->bindparam(':bio', $bio);
            $stmt->bindparam(':age', $age);
            $stmt->bindparam(':sex', $sex);
            $stmt->execute();
            #echo "New record created successfully";
            return true;
       }catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }

    public function getPostsbyUser($uID)
    {
        try{
            $sql = "SELECT * FROM Posts WHERE Posts.uID = :uID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':uID', $uID);
            $stmt->execute();
            return $stmt;
       }catch (PDOException $e) {
            #echo $e->getMessage();
       }
    }
    public function getPostByID($pID){
        try{
            $sql = "select * from Posts,Users where Posts.pID = :pID and Posts.uID = Users.uID ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':pID', $pID);
            $stmt->execute();
            $result = $stmt;
            return $result;
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getUserInfo($userID)
    {
        try{
            $sql = "SELECT * FROM Users WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateUser($userID)
    {
        try{
            $sql = "UPDATE Users SET Users WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function isFollowing($userID, $sessionID)
    {
        try{
            $sql = "SELECT * FROM UserFollowsUser WHERE UserFollowsUser.FollowerID=:sessionID and UserFollowsUser.FolloweeID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();
            $result = $stmt->fetch();
            #echo "<p>$result</p>";
            if(empty($result))
            {
                return false;
            }
            return true;
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function follow($userID, $sessionID)
    {
        try{
            $sql = "INSERT INTO UserFollowsUser (FollowerID, FolloweeID) VALUES (:sessionID, :userID);";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();

            $sql = "UPDATE Users SET followerCt = followerCt + 1 WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            

            $sql = "UPDATE Users SET followCt = followCt + 1 WHERE Users.uID=:sessionID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();
            echo '<div class="alert alert-danger">Checkpoint 1 </div>';
            return true;
            #echo "<p>$result</p>";
            
       }catch (PDOException $e) {
        echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    public function unfollow($userID, $sessionID)
    {
        try{
           
            $sql = "DELETE FROM UserFollowsUser WHERE (UserFollowsUser.FollowerID=:sessionID and UserFollowsUser.FolloweeID=:userID)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();
            
            #echo "<p>$result</p>";

            $sql = "UPDATE Users SET followerCt = followerCt - 1 WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            

            $sql = "UPDATE Users SET followCt = followCt - 1 WHERE Users.uID=:sessionID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();
            return true;


            
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }



        public function getUserName($postID){
            try{
                $sql = "SELECT * FROM Users, Posts WHERE Posts.uID = Users.uID and Posts.pID=:postID";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':postID', $postID);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
           }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
    
        }

    
}

?>