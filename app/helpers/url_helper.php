<?php
//url redirect
function redirect($page){
    header('location: ' . URLROOT . '/' . $page);
}
function checkExistsMod($connection,$sql,$param)
{
    $stmt = $connection->prepare($sql);
    $stmt->execute($param);
    return $stmt->fetchColumn();
}
function selectdCheck($value1,$value2)
   {
     if ($value1 == $value2) 
     {
      echo 'selected="selected"';
     } else 
     {
       echo '';
     }

     return;
}
function selectdCheckEdit($data,$fromdb,$value)
{
    if (!empty($data)) {
        if ($data == $value) {
           echo 'selected="selected"';
        }
        else{
            echo '';
        }
    }
    else{
         if ($fromdb == $value) {
            echo 'selected="selected"';
         }
         else{
            echo '';
         }
     }
     return;
}