<?php require_once $_SERVER['DOCUMENT_ROOT'].'/init.php'?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Задания 1 и 2</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/css/style.css">
        <script src="/js/jquery-1.11.3.min.js"></script>
        <script src="/js/script.js"></script>
    </head>
    <body>
        <div class="content-wrapper">
            <div class="section" id="database">
                <div class="description">
                    <h2>Задание №1</h2>
                </div>
                <div class="controls">
                    <button name="getResult" class="button green-button active">Получить результат</button>
                    <button name="clearResult" class="button orange-button">Очистить результат</button>
                </div>
                <div class="result"></div>
            </div>
            <div class="section" id="files">
                <div class="description">
                    <h2>Задание №2</h2>
                </div>
                <div class="controls">
                    <button name="getAll" class="button green-button">Все файлы</button>
                    <button name="getFiltered" class="button green-button">Отфильтровать файлы</button>
                    <button name="clearResult" class="button orange-button">Очистить результат</button>
                </div>
                <div class="result"></div>
            </div>
        </div>

        <pre>
            <?php print_r(scandir($_SERVER['DOCUMENT_ROOT'].'/files'))?>
        </pre>

    </body>
</html>