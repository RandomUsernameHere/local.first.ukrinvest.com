<?php
    namespace web136\database;


    class ConnectDB {

        public static $instance;

        protected $arConfigs;

        protected $PDO_instance;

        public static function getInstance(){
            if(!self::$instance){
                self::$instance = new ConnectDB();
            }
            return self::$instance;
        }

        private function __construct(){

            try{
                $this->getDbConfig();

                $this->PDO_instance = new \PDO(
                    "mysql:host={$this->arConfigs['HOST']};dbname={$this->arConfigs['DATABASE']}",
                    $this->arConfigs['USER'],
                    $this->arConfigs['PASSWORD']
                );

                $this->PDO_instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            catch(\PDOException $e){
                echo $e->getMessage();
                exit();
            }
            catch(\Exception $e){
                echo $e->getMessage();
                exit();
            }

        }

        public function getPDO_instance(){
            return $this->PDO_instance;
        }

        private function __clone(){

        }

        protected function getDbConfig(){
            if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/config/database.php')){
                throw new \Exception('Не существует файла конфигурации');
            }

            if(!is_readable($_SERVER['DOCUMENT_ROOT'].'/config/database.php')){
                throw new \Exception('Не могу прочитать файл настроек');
            }

            require_once $_SERVER['DOCUMENT_ROOT'].'/config/database.php';

            if(!isset($params)||empty($params)){
                throw new \Exception('Отсутсвует или пуст массив настроек');
            }

            $this->arConfigs = $params;
        }
    }