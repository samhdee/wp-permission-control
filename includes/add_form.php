<div id="add_permission_form">
    <form method="POST" action="<?php echo admin_url('admin.php') ?>">
        <input type="hidden" name="action" value="upc_add" />

        <div class="form-group">
            <label for="type_select">Type</label>

            <select id="type_select">
                <option value=""></option>
                <option value="category">Catégorie</option>
                <option value="label">Étiquette</option>
                <option value="post">Post</option>
            </select>
        </div>

        <div class="form-group">
            <input
                id="user_search"
                class="thing_search"
                type="text"
                placeholder="Nom/rôle"
                name="user"
                size="40"
                autocomplete="off"
                disabled />
        </div>

        <div class="form-group">
            <input
                id="target_search"
                class="thing_search"
                type="text"
                placeholder="Cible"
                name="target"
                size="40"
                autocomplete="off"
                disabled />
        </div>

        <div class="form-group">
            <button id="cancel_add_permission">Annuler</button>
            <input type="submit" value="Do it!" name="submit" disabled />
        </div>
    </form>
</div>