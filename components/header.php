<?php include_once 'components/session.php';
if (isset($_SESSION['uID'])) {
  $userID = $_SESSION['uID'];
}
require_once "db/conn.php";
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="css/forms.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/post.css">

  <!-- Import jquery cdn -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
  </script>

  <title><?php echo $title ?></title>

</head>

<body>


  <?php if (!isset($_SESSION['mail'])) : ?>
    <!-- Image and text -->
    <nav class="navbar navbar-light bg-light">
      <a class="navbar-brand" href="#">
        <img src="https://drive.google.com/thumbnail?id=1LolaArK6Zwpb9r93fiVGC1GQ09Fjy6qs" width="30" height="30" class="d-inline-block align-top" alt="">
        Yum Yum
      </a>
    </nav>


  <?php elseif ($_SESSION['isAdmin'] == true) : ?>
    <nav class="navbar navbar-light bg-light">
      <a class="navbar-brand" href="admin.php">
        <img src="https://drive.google.com/thumbnail?id=1LolaArK6Zwpb9r93fiVGC1GQ09Fjy6qs" width="30" height="30" class="d-inline-block align-top" alt="">
        Admin DashBoard
      </a>






      </form>
      <form action="search.php" method="post" class="d-flex px-2">
        <select class="mdb-select md-form colorful-select dropdown-primary" searchable="Search here.." name="type">
          <option value="1">User</option>
          <option value="2">Post</option>
        </select>
        <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search </button>
      </form>

      </form>
      <form action="logout.php" method="get" class="d-flex px-2">
        <button class="btn btn-sm btn-primary btn-block px-2" name="logout" type="submit">Logout</button>
      </form>
    </nav>


  <?php else : ?>

    <nav class="navbar-expand-lg navbar navbar-dark bg-dark">
      <div class="container-fluid mx-auto">
        <a class="navbar-brand" href="#">
          <img src="https://drive.google.com/thumbnail?id=1LolaArK6Zwpb9r93fiVGC1GQ09Fjy6qs" width="30" height="30" class="d-inline-block align-top" alt="">
          Yum Yum
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="feed.php?id=<?php echo $userID ?>">Feed</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="profile.php?id=<?php echo $userID ?>">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="chatbox.php?id=<?php echo $userID ?>">ChatBox</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="notifications.php?id=<?php echo $userID ?>">Notifications<span class="badge">(<?php $result2 = $crud->getNotificationCount($userID); echo $result2["NotifCount"]?>)</span> </a>              
            </li>
          </ul>
          <div class="d-flex px-2">
            <form action="search.php" method="post" class="d-flex px-2">
              <select class="mdb-select md-form colorful-select dropdown-primary" searchable="Search here.." name="type">
                <option value="1">User</option>
                <option value="2">Post</option>
                <option value="3">Locations</option>
                <option value="4">Tags</option>
              </select>
              <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search </button>
            </form>
            <form action="newpost.php" method="get" class="d-flex px-2">
              <button class="btn btn-sm btn-primary btn-block px-2" name="post" type="submit">New Post</button>
            </form>
            <form action="logout.php" method="get" class="d-flex px-2">
              <button class="btn btn-sm btn-secondary btn-block px-2" name="logout" type="submit">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </nav>
  <?php endif; ?>