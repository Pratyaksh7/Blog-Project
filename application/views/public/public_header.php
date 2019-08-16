<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Articles List</title>
	<?= link_tag('assets/css/bootstrap.min.css') ?>
</head>
<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light ">
  <a class="navbar-brand" href="#">Articles</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor03">
    <?= form_open('user/search', ['class'=> 'form-inline my-2 my-lg-0', 'role'=>'search']) ?>
    <!-- <form class="form-inline my-2 my-lg-0"> -->
      <input class="form-control mr-sm-2" type="text" name="query" placeholder="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
     <?= form_close(); ?>
     <?= form_error('query',"<p class='navbar-text text-danger'>",'</p>' ) ?>
    <ul class="navbar-nav mr-auto " style="margin-left: 70%;">
      <li class="nav-item active">
        <?= anchor('login','Login',['class'=>'nav-link']) ?>
        
      </li>
      
    </ul>
  </div>
</nav>