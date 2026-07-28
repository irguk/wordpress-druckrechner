<?php
// Datei: admin/discount-table-page.php
global $wpdb;
$table_staffel = $wpdb->prefix . 'druck_staffelpreise';

// 1. Daten aus der NEUEN Tabelle laden
$results = $wpdb->get_results("SELECT * FROM $table_staffel ORDER BY name ASC, seiten_ab ASC, menge_ab ASC");

// Falls die Tabelle komplett leer ist, Fallback-Daten anzeigen (optional zum Befüllen)
if (empty($results)) {
    echo '<div class="notice notice-warning"><p>Die Rabatt-Tabelle ist leer. Bitte legen Sie die ersten Preisstufen an.</p></div>';
}
?>

<div class="wrap">
    <h1><span class="dashicons dashicons-forms"></span> Bindungs-Rabatte (Staffelpreise)</h1>

    <style>
        .staffel-table input[type="number"] { width: 85px; padding: 4px; }
        .staffel-table th { background: #f6f7f7; }
        .binding-name-cell { background: #f0f0f0; font-weight: bold; }
        .add-row-box { 
            margin-top: 30px; 
            padding: 20px; 
            background: #fff; 
            border: 1px solid #ccd0d4; 
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
    </style>

    <?php if (isset($_GET['saved'])) : ?>
        <div class="updated"><p>Änderungen wurden erfolgreich in der Datenbank gespeichert!</p></div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])) : ?>
        <div class="updated notice-is-dismissible"><p>Preisstufe wurde gelöscht.</p></div>
    <?php endif; ?>

    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <input type="hidden" name="action" value="druckrechner_speichern_staffel">
        <?php wp_nonce_field('staffel_save_action', 'staffel_nonce'); ?>

        <table class="wp-list-table widefat fixed striped staffel-table">
            <thead>
                <tr>
                    <th width="20%">Bindungsart</th>
                    <th>Seiten (Ab)</th>
                    <th>Seiten (Bis)</th>
                    <th>Menge (Ab Stück)</th>
                    <th>Stückpreis (€)</th>
                    <th width="100px">Aktion</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($results) : foreach ($results as $row) : ?>
                    <tr>
                        <td><strong><?php echo esc_html(ucfirst(str_replace('_', ' ', $row->name))); ?></strong></td>
                        <td><input type="number" name="rows[<?php echo $row->id; ?>][seiten_ab]" value="<?php echo $row->seiten_ab; ?>"></td>
                        <td><input type="number" name="rows[<?php echo $row->id; ?>][seiten_bis]" value="<?php echo $row->seiten_bis; ?>"></td>
                        <td><input type="number" name="rows[<?php echo $row->id; ?>][menge_ab]" value="<?php echo $row->menge_ab; ?>"></td>
                        <td><input type="number" step="0.01" name="rows[<?php echo $row->id; ?>][preis]" value="<?php echo $row->preis; ?>"> €</td>
                        <td>
                            <a href="<?php echo admin_url('admin-post.php?action=druckrechner_delete_staffel&id=' . $row->id); ?>" 
                               class="button button-link-delete" 
                               style="color: #d63638;"
                               onclick="return confirm('Möchten Sie diese Preisstufe wirklich löschen?')">Löschen</a>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="6">Keine Daten vorhanden.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <?php submit_button('Alle Änderungen in Datenbank speichern'); ?>
        </div>
    </form>

    <hr>

    <div class="add-row-box">
        <h3><span class="dashicons dashicons-plus-alt"></span> Neue Preisstufe hinzufügen</h3>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="druckrechner_add_staffel">
            <?php wp_nonce_field('staffel_add_action', 'staffel_add_nonce'); ?>
            
            <table class="form-table">
                <tr>
                    <td>
                        <label>Bindung Name (Key):</label><br>
                        <input type="text" name="new_name" placeholder="z.B. premium_lederoptik" required>
                    </td>
                    <td>
                        <label>Seiten Ab:</label><br>
                        <input type="number" name="new_seiten_ab" value="1" required>
                    </td>
                    <td>
                        <label>Menge Ab:</label><br>
                        <input type="number" name="new_menge_ab" value="1" required>
                    </td>
                    <td>
                        <label>Preis (€):</label><br>
                        <input type="number" step="0.01" name="new_preis" placeholder="0.00" required>
                    </td>
                    <td style="vertical-align: bottom;">
                        <input type="submit" class="button button-secondary" value="Hinzufügen">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>