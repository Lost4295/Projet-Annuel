<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";

include $_SERVER['DOCUMENT_ROOT'] . "/core/formatter.php";
$db = connectToDB();

$qir = $db->query("SELECT * FROM " . PREFIX . "poweranking ORDER BY score DESC");
$powerRankingClassement =  $qir->fetchAll(PDO::FETCH_ASSOC);


?>
<div class="row border">
  <h2>Classement des joueurs aux événements</h2>
</div>
<div class="row border">
  <nav class="navbar navbar-expand-lg navbarBorder">
    <div class="container-fluid d-flex justify-content-center">
      <ul class="navbar-nav">
        <li class="nav-item border">
          <a class="nav-link active" aria-current="page" href="#">CSGO</a>
        </li>
        <li class="nav-item border">
          <a class="nav-link active" aria-current="page" href="#">LOL</a>
        </li>
        <li class="nav-item border">
          <a class="nav-link" href="#">Smash</a>
        </li>

        <li class="nav-item border">
          <a class="nav-link" href="#">SC2</a>
        </li>
        <li class="nav-item border">
          <a class="nav-link" href="#">R6</a>
        </li>
        <li class="nav-item border">
          <a class="nav-link" href="#">Rocket League </a>
        </li>
      </ul>
    </div>
  </nav>
</div>
<div class="row d-flex justify-content-center">
  <div class="container-fluid">
    <form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
</div>
<?php foreach ($powerRankingClassement as $ranking) { ?>
  <div class="row d-flex justify-content-center border col-12">
    <div class="row d-flex justify-content-center">
      <h4><?php echo formatUsers($ranking['uid']) ."    -    ". $ranking['score'] ?> points </h4>
    </div>
  </div>
<?php } if (empty($powerRankingClassement)) { ?>
  <div class="row d-flex justify-content-center border col-12">
    <div class="row d-flex justify-content-center">
      <h4>Il n'y a pas encore de classement.</h4>
    </div>
  </div>
<?php } ?>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>