<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Website Portal Resmi Dinas Pendidikan, Pemuda dan Olahraga Kabupaten Wonosobo Provinsi Jawa Tengah">
    <meta name="keywords" content="dinas,dikpora,wonosobo,jawa-tengah,dinas-pendidikan,pemuda,olahraga">
    <meta name="author" content="Dikpora Wonosobo">
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
    <!-- Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- JQuery Magnify -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/plugin/magnify/css/jquery.magnify.min.css"></link>
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/css/styles.css?<?php echo now(); ?>">
    <style type="text/css">
        html {
            height: -webkit-fill-available;
            overflow-y: hidden;
        }
        body {
            min-height: 100vh;
            min-height: -webkit-fill-available;
            overflow-y: hidden;
        }
        main {
            display: flex;
            flex-wrap: nowrap;
            height: 100vh;
            max-height: 100vh;
            overflow-x: auto;
            overflow-y: hidden;
        }

        /** Menu **/
        .cursor-compass {
            cursor: all-scroll;
        }
        .menu-sortable > li > div {
            background-color: #f9f9f9;
        }
        .menu-sortable > li > ul > li > div {
            background-color: #f4f4f4;
        }
        .menu-sortable > li > ul > li > ul > li > div {
            background-color: #f9f9f9;
        }
        .menu-sortable > li > ul > li > ul > li > ul > li > div {
            background-color: #f4f4f4;
        }

    </style>
</head>
<body>

<main>
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 235px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img src="<?php echo base_url(); ?>/assets/dikpora_logobulet-min.png" width="width 35">
            <span class="fs-4 ms-2">Panel Admin</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>" class="nav-link text-white">
                    <i class="bi bi-house"></i>&nbsp;
                    Beranda
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>/dashboard" class="nav-link text-white<?php if($controller == 'dashboard') echo ' active'; ?>">
                    <i class="bi bi-speedometer"></i>&nbsp;
                    Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>/post" class="nav-link text-white<?php if($controller == 'post') echo ' active'; ?>">
                    <i class="bi bi-clipboard"></i>&nbsp;
                    Postingan
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>/page" class="nav-link text-white<?php if($controller == 'page') echo ' active'; ?>">
                    <i class="bi bi-file-post"></i>&nbsp;
                    Halaman
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>/comment" class="nav-link text-white<?php if($controller == 'comment') echo ' active'; ?>">
                    <i class="bi bi-chat-dots"></i>&nbsp;
                    Komentar
                    <?php if($unapproveComment): ?>
                        <span class="badge bg-warning text-dark rounded-pill float-end"><?php echo $unapproveComment; ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('media?t=img'); ?>" class="nav-link text-white">
                    <i class="bi bi-camera"></i>&nbsp;
                    Media
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>/document/new?category=transparansi" class="nav-link text-white<?php if($controller == 'document' && @$_GET['category'] == 'transparansi') echo ' active'; ?>">
                    <i class="bi bi-download"></i>&nbsp;
                    Transparansi
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>/document/new?category=download" class="nav-link text-white<?php if($controller == 'document' && (@$_GET['category'] == 'download' OR @$_GET['category'] == 'umum')) echo ' active'; ?>">
                    <i class="bi bi-download"></i>&nbsp;
                    Download
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>/service" class="nav-link text-white<?php if($controller == 'service') echo ' active'; ?>">
                    <i class="bi bi-person-workspace"></i>&nbsp;
                    Pelayanan
                    <?php if($unapproveService): ?>
                    <span class="badge bg-warning text-dark rounded-pill float-end"><?php echo $unapproveService; ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <?php if(session()->level <= 2): ?>
            <li>
                <a href="<?php echo base_url(); ?>/user" class="nav-link text-white<?php if($controller == 'user') echo ' active'; ?>">
                    <i class="bi bi-person-fill"></i>&nbsp;
                    User
                </a>
            </li>
            <?php endif; ?>
            <li>
                <a href="<?php echo base_url(); ?>/option" class="nav-link text-white<?php if($controller == 'option') echo ' active'; ?>">
                    <i class="bi bi-tools"></i>&nbsp;
                    Options
                </a>
            </li>
        </ul>
        <hr>
        <ul class="nav nav-pills flex-column">
            <li>
                <a href="<?php echo base_url(); ?>/authentication/logout" class="nav-link text-white">
                    <i class="bi bi-box-arrow-right"></i>&nbsp;
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <div class="d-block py-3 px-2" style="overflow-y: visible; overflow-x: auto; width: 100%; background-color: #ebebeb;">