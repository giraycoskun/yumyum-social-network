<?php

class crud
{
    private $db;

    function __construct($conn)
    {
        $this->db = $conn;
    }

    public function getUsers()
    {
        try {
            $sql = "SELECT Users.mail, Users.pw, FROM Users";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getUser($mail, $password)
    {
        try {
            $sql = "select * from Users where mail = :mail AND pw = :pw ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':mail', $mail);
            $stmt->bindparam(':pw', $password);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getReportedUsers()
    {
        try {
            $sql = "select * from Users where Users.isReported = 1 AND Users.isActive= 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt;
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getBannedUsers()
    {
        try {
            $sql = "select * from Users where Users.isReported = 1 AND Users.isActive= 0";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt;
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getReportedPosts()
    {
        try {
            $sql = "select * from Posts, Users where Posts.isReported = 1 AND Posts.isHidden= 0 AND Posts.uID = Users.uID";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt;
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getHiddenPosts()
    {
        try {
            $sql = "select * from Posts, Users where Posts.isHidden = 1 AND Posts.uID = Users.uID";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt;
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getMessages($userID, $responseID)
    {

        try {
            $sql = "SELECT *
            FROM (
            SELECT * FROM Messages, Users WHERE Users.uID=$userID and Messages.sID = $userID and Messages.rID=$responseID
            UNION
            SELECT * FROM Messages, Users WHERE Users.uID=$responseID and Messages.rID = $userID and Messages.sID=$responseID) AS T
            ORDER BY T.timeSt DESC LIMIT 0, 10";
            $stmt = $this->db->prepare($sql);
            #$stmt->bindparam(':userID', $userID);
            //$stmt->execute();
            $stmt->execute();
            $result = $stmt;
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function insertMessages($userID, $responseID, $message)
    {
        try {
            $sql = "INSERT INTO Messages (rID, sID, content) VALUES (:responseID, :userID, :message)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':responseID', $responseID);
            $stmt->bindparam(':message', $message);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

    }

    public function getChats($userID)
    {

        try {
            $sql = "SELECT T.uID, T.uName, COUNT(T.mID) AS messageCount, T.pp
            FROM (
            SELECT * FROM Messages, Users WHERE Users.uID=Messages.rID and Messages.sID = $userID
            UNION
            SELECT * FROM Messages, Users WHERE Users.uID=Messages.sID and Messages.rID =$userID) AS T
            GROUP BY T.uID";
            $stmt = $this->db->prepare($sql);
            #$stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function deleteChat($userID, $responseID)
    {
        try {

            $sql = "DELETE FROM Messages WHERE Messages.rID=:userID and Messages.sID=:responseID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':responseID', $responseID);
            $stmt->execute();

            $sql = "DELETE FROM Messages WHERE Messages.rID=:responseID and Messages.sID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':responseID', $responseID);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function insertUser($username, $pass, $fname, $mail, $lname, $bio, $age)
    {
        try {
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
        } catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }

    public function getPostsbyUser($uID)
    {
        try {
            $sql = "SELECT * FROM Posts, Users WHERE Posts.uID = :uID and Users.uID=:uID ORDER BY Posts.timeSt DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':uID', $uID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            #echo $e->getMessage();
        }
    }
    public function getPostByID($pID)
    {
        #TODO
        try {
            $sql = "select * from Posts,Users where Posts.pID = :pID and Posts.uID = Users.uID; ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':pID', $pID);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getPostsForFeed($userID)
    {
        try {
            $sql = "SELECT * 
            FROM
            (SELECT  p.pID, p.mediaPath, p.locID, p.timeSt, p.likeCt, p.isHidden, u.name, u.surname, u.uID,  u.uName, t.locName, p.txt, u.pp FROM Posts p, Users u, Locations t 
            WHERE p.isHidden = 0 and p.uID = u.uID and t.locID = p.locID and u.uID = $userID
            UNION 
            SELECT  p.pID, p.mediaPath, p.locID, p.timeSt, p.likeCt, p.isHidden, u.name, u.surname, u.uID,  u.uName, t.locName, p.txt, u.pp FROM Posts p, Users u, Locations t, UserFollowsUser uf
            WHERE p.isHidden = 0 and p.uID = u.uID and t.locID = p.locID and u.uID = uf.FolloweeID and uf.FollowerID = $userID
            UNION
            SELECT   p.pID, p.mediaPath, p.locID, p.timeSt, p.likeCt, p.isHidden, u.name, u.surname, u.uID,  u.uName, t.locName, p.txt, u.pp FROM Users u, Posts p, Locations t,  UserFollowsLocations ul 
            WHERE p.isHidden = 0 and t.locID = p.locID and p.uID = u.uID and ul.locID = p.locID and ul.uID = $userID
            UNION 
            SELECT   p.pID, p.mediaPath, p.locID, p.timeSt, p.likeCt, p.isHidden, u.name, u.surname, u.uID,  u.uName, t.locName, p.txt, u.pp FROM Users u, Posts p, Locations t, UserFollowsTags ut, PostsHasTags pt
            WHERE p.isHidden = 0 and t.locID = p.locID and p.pID = pt.pID and ut.tID = pt.tID and u.uID = p.uID and ut.uID = $userID) AS T
            ORDER BY T.timeSt DESC;";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }

    public function getPostsForSearch($search)
    {
        try {
            $sql = "SELECT * 
            FROM
            (SELECT DISTINCT p.pID, p.mediaPath, p.locID, p.timeSt, p.likeCt, p.isHidden, u.name, u.surname, u.uID,  u.uName, t.locName, p.txt, u.pp 
            FROM Posts p, Users u, Locations t 
            WHERE p.isHidden = 0 and p.uID = u.uID and u.uName LIKE '%$search%' or u.name LIKE '%$search%' or u.surname LIKE '%$search%' or (concat(u.name,' ',u.surname )LIKE  '%$search%') and t.locID = p.locID 
            UNION 
            SELECT DISTINCT p.pID, p.mediaPath, p.locID, p.timeSt, p.likeCt, p.isHidden, u.name, u.surname, u.uID,  u.uName, t.locName, p.txt, u.pp  
            FROM Posts p, Users u, Locations t 
            WHERE p.isHidden = 0 and p.uID = u.uID and p.txt LIKE '%$search%' and t.locID = p.locID 
            UNION 
            SELECT DISTINCT  p.pID, p.mediaPath, p.locID, p.timeSt, p.likeCt, p.isHidden, u.name, u.surname, u.uID,  u.uName, t.locName, p.txt, u.pp  
            from Locations t, Users u, Posts p 
            where t.locName LIKE '%$search%' and t.locID = p.locID and p.uID = u.uID and p.isHidden = 0 
            UNION 
            SELECT DISTINCT  p.pID, p.mediaPath, p.locID, p.timeSt, p.likeCt, p.isHidden, u.name, u.surname, u.uID,  u.uName, f.locName, p.txt, u.pp  
            from Tags t, Users u, PostsHasTags ph, Posts p, Locations f 
            where t.tagName LIKE '%$search%' and t.tagID = ph.tID and ph.pID = p.pID and p.uID = u.uID and f.locID = p.locID) AS T
            ORDER BY T.timeSt DESC;";
            
            $stmt = $this->db->prepare($sql);
            #$stmt->bindparam(':search', $search);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }

    public function getUsersBySearch($search)
    {
        #TODO
        try {
            $sql = "SELECT DISTINCT  u.uID,  u.uName, u.name, u.surname, u.bioContent,u.followCt, u.followerCt,u.pp
           from Users u
           where u.uName LIKE '%$search%' or u.name LIKE '%$search%' or u.surname LIKE '%$search%' or (concat(u.name,' ',u.surname )LIKE  '%$search%') and u.isActive = 1;";
            $stmt = $this->db->prepare($sql);
            #$stmt->bindparam(':search', $search);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }

    public function getLocsBySearch($search)
    {
        #TODO
        try {
            $sql = "SELECT l.locID, l.locName, COUNT(p.pID) as postCount
            FROM Locations l, Posts p
            WHERE l.locName LIKE '%$search%' and p.locID = l.locID
            GROUP BY l.locID;";
            $stmt = $this->db->prepare($sql);
            #$stmt->bindparam(':search', $search);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }

    public function getTagsBySearch($search)
    {
        #TODO
        try {
            $sql = "SELECT t.tagName, t.tagID, COUNT(p.pID) as postCount
            FROM Tags t, Posts p, PostsHasTags pt
            WHERE t.tagName LIKE '%$search%' and t.tagID = pt.tID and p.pID = pt.pID
            GROUP BY t.tagName;";
            $stmt = $this->db->prepare($sql);
            #$stmt->bindparam(':search', $search);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }

    public function getUserInfo($userID)
    {
        try {
            $sql = "SELECT * FROM Users WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateUser($userID, $uname, $pass, $fname, $mail, $lname, $bio, $age)
    {
        #giray
        try {
            $sql = "UPDATE Users SET pw=:pass, uName=:uname ,name=:fname, surname=:lname, mail=:mail, bioContent=:bio, age=:age  WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':uname', $uname);
            $stmt->bindparam(':pass', $pass);
            $stmt->bindparam(':fname', $fname);
            $stmt->bindparam(':mail', $mail);
            $stmt->bindparam(':lname', $lname);
            $stmt->bindparam(':bio', $bio);
            $stmt->bindparam(':age', $age);
            $stmt->execute();
            #echo '<div class="alert alert-danger">Checkpoint 1 </div>';
            return true;
        } catch (PDOException $e) {
            #echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    public function isFollowing($userID, $sessionID)
    {
        try {
            $sql = "SELECT * FROM UserFollowsUser WHERE UserFollowsUser.FollowerID=:sessionID and UserFollowsUser.FolloweeID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();
            $result = $stmt->fetch();
            #echo "<p>$result</p>";
            if (empty($result)) {
                return false;
            }
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function followUser($userID, $sessionID)
    {
        try {
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

        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    public function unfollowUser($userID, $sessionID)
    {
        try {

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
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getUserName($postID)
    {
        try {
            $sql = "SELECT * FROM Users, Posts WHERE Posts.uID = Users.uID and Posts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function reportUser($reportedID)
    {
        try {


            $sql = "UPDATE Users SET isReported = 1 WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $reportedID);
            $stmt->execute();


            return true;
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    public function reportPost($postID)
    {
        try {


            $sql = "UPDATE Posts SET isReported = 1 WHERE Posts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();


            return true;
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    public function getFollowers($userID)
    {
        try {


            $sql = "SELECT Users.uName FROM Users, UserFollowsUser WHERE Users.uID = UserFollowsUser.followerID and UserFollowsUser.followeeID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            #echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    public function getFollowing($userID)
    {
        try {


            $sql = "SELECT Users.uName, Users.uID FROM Users, UserFollowsUser WHERE Users.uID = UserFollowsUser.followeeID and UserFollowsUser.followerID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    public function getFollowedLocations($userID)
    {
        try {

            $sql = "SELECT Locations.locName, Locations.locID FROM UserFollowsLocations, Locations WHERE UserFollowsLocations.uID=:userID and Locations.locID=UserFollowsLocations.locID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
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
        } catch (PDOException $e) {
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
        } catch (PDOException $e) {
            #echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            #echo $e->getMessage();
            return false;
        }
    }
    public function isPostLikedByUser($sessionID, $postID)
    {
        try {
            $sql = "SELECT * FROM UserLikesPosts WHERE UserLikesPosts.likerID=:sessionID and UserLikesPosts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();
            $result = $stmt->fetch();
            #echo "<p>$result</p>";
            if (empty($result)) {
                return false;
            }
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function isUserFollowTag($sessionID, $tagID)
    {
        try {
            $sql = "SELECT * FROM Tags, UserFollowsTags WHERE Tags.tagID=UserFollowsTags.tID and UserFollowsTags.uID=:sessionID and UserFollowsTags.tID=:tagID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':tagID', $tagID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();
            $result = $stmt->fetchAll();

            if (empty($result)) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function isUserFollowLoc($sessionID, $locID)
    {
        try {
            $sql = "SELECT * FROM UserFollowsLocations WHERE UserFollowsLocations.uID=:sessionID and UserFollowsLocations.locID=:locID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':locID', $locID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();
            $result = $stmt->fetchAll();

            if (empty($result)) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getTagName($tagID)
    {
        try {
            $sql = "SELECT * FROM Tags WHERE Tags.tagID=:tagID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':tagID', $tagID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            #echo "<p>$result</p>";
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getLocName($locID)
    {
        try {
            $sql = "SELECT * FROM Locations WHERE Locations.locID=:locID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':locID', $locID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            #echo "<p>$result</p>";
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getCommentsforPost($postID)
    {
        try {
            $sql = "SELECT * FROM Users, Comments WHERE Users.uID=Comments.uID and Comments.pID=:postID ORDER BY Comments.timeSt DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getLocationforPost($postID)
    {
        try {
            $sql = "SELECT Locations.locName, Locations.locID FROM Posts, Locations WHERE Locations.locID=Posts.locID and Posts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getTagsforPost($postID)
    {
        try {
            $sql = "SELECT Tags.tagName, Tags.tagID FROM Tags, PostsHasTags WHERE Tags.tagID=PostsHasTags.tID and PostsHasTags.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getPostsForTag($tagID)
    {
        try {
            $sql = "SELECT * FROM Users, Posts, PostsHasTags WHERE Posts.uID=Users.uID and PostsHasTags.pID = Posts.pID and PostsHasTags.tID=:tagID ORDER BY Posts.timeSt DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':tagID', $tagID);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getPostsForLocation($locID)
    {
        try {
            $sql = "SELECT * FROM Users, Posts WHERE Posts.uID=Users.uID and Posts.locID=:locID ORDER BY Posts.timeSt DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':locID', $locID);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getLikersforPost($postID)
    {
        #TODO
        try {
            $sql = "SELECT Users.uName, Users.uID FROM Users, UserLikesPosts WHERE Users.uID=UserLikesPosts.likerID and UserLikesPosts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function insertComment($userID, $postID, $comment)
    {
        try {
            $sql = "INSERT INTO Comments (uID, pID, content) VALUES (:userID, :postID, :comment)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':postID', $postID);
            $stmt->bindparam(':comment', $comment);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }



    public function getFollowedTags($userID)
    {
        try {

            $sql = "SELECT Tags.tagName, Tags.tagID FROM UserFollowsTags, Tags WHERE UserFollowsTags.uID=:userID and Tags.tagID=UserFollowsTags.tID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Checkpoint 2 </div>';
            echo $e->getMessage();
            return false;
        }
    }

    public function followLoc($locID, $sessionID)
    {
        try {

            $sql = "INSERT INTO UserFollowsLocations (uID, locID) VALUES (:sessionID, :locID)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':locID', $locID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function unfollowLoc($locID, $sessionID)
    {
        try {

            $sql = "DELETE FROM UserFollowsLocations WHERE UserFollowsLocations.locID=:locID and UserFollowsLocations.uID=:sessionID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':locID', $locID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function followTag($tagID, $sessionID)
    {
        try {

            $sql = "INSERT INTO UserFollowsTags (uID, tID) VALUES (:sessionID, :tagID)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':tagID', $tagID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function unfollowTag($tagID, $sessionID)
    {
        try {

            $sql = "DELETE FROM UserFollowsTags WHERE UserFollowsTags.tID=:tagID and UserFollowsTags.uID=:sessionID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':tagID', $tagID);
            $stmt->bindparam(':sessionID', $sessionID);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    public function insertPost($userID, $media, $text, $locationID){
        try{
            $sql = "INSERT INTO Posts (uID, mediaPath, txt, locID) VALUES(:userID, :media, :text,  :locationID)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':media', $media);
            $stmt->bindparam(':text', $text);
            $stmt->bindparam(':locationID', $locationID);
            $stmt->execute();
            $result = $this->getLastPostID($userID);
            #echo "New post created successfully";
            return $result;
       }catch (PDOException $e) {
            echo "1".$e->getMessage();
            return false;
        }
    }
    public function getLocationID($locationName){
        try{
            $sql = "SELECT * FROM Locations WHERE locName = :locationName";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':locationName', $locationName);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }
    public function insertLocation($locationName){
        try{
            $sql = "INSERT INTO Locations (locName) VALUES(:locationName); ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':locationName', $locationName);
            $stmt->execute();
            #echo "New location added successfully";
            $result = $this->getLocationID($locationName);
            return $result;
        }catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }
    public function getLastPostID($userID){
        try{
            $sql = "SELECT * FROM Posts WHERE Posts.uID = :userID and Posts.pID = (SELECT MAX(Posts.pID) FROM Posts)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['pID'];
        }catch (PDOException $e) {
            echo "2".$e->getMessage();
            return false;
        }
    }

    public function updatePost($postID,$media){
        try {
            $sql = "UPDATE Posts SET mediapath=:media WHERE Posts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->bindparam(':media', $media);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updatePostTxt($postID,$content){
        try {
            $sql = "UPDATE Posts SET txt=:content WHERE Posts.pID=:postID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->bindparam(':content', $content);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getTagID($tag){
        try{
            $sql = "SELECT * FROM Tags WHERE Tags.tagName=:tag";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':tag', $tag);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }
    public function insertTag($tag){
        try{
            $sql = "INSERT INTO Tags (tagName) VALUES(:tag); ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':tag', $tag);
            $stmt->execute();
            #echo "New tag added successfully";
            $result = $this->getTagID($tag);
            return $result;
        }catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }
    public function insertPostsHasTags($postID, $tagID){
        try{
            $sql = "INSERT INTO PostsHasTags (pId, tID) VALUES(:postID, :tagID); ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':postID', $postID);
            $stmt->bindparam(':tagID', $tagID);
            $stmt->execute();
            #echo "New post created successfully";
            return true;
       }catch (PDOException $e) {
            #echo $e->getMessage();
            return false;
        }
    }

    public function insertPhotoToUser($userID, $destination){
        try {
            $sql = "UPDATE Users SET pp=:destination WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':destination', $destination);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
  
    public function deleteUser($userID)
    {
        try {

            $sql = "DELETE FROM Users WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function deactivateUser($userID, $date)
    {
        try {
            $sql = "UPDATE Users SET isActive=0, bannedUntil=:date WHERE Users.uID=:userID";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':userID', $userID);
            $stmt->bindparam(':date', $date);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
