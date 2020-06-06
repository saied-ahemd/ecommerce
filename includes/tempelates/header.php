<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php getTitle() ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
          <link rel="stylesheet" href="thems/frontend.css">
          <link rel="stylesheet" href="file:///C:/Users/saied/Desktop/fontawesome/css/all.css" type="text/css">
          <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet"> 
          <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
</head>
<body>
    <div class="upper-bar">
        <div class="container">
        <p>upper-bar</p>

        </div>
        
    </div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="index.php">HOME</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto" style="margin-right:150px;">
      <?php
        $catecories=getCAt();
        foreach($catecories as $cat){
            echo '<li class="nav-item"><a href="categories.php?pageid='.$cat["ID"].'&pageName='.str_replace(' ','-',$cat["Name"]).'" class="nav-link" style="margin-right:20px;">'.$cat["Name"].'</a></li>';
        }
      ?>
    </ul>
  </div>
</nav>
    