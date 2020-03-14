<?php $this->layout('layout', ['title' => 'GALLERY Photo', 'status' => $status, 'categories' => $categories]) ?>

<!-- array (size=10)
  'id' => int 6
  'name' => string 'Название' (length=16)
  'description' => string 'Описание' (length=16)
  'image' => string '5dcb05aa8ad8f.jpg' (length=17)
  'dimensions' => string '1280x760' (length=8)
  'date' => string '12-11-2019' (length=10)
  'category_id' => int 3
  'user_id' => int 4
  'username' => string 'tseh@tseh.tseh' (length=14)
  'title' => string 'Дизайн и интерьер' (length=32) -->
<section class="hero is-info is-medium">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
        <?=$photo['name']?>
      </h1>
      <h2 class="subtitle">
        <?=$photo['description']?>
      </h2>
    </div>
  </div>
</section>

<div class="container main-content">
  <div class="columns">
    <div class="column"></div>
    <div class="column is-half auth-form">
      <div class="card">
        <div class="card-image">
          <figure class="image is-4by3">
            <img src="/uploads/<?=$photo['image']?>" alt="Placeholder image">
          </figure>
        </div>
        <div class="card-content">
          <div class="media">
            <div class="media-left">
              <figure class="image is-48x48">
                <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
              </figure>
            </div>
              <p class="title is-4">
                Добавил: <a href="/user/<?=$photo['user_id']?>"><?=$photo['username']?></a>
              </p>
          </div>

          <div class="content">
            <?=$photo['description']?>
            <br>
            <time datetime="2016-1-1" class="is-size-6 is-pulled-left">Добавлено: <?=$photo['date']?></time>
            <a href="/uploads/<?=$photo['image']?>" class="button is-info is-pulled-right" download>Скачать</a>
            <div class="is-clearfix"></div>
          </div>
        </div>
      </div>
      
    </div>
    <div class="column"></div>
  </div>
  
  <hr>

  <div class="columns">
    <div class="column">
      <h1 class="title">Другие фотографии от <a href="/user/<?=$photo['user_id']?>"><?=$photo['username']?></a></h1>
    </div>
  </div>

  <div class="columns section">

    <? if ( empty($photos) ) : ?>
      <h3>К сожалению нет других фотографий от этого пользователя</h3>
    <? else : ?>
    <? foreach ($photos as $one) : ?>

    <div class="column is-one-quarter">
        <div class="card">
          <div class="card-image">
            <figure class="image is-4by3">
              <a href="/photo/<?=$one['id']?>">
                <img src="/uploads/<?=$one['image']?>" alt="Placeholder image">
              </a>
            </figure>
          </div>
          <div class="card-content">
            <div class="media">
              <div class="media-left">
              <p class="title is-5"><a href="/category/<?=$one['category_id']?>"><?=$one['title']?></a></p>
              </div>
              <div class="media-right">
                <p  class="is-size-7">Размер: <?=$one['dimension']?></p>
                <time datetime="2016-1-1" class="is-size-7">Добавлено: <?=$one['date']?></time>
              </div>
            </div>
          </div>
        </div>
    </div>

  <?endforeach;?>
<?endif;?>

  </div>
</div>