<? foreach ( $photos as $photo) : ?>

<div class="column is-one-quarter">
  <div class="card card_hover <?if ($method == 'edit') echo 'card_relative';?>">
    <div class="card-image">
      <figure class="image is-4by3">
        <? if ($method !== 'edit') : ?>
          <a href="/photo/<?=$photo['id']?>">
            <img src="/uploads/<?=$photo['image']?>" alt="Placeholder image">
          </a>
        <? else: ?>
          <img src="/uploads/<?=$photo['image']?>" alt="Placeholder image">
        <?endif;?>
      </figure>
    </div>
    <div class="card-content">
      <div class="media">
        <div class="media-left">
          <? if ($method !== 'category') : ?>
          <p class="title is-5"><a href="/category/<?=$photo['category_id'];?>"><?=$photo['title'];?></a></p>
          <? endif; ?>
          <p class="title is-5"><a href="/photo/<?=$photo['id']?>"><?=$photo['name']?></a></p>
          <p class="title is-5"><a href="/photo/<?=$photo['id']?>"><?=$photo['description']?></a></p>
        </div>
        <div class="media-right">
          <p  class="is-size-7">Размер: <?=$photo['dimensions']?></p>
          <time datetime="2016-1-1" class="is-size-7">Добавлено: <?=$photo['date']?></time>
          <? if ($method !== 'user') : ?>
          <p class="title is-5">
            Загрузил:<br>
            <a href="/user/<?=$photo['user_id'];?>"><?=$photo['username'];?></a>
          </p>
          <?endif;?>
        </div>
      </div>
    </div>
    <? if ($method == 'edit') : ?>
      <a class="urldelete" href="/delete-photo/<?=$photo['id']?>">
        <img src="/img/delete.png" alt="delete">
      </a>
      <a class="urledit" href="/edit-photo/<?=$photo['id']?>">
        <img src="/img/edit.png" alt="edit">
      </a>
    <?endif;?>
  </div>
</div>

<? endforeach; ?>