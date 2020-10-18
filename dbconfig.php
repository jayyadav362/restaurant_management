<?php 

$connect = mysqli_connect('localhost','root','','foodie');


function calling($table,$cond=NULL){

    global $connect;
    $array = [];
    if($cond==NULL){
        $query = mysqli_query($connect,"SELECT * from $table");
    }
    else{
        $query = mysqli_query($connect,"SELECT * from $table WHERE $cond");
    }
    
    while($row = mysqli_fetch_array($query)){
        $array[] = $row;
    }
    return $array;
}


function delete_data($table,$cond){
    global $connect;

    $query = mysqli_query($connect,"DELETE FROM $table WHERE $cond");

    
}
function get_rows($table,$cond=NULL){

    global $connect;
    $array = [];
    if($cond==NULL){
        $query = mysqli_query($connect,"SELECT * from $table");
    }
    else{
        $query = mysqli_query($connect,"SELECT * from $table WHERE $cond");
    }
    
   $row = mysqli_fetch_array($query);
   return $row;
}

function update($table,$fields,$cond){
    global $connect;

    $query = mysqli_query($connect,"UPDATE $table SET $fields WHERE $cond");
    return ($query)? true: false;


}

function insert($table,$fields){
    $cols = implode(",",array_keys($fields));
    $rows = implode("','",array_values($fields));

    global $connect;
    $query = mysqli_query($connect,"INSERT INTO $table ($cols) value ('$rows')");

    return ($query)? true: false;
}
function redirect($page){
    echo "<script>window.open('$page.php','_self')</script>";
}

function check_data($table,$cond){
    
    global $connect;
    $array = [];
    
    $query = mysqli_query($connect,"SELECT * from $table WHERE $cond");
    $count = mysqli_num_rows($query);

    if($count > 0){
        return true;
    }
    else{
        return false;
    }
}

?>