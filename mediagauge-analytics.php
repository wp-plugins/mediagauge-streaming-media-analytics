<?php

/*

  Plugin Name: MediaGauge - Realtime Streaming Media Analytics
  Plugin URI:  
  Description: Integrates MediaGauge's realtime media analytics tracking.
  Author:      Epic Playground, Inc.
  Version:     1.0
  Author URI:  http://mediagauge.com/
  License:     

*/

require('mediagauge-analytics-admin.php');

add_filter('wp_head', 'mediagauge_autodetect', 10, 0);

function mediagauge_autodetect() {

  // get the plugin's settings
  $enabled = get_option('mediagauge_enabled');
  $api_key  = get_option('mediagauge_api_key');

  // if the "enabled" setting is empty or does not exist, set it to "true"
  if (!$enabled) {
    $enabled = 'true';
    update_option('mediagauge_enabled', $enabled);
  }

  // if the api key setting is empty or does not exist, do not add the tracking code
  if (!$api_key) {
    return true;
  }

  // continue to insert mediagauge's javascript snippet only if mediagauge is enabled
  if ($enabled !== 'true') {
    return true;
  }

  // build the javascript snippet that tracks media engagements
  ?>

    <!-- MediaGauge Streaming Media Analytics (http://mediagauge.com) -->
    <script async="async" src="//code.mediagauge.com/2/mediagauge.min.js?api-keys[]=<?php echo $api_key; ?>"></script>

  <?php

  return true;

}
