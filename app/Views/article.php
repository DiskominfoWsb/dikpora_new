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
                            js = d.createElement(s);
                            js.id = id;
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
                        }(document, "script", "twitter-wjs"));
                    </script>
                    <a class="twitter-share-button" href="https://twitter.com/intent/tweet">Tweet</a>&nbsp;
                    <a href="whatsapp://send?text=<?php echo urlencode(current_url()); ?>" class="d-inline-block a-normal cursor-pointer text-light rounded-pill bg-success" style="height: 20px; font-size: 9pt; padding: 1px 10px 1px 7px; cursor: pointer;">
                        <i class="bi bi-whatsapp"></i> Share
                    </a>
                </div>
                <div id="header-title" class="pt-2 px-3 px-sm-3 px-md-4 px-lg-4">
                    <h1 class="fw-bolder"><?php echo $article->title; ?></h1>
                    <p class="m-0">
                        <small>
                            <?php
                            $time   = strtotime($article->date_created);
                            $day    = array_hari(date('D', $time));
                            $date   = date('d', $time);
                            $month  = array_bulan(date('m', $time));
                            $year   = date('Y', $time);
                            ?>
                            <i class="bi bi-clock"></i> <?php echo "{$day}, {$date} {$month} {$year}"; ?>
                            <br>
                            <?php
                            $myCats = [];
                            foreach ($categories as $cats) {
                                $myCats[] = '<a href="' . base_url('artikel/arsip/' . $cats->ID . '/' . url_title(convert_accented_characters($cats->name), '-', true)) . '">' . $cats->name . '</a>';
                            }
                            echo implode(' / ', $myCats);
                            ?>
                        </small>
                    </p>
                </div>
                <?php if ($article->featured_image) : ?>
                    <div id="featured-image" class="pt-3 pb-1">
                        <img src="<?php echo site_url('upload/view?file=' . str_replace('_thumb', '', $article->featured_image)); ?>" style="width: 100%;">
                    </div>
                <?php endif; ?>
                <article class="py-4 px-3 px-sm-3 px-md-4 px-lg-4">
                    <?php echo $article->content; ?>
                </article>

            </div>

            <?php if (isset($attachComment)) : ?>
                <?php if ($attachComment) : ?>
                    <div class="col-12">
                        <?php echo $this->include('comment-form'); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>

        <?php echo $this->include('sidebar'); ?>

    </div>
</div>