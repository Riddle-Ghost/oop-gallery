<?php $this->layout('layout', ['title' => 'Category', 'status' => $status, 'categories' => $categories]) ?>

<section class="hero is-primary is-primary_profile">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
        Мои картинки
      </h1>
      <h2 class="subtitle">
        Загруженное мной
      </h2>
    </div>
  </div>
</section>
<section class="section main-content">
  <div class="container">
  <?= flash()->display(); ?>
  <div class="tabs is-centered">
    <ul>
      <li class="is-active">
        <a href="/profile">
          <span class="icon is-small"><i class="fas fa-camera"></i></span>
          <span>Мои картинки</span>
        </a>
      </li>
      <li>
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
  
    <div class="columns  is-multiline">
      
      <? if( empty( $photos ) ) : ?>
        <p class="title is-5">У вас пока нет фото. <a href="/upload">Загрузить</a></p>

      <? else :
        $method = 'edit';
        include '../app/views/parts/photos.php';
        
      endif; ?>

    </div>
    <? if( $paginator ) include '../app/views/parts/paginator.php'; ?>
  </div>    
</section>