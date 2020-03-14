<?php $this->layout('layout', ['title' => 'Category', 'status' => $status, 'categories' => $categories]) ?>

<section class="hero is-primary">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
        <?=$photos['0']['title']?>
      </h1>
      <h2 class="subtitle">
        Картинки по категориям
      </h2>
    </div>
  </div>
</section>
<section class="section main-content">
  <div class="container">
    <div class="columns  is-multiline">

    <? if( empty( $photos ) ) : ?>
      <p class="title is-5">В данной категории пока нет фото. <a href="/category">Посмотреть другие</a></p>

    <? else :
      $method = 'category';
      include '../app/views/parts/photos.php';
      
    endif; ?>

    </div>
    <? if( $paginator ) include '../app/views/parts/paginator.php'; ?>
  </div>    
</section>