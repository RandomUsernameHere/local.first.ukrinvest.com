<?php /**@var $Result*/ ?>
<?php if(is_array($Result)&&!empty($Result)):?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Script_name</th>
                <th>Start time</th>
                <th>End time</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($Result as $key=>$value):?>
                <tr>
                    <td><?=$value['id']?></td>
                    <td><?=$value['script_name']?></td>
                    <td><?=$value['start_time']?></td>
                    <td><?=$value['end_time']?></td>
                    <td><?=$value['Result']?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
<?php elseif(!empty($Result)):?>
    <div><?=$Result?></div>
<?php else:?>
    <div>Нет записей</div>
<?php endif; ?>
