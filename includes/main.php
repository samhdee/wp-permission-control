<div class="wrap">
    <h1>
        <?php echo esc_html(get_admin_page_title()) ?>
    </h1>

    <div id="permission_control_admin" class="wrap">
        <div>
            <a href="#" class="page-title-action show_add_permission_form">Ajouter</a>
        </div>

        <?php $table->display() ?>

        <div>
            <a href="#" class="page-title-action show_add_permission_form">Ajouter</a>
        </div>

        <?php require 'add_form.php' ?>
    </div>
</div>