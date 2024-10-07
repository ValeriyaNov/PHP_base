<?php
$num1 = 25;
$num2 = 74;
//1 задача
function sum($num1, $num2){
    return $num1 + $num2;
}
function diff($num1, $num2){
    return $num1 - $num2;
}
function mult($num1, $num2){
    return $num1 * $num2;
}
function div($num1, $num2) {
    if ($num2 == 0){
        return 'Ошибка - на ноль делить нельзя!';
    }
    else{
        return $num1 / $num2;
    }
}
//2 задача
function mathOperation($arg1, $arg2, $operation){
    switch ($operation) {
        case '+':
            return sum($arg1, $arg2);
            break;
        case '-':
            return diff($arg1, $arg2);
            break;
        case '*':
            return mult($arg1, $arg2);
            break;
        case '/':
            return div($arg1, $arg2);
            break;
        default:
            return 'Ошибка - невено указана операция!';
            break;
    }
}
//3 задача
$areas = ["Московская область" => ["Москва", "Зеленоград", "Клин"], "Ленинградская область"=> ["Санкт-Петербург", "Всеволожск", "Павловск", "Кронштадт"], "Курская область"=> ["Курск", "Курчатов", "Железногорск", "Обоянь"]];
foreach ($areas as $key => $area) {
    $len = count($area);
    
    printf ('%s:', $key);
    for ($i = 0; $i < $len; $i ++){
        if ($i < $len - 1){
            printf (' %s,', $area[$i]);
        }
        else{
            printf (" %s", $area[$i]);
            echo("<br>");
            
        }
    }
}
//4 задача
$alphabet = [
    'а' => 'a', 'б' => 'b', 'в' => 'v',
    'г' => 'g', 'д' => 'd', 'е' => 'e',
    'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
    'и' => 'i', 'й' => 'y', 'к' => 'k',
    'л' => 'l', 'м' => 'm', 'н' => 'n',
    'о' => 'o', 'п' => 'p', 'р' => 'r',
    'с' => 's', 'т' => 't', 'у' => 'u',
    'ф' => 'f', 'х' => 'h', 'ц' => 'c',
    'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
    'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
    'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
];
function translate($str, $alphabet){
    $result = "";
    $length = mb_strlen($str);
    
    for ($i = 0; $i < $length; $i ++)
    {
    	$letter = mb_substr($str, $i, 1);
    	
    	if (isset($alphabet[mb_strtolower($letter)])) {
    		if ($letter === mb_strtolower($letter)){
    			$newLetter = $alphabet[$letter];
    		}
    		else{
    			$newLetter = ucfirst($alphabet[mb_strtolower($letter)]);
    		}
    		
    	}
    	
    	else{
    		$newLetter = $letter;
    	}
    	$result .= $newLetter;
    }
    return $result;
}
$initialStr = 'Скажи-ка, дядя, ведь не даром Москва спаленная пожаром французу отдана...';
printf('%s - %s', $initialStr, translate($initialStr,$alphabet));
echo("<br>");

//5 задача
function getPower($val, $pow)
	{
		if ($pow == 1){
			return $val;
		}
		if ($pow != 1){
			return $val * getPower($val, $pow-1);
		}
			
	}
echo getPower(12, 7);
echo("<br>");

//6 задача
function getHours($h) {
    $hours = '';

    if($h>24)$h %= 24;

    if ($h === 1 || $h === 21) {
      $hours .= $h . " час";
    }
    elseif (($h >= 2 && $h <= 4) || ($h >= 22 && $h <= 24)) {
      $hours .= $h . " часа";
    }
    else {
      $hours .= $h . " часов";
    }

    return $hours;
  }

  function getMinutes($i) {
    $minutes = '';

    if (($i % 10 === 1) && ($i != 11)){
      $minutes .= $i . " минута";  
    }
    elseif (($i % 10 >= 2) && ($i % 10 <= 4)) {
      $minutes .= $i . " минуты";  
    }
    else {
      $minutes .= $i . " минут"; 
    }

    return $minutes;
  }

  function getSeconds($s) {
    $seconds = '';

    if (($s % 10 === 1) && ($s != 11)){
      $seconds .= $s . " секунда";  
    }
    elseif (($s % 10 >= 2) && ($s % 10 <= 4)) {
      $seconds .= $s . " секунды";  
    }
    else {
      $seconds .= $s . " секунд"; 
    }

    return $seconds;
  }

  function getCurrentTime($h, $i, $s) {
    return getHours($h) . getMinutes($i) . getSeconds($s);
  }

  

echo "Московское время: " . getCurrentTime(date("H") + 3, date(" i"), date(" s"));
echo("<br>");
echo "Время в Астане: " . getCurrentTime(date("H") + 5, date(" i"), date(" s"));

?>