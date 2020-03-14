<?php $this->layout('layout', ['title' => 'OOP-GALLERY', 'status' => $status, 'categories' => $categories]) ?>


<section class="hero is-medium is-primary is-bold">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
        Самые минималистичные и элегантные обои для вашего рабочего стола!
      </h1>
      <h2 class="subtitle">
        Настроение и вдохновение в одном кадре.
      </h2>
    </div>
  </div>
</section>
<section class="section main-content">
  <div class="container">
    <?= flash()->display(); ?>
    <div class="columns  is-multiline">
      <? if ( empty( $photos ) ) : ?>
        <p>Неверная страница. <a href="/">Обратно</a></p>
      <? else : ?>
      <? $method = '';
        include '../app/views/parts/photos.php'; ?>
      <? endif; ?>
    </div>
    <? if( $paginator ) include '../app/views/parts/paginator.php'; ?>

  </div>
</section>