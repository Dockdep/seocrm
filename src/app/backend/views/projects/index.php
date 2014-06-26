<h1>Проекты</h1>
<a class="btn btn-primary" href="/add_project">Добавить</a>
<table class="table table-hover" data-url="/sort_project">
    <thead>
    <tr>
        <th id="id">#</th>
        <th id="name" class="sortable"><p>Название</p></th>
        <th id="url" class="sortable"><p>url</p></th>
        <th id="status" class="sortable"><p>Статус</p></th>
        <th class="table-buttons"></th>
    </tr>
    </thead>
    <tbody id="result">

    <?php foreach ($data as $item):?>
        <tr>
            <td><?=$item->id; ?></td>
            <td><?= $item->name; ?></td>
            <td><?= $item->url; ?></td>
            <td><?= $item->status; ?></td>
            <td>
                <a href="/delete_project?id=<?=$item->id ?>" class="action-img"><img src="/images/del.png" title="удалить"></a>
                <a href="/edit_project?id=<?=$item->id ?>" class="action-img"><img src="/images/change.png" title="редактировать"></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a class="btn btn-primary" href="/add_project">Добавить</a>