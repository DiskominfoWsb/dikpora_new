<div class="container">

    <h3>Komentar</h3>
    <?php if(session()->alert): ?>
        <div class="alert alert-<?php echo session()->alert['type']; ?>">
            <?php echo session()->alert['message']; ?>
        </div>
    <?php endif; ?>
    <article class="">
        <h5 class="text-center d-none">Download</h5>
        <form method="get">
            <div class="row mb-2 gx-1">
                <div class="col-lg-12">
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
                        <td>Nama</td>
                        <td>Email</td>
                        <td class="text-center">Telepon / HP</td>
                        <td>Komentars</td>
                        <td class="text-center"><i class="bi bi-chat-dots"></i></td>
                        <td class="text-center"><i class="bi bi-tools"></i></td>
                        <td class="text-center">Tanggal</td>
                    </tr>
                </thead>
                <tbody>
                <?php if(!$comments): ?>
                    <tr>
                        <td colspan="8" class="p-2 text-center text-danger fw-bold fst-italic">
                            ... komentar tidak ditemukan!
                        </td>
                    </tr>
                <?php endif; ?>
                <?php $i = $pagerStart+1; ?>
                <?php foreach($comments as $c): ?>
                    <?php
                        $bgColor = ($i%2) ? '' : '#fff';
                        if($c->status == '0') $bgColor = '#fdffe0';
                        $bgColor = ' style="background-color: '.$bgColor.';"';
                    ?>
                    <tr id="msg-<?php echo $c->ID; ?>" <?php echo $bgColor; ?>>
                        <td rowspan="2" class="text-center"><?php echo $i; ?>.</td>
                        <td id="comment-name-<?php echo $c->ID; ?>" class="fw-bold" style="white-space: nowrap; border-bottom: none;">
                            <?php echo $c->name; ?>
                        </td>
                        <td style="border-bottom: none;"><?php echo $c->email; ?></td>
                        <td style="border-bottom: none;" class="text-center"><?php echo $c->phone; ?></td>
                        <td rowspan="2" id="comment-message-<?php echo $c->ID; ?>"><?php echo $c->message; ?></td>
                        <td rowspan="2" class="text-center">
                            <a title="Reply" href="#comment-<?php echo $c->type.'-'.$c->ID.'-'.$c->ID_post_page; ?>" class="comment-reply" data-bs-toggle="modal" data-bs-target="#modalComment">
                                <i class="bi bi-chat-dots text-success"></i>
                            </a>
                        </td>
                        <td rowspan="2" class="text-center">
                            <?php if($c->status == '1'): ?>
                            <a href="<?php echo base_url('comment/unapprove?id='.$c->ID); ?>" title="Unapprove">
                                <i class="bi bi-x-circle text-danger"></i>
                            </a>
                            <?php else: ?>
                            <a href="<?php echo base_url('comment/approve?id='.$c->ID); ?>" title="Approve">
                                <i class="bi bi-check2-square text-primary"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                        <td rowspan="2" class="text-center" style="white-space: nowrap;">
                            <small><?php echo str_replace(' ', '<br>', date('j/m/y H:i:s', strtotime($c->date_submit))); ?></small>
                        </td>
                    </tr>
                    <tr<?php echo $bgColor; ?>>
                        <td colspan="3" style="padding-top: 0; padding-bottom: 0; border-top: none;">
                            <small>
                                <?php $slug = ($c->type == 'post') ? 'artikel/' : 'halaman/'; ?>
                                <a href="<?php echo base_url($slug.$postpage[$c->type][$c->ID_post_page]->slug); ?>" class="a-normal fst-italic">
                                    <?php echo $postpage[$c->type][$c->ID_post_page]->title; ?>
                                </a>
                            </small>
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
                <h5><i class="bi bi-chat-dots"></i> &nbsp;Balas Komentar</h5>
                <form method="post" action="<?php echo base_url(); ?>/comment/reply">
                    <div class="form-group mb-3">
                        <p class="mt-3 mb-0 fw-bold">Pengirim</p>
                        <p class="my-2">Pesan</p>
                        <input type="hidden" name="type" id="type" value="0">
                        <input type="hidden" name="id" id="id" value="0">
                        <input type="hidden" name="id_p" id="id_p" value="0">
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