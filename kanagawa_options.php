<div class="wrap">
  <?php screen_icon(); ?>
  <h2>Kanagawa SMS Alerts Setup</h2>

  <form method="post" action="options.php">
    <?php settings_fields( 'kanagawa-group' ); ?>
    <?php do_settings_fields( 'kanagawa-group', 'kanagawa-settings-page' );?>

    <div style="padding-top:8px;">
      <label>Secret Token</label>
      <input type="text" name="kanagawa-token" value="<?php echo get_option('kanagawa-token'); ?>" />
    </div>
    <div>
      <small><b>What's this?</b> Login to <a href="http://www.kanagawa-sms-alerts.com/user">Kanagawa SMS Alerts</a> to get your secret token.</small>
    </div>

    <?php submit_button(); ?>
  </form>
</div>

