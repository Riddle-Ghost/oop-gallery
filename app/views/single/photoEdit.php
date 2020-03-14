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
<section class="hero is-info">
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
      <?= flash()->display(); ?>
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
            <time datetime="2016-1-1" class="is-size-6 is-pulled-left">Добавлено: <?=$photo['date']?></time>
          </div>

          <div class="content">
          <form method="POST" action="/edit-photo/<?=$photo['id']?>">
                <div class="field">
                  <label class="label">Название</label>
                  <div class="control has-icons-left has-icons-right">
                    <input class="input" type="text" name="name" value='<?=$photo['name']?>'>
                    <span class="icon is-small is-left">
                      <i class="fas fa-camera"></i>
                    </span>
                  </div>
                </div>

                <div class="field">
                  <label class="label">Описание</label>
                  <div class="control has-icons-left has-icons-right">
                    <textarea class="textarea" name="description" rows="3"><?=$photo['description']?></textarea>
                  </div>
                </div>

                <div class="field">
                  <label class="label">Категория</label>
                  <div class="control has-icons-left has-icons-right">
                    <select class="input" name="category_id">
                      <? foreach ($categories as $category) : ?>

                        <? if( $category['id'] == $photo['category_id'] ) : ?>
                          <option selected value="<?=$category['id'];?>"><?=$category['title'];?></option>
                        <? else : ?>
                          <option value="<?=$category['id'];?>"><?=$category['title'];?></option>
                        <? endif; ?>

                      <? endforeach; ?>
                    </select>
                    <span class="icon is-small is-left">
                      <i class="fas fa-camera"></i>
                    </span>
                  </div>
                </div>

                <div class="control">
                  <button class="button is-info is-pulled-right" type="submit">Обновить</button>
                </div>
            </form>
            <div class="is-clearfix"></div>
          </div>
        </div>
      </div>
      
    </div>
    <div class="column"></div>
  </div>
  
  <hr>
  </div>
</div>