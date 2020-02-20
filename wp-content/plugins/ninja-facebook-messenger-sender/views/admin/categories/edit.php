<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
<h1><?php _e('Edit Category', NJT_FB_MESS_I18N); ?></h1>


<div id="ajax-response"></div>

<form name="edittag" id="edittag" method="post" action="" class="validate">
<input type="hidden" name="action" value="update" />
<input type="hidden" name="id" value="<?php echo $cat->id; ?>">
<table class="form-table">
        <tbody>
            <tr class="form-field form-required term-name-wrap">
                <th scope="row">
                    <label for="name"><?php _e('Name', NJT_FB_MESS_I18N); ?></label>
                </th>
                <td>
                    <input name="name" id="name" type="text" value="<?php echo $cat->name; ?>" size="40" required="required" />
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row">
                    <label for="description"><?php _e('Description', NJT_FB_MESS_I18N); ?></label>
                </th>
                <td>
                    <textarea name="description" id="description"><?php echo $cat->description; ?></textarea>
                </td>
            </tr>
            <tr class="form-field ">
                <th scope="row"><label for="parent_id"><?php _e('Parent', NJT_FB_MESS_I18N); ?></label></th>
                <td>
                    <select name="parent_id" id="parent_id" class="postform">
                        <option value="0"><?php _e('None', NJT_FB_MESS_I18N); ?></option>
                        <?php
                        foreach ($parent as $k => $v) {
                            echo sprintf('<option value="%1$d" %3$s>%2$s</option>', $v->id, $v->name, selected($v->id, $cat->parent_id, false));
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </tbody>
</table>
<?php submit_button(__('Update', NJT_FB_MESS_I18N)); ?>
</form>
</div>