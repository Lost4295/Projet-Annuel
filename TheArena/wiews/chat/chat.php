<?php 
include_once $_SERVER ['DOCUMENT_ROOT']."/core/formatter.php";

include_once $_SERVER ['DOCUMENT_ROOT']."/core/functions.php";
redirectIfNotConnected();

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
$sql2 = $db->prepare("SELECT * FROM ".PREFIX."users_blocked WHERE blocked_id = :id AND user_id = :user_id");
$sql2->execute([
    "id" => $user_id,
    'user_id'=>$_SESSION['id']
]);
$result2 = $sql2->fetch(PDO::FETCH_ASSOC);
if(!empty($result2)){
  $_SESSION['message']="Vous avez bloqué cet utilisateur !";
  $_SESSION['message_type']= "danger";
  header("location: /chat");
  exit();
}
if ($result['visibility'] <= 1) {
  $_SESSION["message"] = "Ce profil est privé.";
  $_SESSION["message_type"] = "danger";
  header("location: /chat");
  exit();
}
if ($_SESSION['id'] == $user_id) {
  $_SESSION["message"] = "Vous ne pouvez pas vous envoyer de message à vous même.";
  $_SESSION["message_type"] = "danger";
  header("location: /chat");
  exit();
}

include_once $_SERVER ['DOCUMENT_ROOT']."/core/header.php";

?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>

        <a href="/chat" class="back-icon" title="Retour au chat"><i class="bi bi-arrow-left"></i></a>
        <img src="<?php echo $result['avatar']; ?>" alt="">
        <div class="details">
          <span><a class="text-decoration-none link-dark " href="/user?id=<?php echo $user_id ?>"><?php echo $result['username'] ?></a></span>
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
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    document.getElementById("m").classList.add("d-flex");
    document.getElementById("m").classList.add("justify-content-center");
  });
</script>
<?php include $_SERVER['DOCUMENT_ROOT']."/core/footer.php";
