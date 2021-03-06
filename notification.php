<?php
    require_once('assets/php/header.php');
?>

      <div class="container">
          <div class="row justify-content-center my-2">
              <div class="col-lg-6 mt-4" id="showAllNotification">
                    
              </div>
          </div>
      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha512-c4wThPPCMmu4xsVufJHokogA9X4ka58cy9cEYf5t147wSw0Zo43fwdTy/IC0k1oLxXcUlPvWZMnD8be61swW7g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script>
          $(document).ready(function(){
            
            fetchNotification();
            //Fetch Notification on an User
            function fetchNotification(){
                $.ajax({
                    url: 'assets/php/process.php',
                    method : 'post',
                    data: { action: 'fetchNotification'},
                    success: function(response){
                        $("#showAllNotification").html(response);
                    }
                });
            }

            //Check Notification
            checkNotification();
            function checkNotification(){
                $.ajax({
                    url: 'assets/php/process.php',
                    method: 'post',
                    data: { action : 'checkNotification'},
                    success: function(response){
                        $("#checkNotification").html(response);
                    }
                });
            }

            //Remove Notification
            $("body").on("click", ".close", function(e){
                e.preventDefault();

                notification_id = $(this).attr('id');
                $.ajax({
                    url: 'assets/php/process.php',
                    method: 'post',
                    data: { notification_id: notification_id},
                    success: function(response){
                        checkNotification();
                        fetchNotification();
                    }
                });
            }); 

        });
      </script>
  </body>
</html