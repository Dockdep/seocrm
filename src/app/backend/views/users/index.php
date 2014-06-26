<h1>Пользователи</h1>
<a class="btn btn-primary" href="/add_user">Добавить</a>
<table class="table table-hover" data-url="/sort_user">
    <thead>
    <tr>
        <th id="id">#</th>
        <th id="name" class="sortable"><p>Имя</p></th>
        <th id="email" class="sortable"><p>e-mail</p></th>
        <th id="status" class="sortable"><p>Статус</p></th>
        <th id="projects"><p>Проекты</p></th>
        <th id="last_online" class="sortable"><p>Последний онлайн</p></th>
        <th class="table-buttons"></th>
    </tr>
    </thead>
    <tbody id="result">
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
    </tbody>
</table>
<a class="btn btn-primary" href="/add_user">Добавить</a>