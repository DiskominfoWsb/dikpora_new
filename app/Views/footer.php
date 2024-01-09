<!-- Footer-->
<footer class="bg-dark" style="background-image: url('<?php echo base_url(); ?>/assets/berita-3-min.jpg'); background-size: cover; background-position: center top;">
    <div class="bg-warning-op-90">
        <div class="container">
            <div class="row">
                <div id="footer-warning-1" class="col-lg-5 col-sm-12 col-12 py-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal-search" class="d-block a-normal text-light fw-bolder ps-5" style="background-image: url('<?php echo base_url(); ?>/assets/search-min.png'); background-size: contain; background-repeat: no-repeat;">
                        <h5 class="my-0">PENCARIAN</h5>
                        <p class="my-0 fw-normal"><small>Tidak menemukan konten? Silahkan melakukan pencarian</small></p>
                    </a>
                </div>
                <div id="footer-warning-2" class="col-lg-2 col-md-2">&nbsp;</div>
                <div id="footer-warning-3" class="col-lg-5 col-sm-12 col-12 py-3 ps-5">
                    <a href="<?php echo base_url(); ?>/layanan-pengaduan-masyarakat" class="d-block a-normal text-light fw-bolder ps-5" style="background-image: url('<?php echo base_url(); ?>/assets/document-min.png'); background-size: contain; background-repeat: no-repeat;">
                        <h5 class="my-0">SARAN DAN PENGADUAN</h5>
                        <p class="my-0 fw-normal"><small>Saran dan masukan untuk kemajuan Disdikpora Wonosobo</small></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-dark-op-85">
        <div class="container py-5">
            <div class="row">
                <div class="clear-px little-px col-lg-3 py-3">
                    <div class="clear-px text-light fw-bolder ps-1">
                        <h5 class="mb-3">Statistik Pengunjung</h5>
                        <p class="my-2 fw-normal">
                            <i class="bi bi-graph-up-arrow"></i>&nbsp;
                            <small>Total Pembaca: <?php echo $counter['view']; ?> hits</small>
                        </p>
                        <p class="my-2 fw-normal">
                            <i class="bi bi-graph-up"></i>&nbsp;
                            <small>Total Kunjungan: <?php echo $counter['visit']; ?> hits</small>
                        </p>
                        <p class="my-2 fw-normal">&nbsp;</p>
                        <p class="my-2 fw-normal fs-5">
                            <a href="<?php echo $social['youtube']; ?>" target="_blank"><i class="bi bi-youtube"></i></a> &nbsp;
                            <a href="<?php echo $social['instagram']; ?>" target="_blank"><i class="bi bi-instagram"></i></a> &nbsp;
                            <a href="<?php echo $social['facebook']; ?>" target="_blank"><i class="bi bi-facebook"></i></a> &nbsp;
                            <a href="<?php echo $social['twitter']; ?>" target="_blank"><i class="bi bi-twitter"></i></a>
                        </p>
                    </div>
                </div>
                <div class="clear-px little-px col-lg-4 py-3">
                    <div class="clear-px text-light fw-bolder ps-5">
                        <h5 class="mb-3">Tautan Terkait</h5>
                        <?php foreach($footerLink as $link): ?>
                        <p class="my-2 fw-normal">
                            <i class="bi bi-link-45deg"></i>&nbsp;
                            <small>
                                <a href="<?php echo $link['url']; ?>" title="<?php echo $link['title']; ?>" class="a-normal text-light">
                                    <?php echo $link['title']; ?>
                                </a>
                            </small>
                        </p>
                        <?php endforeach; ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.934691722101!2d109.90475287500064!3d-7.361217892647839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7aa0541f1b8cc3%3A0x2b3215ba8fdce1e6!2sDisdikpora%20Kab%20Wonosobo!5e0!3m2!1sid!2sid!4v1697161450997!5m2!1sid!2sid" width="200" height="100" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="clear-px little-px col-lg-5 py-3 ps-5">
                    <div class="text-light fw-bolder">
                        <h5 class="mb-3">Kontak Kami</h5>
                        <p class="my-2 fw-normal"><i class="bi bi-pin-map-fill"></i>&nbsp;<small> <?php echo $footerContact['footer_address']; ?></small></p>
                        <p class="my-2 fw-normal"><i class="bi bi-telephone-outbound-fill"></i>&nbsp;<small> <?php echo $footerContact['footer_phone']; ?></small></p>
                        <p class="my-2 fw-normal"><i class="bi bi-envelope-fill"></i>&nbsp;<small> <?php echo $footerContact['footer_email']; ?></small></p>
                        <p class="my-2 fw-normal"><i class="bi bi-globe"></i>&nbsp;<small> <?php echo $footerContact['footer_website']; ?></small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="#copyright" class="bg-primary-op-85">
        <div class="container py-3">
            <div class="row">
                <div class="col-lg-8 py-2">
                    <p class="mb-0 text-light">
                        <i class="bi bi-c-circle"></i> <?php echo date('Y', now()); ?> DPUPR Kabupaten Wonosobo &nbsp;|&nbsp;
                        <a href="<?php echo base_url('sitemap'); ?>" class="text-light">Sitemap</a>
                    </p>
                </div>
                <div class="col-lg-4 py-2 ps-5" style="opacity: .65;">
                    <p class="mb-0 text-light text-end">
                        Developed by <a href="https://www.instagram.com/codingku.id7" target="_blank" class="text-light">Codingku.id</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- /footer -->
