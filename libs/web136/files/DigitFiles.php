<?php
    namespace web136\files;

    /**
     * Class DigitFiles
     * @package web136\files
     */
    class DigitFiles {

        /**
         * @var string
         */
        protected $regEx = '/^[a-zA-Z\d]+\.txt$/i';

        /**
         * @var string
         */
        protected $directory;

        /**
         * @var array
         */
        protected $allFilesList;

        /**
         * @var array
         */
        protected $filteredList;

        /**
         * @param string $directory
         */
        public function __construct($directory = 'files'){
            $this->setDirectory($directory);
        }

        /**
         * @return array
         * @description возвращает нефильтрованный список файлов
         */
        public function getAllFilesList() {
            return $this->allFilesList;
        }

        /**
         * @return array
         * @description возвращает список файлов, отфильтрованных
         * в соответсвии с критерием $this->regEx
         */
        public function getFilteredList(){
            return $this->filteredList;
        }

        /**
         * @param $directory
         * @throws \Exception
         * @description Устанавливает директорию для поиска.
         */
        public function setDirectory($directory){
            $this->directory = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.trim($directory, DIRECTORY_SEPARATOR);
            $this->generateAllFilesList();
            $this->generateFilteredList();
        }

        /**
         * @throws \Exception
         * @description генерирует нефильтрованный список файлов
         */
        protected function generateAllFilesList(){

            if(!is_dir($this->directory)){
                throw new \Exception("Путь не является директорией");
            }

            //Значение вынесено в переменную, а не сразу в цикл потому что мне нужна
            //проверка на успешное выполнение
            $tempResult = scandir($this->directory);

            if($tempResult === FALSE){
                throw new \Exception('Ошибка при сканировании директории');
            }

            $tempArray = array();

            foreach($tempResult as $item){

                if($item == '.'||$item == '..'){
                    continue;
                }

                $tempArray[] = array(
                    'NAME' => $item,
                    'IS_DIR' => is_dir($this->directory.DIRECTORY_SEPARATOR.$item)
                );

            }

            $this->allFilesList = $tempArray;

        }

        /**
         *@description генерирует список файлов в соответсвии с критерием $this->regEx
         */
        protected function generateFilteredList(){

            $tmpArray = array();

            foreach($this->allFilesList as $item){
                if(!$item['IS_DIR']&&
                    preg_match($this->regEx, $item['NAME'])){
                    $tmpArray[] = $item;
                }
            }

            $this->filteredList = $tmpArray;

        }

    }