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
                <div class="px-4">
                    <form method="get" action="<?php echo current_url(); ?>">
                        <div class="input-group mt-3 mb-2">
                            <input type="text" name="keywords" class="form-control" placeholder="Kata kunci ..." aria-label="Keywords" aria-describedby="button-addon2" value="<?php echo @$_GET['keywords']; ?>">
                            <button class="btn text-light" style="background: orange; box-shadow: 0 0 2px orange;" type="submit" id="button-addon2">
                                <i class="bi bi-search fw-bolder text-light"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
                <article class="px-4">
                    <div class="row">
                        <?php foreach ($posts as $post): ?>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 my-2 gx-3">
                            <table style="box-shadow: 0 0 3px 0 #ccc; border-radius: .2rem;">
                                <tr style="background: #fff;">
                                    <td style="width: 100px; height: 100px; background-image: url('<?php echo $post->featured_image; ?>'); background-size: cover; border-top-left-radius: .2rem; border-bottom-left-radius: .2rem;"></td>
                                    <td class="px-2 py-1 align-top" style="border-top-right-radius: .2rem; border-bottom-right-radius: .2rem;">
                                        <a href="<?php echo base_url('artikel/'.$post->slug); ?>" title="<?php echo $post->title; ?>" class="d-block a-normal">
                                            <?php echo substr($post->title,0,60); ?> ...
                                        </a>
                                        <small class="fst-italic">
                                            <i class="bi bi-clock"></i> <?php echo indonesian_date($post->date_created); ?>
                                        </small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php endforeach; ?>
                        <div class="col-lg-12 col-12 mt-3 gx-3">
                            <?php echo $pager = str_replace(['<ul class="pagination"','<li>','<a'],['<ul class="pagination pagination-sm"','<li class="page-item">','<a class="page-link"'], $pager); ?>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <?php echo $this->include('sidebar'); ?>

    </div>
</div>