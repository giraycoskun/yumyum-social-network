<?php

include_once 'components/session.php';
require_once 'db/conn.php';


$ID = $_GET['id'];
$sessionID = $_SESSION['uID'];

$action = $_GET['action'];
$from = $_GET['from'];

if ($action == "follow") {
    $crud->followUser($ID, $sessionID);
    if ($from == 'feed') {
        header("Location: showFollow.php?id=$sessionID&action=following");
    } else if ($from == 'profile') {
        header("Location: profile.php?id=$ID");
    } else if ($from == 'search') {
        header("Location: search.php");
    } else if ($from == 'tag') {
        $tagID = $_SESSION['tagID'];
        header("Location: tag.php?id=$sessionID&tagID=$tagID");
    } else if ($from == 'loc') {
        $locID = $_SESSION['locID'];
        header("Location: location.php?id=$sessionID&locID=$locID");
    }
} else if ($action == "unfollow") {
    $crud->unfollowUser($ID, $sessionID);
    if ($from == 'feed') {
        header("Location: showFollow.php?id=$sessionID&action=following");
    } else if ($from == 'profile') {
        header("Location: profile.php?id=$ID");
    } else if ($from == 'search') {
        header("Location: search.php");
    } else if ($from == 'tag') {
        $tagID = $_SESSION['tagID'];
        header("Location: tag.php?id=$sessionID&tagID=$tagID");
    } else if ($from == 'loc') {
        $locID = $_SESSION['locID'];
        header("Location: location.php?id=$sessionID&locID=$locID");
    }
} else if ($action == "followLoc") {
    $crud->followLoc($ID, $sessionID);
    #echo '<div class="alert alert-danger">Checkpoint 1 </div>';
    if ($from == 'feed') {
        header("Location: location.php?id=$sessionID&tagID=$ID");
    } else if ($from == 'profile') {
        header("Location: showFollow.php?id=$sessionID&action=showlocs");
    } else if ($from == 'search') {
        header("Location: search.php");
    }else if ($from == 'tag') {
        $tagID = $_SESSION['tagID'];
        header("Location: tag.php?id=$sessionID&tagID=$tagID");
    } else if ($from == 'loc') {
        $locID = $_SESSION['locID'];
        header("Location: location.php?id=$sessionID&locID=$locID");
    }
} else if ($action == "unfollowLoc") {
    $crud->unfollowLoc($ID, $sessionID);
    #echo '<div class="alert alert-danger">Checkpoint 1 </div>';

    if ($from == 'feed') {
        header("Location: location.php?id=$sessionID&tagID=$ID");
    } else if ($from == 'profile') {
        header("Location: showFollow.php?id=$sessionID&action=showlocs");
    } else if ($from == 'search') {
        header("Location: search.php");
    }else if ($from == 'tag') {
        $tagID = $_SESSION['tagID'];
        header("Location: tag.php?id=$sessionID&tagID=$tagID");
    } else if ($from == 'loc') {
        $locID = $_SESSION['locID'];
        header("Location: location.php?id=$sessionID&locID=$locID");
    }
} else if ($action == "followTag") {
    $crud->followTag($ID, $sessionID);
    #echo '<div class="alert alert-danger">Checkpoint 1 </div>';
    if ($from == 'feed') {
        header("Location: tag.php?id=$sessionID&tagID=$ID");
    } else if ($from == 'profile') {
        header("Location: showFollow.php?id=$sessionID&action=tags");
    } else if ($from == 'search') {
        header("Location: search.php");
    }else if ($from == 'tag') {
        $tagID = $_SESSION['tagID'];
        header("Location: tag.php?id=$sessionID&tagID=$tagID");
    } else if ($from == 'loc') {
        $locID = $_SESSION['locID'];
        header("Location: location.php?id=$sessionID&locID=$locID");
    }
} else if ($action == "unfollowTag") {
    $crud->unfollowTag($ID, $sessionID);
    #echo '<div class="alert alert-danger">Checkpoint 1 </div>';
    if ($from == 'feed') {
        header("Location: tag.php?id=$sessionID&tagID=$ID");
    } else if ($from == 'profile') {
        header("Location: showFollow.php?id=$sessionID&action=tags");
    } else if ($from == 'search') {
        header("Location: search.php");
    }else if ($from == 'tag') {
        $tagID = $_SESSION['tagID'];
        header("Location: tag.php?id=$sessionID&tagID=$tagID");
    } else if ($from == 'loc') {
        $locID = $_SESSION['locID'];
        header("Location: location.php?id=$sessionID&locID=$locID");
    }
}
