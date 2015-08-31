<?php
    namespace web136\database;


    /**
     * Class ConnectDB
     * @package web136\database
     * @description обертка для создания экземпляра PDO
     */
    class ConnectDB {

        /**
         * @var
         * @description хранит экземпляр класса ConnectDb
         */
        public static $instance;

        /**
         * @var
         * @description массив, в котором хранятся параметры для соединения с базой
         */
        protected $arConfigs;

        /**
         * @var \PDO
         * @description экземпляр \PDO
         */
        protected $PDO_instance;

        /**
         * @return ConnectDB
         * @description создает и возвращает экземпляр класса ConnectDb
         */
        public static function getInstance(){
            if(!self::$instance){
                self::$instance = new ConnectDB();
            }
            return self::$instance;
        }

        /**
         * @description создает экземпляр \PDO
         */
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

        /**
         * @return \PDO
         * @description возвращает экземпляр \PDO
         */
        public function getPDO_instance(){
            return $this->PDO_instance;
        }

        /**
         * @description заглушка для чистого и незамутненного Singleton
         */
        private function __clone(){

        }

        /**
         * @throws \Exception
         * @description подключает файл конфигурации базы данных
         * Выкидывает исключения если файл конфигурации не существует, не доступен для чтения или если массив
         * параметров пуст
         */
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