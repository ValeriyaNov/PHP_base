<?php

// function readAllFunction(string $address) : string {
function readAllFunction(array $config) : string {
    $address = $config['storage']['address'];
    
    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $contents = ''; 
    
        while (!feof($file)) {
            $contents .= fread($file, 100);
        }
        
        fclose($file);
        return $contents;
    }
    else {
        return handleError("Файл не существует");
    }
}

// function addFunction(string $address) : string {
function addFunction(array $config) : string {
    $address = $config['storage']['address'];

    $name = readline("Введите имя: ");
    if (!validateName($name)) {
        return handleError("Некорректное имя");
    }
    $date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");
    if (!validate($date)) {
        return handleError("Некорректный формат даты");
    }
    $data = $name . ", " . $date . "\r\n";

    $fileHandler = fopen($address, 'a');

    if(fwrite($fileHandler, $data)){
        return "Запись $data добавлена в файл $address"; 
    }
    else {
        return handleError("Произошла ошибка записи. Данные не сохранены");
    }

    fclose($fileHandler);
}

// function clearFunction(string $address) : string {
function clearFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "w");
        
        fwrite($file, '');
        
        fclose($file);
        return "Файл очищен";
    }
    else {
        return handleError("Файл не существует");
    }
}

function helpFunction() {
    return handleHelp();
}

function readConfig(string $configAddress): array|false{
    return parse_ini_file($configAddress, true);
}

function readProfilesDirectory(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!is_dir($profilesDirectoryAddress)){
        mkdir($profilesDirectoryAddress);
    }

    $files = scandir($profilesDirectoryAddress);

    $result = "";

    if(count($files) > 2){
        foreach($files as $file){
            if(in_array($file, ['.', '..']))
                continue;
            
            $result .= $file . "\r\n";
        }
    }
    else {
        $result .= "Директория пуста \r\n";
    }

    return $result;
}

function readProfile(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!isset($_SERVER['argv'][2])){
        return handleError("Не указан файл профиля");
    }

    $profileFileName = $profilesDirectoryAddress . $_SERVER['argv'][2] . ".json";

    if(!file_exists($profileFileName)){
        return handleError("Файл $profileFileName не существует");
    }

    $contentJson = file_get_contents($profileFileName);
    $contentArray = json_decode($contentJson, true);

    $info = "Имя: " . $contentArray['name'] . "\r\n";
    $info .= "Фамилия: " . $contentArray['lastname'] . "\r\n";

    return $info;
}

function searchBD(array $config) :string {
    $address = $config['storage']['address'];
    
    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $contents = ''; 
    
        while (!feof($file)) {
            $contents .= fread($file, 100);
        }
        
        fclose($file);

        $data = explode("\r\n", $contents);    

        $dateD = date("d");
        $dateM = date("m");

        foreach ($data as $record){
            $recordData = explode(',', $record);
            $recordDataD = explode('-', $recordData[1]);
            if(isset($recordDataD) && $recordDataD[0] == $dateD && $recordDataD[1] == $dateM ){
                return $recordData[0];
            }
        }

        return "Записей с данной датой рождения не найдено";
    }
    else {
        return handleError("Файл не существует");
    }
}

function deleteUser(array $config) :string {
    $address = $config['storage']['address'];
    
    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $contents = ''; 
    
        while (!feof($file)) {
            $contents .= fread($file, 100);
        }
        
        fclose($file);

        $data = explode("\r\n", $contents);    

        $date = readline("Введите имя или дату рождения в формате ДД-ММ-ГГГГ: ");

        $result = [];
        $wasFound = false;
        foreach ($data as $record){
            $recordData = explode(',', $record);
            if(!((isset($recordData[0]) && trim($recordData[0]) == $date) || 
                 (isset($recordData[1]) && trim($recordData[1]) == $date))){
                array_push($result, $record);
            } else {
                $wasFound = true;
            }
        }

        $dataToWrite = implode("\r\n", $result);

        $fileHandler = fopen($address, 'w');
        fwrite($fileHandler, $dataToWrite);
        fclose($fileHandler);

        if ($wasFound) {
            return "Записи, соответствующие указанному критерию, успешно удалены";
        } else {
            return "Записи, соответствующие указанному критерию, не найдены";
        }

        return "Записей с данной датой рождения не найдено";
    }
    else {
        return handleError("Файл не существует");
    }
}