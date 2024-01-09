<div class="container">

    <h3>Pelayanan</h3>
    <?php if(session()->alert): ?>
        <div class="alert alert-<?php echo session()->alert['type']; ?>">
            <?php echo session()->alert['message']; ?>
        </div>
    <?php endif; ?>
    <article class="">
        <h5 class="text-center d-none">Download</h5>
        <form method="get">
            <div class="row mb-2 gx-1">
                <div class="col-lg-3">
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <option value="pengaduan"<?php if(@$_GET['category']=='pengaduan') echo ' selected'; ?>>Pengaduan Masyarakat</option>
                        <option value="permohonan"<?php if(@$_GET['category']=='permohonan') echo ' selected'; ?>>Permohonan Informasi</option>
                    </select>
                </div>
                <div class="col-lg-9">
                    <div class="input-group">
                        <input type="text" name="keywords" class="form-control" aria-labelledby="button-search" value="<?php echo trim(@$_GET['keywords']); ?>" placeholder=" Kata kunci ...">
                        <button type="submit" name="filter" value="1" class="btn btn-sm btn-primary rounded-end" id="button-search">
                            <i class="bi bi-search"></i>
                            Cari&nbsp;
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table bg-light">
                <thead>
                    <tr class="bg-primary text-light">
                        <td class="text-center">No</td>
                        <td class="text-center">Kategori</td>
                        <td>Nama</td>
                        <td>Email</td>
                        <td class="text-center">Telepon / HP</td>
                        <td>Alamat</td>
                        <td class="text-center"><i class="bi bi-chat-dots"></i></td>
                        <td class="text-center"><i class="bi bi-tools"></i></td>
                        <td class="text-center">Tanggal</td>
                    </tr>
                </thead>
                <tbody>
                <?php if(!$messages): ?>
                    <tr>
                        <td colspan="9" class="p-2 text-center text-danger fw-bold fst-italic">
                            ... pesan tidak ditemukan!
                        </td>
                    </tr>
                <?php endif; ?>
                <?php $i = $pagerStart+1; ?>
                <?php foreach($messages as $msg): ?>
                    <?php
                        $bgColor = ($i%2) ? '' : '#fff';
                        if($msg->status == '0') $bgColor = '#fdffe0';
                        $bgColor = ' style="background-color: '.$bgColor.';"';
                    ?>
                    <tr id="msg-<?php echo $msg->ID; ?>" <?php echo $bgColor; ?>>
                        <?php $kategori = ($msg->category == 'pengaduan') ? 'Pengaduan Masyarakat' : 'Permohonan Informasi'; ?>
                        <td rowspan="2" class="text-center"><?php echo $i; ?>.</td>
                        <td rowspan="2" class="text-center"><?php echo $kategori; ?></td>
                        <td id="msg-name-<?php echo $msg->ID; ?>" class="fw-bold"><?php echo $msg->name; ?></td>
                        <td><?php echo $msg->email; ?></td>
                        <td class="text-center"><?php echo $msg->phone; ?></td>
                        <td><?php echo $msg->address; ?></td>
                        <td class="text-center">
                            <a title="Reply" href="#msg-<?php echo $msg->ID; ?>" class="msg-reply" data-bs-toggle="modal" data-bs-target="#modalComment">
                                <i class="bi bi-chat-dots text-success"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <?php if($msg->status == '1'): ?>
                            <a href="<?php echo base_url('service/unapprove?id='.$msg->ID); ?>" title="Unapprove">
                                <i class="bi bi-x-circle text-danger"></i>
                            </a>
                            <?php else: ?>
                            <a href="<?php echo base_url('service/approve?id='.$msg->ID); ?>" title="Approve">
                                <i class="bi bi-check2-square text-primary"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                        <td rowspan="2" class="text-center" style="white-space: nowrap;">
                            <small><?php echo str_replace(' ', '<br>', date('j/m/y H:i:s', strtotime($msg->date_submit))); ?></small>
                        </td>
                    </tr>
                    <tr<?php echo $bgColor; ?>>
                        <td colspan="4" class="fst-italic">
                            <p id="msg-message-<?php echo $msg->ID; ?>" class="my-0"><?php echo $msg->message; ?></p>
                            <?php if($msg->comment): ?>
                            <p id="msg-comment-<?php echo $msg->ID; ?>" class="mt-1 mb-0 ps-5 text-success"><?php echo $msg->comment; ?></p>
                            <?php endif; ?>
                        </td>
                        <td colspan="2" class="text-center">
                            <?php if($msg->attachment):
                                $filePart = explode('.',$msg->attachment);
                                $fileExts = $filePart[count($filePart)-1];
                                $arrayImg = ['jpg','jpeg','png','gif','webp'];
                                if(in_array($fileExts,$arrayImg)):
                            ?>
                                <a href="<?php echo $msg->attachment; ?>" data-magnify="gallery" class="text-decoration-none">
                                    <i class="bi bi-image"></i> img
                                </a>
                                <?php else: ?>
                                <a href="<?php echo $msg->attachment; ?>" class="text-decoration-none">
                                    <i class="bi bi-paperclip"></i>doc
                                </a>
                                <?php endif; ?>
                            <?php else: ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="">
            <?php echo $pager = str_replace(['<ul class="pagination"','<li>','<a'],['<ul class="pagination pagination-sm"','<li class="page-item">','<a class="page-link"'],$pager); ?>
        </div>
    </article>

</div>

<div id="modalComment" class="modal fade">
    <div class="modal-dialog modal-dialog-md">
        <div class="modal-content">
            <div class="modal-body">
                <h5><i class="bi bi-chat-dots"></i> &nbsp;Balas Pesan</h5>
                <form method="post" action="<?php echo base_url(); ?>/service/reply">
                    <div class="form-group mb-3">
                        <p class="mt-3 mb-0 fw-bold">Pengirim</p>
                        <p class="my-2">Pesan</p>
                        <input type="hidden" name="id" id="id" value="0">
                        <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Teks komentar ..."></textarea>
                    </div>
                    <div class="form-group float-end">
                        <button type="submit" class="btn btn-primary">Kirim &raquo;</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>