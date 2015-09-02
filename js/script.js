$(document).ready(function(){

    //кешируем элементы
    var cachedElements = {
        dataBaseGroup: $('#database'),
        filesGroup:$('#files')
    };

    //Кешируем кнопки
    cachedElements.dataBaseButtons = cachedElements.dataBaseGroup.find('button');
    cachedElements.filesButtons = cachedElements.filesGroup.find('button');

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

});
