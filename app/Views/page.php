<div class="container">
    <h3>Halaman &nbsp;<a href="<?php echo base_url(); ?>/page/new" class="a-normal">+</a></h3>
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
                        <td class="text-center">Order</td>
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
                            <a href="<?php echo base_url('page?status='.$status); ?>" class="text-light">
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
                    <?php if(!$pages): ?>
                        <tr>
                            <td colspan="4" class="p-2 text-center text-danger fw-bold fst-italic">
                                ... halaman tidak ditemukan!
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $i = $pagerStart+1; ?>
                    <?php foreach($pages as $page): ?>
                        <tr>
                            <td class="text-center"><?php echo $i; ?>.</td>
                            <td>
                                <?php if($page->ID_page) echo '<em style="opacity: .9;">'.$parents[$page->ID_page].' &raquo; </em>'; ?>
                                <a href="<?php echo base_url('halaman/'.$page->slug); ?>" class="a-normal text-dark">
                                    <?php echo $page->title; ?>
                                </a>
                            </td>
                            <td class="text-center"><?php echo $page->place_order; ?></td>
                            <td style="white-space: nowrap;"><small><?php echo indonesian_date($page->date_created); ?></small></td>
                            <td class="text-center"><small><?php echo $page->username; ?></small></td>
                            <td class="text-center"><small><?php echo $page->hits; ?></small></td>
                            <td class="text-center">
                                <small>
                                    <?php
                                        $cCount = 0;
                                        if(isset($commentsCount[$page->ID])) $cCount += $commentsCount[$page->ID];
                                        echo $cCount;
                                    ?>
                                </small>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo base_url('page/edit?id='.$page->ID); ?>" title="Edit Halaman" class="text-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo base_url('page/edit-status?id='.$page->ID.'&status='.$status); ?>" onclick="return confirm('Apakah Anda yakin?')">
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


<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<!-- Core theme JS-->
<script src="<?php echo base_url(); ?>/js/scripts.js?<?php echo now(); ?>"></script>
</body>
</html>