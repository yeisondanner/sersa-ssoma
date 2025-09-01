<!-- Essential javascripts for application to work-->
<script src="<?= media() ?>/js/libraries/jquery-3.7.1.min.js"></script>
<!--Libreria de sweetalert-->
<script type="text/javascript" src="<?= media() ?>/js/libraries/toastr.min.js"></script>
<script src="<?= media() ?>/js/libraries/popper.min.js"></script>
<script src="<?= media() ?>/js/libraries/bootstrap.min.js"></script>
<!-- Data table plugin-->
<script type="text/javascript" src="<?= media() ?>/js/libraries/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= media() ?>/js/libraries/plugins/dataTables.bootstrap.min.js"></script>

<!-- Buttons for DataTables-->
<script type="text/javascript" language="javascript"
    src="<?= media() ?>/js/libraries/plugins/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="<?= media() ?>/js/libraries/plugins/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="<?= media() ?>/js/libraries/plugins/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="<?= media() ?>/js/libraries/plugins/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript"
    src="<?= media() ?>/js/libraries/plugins/buttons.html5.min.js"></script>
<!--Libreria prinicipal de la app-->
<script src="<?= media() ?>/js/libraries/main.js"></script>
<!--Libreria que valida la sesion de usuario-->
<script src="<?= media() ?>/js/libraries/validateSesionActivity.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="<?= media() ?>/js/libraries/plugins/pace.min.js"></script>

<!--Librerias de la view-->
<?= require_once "./Views/App/" . ucfirst($data["page_container"]) . "/Libraries/foot.php"; ?>
<!-- Page specific javascripts-->
<script type="text/javascript">
    const base_url = "<?= base_url(); ?>";
</script>
<script
    src="<?= media() ?>/js/app/<?= strtolower($data["page_container"]) ?>/functions_<?= $data["page_js_css"] ?>.js"></script>

</body>

</html>