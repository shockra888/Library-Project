<?php
require_once("session.php");

$id = $_GET['id'];

$delRes ="DELETE FROM borrow WHERE bookId=$id";
if ($connect_db->query($delRes) === TRUE){
    $result1 = "DELETE FROM bookcount WHERE id=$id";
    if ($connect_db->query($result1) === TRUE){
        $result = "DELETE FROM book WHERE id=$id";
        if ($connect_db->query($result) === TRUE){
            header("Location:books.php?Deleted_Successfully");
        }
    }
}else{
    echo "Error to Delete record";
}
?>