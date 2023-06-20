
<?php 
  session_start();
include_once $_SERVER ['DOCUMENT_ROOT']."/core/header.php"; 
redirectIfNotConnected(); ?>
  <!-- <link rel="stylesheet" href="/core/css/stylei.css"> -->
<body>
  <div class="wrapper">
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
            <span><?php echo $row['first_name']. " " . $row['last_name'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
      </header>
      <div class="search">
        <span class="text">Select an user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>

  <script src="/wiews/chat/javascript/users.js"></script>


<?php include_once $_SERVER ['DOCUMENT_ROOT']."/core/footer.php"; 

