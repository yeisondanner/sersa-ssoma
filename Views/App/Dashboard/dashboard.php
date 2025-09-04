<?= headerAdmin($data) ?>
<main class="app-content">
    <div class="app-title pt-5">
        <div>
            <h1 class="text-primary"><i class="fa fa-dashboard"></i> <?= $data["page_title"] ?></h1>
            <p><?= $data["page_description"] ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a
                    href="<?= base_url() ?>/<?= $data['page_view'] ?>"><?= $data["page_title"] ?></a></li>
        </ul>
    </div>
    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-4 mb-4">
            <a href="#" class="card custom-card p-4 text-center h-100">
                <div class="icon-wrapper bg-primary mx-auto">
                    <i class="fa fa-wrench"></i>
                </div>
                <h5>Cambio de Disco Duro</h5>
                <p>Se reemplazó disco dañado de 1TB</p>
                <div class="date"><i class="fa fa-calendar"></i> 2025-09-04</div>
            </a>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4 mb-4">
            <a href="#" class="card custom-card p-4 text-center h-100">
                <div class="icon-wrapper bg-success mx-auto">
                    <i class="fa fa-cogs"></i>
                </div>
                <h5>Mantenimiento Preventivo</h5>
                <p>Limpieza interna y cambio de pasta térmica</p>
                <div class="date"><i class="fa fa-calendar"></i> 2025-09-01</div>
            </a>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4 mb-4">
            <a href="#" class="card custom-card p-4 text-center h-100">
                <div class="icon-wrapper bg-warning mx-auto">
                    <i class="fa fa-desktop"></i>
                </div>
                <h5>Actualización de Software</h5>
                <p>Se instaló la última versión del sistema operativo</p>
                <div class="date"><i class="fa fa-calendar"></i> 2025-08-30</div>
            </a>
        </div>
    </div>
</main>
<?= footerAdmin($data) ?>