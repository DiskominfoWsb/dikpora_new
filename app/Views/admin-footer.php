    </div>
</main>
<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<!-- JQuery UI -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
<!-- CKEditor -->
<script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- JQuery Magnify -->
<script src="<?php echo base_url(); ?>/plugin/magnify/js/jquery.magnify.min.js"></script>
<!-- Core theme JS-->
<script src="<?php echo base_url(); ?>/js/admin_scripts.js?<?php echo now(); ?>"></script>
<script>

    <?php if($controller == 'option'): ?>
    //sortable menu box
    $('.menu-sortable').sortable({revert: true});

    //remove menu box
    $(document).on('click','.menu-drop',function() {
        $(this).parent().parent().parent().remove();
    });

    //add new menu box
    function formMenuSortable(title, id, url='#', parent=0) {
        form = '<li class="d-block my-1">';
        form += '<div class="py-2 ps-3 pe-2 border border-1 cursor-compass">';
        form += '<div class="float-end me-1">';
        form += '<span class="d-inline-block me-2 pe-2 fw-bold cursor-pointer menu-plus" parent-target="#parent-'+id+'">+</span>';
        form += '<span class="d-inline-block fw-bold text-danger cursor-pointer menu-drop">x</span>';
        form += '</div>';
        form += '<div>'+title+'</div>';
        form += '<input type="hidden" id="menu-'+id+'" name="menu-id['+parent+'][]" value="'+id+'">';
        form += '<input type="hidden" id="title-'+id+'" name="menu-title['+id+']" value="'+safeText(title)+'">';
        form += '<input type="hidden" id="url-'+id+'" name="menu-url['+id+']" value="'+url+'">';
        form += '</div>';
        form += '<ul id="parent-'+id+'" class="menu-sortable"><!-- Diisi dari table option menu_tree --></ul>';
        form += '</li>';
        return form;
    }
    function safeText(a) {
        return a
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    //main menu
    $('#menu-new-button').click(function() {
        var id      = 'n'+Date.now();
        var title   = $('#menu-new-title').val();
        if(title == '') title = 'Judul';
        var url     = $('#menu-new-url').val();
        if(url == '') url = '#';
        $('#parent-0').append(formMenuSortable(title,id,url));
        $('#canvasNavMenuNew').scrollTop($('#canvasNavMenuNew')[0].scrollHeight);
    });
    function menuNewStatic(title, id, url='#', parent=0) {
        if(title == '') title = 'Judul';
        if(url == '') url = '#';
        $('#parent-0').append(formMenuSortable(title,id,url,parent));
        $('#canvasNavMenuNew').scrollTop($('#canvasNavMenuNew')[0].scrollHeight);
    }
    function menuNewDynamic(title, id, url='#', parent=0) {
        if(title == '') title = 'Judul';
        if(url == '') url = '#';
        $('#parent-0').append(formMenuSortable(title,id,url,parent));
        $('#canvasNavMenuNew').scrollTop($('#canvasNavMenuNew')[0].scrollHeight);
    }

    //menu child
    $('#menu-child-new-button').click(function() {
        var id      = 'n'+Date.now();
        var title   = $('#menu-child-new-title').val();
        parentID    = $('#menu-child-parent').val();
        parentRawID = parentID.replace('#parent-', '');
        if(title == '') title = 'Judul';
        var url     = $('#menu-child-new-url').val();
        if(url == '') url = '#';
        $(parentID).append(formMenuSortable(title,id,url,parentRawID));
        $('.menu-sortable').sortable({revert: true});
    });
    function menuChildNewStatic(title, id, url='#') {
        if(title == '') title = 'Judul';
        if(url == '') url = '#';
        parentID    = $('#menu-child-parent').val();
        parentRawID = parentID.replace('#parent-', '');
        $(parentID).append(formMenuSortable(title,id,url,parentRawID));
        $('.menu-sortable').sortable({revert: true});
    }
    function menuChildNewDynamic(title, id, url='#') {
        if(title == '') title = 'Judul';
        if(url == '') url = '#';
        parentID    = $('#menu-child-parent').val();
        parentRawID = parentID.replace('#parent-', '');
        $(parentID).append(formMenuSortable(title,id,url,parentRawID));
        $('.menu-sortable').sortable({revert: true});
    }

    const modalMenuChild = new bootstrap.Modal('#modal-menu-child', {
        keyboard: false
    });
    $(document).on('click', '.menu-plus', function(){
        parentID = $(this).attr('parent-target');
        $('#menu-child-parent').val(parentID);
        modalMenuChild.show();
    });

    <?php endif; ?>

    /**
     * Khusus jenis transparansi
     */
    function convertToSlug(Text) {
        return Text.toLowerCase()
            .replace(/ /g, '-')
            .replace(/[^\w-]+/g, '');
    }
    function hapusJenisTransparansi(slug='',preClass='.jenis-transparansi-') {
        if(slug != '' || slug != null) {
            $.ajax({
                type: 'GET',
                data: {slug: slug},
                url: '<?php echo base_url('document/drop-jenis-transparansi'); ?>',
                success: function() {
                    $(preClass+slug).remove();
                    refreshListJenisTransparansi('#subCategoryDynamic');
                },
                error: function() {
                    alert('Koneksi bermasalah!');
                }
            });
        }else {
            alert('Invalid slug!');
        }
    }
    function getJenisTransparansi(name='jenis_transparansi') {
        $('#daftarJenisTransparansi').html('Memuat data...');
        $.ajax({
            type: 'GET',
            data: {option_name: name},
            url: '<?php echo base_url('document/get-jenis-transparansi'); ?>',
            success: function(data) {
                data = JSON.parse(data);
                jenisku = '';
                for(i=0;i<data.length;i++) {
                    jenisku += formJenisTransparansi(data[i].title,data[i].slug);
                    $('#daftarJenisTransparansi').html(jenisku);
                }
            },
            error: function() {
                alert('Koneksi bermasalah!');
            }
        });
    }
    function refreshListJenisTransparansi(id='#subCategoryDynamic') {
        $.ajax({
            type: 'GET',
            data: {option_name: 'jenis_transparansi'},
            url: '<?php echo base_url('document/get-jenis-transparansi'); ?>',
            success: function(data) {
                data = JSON.parse(data);
                jenisku = '';
                for(i=0;i<data.length;i++) {
                    jenisku += '<option value="'+data[i].slug+'">'+data[i].title+'</option>';
                    $(id).html(jenisku);
                }
            },
            error: function() {
                alert('Koneksi bermasalah!');
            }
        });
    }
    function formJenisTransparansi(titleku,slug='') {
        slug = (slug == '') ? convertToSlug(titleku) : slug;
        jenisku = '<div class="d-inline-block py-1 px-2 me-2 mb-2 border rounded jenis-transparansi-'+slug+'" style="background-color: #f5f5f5;">';
        jenisku += titleku;
        jenisku += '<span class="ps-1 cursor-pointer text-danger" onclick="hapusJenisTransparansi(\''+slug+'\')">x</span></div>';
        return jenisku;
    }
    function tambahJenisTransparansi(id='#daftarJenisTransparansi') {
        titleku = $('#judulJenisTransparansi').val();
        $('#judulJenisTransparansi').val('');
        $.ajax({
            type: 'GET',
            data: {title: titleku},
            url: '<?php echo base_url('document/add-jenis-transparansi'); ?>',
            success: function() {
                $(id).append(formJenisTransparansi(titleku));
                refreshListJenisTransparansi('#subCategoryDynamic');
            },
            error: function() {
                alert('Gagal menambah data baru!');
            }
        });
    }
    function showModal() {
        getJenisTransparansi();
        modalJenisTransparansi = new bootstrap.Modal('#modalJenisTransparansi', {keyboard: false});
        modalJenisTransparansi.show();
    }
    function hideModal() {
        modalJenisTransparansi.hide();
    }

    <?php if($controller == 'media'): ?>
    $('.media-item .media-item-title').css('opacity','0');
    $('.media-item').mouseover(function (){
        $(this).children('.media-item-title').css('opacity','1');
    });
    $('.media-item').mouseleave(function (){
        $(this).children('.media-item-title').css('opacity','0')
    });
    $('.media-item').click(function(){
        $(this).children('div').children('div').children('a[title=Lihat]').focus();
    });
    <?php endif; ?>

</script>
</body>
</html>