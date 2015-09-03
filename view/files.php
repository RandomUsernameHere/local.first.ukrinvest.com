<?php /**@var $Result*/ ?>
<?php if(is_array($Result)&&!empty($Result)):?>
    <h3><?=$Result['HEADING']?></h3>
    <table>
        <thead>
            <tr>
                <th colspan="2">Имя</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($Result['CONTENT'] as $item): ?>
                <tr>
                    <td class="icon">
                        <?php if($item['IS_DIR']):?>
                            <img src="/images/dir.png" alt="Папка">
                        <?php else: ?>
                            <img src="/images/file.png" alt="Файл">
                        <?php endif;?>
                    </td>
                    <td class="filename">
                        <?=$item['NAME']?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif(!empty($Result)): ?>
    <div><?=$Result?></div>
<?php else:?>
    <div>Результатов нет</div>
<?php endif;?>