<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/init.php';

    try{
        $files = new web136\files\DigitFiles();

        switch($_POST['FILE_PARAM']){
            case 'getAll':
                $Result['HEADING'] = 'Все файлы';
                $Result['CONTENT'] = $files->getAllFilesList();
            break;
            case 'getFiltered':
                $Result['HEADING'] = 'Отфильтрованные файлы';
                $Result['CONTENT']  = $files->getFilteredList();
            break;
            default:
                throw new \Exception('Параметр FILE_PARAM имеет некорректное значение');
            break;
        }
    }
    catch (\Exception $e){
        $Result = $e->getMessage();
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/view/files.php';
