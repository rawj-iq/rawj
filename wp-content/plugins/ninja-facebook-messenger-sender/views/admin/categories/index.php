<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php _e('Categories', NJT_FB_MESS_I18N); ?></h1>
    <div id="col-container">
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <h2><?php _e('Add New Category', NJT_FB_MESS_I18N); ?></h2>
                    <form action="" method="POST">
                        <input type="hidden" name="action" value="create" />
                        <div class="form-field">
                            <label for="name"><?php _e('Name', NJT_FB_MESS_I18N); ?></label>
                            <input type="text" name="name" id="name" class="" required="required" />
                            <p><?php _e('The name of category.', NJT_FB_MESS_I18N) ?></p>
                        </div>
                        <div class="form-field">
                            <label for="description"><?php _e('Description', NJT_FB_MESS_I18N); ?></label>
                            <textarea name="description" id="description" class=""></textarea>
                            <p><?php _e('The description of category.', NJT_FB_MESS_I18N) ?></p>
                        </div>
                        <div class="form-field">
                            <label for="parent_id"><?php _e('Parent', NJT_FB_MESS_I18N); ?></label>
                            <select name="parent_id" id="parent_id" class="">
                                <option value="0"><?php _e('None', NJT_FB_MESS_I18N); ?></option>
                                <?php
                                foreach ($dropdown as $k => $v) {
                                    echo sprintf('<option value="%1$d">%2$s</option>', $v->id, $v->name);
                                }
                                ?>
                            </select>
                        </div>
                        <?php submit_button(__('Add New Category', NJT_FB_MESS_I18N)); ?>
                    </form>
                </div>
            </div>
        </div>
        <!-- /#col-left -->
        <div id="col-right">
            <div class="col-wrap">
                <?php echo $table ?>
            </div>
        </div>
        <!-- /#col-right -->
    </div>
</div>