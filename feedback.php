<?php
    require_once('assets/php/header.php');
?>

      <div class="container">
          <div class="row justify-content-center">
              <div class="col-lg-8 mt-3">
                  <?php if($verified == 'Verified!'): ?>
                  <div class="card border-primary">
                      <div class="card-header lead text-center bg-primary text-white">Send Feedback to Admin</div>
                      <div class="card-body">
                          <form action="" method="post" class="px-4" id="feedback-form">

                            <div class="form-group">
                                <input type="text" name="subject" placeholder="Write Your Subject" class="form-control form-control-lg rounded-0" required>
                            </div>
                            <div class="form-group">
                                <textarea name="feedback" id=""  class="form-control-lg form-control rounded-0" placeholder="Write Your Feedback Here..." rows="8" required></textarea>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="feedback" id="feedbackBtn" value="Send Feedback" class="btn btn-primary btn-block btn-lg rounded-0">
                            </div>
                          </form>
                      </div>
                  </div>

                  <?php else: ?>
                    <h1 class="text-center text-seconday mt-5">Verify Your E-Mail First to send Feedback to Admin!</h1>
                    <?php endif; ?>
              </div>
          </div>
      </div>


      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha512-c4wThPPCMmu4xsVufJHokogA9X4ka58cy9cEYf5t147wSw0Zo43fwdTy/IC0k1oLxXcUlPvWZMnD8be61swW7g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <script>
          $(document).ready(function(){

            //Send Feedback to Admin Ajax Request
            $("#feedbackBtn").click(function(e){
                if($("#feedback-form")[0].checkValidity()){
                    e.preventDefault();

                    $(this).val('Please Wait...');
                    $.ajax({
                        url: 'assets/php/process.php',
                        method: 'post',
                        data: $("#feedback-form").serialize()+'&action=feedback',
                        success: function(response){
                            $("#feedback-form")[0].reset();
                            $("#feedbackBtn").val('Send Feedback');
                            Swal.fire({
                                title:'Feedback Successfuly sent to the Admin',
                                type:'success'
                            });
                        }
                    });
                }
            });

        })
      </script>
  </body>
</html