<div class="col-lg-4">
    <div id="sidebar" class="my-4 bg-light">
        <div class="sidebar-news">
            <div class="sidebar-header py-3 mb-4 text-center fw-bold text-light">
                Artikel Terbaru
            </div>
            <?php foreach($featured as $fear): ?>
                <div class="sidebar-body mb-3 cursor-pointer">
                    <a href="<?php echo base_url('artikel/'.$fear->slug); ?>" class="d-block a-normal text-dark">
                        <div class="sidebar-image d-block bg-info" style="background-image: url('<?php echo $fear->featured_image; ?>'); background-size: cover; background-position: center top;">
                            &nbsp;
                        </div>
                        <div class="sidebar-title py-1 px-3">
                            <p class="m-0 mt-1" style="line-height: 100%;">
                                <?php echo substr($fear->title,0,50); ?> ...<br class="mb-1">
                            </p>
                            <small><i class="bi bi-clock"></i> <?php echo indonesian_date($fear->date_created); ?></small>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="sidebar-category">
            <div class="sidebar-header py-3 m-0 fw-bold text-light" style="border-bottom: 1px solid #000;">
                <div class="d-block px-4">Kategori</div>
                <p class="mt-3 px-4 text-start fw-normal">
                    <?php
                    $listCategory = [];
                    foreach($categoriesList as $cl)
                    {
                        $listCategory[] = '<a href="'.base_url('artikel/arsip/'.$cl->ID).'" class="a-normal text-light">'.$cl->name.'</a>';
                    }
                    echo implode(' <span class="text-info">|</span> ', $listCategory);
                    ?>
                </p>
            </div>
        </div>
        <div class="sidebar-tags">
            <div class="sidebar-header py-3 m-0 fw-bold text-light">
                <div class="d-block px-4">Tags Populer</div>
                <p class="mt-3 px-4 text-start fw-normal">
                    <?php
                    for($i=0; $i<7; $i++)
                    {
                        echo '<a href="'.base_url('artikel/pencarian?keywords='.$popularTags[$i]['tag']).'" class="a-normal text-light">'.$popularTags[$i]['tag'].'</a> <small class="text-info">('.$popularTags[$i]['count'].')</small> ';
                    }
                    ?>
                </p>
            </div>
            <div class="sidebar-body">

            </div>
        </div>
    </div>
</div>