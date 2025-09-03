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
        <div class="col-md-6 mb-3">
            <a href="#">
                <div class="card card-equal card-hover w-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-3 p-2 rounded">
                            <div class="icon-circle mr-3"><i class="fa fa-university" aria-hidden="true"></i></div>
                            <div>
                                <h5 class="card-title mb-0">Tarjeta Premium</h5>
                                <small>Glassmorphism Style</small>
                            </div>
                        </div>
                        <p class="card-text">Esta tarjeta tiene un efecto de vidrio esmerilado moderno, elegante y
                            atractivo para el usuario final. Perfecto para interfaces limpias y minimalistas.</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 2 -->
        <div class="col-md-6 mb-3">
            <a href="#">
                <div class="card card-equal card-hover w-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-3 p-2 rounded">
                            <div class="icon-circle mr-3"><i class="fa fa-star" aria-hidden="true"></i></div>
                            <div>
                                <h5 class="card-title mb-0">Otra Tarjeta</h5>
                                <small>Efecto vidrio</small>
                            </div>
                        </div>
                        <p class="card-text">Cuando pasas el mouse, la tarjeta se eleva suavemente y mantiene su
                            transparencia con el blur de fondo. Efecto elegante que sorprende.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>
<?= footerAdmin($data) ?>