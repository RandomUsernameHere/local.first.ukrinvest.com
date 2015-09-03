$(document).ready(function(){

    //кешируем элементы
    var cachedElements = {
        dataBaseGroup: $('#database'),
        filesGroup:$('#files')
    };

    //Кешируем кнопки
    cachedElements.dataBaseButtons = cachedElements.dataBaseGroup.find('button');
    cachedElements.filesButtons = cachedElements.filesGroup.find('button.need_result');
    cachedElements.filesClearButton = cachedElements.filesGroup.find('button.clearing');

    //Элементы для записи результата
    cachedElements.dataBaseResult = cachedElements.dataBaseGroup.find('.result');
    cachedElements.filesResult = cachedElements.filesGroup.find('.result');

    //Клик по кнопкам группы database
    cachedElements.dataBaseButtons.click(function(e){
        if($(this).hasClass('active')){
            var $button = $(this);
            $.ajax({
                url:'/controller/init.php',
                type: 'post',
                data:{
                    name: $button.attr('name')
                },
                success:function(data){
                    cachedElements.dataBaseResult.html(data);
                    $button.removeClass('active');
                    $button.siblings().addClass('active');
                },
                error:function(){
                    cachedElements.dataBaseResult.html('Ошибка связи с сервером');
                }
            });
        }
        else{
            e.preventDefault();
        }
    });

    //Клик по кнопкам группы files
    cachedElements.filesButtons.click(function(){
        var Marker = $(this).attr('name');

        $.ajax({
            url: '/controller/files.php',
            type: 'post',
            data:{
                'FILE_PARAM':Marker
            },
            success: function(data){
                cachedElements.filesGroup.find('.result').find('.half[data-result="'+Marker+'"]').html(data);
            },
            error: function(){
                cachedElements.filesGroup.find('.result').find('.half[data-result="'+Marker+'"]').html('Ошибка связи с сервером');
            }
        });
    });

    //Очищаем результат выборки файлов
    cachedElements.filesClearButton.click(function(){
        cachedElements.filesGroup.find('.half').empty();
    });

});
