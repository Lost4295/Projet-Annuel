<?php 
    session_start();
    if(isset($_SESSION['id'])){
        include_once $_SERVER["DOCUMENT_ROOT"]."/core/functions.php";
        $outgoing_id = $_SESSION['id'];
        $incoming_id = $_POST['incoming_id'];
        $output = "";
        $db = connectToDB();
        $sql2 = $db->prepare("SELECT * FROM ".PREFIX."messages WHERE (reciever_id =:incoming_id AND user_id =:outgoing_id) OR (reciever_id =:outgoing_id AND user_id =:incoming_id) ORDER BY id ASC");
        $sql2->execute(
              [
            'incoming_id'=>$incoming_id,
            'outgoing_id'=>$_SESSION['id']
          ]);
          $result2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result2 as $key => $message){
            if ($message['isread']==0 && $outgoing_id == $message['reciever_id']){
        $sql3 = $db->prepare("UPDATE ".PREFIX."messages SET isread= 1 WHERE id =:id ");
          $sql3->execute(
              [
              'id'=>$message['id']
              ]
              );
            }
          }
        $messages = $db->prepare("SELECT * FROM ".PREFIX."messages LEFT JOIN ".PREFIX."users ON ".PREFIX."users.id = ".PREFIX."messages.user_id
                WHERE (user_id = :oid AND reciever_id = :iid)
                OR (user_id = :iid AND reciever_id = :oid) ORDER BY ".PREFIX."messages.id");
        $messages->execute([
            'oid'=> $outgoing_id,
            'iid'=> $incoming_id
        ]);
        $result = $messages->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            foreach($result as $key =>$row){
                if($row['user_id'] === $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['content'] .'</p>
                                </div>
                                </div>';
                }else{
                    $output .= '<div class="chat incoming">
                                <img src="'.$row['avatar'].'" alt="">
                                <div class="details">
                                    <p>'. $row['content'] .'</p>
                                </div>
                                </div>';
                }
            }
        }else{
            $output .= '<div class="text">Aucun message envoyé. Quand vous en enverrez un, il apparaîtra ici.</div>';
        }
        echo $output;
    }else{
        header("location: ../login.php");
    }
