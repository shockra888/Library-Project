<?php
require_once("session.php");
$id = $_GET['id'];
$Bid = $_GET['Bid'];

$Date = date("Y-m-d");

$BorrowReturn = "UPDATE `borrow` SET `dateReturned` = '$Date' WHERE `borrow`.`id` = $id";
if ($connect_db->query($BorrowReturn) === TRUE) {
    $BorrowCount = mysqli_query($connect_db, "UPDATE bookcount SET totalNumber = totalNumber + 1 WHERE bookId = $Bid");
    header("Location:BorrowedbyAdmin.php?=$_SESSION[id]");
} else {
    echo "ERROR";
}
