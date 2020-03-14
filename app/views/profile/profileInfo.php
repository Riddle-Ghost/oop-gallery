<?php $this->layout('layout', ['title' => 'Profile Info', 'status' => $status, 'categories' => $categories]) ?>


<div class="container main-content">

  <div class="columns">
      <div class="column">
        <div class="tabs is-centered pt-100">
          <ul>
            <li>
              <a href="/profile">
                <span class="icon is-small"><i class="fas fa-camera"></i></span>
                <span>Мои картинки</span>
              </a>
            </li>
            <li class="is-active">
              <a href="/profile-info">
                <span class="icon is-small"><i class="fas fa-user"></i></span>
                <span>Основная информация</span>
              </a>
            </li>
            <li>
              <a href="/profile-security">
                <span class="icon is-small"><i class="fas fa-lock"></i></span>
                <span>Безопасность</span>
              </a>
            </li>
          </ul>
        </div>
        <div class="is-clearfix"></div>
          <div class="columns is-centered">
            <div class="column is-half">
              
              <form method="POST" action="/profile-info">
                <div class="field">
                  <?= flash()->display(); ?>
                  <label class="label">Ваше имя</label>
                  <div class="control has-icons-left has-icons-right">
                    <input class="input" type="text" name="username" value="<?=$status['username'];?>">
                    <span class="icon is-small is-left">
                      <i class="fas fa-user"></i>
                    </span>
                  </div>
                </div>

                <div class="field">
                  <label class="label">Email</label>
                  <div class="control has-icons-left has-icons-right">
                    <input class="input" type="text" name="email" value="<?=$status['email'];?>">
                    <span class="icon is-small is-left">
                      <i class="fas fa-user"></i>
                    </span>
                  </div>
                </div>

                <div class="field">
                  <label class="label">Чтобы сменить Email, необходимо ввести пароль</label>
                  <div class="control has-icons-left has-icons-right">
                    <input class="input" type="password" name="password">
                    <span class="icon is-small is-left">
                      <i class="fas fa-user"></i>
                    </span>
                  </div>
                </div>

                <div class="control">
                  <button class="button is-link" type="submit">Обновить</button>
                </div>
              </form>
            </div>
          </div>
      </div>
  </div>
</div>