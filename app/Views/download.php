<div class="container">
    <div class="row gx-2">
        <div class="col-lg-8">
            <div id="article" class="mt-4 mb-5 rounded-3 bg-light">
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
                <article class="py-4 px-4">
                    <h5 class="text-center d-none">Download</h5>
                    <form method="get">
                        <div class="row mb-2">
                            <div class="input-group">
                                <input type="text" name="keywords" class="form-control" aria-labelledby="button-search" value="<?php echo trim(@$_GET['keywords']); ?>" placeholder=" Kata kunci ...">
                                <button type="submit" name="filter" value="1" class="btn btn-warning text-light btn-secondary rounded-end" id="button-search">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Judul Dokumen</th>
                                    <th class="text-center"><i class="bi bi-download"></i></th>
                                    <th class="text-center">Tanggal</th>
                                </tr>
                                <?php if(!$document): ?>
                                <tr>
                                    <td colspan="4" class="p-2 text-center text-danger fw-bold fst-italic">
                                        ... dokumen tidak ditemukan!
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <?php $i = $pagerStart+1; ?>
                                <?php foreach($document as $doc): ?>
                                <tr>
                                    <td class="text-center"><?php echo $i; ?>.</td>
                                    <td>
                                        <?php echo $doc->title; ?><br>
                                        <small class="fst-italic">
                                            <?php echo $doc->description; ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <small>
                                            <a href="<?php echo $doc->url; ?>" class="d-block px-1 text-center text-light bg-success a-normal rounded">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <small><?php echo date('d/m/Y', strtotime($doc->date_uploaded)); ?></small>
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
        </div>

        <?php echo $this->include('sidebar'); ?>

    </div>
</div>