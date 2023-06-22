<?php 

include_once $_SERVER ['DOCUMENT_ROOT']."/core/functions.php";
redirectIfNotConnected();
include_once $_SERVER ['DOCUMENT_ROOT']."/core/header.php"; 

?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $user_id = strip_tags($_GET['user_id']);
          $db = connectToDB();
          $sql = $db->prepare("SELECT * FROM ".PREFIX."users WHERE id =:id");
          $sql->execute(
            [
              'id'=>$user_id
            ]
            );
            $result = $sql->fetch(PDO::FETCH_ASSOC);
          if(empty($result)){
            $_SESSION['message']="Cet utilisateur n'existe pas !";
            $_SESSION['message_type']= "danger";
            header("location: /chat");
            exit();
          }
        ?>
        <a href="/chat" class="back-icon"><i class="bi bi-arrow-left"></i></a>
        <img src="<?php echo $result['avatar']; ?>" alt="">
        <div class="details">
          <span><?php echo $result['username'] ?></span>
          <p><?php echo formatActivity($result['activeonsite']); ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Écrivez votre message..." autocomplete="off">
        <button><i class="bi bi-send"></i></button>
      </form>
    </section>
  </div>

  <script src="/wiews/chat/javascript/chat.js"></script>

<?php include $_SERVER['DOCUMENT_ROOT']."/core/footer.php";
