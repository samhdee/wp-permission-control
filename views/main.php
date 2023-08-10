<style>
    .nav-tab {
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        transition: background-color .15s ease;
    }
</style>

<div class="wrap">
    <h1>
        <?php echo esc_html(get_admin_page_title()) ?>
    </h1>

    <nav class="nav-tab-wrapper">
        <a
            href="?page=permissions_plugin&tab=categories"
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


    <?php
        switch ($tab) {
            case 'categories':
            case 'labels':
            case 'posts':
            case 'users':
                require $tab;
                break;

            default:
                return;
        } ?>
</div>