<?php $this->layout('layout', ['title' => 'Category', 'status' => $status, 'categories' => $categories]) ?>

<section class="hero is-primary">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
        <?=$photos['0']['username']?>
      </h1>
      <h2 class="subtitle">
        Картинки пользователя
      </h2>
    </div>
  </div>
</section>
<section class="section main-content">
  <div class="container">
    <div class="columns  is-multiline">

    <? if( empty( $photos ) ) : ?>
      <p class="title is-5">У этого юзера пока нет фото. <a href="/category">Посмотреть другие</a></p>
    <? else :
    $method = 'user';
    include '../app/views/parts/photos.php';
      
    endif; ?>
    
    </div>
  </div>    
</section>