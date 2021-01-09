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
    public function getBannedUsers(){
        try{
            $sql = "select * from Users where Users.isReported = 1 AND Users.isActive= 0";
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
    public function getHiddenPosts(){
        try{
            $sql = "select * from Posts, Users where Posts.isHidden = 1 AND Posts.uID = Users.uID";
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

    


    public function insertUser($username, $pass, $fname, $mail, $lname, $bio, $age){
        try{
            $sql = "INSERT INTO Users (uName, pw, name, surname, mail, bioContent, age) VALUES(:username, :pass, :fname,  :lname,  :mail, :bio, :age); ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':username', $username);
            $stmt->bindparam(':pass', $pass);
            $stmt->bindparam(':fname', $fname);
            $stmt->bindparam(':lname', $lname);
            $stmt->bindparam(':mail', $mail);
            $stmt->bindparam(':bio', $bio);
            $stmt->bindparam(':age', $age);
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
            $sql = "SELECT * FROM Posts, Users WHERE Posts.uID = :uID and Users.uID=:uID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':uID', $uID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
       }catch (PDOException $e) {
            #echo $e->getMessage();
       }
    }
    public function getPostByID($pID){
        try{
            $sql = "select * from Posts,Users where Posts.pID = :pID and Posts.uID = Users.uID; ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':pID', $pID);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getPostsForFeed($userID)
    {
        try{
            $sql = "SELECT * FROM Posts, UserFollowsUser, Users WHERE Posts.uID = Users.uID and UserFollowsUser.FolloweeID = Posts.uID and UserFollowsUser.FollowerID=:userID ORDER BY Posts.timeSt LIMIT 0,20";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
       }catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
       }
    }
    public function getUsersBySearch($search)
    {
        #TODO
        try{
           $sql = "SELECT DISTINCT  u.uID,  u.uName, u.name, u.surname, u.bioContent,u.followCt, u.followerCt,u.pp
           from Users u
           where u.uName LIKE '%$search%' or u.name LIKE '%$search%' or u.surname LIKE '%$search%' or (concat(u.name,' ',u.surname )LIKE  '%$search%') and u.isActive = 1;";
            $stmt = $this->db->prepare($sql);
            #$stmt->bindparam(':search', $search);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
       }catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
       }

    }
    public function getPostsForSearch($search)
    {
        #TODO
        try{
            $sql = "SELECT DISTINCT p.pID, p.mediaPath, p.locID, p.timeSt, p.likeCt, p.isHidden, u.name, u.surname, u.uID,  u.uName, t.locName, p.txt FROM Posts p, Users u, Locations t 
            WHERE p.isHidden = 0 and p.uID = u.uID and p.txt LIKE '%$search%' and t.locID = p.locID 
            UNION 
            SELECT DISTINCT  p.pID, p.mediaPath, p.locID, p.timeSt, p.likeCt, p.isHidden, u.name, u.surname, u.uID,  u.uName, t.locName, p.txt from Locations t, Users u, Posts p where t.locName LIKE '%$search%' and t.locID = p.locID and p.uID = u.uID 
            UNION 
            SELECT DISTINCT  p.pID, p.mediaPath, p.locID, p.timeSt, p.likeCt, p.isHidden, u.name, u.surname, u.uID,  u.uName, f.locName, p.txt 
            from Tags t, Users u, PostsHasTags ph, Posts p, Locations f 
            where t.tagName LIKE '%$search%' and t.tagID = ph.tID and ph.pID = p.pID and p.uID = u.uID and f.locID = p.locID";
            $stmt = $this->db->prepare($sql);
            #$stmt->bindparam(':search', $search);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
       }catch (PDOException $e) {
            #echo $e->getMessage();
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

    public function updateUser($userID, $pass, $fname, $mail, $lname, $bio, $age)
    {
        #giray
        try{
            $sql = "UPDATE Users SET pw=:pass, name=:fname, surname=:lname, mail=:mail, bioContent=:bio, age=:age  WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':pass', $pass);
            $stmt->bindparam(':fname', $fname);
            $stmt->bindparam(':mail', $mail);
            $stmt->bindparam(':lname', $lname);
            $stmt->bindparam(':bio', $bio);
            $stmt->bindparam(':age', $age);
            $stmt->execute();
            #echo '<div class="alert alert-danger">Checkpoint 1 </div>';
            return true;
       }catch (PDOException $e) {
            #echo '<div class="alert alert-danger">Checkpoint 2 </div>';
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

    public function followUser($userID, $sessionID)
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
            #echo '<div class="alert alert-danger">Checkpoint 1 </div>';
            return true;
            #echo "<p>$result</p>";
            
       }catch (PDOException $e) {
        echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    public function unfollowUser($userID, $sessionID)
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

    public function unfollowLoc($locID, $sessionID)
    {
        try{
           
            $sql = "DELETE FROM UserFollowsLocations WHERE UserFollowsLocations.locID=:locID and UserFollowsLocations.uID=:sessionID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':locID', $locID);
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

    public function reportUser($reportedID){
        try{
            
            
            $sql = "UPDATE Users SET isReported = 1 WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $reportedID);
            $stmt->execute();
            

            return true;
            
        }catch (PDOException $e) {
        echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }

    }

    public function reportPost($postID){
        try{
            
            
            $sql = "UPDATE Posts SET isReported = 1 WHERE Posts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();
            

            return true;
            
        }catch (PDOException $e) {
        echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }

    }

    public function getFollowers($userID){
        try{
            
            
            $sql = "SELECT Users.uName FROM Users, UserFollowsUser WHERE Users.uID = UserFollowsUser.followerID and UserFollowsUser.followeeID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
            
        }catch (PDOException $e) {
        #echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }

    }

    public function getFollowing($userID){
        try{
            
            
            $sql = "SELECT Users.uName FROM Users, UserFollowsUser WHERE Users.uID = UserFollowsUser.followeeID and UserFollowsUser.followerID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
            
        }catch (PDOException $e) {
        echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    public function getFollowedLocations($userID)
    {
        try{

            $sql = "SELECT Locations.locName, Locations.locID FROM UserFollowsLocations, Locations WHERE UserFollowsLocations.uID=:userID and Locations.locID=UserFollowsLocations.locID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
            
        }catch (PDOException $e) {
        echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    public function likePost($sessionID, $postID)
    {
        try {

            $sql = "INSERT INTO UserLikesPosts (likerID, pID) VALUES (:sessionID, :postID);";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();

            $sql = "UPDATE Posts SET likeCt = likeCt + 1 WHERE Posts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();

            return true;
            
        }catch (PDOException $e) {
            #echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            #echo $e->getMessage();
            return false;
        }
    }
    public function dislikePost($sessionID, $postID)
    {
        try {

            $sql = "DELETE FROM UserLikesPosts WHERE UserLikesPosts.likerID=:sessionID and UserLikesPosts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();

            $sql = "UPDATE Posts SET likeCt = likeCt - 1 WHERE Posts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();

            return true;
            
        }catch (PDOException $e) {
            #echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            #echo $e->getMessage();
            return false;
        }
        
    }
    public function isPostLikedByUser($sessionID, $postID)
    {
        try{
            $sql = "SELECT * FROM UserLikesPosts WHERE UserLikesPosts.likerID=:sessionID and UserLikesPosts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
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

    public function getCommentsforPost($postID)
    {
        try{
            $sql = "SELECT * FROM Users, Comments WHERE Users.uID=Comments.uID and Comments.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function insertComment($userID, $postID, $comment)
    {
        try{
            $sql = "INSERT INTO Comments (uID, pID, content) VALUES (:userID, :postID, :comment)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':postID', $postID);
            $stmt->bindparam(':comment', $comment);
            $stmt->execute();

            return true;
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }



    public function getFollowedTags($userID){
        try{

            $sql = "SELECT Tags.tagName, Tags.tagID FROM UserFollowsTags, Tags WHERE UserFollowsTags.uID=:userID and Tags.tagID=UserFollowsTags.tID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
            
        }catch (PDOException $e) {
        echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    
    public function unfollowTag($tagID, $sessionID){
        try{
           
            $sql = "DELETE FROM UserFollowsTags WHERE UserFollowsTags.tID=:tagID and UserFollowsTags.uID=:sessionID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':tagID', $tagID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();
            
            return true;


            
       }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}


