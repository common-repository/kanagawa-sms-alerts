<div id="kanagawa-broadcast">
  <h2>Broadcast a Text Message</h2>
  <form action="http://app.kanagawa-sms-alerts.com/broadcast" method="POST" accept="text/html">
      <input type="hidden" name="token" value="<?php echo get_option('kanagawa-token');?>"/><!--secret token-->
      <input type="hidden" name="accept" value="text/html"/>
      <textarea name="text"></textarea>
      <div><span class='kanagawa-characters-left'>160</span> characters left</div>
      <input type="submit" value="Broadcast"/>
  </form> 
</div>
<div id="kanagawa-info">
  <!-- ajax loaded info about our account status -->
</div>

<?php wp_enqueue_script("jquery"); ?>
<?php wp_enqueue_script("jquery.templates", plugins_url('/kanagawa-sms-alerts/js/jquery.tmpl.min.js'), false, "beta-1"); ?>
<script id="kanagawa-info-template" type="text/x-jquery-tmpl"> 
  <ul>
    <li>You have <b class="kanagawa-messages-left">${messagesLeft}</b> messages left</li>
    <li>You have <b>${subscribersCount}</b> subscribers</li>
  </ul>
</script>

<script type="text/javascript">
  jQuery(function($){
    $.getJSON('http://app.kanagawa-sms-alerts.com/info?token=<?php echo get_option('kanagawa-token'); ?>&callback=?', function(response, text, xhr){
      var $target = $('#kanagawa-info');
      if(status == "error"){$target.html("There was an error " + xhr.status + " " + xhr.statusText); return;}

      $.tmpl($("#kanagawa-info-template"), response).appendTo($target);
    });
  });
</script>

<script type="text/javascript">
  jQuery(function($){
    var $submitButton = $('#kanagawa-broadcast form input[type="submit"]');
    $submitButton.attr('disabled','disabled');
    $('#kanagawa-broadcast textarea').on("keyup", function(){
      var charsAllowed = 160;
      var charsUsed = $(this).val().length;
      var charsLeft = charsAllowed - charsUsed
      $('.kanagawa-characters-left').html(charsLeft);
      if (charsLeft < 0 || charsUsed == 0){
        $submitButton.attr('disabled','disabled');
      }else{
        $submitButton.removeAttr('disabled');
      }
    });
  });
</script>
<script type="text/javascript">
  jQuery(function($){
    var $form = $('#kanagawa-broadcast form');
    $(document).ajaxError(function(e, jqxhr, settings, err){
      $form.html("An error occurred: <pre>"+err+"</pre>");
    });
    if ($.support.cors){ //then this is a good browser that will do cross-site xhr
      $form.submit(function(e){
        e.preventDefault();
        $('input[name="accept"]', $form).val("application/json");
        $.post($form.attr("action"), $form.serialize(), function(data, status, xhr){
          if(status == "error"){
            $form.html("An error occurred: <pre>"+data+"</pre>");
          }else{
            $form.html("<h2>Success!</h2>");
            $('#kanagawa-info .kanagawa-messages-left').html(data.messagesLeft);
          }
        });
      });
    }
  });
</script>

<style type="text/css">
  #kanagawa-broadcast textarea{
    width: 20em;
    height: 10em;
  }
  #kanagawa-broadcast input[type="submit"]{
    font-size: medium;
    display: block;
  }
</style>
