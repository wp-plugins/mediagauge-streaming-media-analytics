<?php

add_action('admin_menu', 'mediagauge_admin');

// adds the mediagauge admin page to the wordpress settings menu
function mediagauge_admin() {
	add_options_page('MediaGauge Analytics Options', 'MediaGauge Analytics', 'manage_options', 'mediagauge', 'mediagauge_options', 'icon.png');
}

// builds the mediagauge admin page
function mediagauge_options() {

  // check that the current user has the necessary permissions
	if (!current_user_can('manage_options' ))  {
		wp_die(__('You do not have sufficient permissions to access this page.' ));
	}

  // if the form has been submitted...
  if ($_POST) {

    $enabled = $_POST['mediagauge_enabled'] ? 'true' : 'false';
    $api_key  = trim($_POST['mediagauge_api_key']);

    if (!mediagauge_valid_api_key($api_key)) {
      $api_key_error = 'API Key is not valid.';
    } else {
      update_option('mediagauge_api_key', $api_key);
    }

    update_option('mediagauge_enabled', $enabled);

  }

  // if the form has not yet been submitted...
  else {

    // get the plugin's settings
    $enabled = get_option('mediagauge_enabled');
    $api_key  = get_option('mediagauge_api_key');

    // if the "enabled" setting is empty or does not exist, set it to "true"
    if (!$enabled) {
      $enabled = 'true';
      update_option('mediagauge_enabled', $api_key);
    }

  }

  // build the html
  ?>

  <div class="wrap">
    <div id="icon-mediagauge" class="icon32" style="background: transparent url(<?php echo plugin_dir_url(__FILE__) . 'icon.png'; ?>) no-repeat -4px -4px;"><br></div>
    <h2>MediaGauge Analytics Settings</h2>
    <form method="post" action="options-general.php?page=mediagauge">
      <table class="form-table">
        <tbody>
          <tr valign="top">
            <th scope="row">Enable/Disable: </th>
            <td>
              <fieldset>
                <legend class="screen-reader-text"><span>Enable Tracking?</span></legend>
                <label for="mediagauge_enabled">
                  <input name="mediagauge_enabled" type="checkbox" id="mediagauge_enabled" value="1"<?php echo $enabled == 'true' ? ' checked' : ''; ?>>
                  Enable MediaGauge media analytics tracking
                </label>
              </fieldset>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="blogname">API key to track: </label></th>
            <td>
              <input name="mediagauge_api_key" type="text" id="mediagauge_api_key" value="<?php echo $api_key; ?>" class="regular-text">
              <?php if ($api_key_error): ?>
                <p style="color:#c00;"><?php echo $api_key_error; ?></p>
              <?php endif; ?>
            </td>
          </tr>
        </tbody>
      </table>
      <p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"></p>
    </form>
  </div>

  <?php

}

function mediagauge_valid_api_key($string) {
  // valid the api key here...
  return true;
}
