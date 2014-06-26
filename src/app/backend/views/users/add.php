<h1>Добавить пользователя</h1>
<form id = "send-form" data-url="/check_user" action="add_user" method="post">
    <div class="input-group">
        <span class="input-group-addon title-block-sizing">Имя пользователя</span>
        <input type="text" data-reg="name" data-оbligatory="true" class="form-control input-sizing validate-input" placeholder="Имя пользователя" name="name">
    </div>
    <div class="input-group">
        <span class="input-group-addon title-block-sizing">@</span>
        <input type="email" data-reg="email" data-оbligatory="true" data-ajaxceck="true" class="form-control input-sizing validate-input" placeholder="E-mail" name="email">
    </div>
    <div class="input-group">
        <span class="input-group-addon title-block-sizing">Пароль</span>
        <input type="password" data-оbligatory="true" data-reg="password" class="form-control input-sizing validate-input" placeholder="Пароль" id="password" name="password">
    </div>
    <div class="input-group">
        <span class="input-group-addon title-block-sizing">Повторите пароль</span>
        <input type="password" data-оbligatory="true"  data-reg="password" data-confirm="password" class="form-control input-sizing validate-input" placeholder="Подтверждение" name="confirm_password">
    </div>
    <p>
        <label for="status">Статус</label>
        <select id="status" name="status">
            <?php foreach($status as $item):?>
                <?php if($item->name == "User"): ?>
                    <option value="<?= $item->name?>" selected><?= $item->ru?></option>
                <?php else :?>
                    <option value="<?= $item->name?>"><?= $item->ru?></option>
                <?php endif ?>
            <?php endforeach?>
        </select>
    </p>
    <h1>Доступы к "BO"</h1>
    <div id="roleList">
        <?php
        function showRole($array,$key){
        $num=count($array);
        for($i=0; $i<$num; $i++){
                if($array[$i]->parent_id==$key){
                    if($key == 0){?>
                        <div class="back-office-block"><ul><li><label><input type="checkbox" class="main-role" name="role[]" value="<?=$array[$i]->id?>"><?=$array[$i]->ru?></label>
                        <?php
                        $key=$array[$i]->id;
                        showRole($array,$key);
                        $key = $array[$i]->parent_id;
                        ?>
                                </li>
                            </ul>
                        </div>
                <?php } else { ?>
                        <ul>
                        <li><label><input type="checkbox" name="role[]" value="<?=$array[$i]->id?>"><?=$array[$i]->ru?></label>
                        <?php
                        $key=$array[$i]->id;
                        showRole($array,$key);
                        $key = $array[$i]->parent_id;
                        echo "</li>";
                        echo "</ul>";
                    }
                }
            }
        }
        $key=0;
        showRole($role,$key);?>
    </div>
    <h1>Доступы к Проектам</h1>
        <table class="table table-hover">
            <thead>
            <tr>
                <th id="id">#</th>
                <th id="name" >Название</th>
                <th id="url" >url</th>
            </tr>
            </thead>
            <tbody id="result">
            <?php foreach ($projects as $item):?>
                <tr>
                    <td><input type="checkbox" name="projects[]" value="<?=$item->id?>"></td>
                    <td><?= $item->name; ?></td>
                    <td><?= $item->url; ?></td>
                    <td><?= $item->status; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <p>
        <input type="submit" id="send-button" class="btn btn-lg btn-success" value="Добавить">
    </p>
</form>