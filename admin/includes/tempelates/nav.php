<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="home.php">SUGER</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item">
        <a class="nav-link" href="categories.php">catigories</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="items.php">items</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">statistics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="comments.php">Comments</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="members.php">members</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">logs</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          more
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION['id']?>">Edit profile</a>
          <a class="dropdown-item" href="#">setting</a>
          <a class="dropdown-item" href="../index.php" target="blank">Visit Shop</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Log out</a>
        </div>
      </li>
    </ul>
  </div>
</nav>