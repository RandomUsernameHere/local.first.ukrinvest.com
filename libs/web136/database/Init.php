<?php
    namespace web136\database;

    /**
     * Class Init
     * @package web136\database
     */
    final class Init {

        /**
         * @var \PDO
         */
        protected $db;

        /**
         * @param void
         * @return void
         * @description добавляет в класс экземпляр \PDO
         */
        protected function setDb(){
            $this->db = ConnectDB::getInstance()->getPDO_instance();
        }

        /**
         * @param int $rows_quantity
         */
        public function __construct($rows_quantity=50){

            $this->setDb();

            $this->create();

            $this->fill($rows_quantity);

        }

        /**
         * @return bool|string
         * @description Создает таблицу в БД, если та не существует
         */
        private function create(){

            try{

                if(!$this->isTableExist()){
                    $this->db->query(
                        'CREATE TABLE IF NOT EXISTS `test` (
                          `id` INTEGER(5) UNSIGNED AUTO_INCREMENT,
                          `script_name` VARCHAR(25),
                          `start_time` INTEGER(10),
                          `end_time` INTEGER(10),
                          `Result` VARCHAR(8),
                        PRIMARY KEY (id))
                        ENGINE MyIsam CHARACTER SET utf8'
                    );
                }

                return true;
            }
            catch (\PDOException $e){
                return $e->getMessage();
            }
            catch (\Exception $e){
                return $e->getMessage();
            }

        }

        /**
         * @param int $rows_quantity
         * @return bool|string
         * @description Создает в таблице $rows_quantity случайных записей в случае, если таблица пуста
         */
        private function fill($rows_quantity=50){

            try{

                if(!$this->isTableExist()){
                    throw new \Exception('Таблицы для заполнения не существует!');
                }
                else{

                    if($this->isTableEmpty()){
                        $statement = $this->db->prepare(
                            'INSERT INTO `test`
                            (
                                `script_name`,
                                `start_time`,
                                `end_time`,
                                `Result`
                            )
                        VALUES
                            (
                                :script_name,
                                :start_time,
                                :end_time,
                                :Result
                            )'
                        );

                        for($i=1; $i<=$rows_quantity; $i++){
                            $statement->execute(
                                array(
                                    ':script_name'=>$this->generateScriptName(15),
                                    ':start_time'=>$this->generateTime(),
                                    ':end_time'=>$this->generateTime(),
                                    ':Result'=>$this->generateResult()
                                )
                            );
                        }

                        $statement->closeCursor();
                    }

                }

                return true;

            }
            catch (\PDOException $e){
                return $e->getMessage();
            }
            catch (\Exception $e){
                return $e->getMessage();
            }



        }

        /**
         * @return array|string
         * @description Получает данные из таблицы в соответствии с заданием
         */
        public function get(){

            try{
                $statement = $this->db->prepare(
                    "SELECT
                    `id`,
                    `script_name`,
                    `start_time`,
                    `end_time`,
                    `Result`
                FROM
                  `test`
                WHERE
                  `Result` = 'normal' OR `Result` = 'success'
                ");

                if($statement->execute()){

                    $resultArray = array();

                    while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
                        $resultArray[] = $row;
                    }

                    $statement->closeCursor();

                    return $resultArray;
                }
                else{

                    throw new \Exception('Ошибка при выполнении запроса');
                }
            }
            catch (\PDOException $e){
                return $e->getMessage();
            }
            catch (\Exception $e){
                return $e->getMessage();
            }

        }

        /**
         * @return bool|string
         * @description Удаляет таблицу
         */
        public function deleteTable(){
            try{
                $this->db->query(
                    'DROP TABLE  `test`'
                );
            }
            catch(\PDOException $e){
                return $e->getMessage();
            }
            catch(\Exception $e){
                return $e->getMessage();
            }
            return true;
        }

        /**
         * @param int $length
         * @return string
         * @description случайным порядком формирует строку длиной $length
         */
        protected function generateScriptName($length=15){
            $characters = 'abcdefghiklmnopqastuvwxyzABCDEFGHIJKLMNOPQRSTUVWQYZ';

            $result = '';

            for($i=0; $i<=$length; $i++){
                $result .= $characters[mt_rand(0, strlen($characters)-1)];
            }

            return $result;
        }

        /**
         * @return int
         * @description негерирует случайный timestamp
         */
        protected function generateTime(){
            return mktime(0,0,0,rand(2005,2105),rand(1,31),rand(1,12));
        }

        /**
         * @return string
         * @description случайным образом выбирает строку из списка
         */
        protected function generateResult(){
            $variants = array(
                'normal', 'illegal', 'failed', 'success'
            );
            return $variants[rand(0, count($variants)-1)];
        }

        /**
         * @return bool
         * @throws \Exception
         * @description Проверяет существует ли таблица
         */
        protected function isTableExist(){

            $statement = $this->db->prepare("SHOW TABLES LIKE 'test'");

            if($statement->execute()){
                $resultArray = array();

                while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
                    $resultArray[] = $row;
                }

                $statement->closeCursor();

                return !empty($resultArray);
            }
            else{
                throw new \Exception('Ошибка при выполнении запроса');
            }
        }

        /**
         * @return bool
         * @throws \Exception
         * @description Проверяет таблицу на пустоту
         */
        protected function isTableEmpty(){
            $statement = $this->db->prepare("SELECT `id` FROM `test` LIMIT 1");

            if($statement->execute()){
                $resultArray = array();

                while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
                    $resultArray[] = $row;
                }

                $statement->closeCursor();

                return empty($resultArray);
            }
            else{
                throw new \Exception('Ошибка при выполнении запроса');
            }
        }
    }