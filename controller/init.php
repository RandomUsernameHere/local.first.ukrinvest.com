<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/init.php';

    if(!isset($_POST['name'])||empty($_POST['name'])){
        $Result = 'Неизвестное действие!';
    }
    else{
        switch ($_POST['name']){
            case 'getResult':
                $init = new web136\database\Init();
                $Result = $init->get();
            break;
            case 'clearResult':
                $init = new web136\database\Init();
                $delete = $init->deleteTable();
                if($delete===true){
                    unset($init);
                    $Result = array();
                }
                else{
                    $Result = $delete;
                }
            break;
            default:
                $Result = 'Неизвестное действие!';
            break;
        }
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/view/init.php';