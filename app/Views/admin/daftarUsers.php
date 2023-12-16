<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
                <div class="col-sm-12">
                    <?php

                    use NumberToWords\Legacy\Numbers\Words\Locale\Id;

                    if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-sm-12">
                    <?php if (session()->getFlashdata('empty')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashdata('empty') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="" method="post">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg" placeholder="Keyword pencarian.." name="keyword">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-lg btn-default" name="">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <a href="/admin/tambahUsers" class="btn btn-outline-primary mb-3" style="color: deepskyblue;"><i class="fas fa-plus"></i> Tambah User</a>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No.</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Fullname</th>
                                        <th>Status</th>
                                        <th>Role</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1 + (10 * ($currentPage - 1));
                                    $roleColors = [
                                        'admin' => 'bg-primary',
                                        'guru' => 'bg-warning',
                                        'santri' => 'bg-success',
                                        'ortu' => 'bg-info',
                                    ];
                                    ?>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td style="text-align: center;"><?= $i++; ?></td>
                                            <td><?= $user->username; ?></td>
                                            <td><?= $user->email; ?></td>
                                            <td><?= $user->fullname; ?></td>
                                            <td style="text-align: center;">
                                                <form id="form<?= $user->userid; ?>" action="<?= base_url('admin/updateStatus/' . $user->userid); ?>" method="post">
                                                    <?= csrf_field(); ?>
                                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                        <input type="checkbox" name="active" class="custom-control-input user-switch" id="userSwitch<?= $user->userid; ?>" data-userid="<?= $user->userid; ?>" <?= ($user->active == '1') ? 'checked' : ''; ?>>
                                                        <label class="custom-control-label" for="userSwitch<?= $user->userid; ?>"></label>
                                                    </div>
                                                </form>

                                                <script>
                                                    document.querySelectorAll('.user-switch').forEach(userSwitch => {
                                                        userSwitch.addEventListener('change', function() {
                                                            const formId = `form${this.getAttribute('data-userid')}`;
                                                            const form = document.getElementById(formId);

                                                            if (form) {
                                                                form.submit();
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </td>
                                            <td><span class="badge <?= $roleColors[$user->role]; ?>"><?= $user->role; ?></span></td>
                                            <td style="text-align: center;">
                                                <a href="<?= base_url('admin/edit/' . $user->userid); ?>"><button class="badge bg-warning"><span><i class="fas fa-edit"></i>Edit</span></button></a>
                                                <?php if ($user->role != 'admin') : ?>
                                                    <form action="/admin/hapusUsers/<?= $user->userid; ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="badge bg-danger" onclick="return confirm('apakah anda yakin')"><span><i class="fas fa-trash-alt"></i>Hapus</span></button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <br>
                        </div>
                        <div class="card-footer clearfix">
                            <?= $pager->links('users', 'paginations') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?= $this->endSection(); ?>