<div class="container">
    <div class="row gx-2">
        <div class="col-lg-8">
            <div id="article" class="mt-4 mb-4 rounded-3 bg-light">
                <div id="share-icon" class="d-flex justify-content-end align-items-end px-4 py-3">
                    <div id="fb-root"></div>
                    <script>
                        (function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                    </script>
                    <div class="fb-share-button" data-href="<?php echo current_url(); ?>" data-layout="button"></div>&nbsp;
                    <script>
                        window.twttr = (function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0],
                                t = window.twttr || {};
                            if (d.getElementById(id)) return t;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "https://platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js, fjs);

                            t._e = [];
                            t.ready = function(f) {
                                t._e.push(f);
                            };

                            return t;
                        }(document, "script", "twitter-wjs"));</script>
                    <a class="twitter-share-button" href="https://twitter.com/intent/tweet">Tweet</a>&nbsp;
                    <a href="whatsapp://send?text=<?php echo urlencode(current_url()); ?>" class="d-inline-block a-normal cursor-pointer text-light rounded-pill bg-success" style="height: 20px; font-size: 9pt; padding: 1px 10px 1px 7px; cursor: pointer;">
                        <i class="bi bi-whatsapp"></i> Share
                    </a>
                </div>
                <div id="header-title" class="pt-2 px-4">
                    <h1 class="fw-bolder"><?php echo $article->title; ?></h1>
                </div>
                <?php if(session()->alert): ?>
                    <div class="mt-3 mx-4 alert alert-<?php echo session()->alert['type']; ?>">
                        <?php echo session()->alert['message']; ?>
                    </div>
                <?php else: ?>
                    <div class="pb-2">&nbsp;</div>
                <?php endif; ?>
                <article class="pt-2 pb-4 px-4">
                    <form method="post" action="<?php echo base_url(); ?>/kirim-layanan" enctype="multipart/form-data">
                        <div class="row mb-2 gx-3">
                            <div class="col-6 form-group mb-2">
                                <input type="hidden" name="category" value="permohonan">
                                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-6 form-group mb-2">
                                <label for="address">Alamat <span class="text-danger">*</span></label>
                                <input type="text" name="address" id="address" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-6 form-group mb-2">
                                <label for="profession">Pekerjaan <span class="text-danger">*</span></label>
                                <input type="text" name="profession" id="profession" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-3 form-group mb-2">
                                <label for="_rt">RT</label>
                                <input type="number" name="_rt" id="_rt" class="form-control form-control-sm">
                            </div>
                            <div class="col-3 form-group mb-2">
                                <label for="_rw">RW</label>
                                <input type="number" name="_rw" id="_rw" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 form-group mb-2">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-6 form-group mb-2">
                                <label for="_kelurahan">Kelurahan / Desa <span class="text-danger">*</span></label>
                                <input type="text" name="_kelurahan" id="_kelurahan" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-6 form-group mb-2">
                                <label for="phone">No. Telepon / HP</label>
                                <input type="text" name="phone" id="phone" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 form-group mb-2">
                                <label for="_kecamatan">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" name="_kecamatan" id="_kecamatan" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-12 form-group mb-2">
                                <label for="purpose">Tujuan Penggunaan Informasi</label>
                                <input type="text" name="purpose" id="purpose" class="form-control form-control-sm">
                            </div>
                            <div class="col-12 form-group mb-2">
                                <label for="message">Teks Pesan <span class="text-danger">*</span></label>
                                <textarea name="message" id="message" class="form-control form-control-sm" rows="5" required></textarea>
                            </div>
                            <div class="col-12 form-group mb-2">
                                <label for="file">Lampiran</label>
                                <input type="file" name="file" id="file" placeholder="Lampiran" class="form-control form-control-sm" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.txt">
                            </div>
                            <div class="col-12 form-group mb-2">
                                <div class="g-recaptcha mb-2" data-sitekey="6LdK2yoiAAAAAHMVPsiUMxuMy89MbSM0Y9zqpb05"></div>
                                <button type="reset" class="btn btn-info text-light">Reset Form</button>
                                <button type="submit" class="btn btn-primary">Kirim &raquo;</button>
                            </div>
                        </div>
                    </form>

                    <div class="">
                        <?php //echo $pager = str_replace(['<ul class="pagination"','<li>','<a'],['<ul class="pagination pagination-sm"','<li class="page-item">','<a class="page-link"'],$pager); ?>
                    </div>
                </article>

            </div>

            <div class="d-block mb-5">
                <?php foreach($permohonan as $p): ?>
                <div class="d-block mb-3 px-4 py-3 bg-light rounded">
                    <p class="m-0 mb-1">
                        <span class="fw-bold"><?php echo $p->name; ?> &nbsp;</span>
                        <small>
                            <i class="bi bi-clock"></i>
                            <?php echo indonesian_date($p->date_submit); ?>
                        </small>
                        <?php if($p->attachment): ?>
                        <span class="float-end">
                            <a href="<?php echo $p->attachment; ?>" class="a-normal">
                                <i class="bi bi-paperclip"></i> file
                            </a>
                        </span>
                        <?php endif; ?>
                    </p>
                    <p class="m-0"><?php echo str_replace("\n", '<br>', $p->message); ?></p>
                    <?php if($p->comment): ?>
                        <div class="d-block mt-3 ps-5">
                            <p class="m-0 mb-1">
                                <span class="fw-bold text-success">Admin</span> &nbsp;
                                <small>
                                    <i class="bi bi-clock"></i>
                                    <?php echo indonesian_date($p->date_submit); ?>
                                </small>
                            </p>
                            <p class="m-0"><?php echo str_replace("\n", '<br>', $p->comment); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <div class="d-block mt-3">
                    <?php echo $pager = str_replace(['<ul class="pagination"','<li>','<a'],['<ul class="pagination pagination-sm"','<li class="page-item">','<a class="page-link"'], $pager); ?>
                </div>
            </div>
        </div>

        <?php echo $this->include('sidebar'); ?>

    </div>
</div>