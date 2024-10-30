<div id="kanagawa-subscribe">
    <div>
        <span class="kanagawa-subscribe">To subscribe to our text message alerts, text "START" to: </span>
        <span class="kanagawa-phone-number"></span> 
    </div>
    <div>
        <span class="kanagawa-unsubscribe">To unsubscribe, reply with: "STOP"</span>
    </div>
</div>

<?php wp_enqueue_script("jquery"); ?>
<script type="text/javascript">
  jQuery(function($){
    $.getJSON('http://app.kanagawa-sms-alerts.com/info?token=<?php echo get_option('kanagawa-token'); ?>&callback=?', function(response, text, xhr){
      var $target = $('.kanagawa-phone-number');
      if(status == "error"){$target.html("There was an error " + xhr.status + " " + xhr.statusText); return;}
      $target.text(response.friendlyPhoneNumber);
    });
  });
</script>
