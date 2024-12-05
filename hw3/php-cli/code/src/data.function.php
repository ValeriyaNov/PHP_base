<?php

$address = '/code/birthdays.txt';


function validate(string $date): bool {
    $time = strtotime($date);

    $dateBlocks = explode("-", $date);

    if(count($dateBlocks) < 3){
        return false;
    }

    if(isset($dateBlocks[0]) && $dateBlocks[0] > 31) {
        return false;
    }

    if(isset($dateBlocks[1]) && $dateBlocks[1] > 12) {
        return false;
    }

    if(isset($dateBlocks[2]) && $dateBlocks[2] < 1923) {
        return false;
    }

    if($time > strtotime(date('d-m-Y'))) {
        return false;
    }
  
    return true;
}

function validateName(string $name) :bool { // проверка имени, чтобы оно было больше 2 символов и состояло только из букв
    if (mb_strlen($name) <= 2){
        return false;
    }
    if (!preg_match("/^[a-z]+$/i", $name)){
        return false;
    }
    return true;
    

}
