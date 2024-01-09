<div class="container">
    <h3>
        Options
    </h3>
    <?php if(session()->alert): ?>
        <div class="alert alert-<?php echo session()->alert['type']; ?>">
            <?php echo session()->alert['message']; ?>
        </div>
    <?php endif; ?>
    <article class="">
        <form method="post" action="<?php echo base_url(); ?>/option/save" enctype="multipart/form-data">
            <div class="row">

                <div class="col-lg-5 pe-0 form-group">
                    <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Menu</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Halaman</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Kategori</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="border-start border-end border-bottom p-3" style="height: 350px; max-height: 350px; overflow-y: auto; background: #fff;">
                                <p class="my-1 fst-italic">Tambah link menu manual dan/ halaman statis</p>
                                <div class="form-group">
                                    <input type="text" id="menu-new-title" name="menu-new-title" class="form-control form-control-sm my-2" placeholder="Judul" style="width: 60%;">
                                    <input type="text" id="menu-new-url" name="menu-new-url" class="form-control form-control-sm" my-2 placeholder="URL">
                                    <button type="button" id="menu-new-button" class="btn btn-sm btn-primary my-2">Tambahkan &raquo;</button>
                                </div>
                                <p class="my-1 fst-italic">Halaman statis yang tersedia:</p>
                                <ul class="p-0">
                                    <?php for($i=0; $i<count($halamanStatis); $i++): ?>
                                    <li class="d-block my-1">
                                        <div class="py-2 ps-3 pe-2 border border-1">
                                            <div class="float-end me-1">
                                                <span class="d-inline-block px-2 fw-bold cursor-pointer" onclick="menuNewStatic(<?php echo "'".addslashes($halamanStatis[$i]['title'])."','s".$halamanStatis[$i]['ID']."','".$halamanStatis[$i]['url']."'"; ?>)">
                                                    &raquo;
                                                </span>
                                            </div>
                                            <div><?php echo $halamanStatis[$i]['title']; ?></div>
                                        </div>
                                    </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <div class="border-start border-end border-bottom p-3" style="height: 350px; max-height: 350px; overflow-y: auto; background: #fff;">
                                <p class="my-1 fst-italic">Halaman dinamis aktif:</p>
                                <ul class="p-0">
                                    <?php for($i=0; $i<count($halamanDinamis); $i++): ?>
                                        <li class="d-block my-1">
                                            <div class="py-2 ps-3 pe-2 border border-1">
                                                <div class="float-end me-1">
                                                <span class="d-inline-block px-2 fw-bold cursor-pointer" onclick="menuNewDynamic(<?php echo "'".addslashes($halamanDinamis[$i]['title'])."','p".$halamanDinamis[$i]['ID']."','".base_url('halaman/'.$halamanDinamis[$i]['slug'])."'"; ?>)">
                                                    &raquo;
                                                </span>
                                                </div>
                                                <div><?php echo $halamanDinamis[$i]['title']; ?></div>
                                            </div>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                            <div class="border-start border-end border-bottom p-3" style="height: 350px; max-height: 350px; overflow-y: auto; background: #fff;">
                                <p class="my-1 fst-italic">Kategori dinamis aktif:</p>
                                <ul class="p-0">
                                    <?php for($i=0; $i<count($kategoriDinamis); $i++): ?>
                                        <li class="d-block my-1">
                                            <div class="py-2 ps-3 pe-2 border border-1">
                                                <div class="float-end me-1">
                                                <span class="d-inline-block px-2 fw-bold cursor-pointer" onclick="menuNewStatic(<?php echo "'".addslashes($kategoriDinamis[$i]['name'])."','c".$kategoriDinamis[$i]['ID']."','".base_url('artikel/arsip/'.$kategoriDinamis[$i]['ID'])."'"; ?>)">
                                                    &raquo;
                                                </span>
                                                </div>
                                                <div><?php echo $kategoriDinamis[$i]['name']; ?></div>
                                            </div>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-1 text-center">
                    <br><br><br><br><br><br><br><br>
                    <i class="bi bi-chevron-right fs-2"></i>
                </div>

                <div id="canvasNavMenuNew" class="col-lg-6 ps-0 form-group" style="height: 388px; max-height: 388px; overflow-y: scroll;">
                    <ul id="parent-0" class="menu-sortable m-0 p-0">
                        <?php echo $navMenuNew; ?>
                    </ul>
                </div>

                <div class="col-12 mb-1 px-3"><hr class="border-1"></div>

                <div class="col-lg-6 form-group">
                    <h6 class="mb-2">
                        Banner Popup
                        <?php
                        if($bannerWelcome)
                        {
                            echo '&nbsp;<a href="'.$bannerWelcome['image'].'" data-magnify="gallery">';
                            echo '<i class="bi bi-image"></i>';
                            echo '</a>';
                        }
                        ?>
                    </h6>
                    <input type="file" name="fileBannerWelcome" class="form-control form-control-sm" accept=".jpg,.jpeg,.png">
                    <p class="m-0 fst-italic text-secondary">upload gambar baru jika ingin diubah</p>
                </div>

                <div class="col-lg-6 form-group">
                    <h6 class="mb-2">
                        Banner Pengumuman
                        <?php
                        if($bannerPengumuman)
                        {
                            echo '&nbsp;<a href="'.$bannerPengumuman['image'].'" data-magnify="gallery">';
                            echo '<i class="bi bi-image"></i>';
                            echo '</a>';
                        }
                        ?>
                    </h6>
                    <input type="file" name="fileBannerPengumuman" class="form-control form-control-sm" accept=".jpg,.jpeg,.png">
                    <p class="m-0 fst-italic text-secondary">upload gambar baru jika ingin diubah</p>
                </div>

                <div class="col-12 px-3"><hr class="border-1"></div>

                <h6 class="mb-2"><i class="bi bi-card-list"></i> Layanan Inovasi</h6>
                <?php for($i=0; $i<count($layananInovasi); $i++): ?>
                <div class="col-lg-6 mb-2">
                    <div class="form-group mb-2">
                        <input type="hidden" name="modalToolsId[<?php echo $i; ?>]" value="<?php echo $layananInovasi[$i]->id; ?>">
                        <input type="hidden" name="modalToolsIcon[<?php echo $i; ?>]" value="<?php echo str_replace('devdpupr','dpupr',$layananInovasi[$i]->icon); ?>">
                        <div class="input-group input-group-sm mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon<?php echo $i; ?>" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">Judul</span>
                            </div>
                            <input type="text" name="modalToolsTitle[<?php echo $i; ?>]" class="form-control form-control-sm" placeholder="Judul ..." value="<?php //echo $layananInovasi[$i]->title; ?>" aria-label="Judul" aria-describedby="basic-addon<?php //echo $i; ?>">
                        </div>
                        <textarea id="<?php echo $layananInovasi[$i]->id; ?>" name="modalToolsContent[<?php echo $i; ?>]" class="form-control form-control-sm" rows="5"><?php //echo str_replace('<', '&lt;', $layananInovasi[$i]->content); ?></textarea>
                    </div>
                </div>
                <?php endfor; ?>

                <div class="col-12 mb-1 px-3"><hr class="border-1"></div>

                <h6 class="mb-2"><i class="bi bi-tools"></i> Icon Tools Informasi Lain</h6>
                <?php for($i=0; $i<count($icon); $i++): ?>
                <?php for($j=0; $j<count($icon[$i]); $j++): ?>
                <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-2">
                    <div class="d-flex justify-content-center align-items-center bg-light rounded-top" style="height: 150px;">
                        <img src="<?php echo base_url('assets/icon-tool/'.$icon[$i][$j][0]); ?>" style="width: 75px; height: auto;">
                    </div>
                    <div class="form-group">
                        <input type="file" name="iconToolImage[<?php echo $i;?>][<?php echo $j;?>]" class="form-control form-control-sm">
                        <input type="text" name="iconToolTitle[<?php echo $i;?>][<?php echo $j;?>]" class="form-control form-control-sm" value="<?php //echo $icon[$i][$j][1]; ?>" placeholder="Judul ...">
                        <input type="text" name="iconToolUrl[<?php echo $i;?>][<?php echo $j;?>]" class="form-control form-control-sm fst-italic" value="<?php //echo $icon[$i][$j][2]; ?>" placeholder="URL ...">
                    </div>
                </div>
                <?php endfor; ?>
                <?php endfor; ?>

                <div class="col-12 mb-1 px-3"><hr class="border-1"></div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <h6 class="mb-2"><i class="bi bi-youtube text-danger"></i> Social &dash; Youtube</h6>
                    <div class="form-group">
                        <input type="text" name="socialYoutube" value="<?php echo $socials['youtube']; ?>" class="form-control form-control-sm mb-1 fst-italic">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <h6 class="mb-2"><i class="bi bi-instagram text-dark"></i> Social &dash; Instagram</h6>
                    <div class="form-group">
                        <input type="text" name="socialInstagram" value="<?php echo $socials['instagram']; ?>" class="form-control form-control-sm mb-1 fst-italic">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <h6 class="mb-2"><i class="bi bi-facebook text-primary"></i> Social &dash; Facebook</h6>
                    <div class="form-group">
                        <input type="text" name="socialFacebook" value="<?php echo $socials['facebook']; ?>" class="form-control form-control-sm mb-1 fst-italic">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <h6 class="mb-2"><i class="bi bi-twitter text-info"></i> Social &dash; Twitter</h6>
                    <div class="form-group">
                        <input type="text" name="socialTwitter" value="<?php echo $socials['twitter']; ?>" class="form-control form-control-sm mb-1 fst-italic">
                    </div>
                </div>

                <div class="col-12 mb-1 px-3"><hr class="border-1"></div>

                <h6 class="mb-2">Link Tautan Terkait &nbsp;<a href="#" id="tambahLink" class="a-normal">+</a> </h6>
                <?php for($i=0; $i<count($externalLink); $i++): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2 external-link">
                    <div class="form-group">
                        <input type="text" name="exLinkTitle[]" value="<?php echo $externalLink[$i]['title']; ?>" class="form-control form-control-sm mb-1">
                        <input type="text" name="exLinkUrl[]" value="<?php echo $externalLink[$i]['url']; ?>" class="form-control form-control-sm fst-italic">
                    </div>
                </div>
                <?php endfor; ?>

                <div id="siteIdentity" class="col-12 mb-1 px-3"><hr class="border-1"></div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <h6 class="mb-2"><i class="bi bi-pin-map-fill"></i> Kontak &dash; Alamat</h6>
                    <div class="form-group">
                        <input type="text" name="contactAddress" value="<?php echo $contactUs['address']; ?>" class="form-control form-control-sm mb-1">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <h6 class="mb-2"><i class="bi bi-telephone-outbound-fill"></i> Kontak &dash; Telepon</h6>
                    <div class="form-group">
                        <input type="text" name="contactPhone" value="<?php echo $contactUs['phone']; ?>" class="form-control form-control-sm mb-1">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <h6 class="mb-2"><i class="bi bi-envelope-fill"></i> Kontak &dash; Email</h6>
                    <div class="form-group">
                        <input type="text" name="contactEmail" value="<?php echo $contactUs['email']; ?>" class="form-control form-control-sm mb-1">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <h6 class="mb-2"><i class="bi bi-globe"></i> Kontak &dash; Website</h6>
                    <div class="form-group">
                        <input type="text" name="contactWebsite" value="<?php echo $contactUs['website']; ?>" class="form-control form-control-sm mb-1">
                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </article>

