<div class="container">
    <h3>Media &nbsp;<!--
        <a href="javascript:void(0)" id="tambahMedia" class="a-normal" data-bs-toggle="modal" data-bs-target="#modalTambaMedia">+</a>
    --></h3>
    <?php if(session()->alert): ?>
    <div class="alert alert-<?php echo session()->alert['type']; ?>">
        <?php echo session()->alert['message']; ?>
    </div>
    <?php else: ?>
    <div class="alert alert-info">
        <i class="bi bi-exclamation-triangle"></i>
        <strong>Perhatian!</strong> Menghapus media akan mempengaruhi konten yang berisi media tersebut.
    </div>
    <?php endif; ?>
    <div class="col-lg-12">
        <?php foreach($imageFiles as $if): ?>
        <div class="media-item d-inline-flex align-items-end justify-content-center border rounded bg-info" style="background-image: url('<?php echo $if['thumbnail']; ?>');">
            <div class="media-item-title d-flex justify-content-center align-items-center bg-dark-op-50 rounded-bottom">
                <div class="d-inline-flex">
                    <!-- <input class="cursor-pointer" type="checkbox" name="mediaImage" value=""> -->
                    <a href="<?php echo $if['original']; ?>" class="text-light ms-2 pt-1" role="button" data-magnify="gallery" title="Lihat">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="javascript:void(0)" class="text-light ms-2 pt-1">
                        <i class="bi bi-link-45deg" title="Salin URL"></i>
                    </a>
                    <a href="<?php echo base_url('media'); ?>/delete?t=img&f=<?php echo $if['fullname'].'&m='.$if['fullthumb']; ?>" class="text-light ms-2 pt-1" title="Hapus" onclick="return confirm('Apakah Anda yakin?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>