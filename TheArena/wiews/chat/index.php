
<?php 
include_once $_SERVER ['DOCUMENT_ROOT']."/core/functions.php";
include_once $_SERVER ['DOCUMENT_ROOT']."/core/formatter.php";
  redirectIfNotConnected();

include_once $_SERVER ['DOCUMENT_ROOT']."/core/header.php";
?>
  <!-- <link rel="stylesheet" href="/core/css/stylei.css"> -->
<div class="col d-flex align-items-center justify-content-center">
  <div class="row">
    <section class="users">
      <header>
        <div class="content">
          <?php 
          $db = connectToDB();
            $sql = $db->prepare("SELECT * FROM ".PREFIX."users WHERE email= :email");
            $sql->execute([
                "email" => $_SESSION['email']
            ]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id'] = $row['id'];
          ?>
          <img src="<?php echo $row['avatar']; ?>" alt="">
          <div class="details">
            <h3><?php echo $row['username'] ?></h3>
            <p><?php echo formatActivity($row['activeonsite']); ?></p>
          </div>
        </div>
      </header>
      <div class="search col-auto">
        <span class="text">Select an user to start chat</span>
        <input type="text" placeholder="Entrez un nom pour rechercher un utilisateur...">
        <button><i class="bi bi-search"></i></button>
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>
  </div>

  <script src="/wiews/chat/javascript/users.js"></script>


<?php include_once $_SERVER ['DOCUMENT_ROOT']."/core/footer.php"; 