</div>


<!-- Modal menu -->
<div id="modal-menu-child" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" id="menu-child-parent" value="">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Sub Menu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-3">
                <ul class="nav nav-tabs" id="tabMenuChild" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab-child" data-bs-toggle="tab" data-bs-target="#home-tab-pane-child" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Menu</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab-child" data-bs-toggle="tab" data-bs-target="#profile-tab-pane-child" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Halaman</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab-child" data-bs-toggle="tab" data-bs-target="#contact-tab-pane-child" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Kategori</button>
                    </li>
                </ul>
                <div class="tab-content" id="tabContentChild">
                    <div class="tab-pane fade show active" id="home-tab-pane-child" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <div class="border-start border-end border-bottom p-3" style="height: 400px; max-height: 400px; overflow-y: auto; background: #fff;">
                            <p class="my-1 fst-italic">Tambah link menu manual dan/ halaman statis</p>
                            <div class="form-group">
                                <input type="text" id="menu-child-new-title" name="menu-child-new-title" class="form-control form-control-sm my-2" placeholder="Judul" style="width: 75%;">
                                <input type="text" id="menu-child-new-url" name="menu-child-new-url" class="form-control form-control-sm" my-2 placeholder="URL">
                                <button type="button" id="menu-child-new-button" class="btn btn-sm btn-primary my-2">Tambahkan &raquo;</button>
                            </div>
                            <p class="my-1 fst-italic">Halaman statis yang tersedia:</p>
                            <ul class="p-0">
                                <?php for($i=0; $i<count($halamanStatis); $i++): ?>
                                    <li class="d-block my-1">
                                        <div class="py-2 ps-3 pe-2 border border-1">
                                            <div class="float-end me-1">
                                                <span class="d-inline-block px-2 fw-bold cursor-pointer" onclick="menuChildNewStatic(<?php echo "'".addslashes($halamanStatis[$i]['title'])."','s".$halamanStatis[$i]['ID']."','".$halamanStatis[$i]['url']."'"; ?>)">
                                                    &raquo;
                                                </span>
                                            </div>
                                            <div><?php echo $halamanStatis[$i]['title']; ?></div>
                                        </div>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile-tab-pane-child" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <div class="border-start border-end border-bottom p-3" style="height: 350px; max-height: 350px; overflow-y: auto; background: #fff;">
                            <p class="my-1 fst-italic">Halaman dinamis aktif:</p>
                            <ul class="p-0">
                                <?php for($i=0; $i<count($halamanDinamis); $i++): ?>
                                    <li class="d-block my-1">
                                        <div class="py-2 ps-3 pe-2 border border-1">
                                            <div class="float-end me-1">
                                                <span class="d-inline-block px-2 fw-bold cursor-pointer" onclick="menuChildNewDynamic(<?php echo "'".addslashes($halamanDinamis[$i]['title'])."','p".$halamanDinamis[$i]['ID']."','".base_url('halaman/'.$halamanDinamis[$i]['slug'])."'"; ?>)">
                                                    &raquo;
                                                </span>
                                            </div>
                                            <div><?php echo $halamanDinamis[$i]['title']; ?></div>
                                        </div>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact-tab-pane-child" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        <div class="border-start border-end border-bottom p-3" style="height: 350px; max-height: 350px; overflow-y: auto; background: #fff;">
                            <p class="my-1 fst-italic">Kategori dinamis aktif:</p>
                            <ul class="p-0">
                                <?php for($i=0; $i<count($kategoriDinamis); $i++): ?>
                                    <li class="d-block my-1">
                                        <div class="py-2 ps-3 pe-2 border border-1">
                                            <div class="float-end me-1">
                                                <span class="d-inline-block px-2 fw-bold cursor-pointer" onclick="menuChildNewStatic(<?php echo "'".addslashes($kategoriDinamis[$i]['name'])."','c".$kategoriDinamis[$i]['ID']."','".base_url('artikel/arsip/'.$kategoriDinamis[$i]['ID'])."'"; ?>)">
                                                    &raquo;
                                                </span>
                                            </div>
                                            <div><?php echo $kategoriDinamis[$i]['name']; ?></div>
                                        </div>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>