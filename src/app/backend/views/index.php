<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <title></title>
</head>
<body>
    <header>
            <nav class="navbar navbar-default navbar-static-top" role="navigation">
                    <ul class="nav navbar-nav">
                        <li><a href="/user_index">Пользователи</a></li>
                        <li><a href="/project_index">Проекты</a></li>
                        <li><a href="/index_parser">Парсер</a></li>
                        <li><a href="http://seo.dev.artwebua.com.ua/">На сайт</a></li>
                        <?php if($this->session->get("user-name")):?>
                            <li><a href="/logout_page">Выход</a></li>
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
    <script type="text/javascript" src="/js/main.js"></script>
    <script type="text/javascript" src="/js/validate.js"></script>
    <script type="text/javascript" src="/js/parser.js"></script>
</body>
</html>