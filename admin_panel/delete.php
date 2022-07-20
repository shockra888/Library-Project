
<?php
require_once("session.php");

$id = $_GET['id'];

if($id==1){
    $msg =  "Unable_to_delete_admin_account";
    header("Location:users.php?=$msg");
}else{

$Delacc = "DELETE FROM account WHERE id=$id";

if ($connect_db->query($Delacc) === TRUE){
    $DelRes = "DELETE FROM borrow WHERE StudentId=$id";

    if ($connect_db->query($DelRes) === TRUE){
        $DelStudent = "DELETE FROM student WHERE id=$id";

        if ($connect_db->query($DelStudent) === TRUE){
            header("Location:users.php?Deleted_Successfully");
        }
    }
}
}

?>
