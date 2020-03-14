<?php $this->layout('layout', ['title' => 'Set New Password', 'status' => $status, 'categories' => $categories]) ?>


<section class="hero is-dark">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
        Восстановление пароля.
      </h1>
      <h2 class="subtitle">
        Введите новый пароль.
      </h2>
    </div>
  </div>
</section>
<div class="container main-content">
  <div class="columns">
    <div class="column"></div>
    <form class="column is-quarter auth-form" method="POST" action="/password-reset/<?=$selector?>/<?=$token?>">

      <div class="field">
        <?= flash()->display(); ?>
        <label class="label">Новый пароль</label>
        <div class="control has-icons-left has-icons-right">
          <input class="input" type="password" name="password">  <!-- is-danger -->
          <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
          </span>
          <!-- <span class="icon is-small is-right">
            <i class="fas fa-exclamation-triangle"></i>
          </span> -->
        </div>
        <!-- <p class="help is-danger">This email is invalid</p> -->
      </div>

      <div class="field is-grouped">
        <div class="control">
          <button class="button is-link" type="submit">Отправить</button>
        </div>
      </div>
    </form>
    <div class="column"></div>
  </form>
</div>