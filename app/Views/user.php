<div class="container">
    <h3>User &nbsp;
        <?php if(session()->level <= 1): ?>
        <a href="#" id="tambahUser" class="a-normal" data-bs-toggle="modal" data-bs-target="#modalTambahUser">+</a>
        <?php endif; ?>
    </h3>
    <?php if(session()->alert): ?>
    <div class="alert alert-<?php echo session()->alert['type']; ?>">
        <?php echo session()->alert['message']; ?>
    </div>
    <?php endif; ?>
    <div class="col-lg-12">
        <form method="get">
            <div class="input-group mb-2">
                <input type="text" name="keywords" class="form-control" aria-labelledby="search-button" value="<?php echo trim(@$_GET['keywords']); ?>" placeholder="Kata kunci . . .">
                <button type="submit" name="search" id="search-button" class="btn btn-primary" value="1">
                    <i class="bi bi-search"></i>&nbsp;
                    Cari
                </button>
            </div>
        </form>
        <div class="table-responsive bg-light p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="bg-primary text-light">
                        <td class="text-center">No</td>
                        <td>Username</td>
                        <td>Nama Lengkap</td>
                        <td>Tempat lahir</td>
                        <td>Tanggal lahir</td>
                        <td>Email</td>
                        <td class="text-center">Level</td>
                        <td class="text-center">
                            <i class="bi bi-pencil-square"></i>
                        </td>
                        <td class="text-center">
                            <i class="bi bi-trash"></i>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!$users): ?>
                        <tr>
                            <td colspan="9" class="p-2 text-center text-danger fw-bold fst-italic">
                                ... user tidak ditemukan!
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $i = 1; ?>
                    <?php foreach($users as $user): ?>
                        <tr id="#user-<?php echo session()->ID.'-'.$user->ID; ?>">
                            <td class="text-center"><?php echo $i; ?>.</td>
                            <td><?php echo $user->username; ?></td>
                            <td><?php echo $user->full_name; ?></td>
                            <td><?php echo $user->birth_place; ?></td>
                            <td style="white-space: nowrap;"><small><?php echo indonesian_date($user->birth_date); ?></small></td>
                            <td><?php echo $user->email; ?></td>
                            <td class="text-center"><?php echo $user->level; ?></td>
                            <td class="text-center">
                                <?php if(session()->level > 2): ?>
                                    <i class="bi bi-pencil-square text-secondary"></i>
                                <?php elseif(session()->level > 1 && $user->level == '1'): ?>
                                    <i class="bi bi-pencil-square text-secondary"></i>
                                <?php else: ?>
                                <a href="#user-<?php echo session()->ID.'-'.$user->ID; ?>" title="Edit user" class="editUser text-primary" data-bs-toggle="modal" data-bs-target="#modalEditUser">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($user->level == '1' OR session()->level > 1): ?>
                                    <i class="bi bi-trash text-secondary"></i>
                                <?php else: ?>
                                <a href="<?php echo base_url('user/hapus?id='.$user->ID); ?>" onclick="return confirm('Apakah Anda yakin?')">
                                    <i class="bi bi-trash text-danger"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal tambah -->
<div id="modalTambahUser" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form method="post" action="<?php echo base_url(); ?>/user/add-new">
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="tambahEmail">Email</label>
                        <input id="tambahEmail" type="email" name="email" class="form-control form-control-sm" maxlength="50" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="tambahUsername">Username</label>
                        <input id="tambahUsername" type="text" name="username" class="form-control form-control-sm" maxlength="15" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="tambahName">Nama Lengkap</label>
                        <input id="tambahName" type="text" name="name" class="form-control form-control-sm" maxlength="75" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="tambahPassword">Password</label>
                        <input id="tambahPassword" type="password" name="password" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="tambahConfirmation">Ulangi Password</label>
                        <input id="tambahConfirmation" type="password" name="confirmation" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="tambahPlace">Tempat lahir</label>
                        <input id="tambahPlace" type="text" name="place" class="form-control form-control-sm" maxlength="50">
                    </div>
                    <div class="form-group mb-2">
                        <label for="tambahDate">Tanggal lahir</label>
                        <input id="tambahDate" type="text" name="date" class="form-control form-control-sm" placeholder="YYYY-MM-DD">
                    </div>
                    <div class="form-group mb-2">
                        <label for="tambahLevel">Level</label>
                        <select id="tambahLevel" name="level" class="form-select form-select-sm">
                            <option value="1">1 (Super Admin)</option>
                            <option value="2">2 (Admin)</option>
                            <option value="3">3 (Content manager)</option>
                            <option value="4">2 (Contributor)</option>
                            <option value="5">2 (Subscriber)</option>
                        </select>
                    </div>
                    <div class="form-group mb-2 float-end">
                        <button type="reset" class="btn btn-info">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal edit -->
<div id="modalEditUser" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form method="post" action="<?php echo base_url(); ?>/user/update">
                <input type="hidden" id="my-base-url" value="<?php echo base_url(); ?>">
                <input type="hidden" id="editID" name="id" value="0">
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="editEmail">Email</label>
                        <input id="editEmail" type="email" name="email" class="form-control form-control-sm" maxlength="50" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="editUsername">Username</label>
                        <input id="editUsername" type="text" name="username" class="form-control form-control-sm" maxlength="15" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="editName">Nama Lengkap</label>
                        <input id="editName" type="text" name="name" class="form-control form-control-sm" maxlength="75" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="editPassword">Password Baru</label>
                        <input id="editPassword" type="password" name="password" class="form-control form-control-sm">
                    </div>
                    <div class="form-group mb-2">
                        <label for="editConfirmation">Ulangi Password Baru</label>
                        <input id="editConfirmation" type="password" name="confirmation" class="form-control form-control-sm">
                    </div>
                    <div class="form-group mb-2">
                        <label for="editPlace">Tempat lahir</label>
                        <input id="editPlace" type="text" name="place" class="form-control form-control-sm" maxlength="50">
                    </div>
                    <div class="form-group mb-2">
                        <label for="editDate">Tanggal lahir</label>
                        <input id="editDate" type="text" name="date" class="form-control form-control-sm" placeholder="YYYY-MM-DD">
                    </div>
                    <div class="form-group mb-2">
                        <label for="editLevel">Level</label>
                        <select id="editLevel" name="level" class="form-select form-select-sm">
                            <option value="1">1 (Super Admin)</option>
                            <option value="2">2 (Admin)</option>
                            <option value="3">3 (Content manager)</option>
                            <option value="4">2 (Contributor)</option>
                            <option value="5">2 (Subscriber)</option>
                        </select>
                    </div>
                    <div class="form-group mb-2 float-end">
                        <button type="reset" class="btn btn-info">Reset</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>