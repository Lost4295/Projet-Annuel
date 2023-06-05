<!-- TODO faire en sorte de finir les events en entier (crud sur shop, back + front avec tout ce qu'il faut) -->

<?php require $_SERVER['DOCUMENT_ROOT'].'/core/header.php' ?>

<div class="slider">
    <?php
        $folder = $_SERVER['DOCUMENT_ROOT'].'/img/';
        $files = glob($folder . "*.{jpg,gif,png}", GLOB_BRACE);
        foreach($files as $file) {
            $url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);?>
            <div class="carousel-item">
      <img src="<?php echo $url ?>" class="d-block w-100" width="150px" alt="...">
    </div>
        <?php } 
    ?>
</div>
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="..." class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


<a href="/events" class="btn btn-warning">Événements</a>*


<button type="button" class="btn btn-warning" onclick="functiondefou()">
  Launch demo moda
</button>


<script>
  function functiondefou(){
    alert("defou");
    window.location.href = "/events";
  }
</script>

<?php


$test =10;

$int=intval($test);
$float=floatval($test);

echo $int."<br>";
echo $float."<br>";

echo ($float==$int)?"true":"false"."<br>";
