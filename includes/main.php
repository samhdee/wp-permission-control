<div class="wrap">
    <h1>
        <?php echo esc_html(get_admin_page_title()) ?>
    </h1>

    <nav class="nav-tab-wrapper">
        <a
            href="?page=permissions_plugin"
            class="nav-tab<?php if (empty($tab)): ?> nav-tab-active<?php endif ?>"
        >
            Catégories
        </a>
        <a
            href="?page=permissions_plugin&tab=labels"
            class="nav-tab<?php if ($tab === 'labels'): ?> nav-tab-active<?php endif ?>"
        >
            Étiquettes
        </a>
        <a
            href="?page=permissions_plugin&tab=posts"
            class="nav-tab<?php if ($tab === 'posts'): ?> nav-tab-active<?php endif ?>"
        >
            Posts
        </a>
        <a
            href="?page=permissions_plugin&tab=users"
            class="nav-tab<?php if ($tab === 'users'): ?> nav-tab-active<?php endif ?>"
        >
            Utilisateurs
        </a>
    </nav>

    <div id="permission-control-admin" class="wrap">
        <div>
            <a href="#" class="page-title-action show-add-permissions-form">Ajouter</a>
        </div>

        <?php $table->display() ?>

        <div>
            <a href="#" class="page-title-action show-add-permissions-form">Ajouter</a>
        </div>

        <?php require 'add_form.php' ?>
    </div>
</div>