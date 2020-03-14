<?php $this->layout('admin/layout', ['title' => 'Photos Edit']) ?>

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
              <h2 class="box-title">Изменить изображение</h2>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-6">
                    <form action="/admin/photos/edit/<?=$photo['id']?>" method="post">

                    <div class="form-group">
                        <label>Изображение</label><br>
                        <img src="/uploads/<?=$photo['image']?>" width="200" alt="">
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputEmail1">Название</label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value="<?=$photo['name']?>">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Краткое описание</label>
                        <textarea class="form-control" name="description"><?=$photo['description']?></textarea>
                      </div>

                      <div class="form-group">
                        <label>Категория</label>
                        <select class="form-control select2" name="category_id" style="width: 100%;">
                          <? foreach ($categories as $category) : ?>
                            <? if($photo['category_id'] == $category['id']) : ?>
                              <option selected="selected" value="<?=$category['id']?>"><?=$category['title']?></option>
                            <? else : ?>
                              <option value="<?=$category['id']?>"><?=$category['title']?></option>
                            <? endif; ?>
                          <? endforeach; ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <button class="btn btn-warning" type="submit">Изменить</button>
                      </div>
                    </form>
                </div>
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