<?php

//silence is golden

$data = [
    [
        'id'        => 'modalTools1',
        'icon'      => 'http://localhost/dpupr/public/assets/icon-tool/panji_icon.png',
        'content'   => '
                        <p class="fw-bolder">Kepanjangan :</p>
                        <ul>
                            <li>Pendampingan Perijinan Bangunan Gedung</li>
                        </ul>
                        <p class="fw-bolder">Layanan yang diberikan :</p>
                        <ul>
                            <li>Sosialisasi PBG &amp; SLF</li>
                            <li>Pendampingan Perijinan melalui SIMBG</li>
                        </ul>
                        <p class="fw-bolder">Bisnis Proses :</p>
                        <ul>
                            <li>Website Edukasi</li>
                            <li>Menyediakan nomor WA khusus untuk pendampingan SIMBG</li>
                        </ul>
                        ',
    ],
    [
        'id'        => 'modalTools2',
        'icon'      => 'http://localhost/dpupr/public/assets/icon-tool/petarung_icon.png',
        'content'   => '
                        <p class="fw-bolder">Kepanjangan :</p>
                        <ul>
                            <li>Pengendalian Tata Ruang</li>
                        </ul>
                        <p class="fw-bolder">Layanan yang diberikan :</p>
                        <ul>
                            <li>Persetujuan KKPR berbasis web</li>
                            <li>Edukasi Pengendalian Tata Ruang</li>
                        </ul>
                        <p class="fw-bolder">Bisnis Proses :</p>
                        <ul>
                            <li>WA group Forum Tata Ruang</li>
                            <li>Website edukasi tata ruang</li>
                            <li>Tanda tangan digital Persetujuan KKPR</li>
                        </ul>
                        ',
    ],
    [
        'id'        => 'modalTools3',
        'icon'      => 'http://localhost/dpupr/public/assets/icon-tool/bolo-serayu_icon.png',
        'content'   => '
                        <p class="fw-bolder">Kepanjangan :</p>
                        <ul>
                            <li>Bogowonto, Luk Ulo, Serayu</li>
                        </ul>
                        <p class="fw-bolder">Layanan yang diberikan :</p>
                        <ul>
                            <li>Pembentukan Wadah Koordinasi Pengelolaan SDA > GNKPA sampai tingkat desa</li>
                            <li>Edukasi dan Promosi website</li>
                        </ul>
                        <p class="fw-bolder">Bisnis Proses :</p>
                        <ul>
                            <li>Membentuk kelembagaan koordinasi sampai tingkat desa</li>
                            <li>Kerjasama pemeliharaan SDA</li>
                            <li>Marketing Website dan Networking medsos</li>
                        </ul>
                        ',
    ],
    [
        'id'        => 'modalTools4',
        'icon'      => 'http://localhost/dpupr/public/assets/icon-tool/sembada_icon.png',
        'content'   => '
                        <p class="fw-bolder">Kepanjangan :</p>
                        <ul>
                            <li>Sesarengan Mbangun Dalan</li>
                        </ul>
                        <p class="fw-bolder">Layanan yang diberikan :</p>
                        <ul>
                            <li>Kolaborasi pembangunan jalan dengan masyarakat dan dunia usaha</li>
                            <li>Forum Kolaborasi Kecamatan</li>
                        </ul>
                        <p class="fw-bolder">Bisnis Proses :</p>
                        <ul>
                            <li>Sosialisasi rencana T1 mendorong partisipasi sharing incash/inkind</li>
                            <li>Kerjasama pembangunan dan pemeliharaan jalan</li>
                            <li>Marketing website dan Networking Medsos</li>
                        </ul>
                        ',
    ],
];

echo '<textarea>'. json_encode($data) .'</textarea>';