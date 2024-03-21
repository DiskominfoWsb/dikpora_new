<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Website Portal Resmi Dinas Pendidikan, Pemuda dan Olahraga Kabupaten Wonosobo Provinsi Jawa Tengah">
    <meta name="keywords" content="dinas,dikpora,wonosobo,jawa-tengah,dinas-pendidikan,pemuda,olahraga">
    <meta name="author" content="DISDIKPORA Kabupaten Wonosobo">
    <title>Dinas Pendidikan, Pemuda dan Olahraga Kabupaten Wonosobo</title>
    <!-- Favicon-->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>/assets/dikpora_logobulet-min.png">
    <!-- Bootstrap CSS Only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Inconsolata|Nunito|Mukta|Dosis|Exo+2">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/css/styles.css?<?php echo now(); ?>">
</head>

<body id="_top">

    <!-- Page header with logo and tagline-->
    <header id="header1" class="pb-5 bg-light border-bottom mb-0" style="background-image: url('<?php echo base_url(); ?>/assets/bg-baru.png');">
        <!-- Navbar brand collapsed-->
        <nav id="navku" class="navbar fixed-top d-none">
            <div class="container">
                <div id="brandku" class="d-flex justify-content-start align-items-start">
                    <div class="pe-2">
                        <img src="<?php echo base_url(); ?>/assets/logo-kabupaten-wonosobo-min.png" height="35" width="auto">
                    </div>
                    <div class="pe-4">
                        <small class="fw-bolder" style="line-height: 0;">PEMERINTAH DAERAH<br>KAB. WONOSOBO</small>
                    </div>
                    <div class="pe-2 cursor-pointer">
                        <img src="<?php echo base_url(); ?>/assets/dikpora_logobulet-min.png" height="35" width="auto">
                    </div>
                    <div class="mt-1 cursor-pointer">
                        <small class="fw-bolder">
                            <span><strong>DISDIKPORA</strong></span>
                            <span><br>KABUPATEN WONOSOBO</span>
                        </small>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <ul class="navbarku">
                        <?php echo $menuNewTree1; ?>
                        <li>
                            <a href="<?php echo base_url('login'); ?>" class="py-1 px-3 rounded-pill text-light a-normal signup-light">
                                <small class="d-block">sign in</small>
                            </a>
                        </li>
                    </ul>
                    <a href="javascript:void(0)" class="menu-toggler">
                        <i class="bi bi-list text-dark fs-1 fw-bold"></i>
                    </a>
                </div>
            </div>
        </nav>
        <nav id="navperma" class="navbar">
            <div class="container">
                <div id="brandperma" class="d-flex justify-content-start align-items-start pt-1">
                    <div class="pe-2">
                        <img src="<?php echo base_url(); ?>/assets/logo-kabupaten-wonosobo-min.png" height="35" width="auto">
                    </div>
                    <div class="pe-4">
                        <small class="fw-bolder" style="line-height: 0;">PEMERINTAH DAERAH<br>KAB. WONOSOBO</small>
                    </div>
                    <div class="pe-2">
                        <!--img src="<?php //echo base_url(); 
                                        ?>/assets/dikpora_logobulet.png" height="35" width="auto"-->
                    </div>
                    <div class="mt-1 cursor-pointer">
                        <!--small class="fw-bolder" style="line-height: 0;">
                                <span><strong>DISDIKPORA</strong></span>
                                <span><br>KABUPATEN WONOSOBO</span>
                            </small-->
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <ul class="navbarku">
                        <?php echo $menuNewTree2; ?>
                        <li>
                            <a href="<?php echo base_url('login'); ?>" class="py-1 px-3 rounded-pill text-light signup-light">
                                <small class="d-block">sign in</small>
                            </a>
                        </li>
                    </ul>
                    <a href="javascript:void(0)" class="menu-toggler">
                        <i class="bi bi-list text-light fs-1 fw-bold"></i>
                    </a>
                </div>
            </div>
        </nav>
        <div id="dashboardku">
            <div class="container">
                <div class="row justify-content-center mb-5 animate__animated animate__fadeInUp">
                    <div class="col-lg-2 d-inline-flex text-center justify-content-center">
                        <img id="logoku" src="<?php echo base_url(); ?>/assets/dikpora_logobulet.png" width="130">
                    </div>
                    <h4 class="text-center fw-bolder d-none">DISDIKPORA</h4>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-3">
                        <form method="get" action="<?php echo base_url(); ?>/artikel/pencarian">
                            <div class="input-group mt-3 mb-3">
                                <!--input id="input-search" type="text" name="keywords" class="form-control px-4" placeholder="Cari artikel berita, pengumuman, dsb . . ." aria-label="Keywords" aria-describedby="button-addon2">
                                    <button class="btn" style="background: orange; border-radius: 0 20px 20px 0; box-shadow: 0 0 2px orange;" type="submit" id="button-addon2">&nbsp;<i class="bi bi-search fw-bolder text-light"></i>&nbsp;</button-->
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row justify-content-center mt-5 animate__animated animate__fadeInDown">
                    <div class="d-inline-flex justify-content-center">
                        <div id="tools" class="mt-1 rounded-4">
                            <!--h4 class="text-center mb-3 py-1">Inovasi Layanan</h4>
                                <table border="0" class="mx-auto">
                                    <tr>
                                        <?php for ($i = 0; $i < count($layananInovasi); $i++) : ?>
                                        <td data-bs-toggle="modal" data-bs-target="#<?php echo $layananInovasi[$i]->id; ?>">
                                            <img src="<?php echo $layananInovasi[$i]->icon; ?>" alt="<?php echo $layananInovasi[$i]->title; ?>" width="55" class="rounded-circle cursor-pointer">
                                        </td>
                                        <?php endfor; ?>
                                    </tr>
                                    <tr class="fw-bolder">
                                        <?php for ($i = 0; $i < count($layananInovasi); $i++) : ?>
                                        <td style="vertical-align: top">
                                            <small><?php echo $layananInovasi[$i]->title; ?></small>
                                        </td>
                                        <?php endfor; ?>
                                    </tr>
                                </table-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Carousel double -->
    <div class="py-5">
        <div class="container">
            <div class="d-flex justify-content-center pb-4">
                <div class="d-inline-block pt-1 pb-4 px-2 bg-ornamen">Berita Terbaru</div>
            </div>
            <div id="carouselExampleIndicators2" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php for ($i = 0; $i < 3; $i++) : ?>
                        <div class="carousel-item<?php if ((3 * $i) + 0 == 0) echo ' active'; ?>">
                            <div class="row mx-1">
                                <div class="carousel-col col-lg-4 ps-5">
                                    <a href="<?php echo base_url('artikel/' . $newsletter[(3 * $i) + 0]['slug']); ?>" class="d-block a-normal text-darken a-link" title="<?php echo $newsletter[(3 * $i) + 0]['title']; ?>">
                                        <div class="inner-group d-block bg-warning-op-85">
                                            <?php if (!$newsletter[(3 * $i) + 0]['featured_image']) $newsletter[(3 * $i) + 0]['featured_image'] = 'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png'; ?>
                                            <div class="d-flex container featured-image" style="background-image: url('<?php echo site_url('upload/view?file=' . $newsletter[(3 * $i) + 0]['featured_image']); ?>'); background-size: cover; background-position: center top; height: 250px;">
                                                <div class="row align-items-end">
                                                    <div class="featured-title d-block">
                                                        <p class="fw-bolder m-0 pt-2 pb-1">
                                                            <?php echo substr($newsletter[(3 * $i) + 0]['title'], 0, 60); ?> ...<br>
                                                            <small class="fw-normal">
                                                                <i class="bi bi-clock"></i>
                                                                <?php echo indonesian_date($newsletter[(3 * $i) + 0]['date_created']); ?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="carousel-col col-lg-4 ps-3 pe-3">
                                    <a href="<?php echo base_url('artikel/' . $newsletter[(3 * $i) + 1]['slug']); ?>" class="d-block a-normal text-darken a-link" title="<?php echo $newsletter[(3 * $i) + 1]['title']; ?>">
                                        <div class="inner-group d-block bg-warning-op-85 cursor-pointer">
                                            <div class="d-flex container featured-image" style="background-image: url('<?php echo  site_url('upload/view?file=' . $newsletter[(3 * $i) + 1]['featured_image']); ?>'); background-size: cover; background-position: center top; height: 250px;">
                                                <div class="row align-items-end">
                                                    <div class="featured-title">
                                                        <p class="fw-bolder m-0 pt-2 pb-1">
                                                            <?php echo substr($newsletter[(3 * $i) + 1]['title'], 0, 60); ?> ...<br>
                                                            <small class="fw-normal">
                                                                <i class="bi bi-clock"></i>
                                                                <?php echo indonesian_date($newsletter[(3 * $i) + 1]['date_created']); ?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="carousel-col col-lg-4 pe-5">
                                    <a href="<?php echo base_url('artikel/' . $newsletter[(3 * $i) + 2]['slug']); ?>" class="d-block a-normal text-darken a-link" title="<?php echo $newsletter[(3 * $i) + 2]['title']; ?>">
                                        <div class="inner-group d-block bg-warning-op-85 cursor-pointer">
                                            <div class="d-flex container featured-image" style="background-image: url('<?php echo  site_url('upload/view?file=' . $newsletter[(3 * $i) + 2]['featured_image']); ?>'); background-size: cover; background-position: center top; height: 250px;">
                                                <div class="row align-items-end">
                                                    <div class="featured-title">
                                                        <p class="fw-bolder m-0 pt-2 pb-1">
                                                            <?php echo substr($newsletter[(3 * $i) + 2]['title'], 0, 60); ?> ...<br>
                                                            <small class="fw-normal">
                                                                <i class="bi bi-clock"></i>
                                                                <?php echo indonesian_date($newsletter[(3 * $i) + 2]['date_created']); ?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <button class="carousel-control-prev justify-content-start" style="width: 5%;" type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next justify-content-end" style="width: 5%;" type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="d-flex justify-content-center">
                <a href="<?php echo base_url('artikel/arsip/7/berita'); ?>" class="d-inline-block mt-4 py-1 px-3 border border-1 rounded-pill a-normal1" style="background: orange">
                    &laquo; Arsip Berita &raquo;
                </a>
            </div>

        </div>
        <div class="container pt-4">
            <div class="d-flex justify-content-center pb-4">
                <div class="d-inline-block pt-3 pb-4 px-2 bg-ornamen">Pengumuman</div>
            </div>
            <div id="carouselExampleIndicators1" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $announceMax    = 1;
                    $announceCount  = count((array)$announcement);
                    if ($announceCount >= 9) {
                        $announceMax = 3;
                    } elseif ($announceCount >= 6) {
                        $announceMax = 2;
                    } else {
                        $announceMax = 1;
                    }
                    ?>
                    <?php for ($i = 0; $i < $announceMax; $i++) : ?>
                        <div class="carousel-item<?php if ((3 * $i) + 0 == 0) echo ' active'; ?>">
                            <div class="row mx-1">
                                <div class="carousel-col col-lg-4 ps-5">
                                    <a href="<?php echo base_url('artikel/' . $announcement[(3 * $i) + 0]['slug']); ?>" class="d-block a-normal text-darken a-link" title="<?php echo $announcement[(3 * $i) + 0]['title']; ?>">
                                        <div class="inner-group d-block bg-warning-op-85">
                                            <div class="d-flex container featured-image" style="background-image: url('<?php echo site_url('upload/view?file=' . $announcement[(3 * $i) + 0]['featured_image']); ?>'); background-size: cover; background-position: center top; height: 250px;">
                                                <div class="row align-items-end">
                                                    <div class="featured-title">
                                                        <p class="fw-bolder m-0 py-2">
                                                            <?php echo substr($announcement[(3 * $i) + 0]['title'], 0, 60); ?> ...<br>
                                                            <small class="fw-normal">
                                                                <i class="bi bi-clock"></i>
                                                                <?php echo indonesian_date($announcement[(3 * $i) + 0]['date_created']); ?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="carousel-col col-lg-4 ps-3 pe-3">
                                    <a href="<?php echo base_url('artikel/' . $announcement[(3 * $i) + 1]['slug']); ?>" class="d-block a-normal text-darken a-link" title="<?php echo $announcement[(3 * $i) + 1]['title']; ?>">
                                        <div class="inner-group d-block bg-warning-op-85 cursor-pointer">
                                            <div class="d-flex container featured-image" style="background-image: url('<?php echo site_url('upload/view?file=' . $announcement[(3 * $i) + 1]['featured_image']); ?>'); background-size: cover; background-position: center top; height: 250px;">
                                                <div class="row align-items-end">
                                                    <div class="featured-title">
                                                        <p class="fw-bolder m-0 py-2">
                                                            <?php echo substr($announcement[(3 * $i) + 1]['title'], 0, 60); ?> ...<br>
                                                            <small class="fw-normal">
                                                                <i class="bi bi-clock"></i>
                                                                <?php echo indonesian_date($announcement[(3 * $i) + 1]['date_created']); ?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="carousel-col col-lg-4 pe-5">
                                    <a href="<?php echo base_url('artikel/' . $announcement[(3 * $i) + 2]['slug']); ?>" class="d-block a-normal text-darken a-link" title="<?php echo $announcement[(3 * $i) + 2]['title']; ?>">
                                        <div class="inner-group d-block bg-warning-op-85 cursor-pointer">
                                            <div class="d-flex container featured-image" style="background-image: url('<?php echo  site_url('upload/view?file=' . $announcement[(3 * $i) + 2]['featured_image']); ?>'); background-size: cover; background-position: center top; height: 250px;">
                                                <div class="row align-items-end">
                                                    <div class="featured-title">
                                                        <p class="fw-bolder m-0 py-2">
                                                            <?php echo substr($announcement[(3 * $i) + 2]['title'], 0, 60); ?> ...<br>
                                                            <small class="fw-normal">
                                                                <i class="bi bi-clock"></i>
                                                                <?php echo indonesian_date($announcement[(3 * $i) + 2]['date_created']); ?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <button class="carousel-control-prev justify-content-start" style="width: 5%;" type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next justify-content-end" style="width: 5%;" type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="d-flex justify-content-center">
                <a href="<?php echo base_url('artikel/arsip/6/pengumuman'); ?>" class="d-inline-block mt-4 py-1 px-3 border border-1 rounded-pill a-normal1" style="background: orange">
                    &laquo; Arsip Pengumuman &raquo;
                </a>
            </div>
        </div>
    </div>
    <!-- /Carousel double -->

    <!-- Sifat pengumuman penting -->
    <div id="container-pengumuman">
        <div class="d-block">
            <img src="<?php echo $bannerPengumuman['image']; ?>" style="width: 100%; height: auto;">
        </div>
    </div>
    <!-- /Sifat pengumuman penting -->

    <!-- Tools Tengah -->
    <div class="container mt-4 mb-5">
        <!--div>
                <div class="d-flex justify-content-center pb-4">
                    <div class="d-inline-block pt-3 pb-4 px-2 bg-ornamen">Informasi Lain</div>
                </div>
            </div>
            <?php //for($i=0; $i<count($icon); $i++): 
            ?>
            <div class="row tools-row mt-2">
                <?php //for($j=0; $j<count($icon[$i]); $j++): 
                ?>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4 col-6 a-link">
                    <div class="tools-tengah mt-2 mb-3 mx-2 py-3 px-2 rounded" onclick="window.location='<?php //echo $icon[$i][$j][2]; 
                                                                                                            ?>'">
                        <div class="d-flex p-3 justify-content-center align-items-center">
                            <img src="<?php //echo base_url(); 
                                        ?>/assets/icon-tool/<?php //echo $icon[$i][$j][0];
                                                            ?>">
                        </div>
                        <h6 class="m-0 p-0 text-center fw-bold"><?php //echo $icon[$i][$j][1];
                                                                ?></h6>
                    </div>
                </div>
                <?php //endfor; 
                ?>
            </div-->
        <?php //endfor; 
        ?>
    </div>
    <!-- /Tools tengah -->

    <!-- Floating tools -->
    <div class="d-inline-flex fixed-bottom justify-content-center align-items-end">
        <!--div id="toolsku" class="mb-3 p-3 pt-2 rounded-4 d-none" style="background-image: url('<?php echo base_url(); ?>/assets/opacity-9.png'); background-repeat: repeat;">
                <h5 class="text-center mb-2">Inovasi Layanan</h5>
                <table border="0">
                    <tr>
                        <?php for ($i = 0; $i < count($layananInovasi); $i++) : ?>
                        <td data-bs-toggle="modal" data-bs-target="#<?php echo $layananInovasi[$i]->id; ?>">
                            <img src="<?php echo $layananInovasi[$i]->icon; ?>" alt="<?php echo $layananInovasi[$i]->title; ?>" width="45" class="rounded-circle bg-warning">
                        </td>
                        <?php endfor; ?>
                    </tr>
                    <tr class="fw-bolder">
                        <?php for ($i = 0; $i < count($layananInovasi); $i++) : ?>
                        <td style="white-space: nowrap;">
                            <small><?php echo $layananInovasi[$i]->title; ?></small>
                        </td>
                        <?php endfor; ?>
                    </tr>
                </table>
            </div-->
    </div>

    <!-- Floating chat -->
    <div id="chatku">
        <a href="#chatku" class="d-inline-flex justify-content-center align-items-center bg-warning rounded-circle" data-bs-html="true" data-bs-toggle="popover" data-bs-content="<!-- <i class='bi bi-whatsapp'></i> <a href='https://wa.me' class='a-normal'>Whatsapp</a><br><i class='bi bi-telegram'></i> <a href='https://t.me' class='a-normal'>Telegram</a><br> --><span class='fs-6'><i class='bi bi-envelope'></i> <a href='mailto:dpupr@wonosobokab.go.id' class='a-normal'>Email</a></span>">
            <i class="bi bi-chat-right-text-fill text-light animate__animated animate__heartBeat"></i>
        </a>
    </div>

    <!-- Modal Welcome -->
    <div id="modalWelcome" class="modal backdrop-blur animate__animated animate__zoomIn" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content p-0" style="background: none; border: none;">
                <div class="modal-body p-0">
                    <div class="" style="position: absolute; right: 0; margin: 15px 15px 0 0;">
                        <small>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </small>
                    </div>
                    <img src="<?php echo $bannerWelcome['image']; ?>" style="width: 100%; height: auto;">
                    <!--
                        <div class="d-flex justify-content-center">
                            <div class="pe-3">
                                <img src="<?php echo base_url(); ?>/assets/logo-kabupaten-wonosobo-min.png" height="50" width="auto">
                            </div>
                            <div class="ps-3">
                                <img src="<?php echo base_url(); ?>/assets/logo-dpupr-min.png" height="45" width="auto">
                            </div>
                        </div>
                        <h1 class="text-center my-2" style="font-family: 'Brush Script MT', cursive; font-size: 95px; color: #e8b431;">Selamat Datang</h1>
                        <p class="fw-bolder fs-5 text-center mb-2">Di Website Portal Resmi DPUPR Kabupaten Wonosobo</p>
                        <p class="text-center mb-3">Semoga dengan website ini, kami mampu memberikan<br>informasi yang dibutuhkan oleh masyarakat maupun oleh pihak-pihak lain<br>yang ingin mencari informasi tentang kami.</p>
                        -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tools -->
    <?php for ($i = 0; $i < count($layananInovasi); $i++) : ?>
        <div id="<?php echo $layananInovasi[$i]->id; ?>" class="modal fade backdrop-blur" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered animate__animated animate__zoomIn">
                <div class="modal-content" style="border-radius: 20px; border: none; opacity: .90;">
                    <div class="modal-body">
                        <div class="text-end">
                            <small>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </small>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-lg-3 text-center">
                                <img src="<?php echo $layananInovasi[$i]->icon; ?>" class="rounded-circle bg-warning">
                            </div>
                            <div class="col-sm-12 col-md-9 col-lg-9">
                                <?php echo $layananInovasi[$i]->content; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endfor; ?>
    <!-- /. Modal -->

    <!-- Footer -->
    <footer class="bg-dark" style="background-image: url('<?php echo base_url(); ?>/assets/footer-web.png'); background-size: cover; background-position: center top;">
        <div class="bg-warning-op-90">
            <div class="container">
                <div class="row">
                    <div id="footer-warning-1" class="col-lg-5 col-sm-12 col-12 py-3">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-search" class="d-block a-normal text-light fw-bolder ps-5" style="background-image: url('<?php echo base_url(); ?>/assets/search-min.png'); background-size: contain; background-repeat: no-repeat;">
                            <h5 class="my-0">PENCARIAN</h5>
                            <p class="my-0 fw-normal"><small>Tidak menemukan konten? Silahkan melakukan pencarian</small></p>
                        </a>
                    </div>
                    <div id="footer-warning-2" class="col-lg-2 col-md-2">&nbsp;</div>
                    <div id="footer-warning-3" class="col-lg-5 col-sm-12 col-12 py-3 ps-5">
                        <a href="<?php echo base_url(); ?>/layanan-pengaduan-masyarakat" class="d-block a-normal text-light fw-bolder ps-5" style="background-image: url('<?php echo base_url(); ?>/assets/document-min.png'); background-size: contain; background-repeat: no-repeat;">
                            <h5 class="my-0">SARAN DAN PENGADUAN</h5>
                            <p class="my-0 fw-normal"><small>Saran dan masukan untuk kemajuan DISDIKPORA Wonosobo</small></p>
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
                            <?php foreach ($footerLink as $link) : ?>
                                <p class="my-2 fw-normal">
                                    <i class="bi bi-link-45deg"></i>&nbsp;
                                    <small>
                                        <a href="<?php echo $link['url']; ?>" title="<?php echo $link['title']; ?>" class="a-normal a-link-white">
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
                            <i class="bi bi-c-circle"></i> <?php echo date('Y', now()); ?> DISDIKPORA Kabupaten Wonosobo
                        </p>
                    </div>
                    <div class="col-lg-4 py-2 ps-5" style="opacity: .65;">
                        <p class="mb-0 text-light text-end">
                            Developed by <a href="https://www.instagram.com/codingku.id7" class="text-light">Codingku.id</a>
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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- Core theme JS-->
    <script src="<?php echo base_url(); ?>/js/scripts.js?<?php echo now(); ?>"></script>
    <!-- Additional -->
    <script>
        'use strict';
        var modalWelcome = new bootstrap.Modal($('#modalWelcome'), {
            keyboard: false,
            backdrop: 'static'
        });
        <?php if ($displayPopup) : ?>
            modalWelcome.show();
        <?php endif; ?>
    </script>
</body>

</html>