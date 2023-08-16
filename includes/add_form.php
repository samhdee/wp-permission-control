<div id="add_permission_form">
    <form method="POST" action="<?php echo admin_url('admin.php') ?>">
        <input type="hidden" name="action" value="wpc_add" />

        <div class="form-group">
            <div class="form-element">
                <select id="population_type_select">
                    <option value="">Type de population</option>
                    <option value="user">Utilisateur</option>
                    <option value="role">Rôle</option>
                </select>
            </div>

            <div class="form-element">
                <input
                    id="population_search"
                    class="thing_search"
                    type="text"
                    placeholder="Nom"
                    name="population_id"
                    size="32"
                    autocomplete="off"
                    data-taxo="population_type_select"
                    disabled />

                <i class="far fa-circle-xmark empty_search"></i>
                <div id="wpc_population_search" class="wpc_search_results"></div>

                <select id="role_select">
                    <option value="">Nom</option>
                    <option value="contributor">Contributeur·rice</option>
                    <option value="author">Auteur·rice</option>
                    <option value="editor">Éditeur·rice</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="form-element">
                <select id="content_type_select">
                    <option value="">Type de contenu</option>
                    <option value="category">Catégorie</option>
                    <option value="post_tag">Étiquette</option>
                    <option value="page">Page</option>
                    <option value="post">Post</option>
                </select>
            </div>

            <div class="form-element">
                <input
                    id="content_search"
                    class="thing_search"
                    type="text"
                    placeholder="Cible"
                    name="content_id"
                    size="32"
                    autocomplete="off"
                    data-taxo="content_type_select"
                    disabled />

                <i class="far fa-circle-xmark empty_search"></i>
                <div id="wpc_content_search" class="wpc_search_results"></div>
            </div>
        </div>

        <div class="form-group">
            <button id="cancel_add_permission">Annuler</button>
            <input type="submit" value="Do it!" name="submit" disabled />
        </div>
    </form>

</div>