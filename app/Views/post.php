<div class="container">
    <h3>Postingan &nbsp;<a href="<?php echo base_url(); ?>/post/new" class="a-normal">+</a></h3>
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
                        <td>Judul</td>
                        <td>Tanggal</td>
                        <td class="text-center">Penulis</td>
                        <td class="text-center">Hits</td>
                        <td class="text-center"><i class="bi bi-chat"></i></td>
                        <td class="text-center">
                            <a href="#" title="Edit postingan" class="text-light">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <?php $Status = (@$_GET['status'] === '0') ? '0' : '1'; ?>
                            <?php $status = (@$_GET['status'] === '0') ? '1' : '0'; ?>
                            <a href="<?php echo base_url('post?status='.$status); ?>" class="text-light">
                                <?php if($Status === '0'): ?>
                                <i class="bi bi-reply-all-fill"></i>
                                <?php else: ?>
                                <i class="bi bi-trash"></i>
                                <?php endif; ?>
                            </a>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!$posts): ?>
                        <tr>
                            <td colspan="4" class="p-2 text-center text-danger fw-bold fst-italic">
                                ... artikel tidak ditemukan!
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $i = $pagerStart+1; ?>
                    <?php foreach($posts as $post): ?>
                        <tr>
                            <td class="text-center"><?php echo $i; ?>.</td>
                            <td>
                                <a href="<?php echo base_url('artikel/'.$post->slug); ?>" class="a-normal text-dark">
                                    <?php echo $post->title; ?>
                                </a>
                            </td>
                            <td style="white-space: nowrap;"><small><?php echo indonesian_date($post->date_created); ?></small></td>
                            <td class="text-center"><small><?php echo $post->username; ?></small></td>
                            <td class="text-center"><small><?php echo $post->hits; ?></small></td>
                            <td class="text-center">
                                <small>
                                    <?php
                                        $cCount = 0;
                                        if(isset($commentsCount[$post->ID])) $cCount += $commentsCount[$post->ID];
                                        echo $cCount;
                                    ?>
                                </small>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo base_url('post/edit?id='.$post->ID); ?>" title="Edit postingan" class="text-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo base_url('post/edit-status?id='.$post->ID.'&status='.$status); ?>" onclick="return confirm('Apakah Anda yakin?')">
                                    <?php if($Status === '0'): ?>
                                        <i class="bi bi-reply-all-fill text-success"></i>
                                    <?php else: ?>
                                        <i class="bi bi-trash text-danger"></i>
                                    <?php endif; ?>
                                </a>
                            </td>
                        </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="my-2">
            <?php echo $pager = str_replace(['<ul class="pagination"','<li>','<a'],['<ul class="pagination pagination-sm"','<li class="page-item">','<a class="page-link"'],$pager); ?>
        </div>
    </div>
</div>