<div id="modal-search" class="modal fade backdrop-blur" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: none; border: none;">
            <form method="get" action="<?php echo base_url(); ?>/artikel/pencarian">
                <div class="input-group">
                    <input id="input-search" type="text" name="keywords" class="form-control form-control-lg px-4" placeholder="Cari artikel berita, pengumuman, dsb . . ." aria-label="Keywords" aria-describedby="button-addon2" style="border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                    <button class="btn btn-lg" style="background: orange; border-radius: 0 20px 20px 0; box-shadow: 0 0 2px orange;" type="submit" id="button-addon2">&nbsp;<i class="bi bi-search fw-bolder text-light"></i>&nbsp;</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Floating tools -->
<div class="d-inline-flex fixed-bottom justify-content-center align-items-end">
    <div id="toolsku" class="mb-3 p-3 rounded-4 d-none" style="background-image: url('<?php echo base_url(); ?>/assets/opacity-9.png'); background-repeat: repeat;">
        <table border="0">
            <tr>
                <td data-bs-toggle="modal" data-bs-target="#modalTools1">
                    <img src="<?php echo base_url(); ?>/assets/wayang-icon-min.png" alt="pandji" width="45" class="rounded-circle bg-warning">
                </td>
                <td data-bs-toggle="modal" data-bs-target="#modalTools2">
                    <img src="<?php echo base_url(); ?>/assets/chicken-icon-min.png" alt="petarung" width="45" class="rounded-circle bg-warning">
                </td>
                <td data-bs-toggle="modal" data-bs-target="#modalTools3">
                    <img src="<?php echo base_url(); ?>/assets/bolo-serayu-icon-min.png" alt="bolo-serayu" width="45" class="rounded-circle bg-warning">
                </td>
                <td data-bs-toggle="modal" data-bs-target="#modalTools4">
                    <img src="<?php echo base_url(); ?>/assets/wayang-icon-min.png" alt="sembada" width="45" class="rounded-circle bg-warning">
                </td>
            </tr>
            <tr class="fw-bolder">
                <td style="white-space: nowrap;">
                    <small>PANDJI</small>
                </td>
                <td style="white-space: nowrap;">
                    <small>PETARUNG</small>
                </td>
                <td style="white-space: nowrap;">
                    <small>BOLO SERAYU</small>
                </td>
                <td style="white-space: nowrap;">
                    <small>SEMBADA</small>
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Floating chat -->
<div id="chatku" class="chatku">
    <a href="#chatku" class="d-inline-flex justify-content-center align-items-center bg-warning rounded-circle" data-bs-html="true" data-bs-toggle="popover" data-bs-content="<!-- <i class='bi bi-whatsapp'></i> <a href='https://wa.me' class='a-normal'>Whatsapp</a><br><i class='bi bi-telegram'></i> <a href='https://t.me' class='a-normal'>Telegram</a><br> --><span class='fs-6'><i class='bi bi-envelope'></i> <a href='mailto:dpupr@wonosobokab.go.id' class='a-normal'>Email</a></span>">
        <i class="bi bi-chat-right-text-fill text-light animate__animated animate__heartBeat"></i>
    </a>
</div>
<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<!-- reCAPTCHA v2 -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- Core theme JS-->
<script src="<?php echo base_url(); ?>/js/scripts.js?<?php echo now(); ?>"></script>
</body>
</html>