<div class="container">
    <h3>Edit Halaman</h3>
    <form method="post" action="<?php echo base_url(); ?>/page/update" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group mb-2">
                <input type="hidden" name="id" value="<?php echo $page->ID; ?>">
                <input value="<?php echo $page->title; ?>" type="text" name="title" class="form-control" maxlength="150" placeholder="Judul . . .">
            </div>
            <div class="form-group">
                <textarea id="post-content" name="content" class="form-control"><?php echo $page->content; ?></textarea>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header fw-bold">
                    Cuplikan Gambar
                    <?php
                    if($page->featured_image)
                    {
                        echo '&nbsp;<a href="'.str_replace('_thumb', '', $page->featured_image).'" data-magnify="gallery">';
                        echo '<i class="bi bi-image"></i>';
                        echo '</a>';
                    }
                    ?>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input value="<?php echo $page->featured_image; ?>" type="hidden" name="image-old">
                        <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp">
                    </div>
                </div>
            </div>
            <div class="card mt-2" style="height: 215px; max-height: 185px; overflow-y: scroll;">
                <div class="card-header fw-bold">Halaman Induk</div>
                <div class="card-body">
                    <?php
                        echo pageTreeRadio($pages,0,0,$page->ID_page);
                    ?>
                </div>
            </div>
            <div class="form-group mt-2">
                <input value="<?php echo $page->tags; ?>" type="text" name="tags" class="form-control" maxlength="100" placeholder="tag-1, tag-2, tag-3, . . .">
            </div>
            <div class="form-group mt-2">
                <input value="<?php echo $page->place_order; ?>" type="text" name="place-order" placeholder="order" style="width: 100px;" class="text-center">
                <input value="<?php echo $page->css_id; ?>" type="text" name="css-id" placeholder="css id ..." style="width: 100px;">
                <input value="<?php echo $page->css_class; ?>" type="text" name="css-class" placeholder="css class ..." style="width: 100px;">
            </div>
            <div class="card mt-2">
                <div class="card-header fw-bold">Penulis</div>
                <div class="card-body">
                    <div class="form-group">
                        <select name="author" class="form-select">
                            <?php foreach($users as $user): ?>
                            <option value="<?php echo $user->ID;?>"<?php if($user->ID == $page->ID_user) echo ' selected="selected"';?>><?php echo $user->username.' &dash; '.$user->full_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header fw-bold">Publikasikan</div>
                <div class="card-body">
                    <input type="text" name="date" class="d-inline-flex pb-1 px-2 date-picker" value="<?php echo date('Y-m-d', strtotime($page->date_created)); ?>" style="width: 125px;">
                    <button type="submit" name="publish-now" class="btn btn-sm btn-primary" value="1"><i class="bi bi-check-circle"></i> Sekarang&nbsp;</button>
                    <button type="submit" name="publish-later" class="btn btn-sm btn-info text-light"><i class="bi bi-clock"></i> Nanti&nbsp;</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>