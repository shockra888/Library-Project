<?php
error_reporting(~E_DEPRECATED & ~E_NOTICE);
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'project_library';
$connect_db = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if($connect_db === FALSE){
    die("Error to connect database" . mysqli_connect_error());
}
