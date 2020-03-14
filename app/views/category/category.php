<?php $this->layout('layout', ['title' => 'Category', 'status' => $status, 'categories' => $categories]) ?>

<section class="hero is-primary">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
        Категории
      </h1>
      <h2 class="subtitle">
        Картинки по категориям
      </h2>
    </div>
  </div>
</section>
<section class="section main-content">

  <? foreach ( $photosCategories as $photos) : ?>

    <div class="container">
      <p class="title is-5">
        <a href="category/<?=$photos['0']['category_id']?>"><?=$photos['0']['title']?></a>
      </p>
      <div class="columns  is-multiline">

        <? $method = 'category';
          include '../app/views/parts/photos.php'; ?>

      </div>
    </div>
  
  <? endforeach; ?>
      
</section>