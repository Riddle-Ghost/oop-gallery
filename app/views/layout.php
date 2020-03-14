<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->e($title)?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.0/js/all.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <div class="container">
        <nav class="navbar is-transparent">
          <div class="navbar-brand">
            <a class="navbar-item" href="/">
              <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
            </a>
            <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>

          <div id="navbarExampleTransparentExample" class="navbar-menu">
            <div class="navbar-start">
              <a class="navbar-item" href="/">
                Главная
              </a>
              <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="/category">
                  Категории
                </a>
                <div class="navbar-dropdown is-boxed">
                  <? foreach ($categories as $category) : ?>
                  <a class="navbar-item" href="/category/<?=$category['id']?>">
                    <?=$category['title']?>
                  </a>
                  <? endforeach; ?>

                </div>
              </div>
            </div>

            <div class="navbar-end">
              <div class="navbar-item">
                <div class="field is-grouped">
                  
                  <? if (!$status['isLogged'] ) : ?>

                  <p class="control">
                    <a class="button is-link" href="/login">
                      <span class="icon">
                        <i class="fas fa-user"></i>
                      </span>
                      <span>Войти</span>
                    </a>
                  </p>
                  <p class="control">
                    <a class="button is-primary" href="/register">
                      <span class="icon">
                        <i class="fas fa-address-book"></i>
                      </span>
                      <span>Зарегистрироваться</span>
                    </a>
                  </p>

                  <? else : ?>

                  <p class="control">
                    <a class="button is-primary" href="/upload">
                      <span class="icon">
                        <i class="fas fa-upload"></i>
                      </span>
                      <span>Загрузить картинку</span>
                    </a>
                  </p>
                  <div class="account control">
                    <p>
                      Здравствуйте, <b><?=$status['usernameTrim']?></b>
                    </p>
                  </div>
                  <p class="control">
                    <a class="button is-info" href="/profile">
                      <span class="icon">
                        <i class="fas fa-user"></i>
                      </span>
                      <span>Профиль</span>
                    </a>
                  </p>
                  <p class="control">
                    <a class="button is-primary" href="/admin">
                      <span class="icon">
                        <i class="fas fa-user"></i>
                      </span>
                      <span>Админка</span>
                    </a>
                  </p>
                  <p class="control">
                    <a class="button is-dark" href="/logout">
                      <span class="icon">
                        <i class="fas fa-window-close"></i>
                      </span>
                      <span>Выйти</span>
                    </a>
                  </p>

                  <? endif; ?>

                </div>
              </div>
            </div>
          </div>
        </nav>
      </div>


<?=$this->section('content')?>


<footer class="section hero is-light">
    <div class="container">
      <div class="content has-text-centered">
        <div class="tabs">
          <ul>
            <li class="is-active"><a>Главная</a></li>
            <li><a>Природа</a></li>
            <li><a>Дизайн и Интерьер</a></li>
            <li><a>Животные</a></li>
            <li><a>Природа</a></li>
            <li><a>Дизайн и Интерьер</a></li>
            <li><a>Животные</a></li>
            <li><a>Природа</a></li>
            <li><a>Дизайн и Интерьер</a></li>
            <li><a>Животные</a></li>
          </ul>
        </div>
        <p>
          <strong>Marlin</strong> - Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit expedita consequatur, et. Unde, nulla, dicta.
        </p>
        <p class="is-size-7">
          All rights reserved. 2018
        </p>
      </div>
    </div>
</footer>
</div>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src='/js/navbar.js'></script>
</body>
</html>