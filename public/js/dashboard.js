$(document).ready(function (){
    $.ajax({                                      
      url: 'ajax_load.php',              
      type: "post",          
      data: "artist=<?php echo $artist; ?>",
      dataType: 'html',                
      beforeSend: function() {
          $('#current_page').append("loading..");
          },
      success: finished(html),
   });
});