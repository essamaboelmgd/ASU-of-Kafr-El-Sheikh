<?php 

$conn = mysqli_connect("localhost", "root", "", "asu");

if(!$conn){
    echo 'Error : ' .mysqli_connect_error();
}
    

