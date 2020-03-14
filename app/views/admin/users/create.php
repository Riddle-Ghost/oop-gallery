<?php $this->layout('admin/layout', ['title' => 'Users Create']) ?>

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
              <h2 class="box-title">Добавить пользователя</h2>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-6">
                    <form action="/admin/users/create" method="post">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Имя</label>
                        <input type="text" class="form-control" name="username" id="exampleInputEmail1" >
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" >
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Пароль</label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" >
                      </div>

                      <div class="form-group">
                        <label>Роль</label>
                        <select class="form-control select2" style="width: 100%;" name="role">
                          <option selected="selected" value="0">Обычный пользователь</option>
                          <option value="1">Администратор</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Аватар</label>
                        <input type="file" name="picture" id="exampleInputEmail1" >
                      </div>

                      <div class="form-group">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name='status' value="1">
                            Бан
                          </label>
                        </div>
                      </div>

                      <div class="form-group">
                        <button class="btn btn-success" type="submit">Добавить</button>
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