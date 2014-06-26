<?php foreach ($data as $item):?>
    <tr>
        <td><?=$item->id; ?></td>
        <td><?= $item->name; ?></td>
        <td><?= $item->email; ?></td>
        <td><?= $item->status; ?></td>
        <td><?php foreach($item->userToProjects as $project):?>
                <p><?=$project->projects->name?></p>
            <?php endforeach ?>
        </td>
        <td><?= $item->last_online; ?></td>
        <td>
            <a href="/delete_user?id=<?=$item->id ?>" class="action-img"><img src="/images/del.png" title="удалить"></a>
            <a href="/update_user?id=<?=$item->id ?>" class="action-img"><img src="/images/change.png" title="редактировать"></a>
        </td>
    </tr>
<?php endforeach; ?>