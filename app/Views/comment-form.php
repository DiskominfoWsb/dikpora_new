<?php if($comments): ?>
    <h5 class="m-0 mb-3"><?php echo count((array)$comments); ?>
        Komentar
        <span class="float-end"><i class="bi bi-chat-dots"></i></span>
    </h5>
    <?php foreach($comments as $c): ?>
        <div class="d-block mb-2 px-4 py-3 bg-light rounded">
            <p class="m-0 mb-1 ps-<?php echo $c->depth*5; ?>">
                <span class="fw-bold"><?php echo $c->name; ?> &nbsp;</span>
                <small>
                    <i class="bi bi-clock"></i>
                    <?php echo indonesian_date($c->date_submit); ?>
                </small>
            </p>
            <p class="m-0 ps-<?php echo $c->depth*5; ?>"><?php echo $c->message; ?></p>
            <!--
            <div class="d-block mt-3 ps-5">
                <p class="m-0 mb-1">
                    <span class="fw-bold text-success">Admin</span> &nbsp;
                    <small>
                        <i class="bi bi-clock"></i>
                        <?php echo indonesian_date($c->date_submit); ?>
                    </small>
                </p>
                <p class="m-0"><?php echo str_replace("\n", '<br>', $c->message); ?></p>
            </div>
            -->
        </div>
    <?php endforeach; ?>
    <!--
    <div class="d-block mt-3">
    <?php //echo $pager = str_replace(['<ul class="pagination"','<li>','<a'],['<ul class="pagination pagination-sm"','<li class="page-item">','<a class="page-link"'], $pager); ?>
    </div>
    -->
    <div class="">&nbsp;</div>
<?php endif; ?>
<h4 id="form-comment">Tinggalkan Komentar</h4>
<?php if(session()->alert): ?>
    <div class="mt-3 alert alert-<?php echo session()->alert['type']; ?>">
        <?php echo session()->alert['message']; ?>
    </div>
<?php endif; ?>
<form method="post" action="<?php echo base_url(); ?>/kirim-komentar" enctype="multipart/form-data">
    <div class="row mb-2 gx-1">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 col-12 form-group mb-2">
            <input type="hidden" name="slug" value="<?php echo $article->slug; ?>">
            <input type="hidden" name="id" value="<?php echo $article->ID; ?>">
            <input type="hidden" name="type" value="<?php echo $controller; ?>">
            <input type="text" name="name" id="name" class="form-control" placeholder="Nama lengkap ..." required>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-6 form-group mb-2">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email ..." required>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6 form-group mb-2">
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Nomor Telepon/HP">
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 form-group mb-2">
            <textarea name="message" id="message" class="form-control" rows="4" placeholder="Teks pesan komentar" required></textarea>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 form-group mb-2">
            <div class="g-recaptcha mb-2" data-sitekey="6LdK2yoiAAAAAHMVPsiUMxuMy89MbSM0Y9zqpb05"></div>
            <button type="reset" class="btn btn-info text-light">Reset Form</button>
            <button type="submit" class="btn btn-primary">Kirim &raquo;</button>
        </div>
    </div>
</form>

<div class="my-2 d-block">&nbsp;</div>