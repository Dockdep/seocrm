<h1>Изменить проект</h1>
<form id = "send-form" data-url="/check_project" action="add_project" method="post">
    <div class="input-group">
        <span class="input-group-addon title-block-sizing">Название проекта</span>
        <input type="text"  data-reg="login" data-оbligatory="true" class="form-control input-sizing" placeholder="Название проекта" name="name" value="<?=$data->name ?>">
    </div>
    <div class="input-group">
        <span class="input-group-addon title-block-sizing">URL</span>
        <input type="text" data-reg="url" data-оbligatory="true" class="form-control input-sizing" placeholder="URL" name="url" value="<?=$data->url ?>">
    </div>
    <div class="input-group">
        <span class="input-group-addon title-block-sizing textarea-title-block-sizing">Контакты</span>
        <textarea name="contacts" class="textarea-sizing" ><?=$data->contacts ?></textarea>
    </div>
    <div class="input-group">
        <span >Статус</span>
        <select  id="status" name="status">
            <?php foreach($status as $item):?>
                <?php if($item->name == $data->status): ?>
                    <option value="<?= $item->name?>" selected><?= $item->ru?></option>
                <?php else :?>
                    <option value="<?= $item->name?>"><?= $item->ru?></option>
                <?php endif ?>
            <?php endforeach?>
        </select>
    </div>
    <p>
        <input type="hidden" name="id" value="<?=$data->id?>">
        <input type="submit" class="btn btn-lg btn-success" value="Изменить">
    </p>
</form>