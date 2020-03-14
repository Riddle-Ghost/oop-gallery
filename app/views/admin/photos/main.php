<?php $this->layout('admin/layout', ['title' => 'Photos Main']) ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content container-fluid">

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Админ-панель</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="">
            <div class="box-header">
              <h2 class="box-title">Все изображения</h2>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <a href="/admin/photos/create" class="btn btn-success btn-lg">Добавить</a> <br> <br>

              <? if( !$photos ) : ?>
                <p>Изображений пока нет</p>
              <? else : ?>

              <table id="example1" class="table table-bordered table-striped" data-order='[[ 0, "desc" ]]'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Автор</th>
                    <th>Изображение</th>
                    <th>Действия</th>
                  </tr>
                </thead>
                <tbody>

                <? foreach ($photos as $photo) : ?>
                  <?=$photo['']?>
                  <tr>
                    <td><?=$photo['id']?></td>
                    <td><?=$photo['name']?></td>
                    <td><?=$photo['title']?></td>
                    <td><?=$photo['username']?></td>
                    <td>
                      <img src="/uploads/<?=$photo['image']?>" width="200">
                    </td>
                    <td>
                      <a href="/photo/<?=$photo['id']?>" class="btn btn-info">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="/admin/photos/edit/<?=$photo['id']?>" class="btn btn-warning">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="/admin/photos/delete/<?=$photo['id']?>" class="btn btn-danger" onclick="return confirm('Вы уверены?');">
                        <i class="fa fa-remove"></i>
                      </a>
                    </td>
                  </tr>

                <?endforeach;?>

                </tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Автор</th>
                    <th>Изображение</th>
                    <th>Действия</th>
                  </tr>
                </tfoot>
              </table>

              <? endif; ?>

            </div>
            <!-- /.box-body -->
          </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            По вопросам к главному администратору.
          </div>
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->