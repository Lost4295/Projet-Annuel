<?php require $_SERVER['DOCUMENT_ROOT']."/core/header.php" ?>
<div style="background-image:url('/img/maze<?php echo rand(1, 7)?>.png'); height:100vh" alt="404" class="img-fluid mx-auto bg-image">
<div>
<div class="card m-3">
<h1 class="fs-1 text-center">404</h1>
<h2 class="fs-2 text-center">La page, ou ressource demandée n'existe pas. Peut-être qu'elle a été déplacée, ou bien que la page a été suprimée ? Qui sait.. The Arena est un grand labyrinthe après tout. </h2>
<h3 class="fs-3 text-center">Vous pouvez retourner à l'accueil en cliquant <a title="Accueil" href="/">ici</a>.</h3>
</div>
<a href="/hiddengame">
<img
    src="/img/vous_etes_ici.png"
    alt="Vous êtes perdu, je crois."
    title="Vous êtes perdu, je crois."
    width="80"
    style="position:relative; top:<?php echo rand(10,500)?>px;left:<?php echo rand(10,500)?>px;bottom:<?php echo rand(10,500)?>px;right:<?php echo rand(10,500)?>px;">
</a>
</div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>