<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $article->title; ?></title>
    <meta name="title" content="<?php echo $article->title; ?>">
    <meta name="description" content="<?php echo str_replace("\n"," ",trim(substr(strip_tags(strip_image_tags($article->content)),0,150))); ?>">
    <meta name="keywords" content="<?php echo $article->tags; ?>">
    <meta name="author" content="Dikpora Kabupaten Wonosobo">
    <!-- Socials share -->
    <meta property="og:site_name"   content="Dikpora Kabupaten Wonosobo">
    <meta property="og:url"         content="<?php echo current_url(); ?>">
    <meta property="og:locale"      content="id_ID">
    <meta property="og:type"        content="article">
    <meta property="og:title"       content="<?php echo $article->title; ?>">
    <meta property="og:description" content="<?php echo str_replace("\n"," ",trim(substr(strip_tags(strip_image_tags($article->content)),0,150))); ?>">
    <meta property="og:image"       content="<?php if(@$article->featured_image){echo $article->featured_image;}else{echo base_url('assets/dikpora_logobulet.png');} ?>">
    <meta name="twitter:site"           content="@Dikpora Kabupaten Wonosobo">
    <meta name="twitter:card"           content="summary">
    <meta name="twitter:title"          content="<?php echo $article->title; ?>">
    <meta name="twitter:description"    content="<?php echo str_replace("\n"," ",trim(substr(strip_tags(strip_image_tags($article->content)),0,150))); ?>">
    <meta name="twitter:creator"        content="@Dikpora Kabupaten Wonosobo">
    <meta name="twitter:image"          content="<?php if(@$article->featured_image){echo $article->featured_image;}else{echo base_url('assets/dikpora_logobulet.png');} ?>">
    <!-- Favicon-->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>/assets/dikpora_logobulet.png">
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
    <style type="text/css">
        body {
            background-color: #ebebeb;
        }
        article {

        }
        img[alt='img-float-left'] {
            margin-top: 7px;
            margin-right: 8px;
        }
        img[alt='img-float-right'] {
            margin-top: 7px;
            margin-left: 8px;
        }
        img[alt='img-align-center'] {
            display: block;
            margin: auto;
            text-align: center;
        }

        #sidebar {
            margin: 0 1.25rem 0 1.25rem;
            border-radius: .75rem;
        }
        #sidebar .sidebar-header {
            background-color: #fc4a1a;
            opacity: .95;
        }
        #sidebar .sidebar-news {

        }
        #sidebar .sidebar-news .sidebar-header {
            border-top-left-radius: .75rem;
            border-top-right-radius: .75rem;
        }
        #sidebar .sidebar-news .sidebar-body {
            padding-left: 2rem;
            padding-right: 2rem;
        }
        #sidebar .sidebar-news .sidebar-body .sidebar-image {
            height: 125px;
            border-top-left-radius: .75rem;
            border-top-right-radius: .75rem;
            background-size: cover;
            background-position: center;
        }
        #sidebar .sidebar-news .sidebar-body .sidebar-title {
            background-image: url('<?php echo base_url(); ?>/assets/bg_footer3.png');
            background-size: cover;
            background-position: center center;
            border-bottom-left-radius: .75rem;
            border-bottom-right-radius: .75rem;
        }
        #sidebar .sidebar-tags .sidebar-header{
            border-bottom-left-radius: .75rem;
            border-bottom-right-radius: .75rem;
        }

        #article h1 {
            font-size: 26.5px;
        }
        #article article p {
            line-height: 1.5;
            font-size: 15.5px;
        }
    </style>
</head>

<body id="_top">
<!-- Page header with logo and tagline-->
<header id="header-article" class="sticky-top">
    <!-- Navbar brand collapsed-->
    <nav id="navku" class="navbar">
        <div class="container">
            <a class="d-block a-normal text-dark" href="<?php echo base_url(); ?>">
                <div id="brandku" class="d-flex justify-content-start align-items-start">
                    <div class="pe-2">
                        <img src="<?php echo base_url(); ?>/assets/logo-kabupaten-wonosobo-min.png" height="35" width="auto">
                    </div>
                    <div class="pe-4">
                        <small class="fw-bolder" style="line-height: 0;">PEMERINTAH DAERAH<br>KAB. WONOSOBO</small>
                    </div>
                    <div class="pe-2 cursor-pointer">
                        <img src="<?php echo base_url(); ?>/assets/dikpora_logobulet.png" height="35" width="auto">
                    </div>
                    <div class="mt-1 cursor-pointer">
                        <small class="fw-bolder">
                            <span><strong>DISDIKPORA</strong></span>
                            <span><br>KABUPATEN WONOSOBO</span>
                        </small>
                    </div>
                </div>
            </a>
            <div class="d-flex justify-content-end align-items-center">
                <ul class="navbarku">
                    <?php echo $menuNewTree1; ?>
                    <li>
                        <a href="<?php echo base_url('login'); ?>" class="py-1 px-3 text-light a-normal signup-light">
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
</header>