<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <title></title>
</head>
<body>
<div class="modal fade" id="registrationFormModal" tabindex="-1" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Регистрация</h4>
            </div>
            <div class="form">
                <form class="cmxform" id="registrationForm" data-url="/check_user" method="post" action="/user_registration">
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
                    <div class="input-group">
                        <button class="btn btn-lg btn-primary" type="submit">Зарегистрироваться</button>
                    </div>
                </form>
            </div><!-- form -->
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="enterForm" tabindex="-1" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Регистрация</h4>
            </div>
            <form class="form-signin" role="form" method="post" action="/user_login" id="admin_login">
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    <input type="email" class="form-control" placeholder="Email" autofocus="" name="email">
                </div>

                <div class="input-group">
                    <input type="password" class="form-control" placeholder="Пароль" name="password" id="passwd">
                    <span class="input-group-addon">Пароль</span>
                </div>
                <div class="input-group">
                    <button class="btn btn-lg btn-primary" type="submit">Войти</button>
                </div>
            </form>
            </div><!-- form -->
        </div>
    </div>
</div>
    <header>
        <nav class="navbar navbar-default navbar-static-top" role="navigation">
                <ul class="nav navbar-nav">
                    <li><a href="#">Soft</a></li>
                    <li><a href="#">Analytics</a></li>
                    <li><a href="#">CRM</a></li>
                    <li><a href="http://backend.seo.dev.artwebua.com.ua/">Настройка</a></li>
                    <?php if($this->session->get("user-name")):?>
                        <li><a href="/user_logout">Выход</a></li>
                    <?php else :?>
                        <li><a href="#enterForm" data-toggle = 'modal'>Вход</a></li>
                        <li><a href="#registrationFormModal" data-toggle = 'modal'>Регистрация</a></li>
                    <?php endif?>
                </ul>
        </nav>
    </header>
    <div class="container-fluid">
        <?php

        echo $this->getContent();

        ?>
    </div>
    <footer>
    </footer>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/validate.js"></script>
</body>
</html>