<?php 
require $_SERVER['DOCUMENT_ROOT'].'/core/functions.php';
$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
$query = $db->prepare("SELECT status FROM ".PREFIX."forums WHERE id=:id");
$query->execute(["id"=>$id]);
$result = $query->fetch(PDO::FETCH_ASSOC);
if ($result['status']==0){
    $status=1;
} else {
    $status=0;
}
$query = $db->prepare("UPDATE ".PREFIX."forums SET status=:status WHERE id=:id");
$query->execute(["id"=>$id, 'status'=>$status]);
}

header("Location: /admin/forum/read?id=".$id);