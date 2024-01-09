<div class="container">

    <h3>Dashboard</h3>
    <?php if(session()->alert): ?>
    <div class="alert alert-<?php echo session()->alert['type']; ?>">
        <?php echo session()->alert['message']; ?>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mt-2 mb-2 justify-content-center align-items-center">
                        <i class="bi bi-clipboard fs-1"></i>
                    </div>
                    <h5 class="card-title text-center"><?php echo $postsCount; ?> Postingan</h5>
                    <div class="d-flex mt-3 mb-2 justify-content-center align-items-center">
                        <a href="<?php echo base_url('post'); ?>" class="btn btn-sm btn-primary">Lihat postingan &raquo;</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mt-2 mb-2 justify-content-center align-items-center">
                        <i class="bi bi-file-post fs-1"></i>
                    </div>
                    <h5 class="card-title text-center"><?php echo $pagesCount; ?> Halaman</h5>
                    <div class="d-flex mt-3 mb-2 justify-content-center align-items-center">
                        <a href="<?php echo base_url('page'); ?>" class="btn btn-sm btn-primary">Lihat halaman &raquo;</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mt-2 mb-2 justify-content-center align-items-center">
                        <i class="bi bi-chat-dots fs-1"></i>
                    </div>
                    <h5 class="card-title text-center"><?php echo $commentsCount; ?> Komentar</h5>
                    <div class="d-flex mt-3 mb-2 justify-content-center align-items-center">
                        <a href="<?php echo base_url('comment'); ?>" class="btn btn-sm btn-primary">Lihat komentar &raquo;</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mt-2 mb-2 justify-content-center align-items-center">
                        <i class="bi bi-person-workspace fs-1"></i>
                    </div>
                    <h5 class="card-title text-center"><?php echo $servicesCount; ?> Masukan</h5>
                    <div class="d-flex mt-3 mb-2 justify-content-center align-items-center">
                        <a href="<?php echo base_url('service'); ?>" class="btn btn-sm btn-primary">Lihat pelayanan &raquo;</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="mt-4">
                <canvas id="statistik-pengunjung" style="height: 350px;"></canvas>
            </div>
        </div>
        <!-- Chart.js -->
        <?php
            //buat label 12 bulan terakhir
            $arrayLabel     = [];
            $arrayData      = [];
            $currentYear    = date('Y', now());
            $currentMonth   = (int)date('m', now());
            $increment = 0;
            for($i=0; $i<12; $i++)
            {
                $bulanAngka = $currentMonth-$increment;
                $bulan = sprintf('%02d', $bulanAngka);
                array_push($arrayLabel, array_bulan($bulanAngka));
                array_push($arrayData, $monthlyCounter[$currentYear.'-'.$bulan]);
                $increment++;
                if($bulanAngka === 1)
                {
                    $currentYear--;
                    $currentMonth = 12;
                    $increment = 0;
                }
            }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const cctx = document.getElementById('statistik-pengunjung');
            new Chart(cctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_reverse($arrayLabel)); ?>,
                    datasets: [{
                        label: 'Kunjungan',
                        data: <?php echo json_encode(array_reverse($arrayData)); ?>,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Statistik Pengunjung Website'
                        }
                    }
                }
            });
        </script>

    </div>

</div>
