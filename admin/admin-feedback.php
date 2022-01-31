<?php
    require_once 'assets/php/admin-header.php';
?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card my-2 border-warning">
                        <div class="card-header bg-warning text-white">
                            <h4 class="m-0">Total Feedback From Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="showAllFeedbacks">
                                <p class="text-center align-self-center lead">Please Wait...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reply Feedback Modal -->
        <div class="modal fade" id="showReplyModal">
            <div class="modal-dialog modal-dialog-centered mw-100 w-50">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Reply This Feedback</h4>
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST" class="px-4" id="feedback-reply-form">
                            <div class="form-group">
                                <textarea name="message" rows="6" placeholder="Write Message Here" id="message" class=" form-control-lg form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" id="feedbackReplyBtn" value="Send Reply" class="btn btn-primary btn-block btn-lg " required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.4/datatables.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script type="text/javascript">

            $(document).ready(function(){
                //Fetc All Users
                fetchAllFeedbacks();
                function fetchAllFeedbacks(){
                        $.ajax({
                            url:'assets/php/admin-action.php',
                                method: 'post',
                                data:{action: 'fetchAllFeedback'},
                                success:function(response){
                                    $("#showAllFeedbacks").html(response);
                                    $("table").DataTable({
                                        order: [0, 'desc']
                                    });
                                }
                        });

                    }

                    //GET the Current Row User Id and Feedback
                    var uid;
                    var fid;

                    $("body").on("click", ".replyFeedbackIcon", function(e){
                        uid = $(this).attr('id');
                        fid = $(this).attr('fid');
                    });

                    //send feedack reply to User
                    $("#feedbackReplyBtn").click(function(e){
                        if($("#feedback-reply-form")[0].checkValidity()){
                            let message = $("#message").val();
                            e.preventDefault();
                            $("#feedbackReplyBtn").val('Please wait...');
                            
                            $.ajax({
                                url:'assets/php/admin-action.php',
                                method: 'post',
                                data: {uid : uid, message : message, fid : fid},
                                success: function(response){
                                    $("#feedbackReplyBtn").val('Send Feedback');
                                    $("#showReplyModal").modal('hide');
                                    $("#feedback-reply-form")[0].reset();
                                    Swal.fire(
                                        'Sent!',
                                        'Reply Sent Successfully!',
                                        'success'
                                    )
                                    fetchAllFeedbacks();
                                }
                            });
                        }
                    });

                    //Check Notification
                checkNotification();
                function checkNotification(){
                    $.ajax({
                        url:'assets/php/admin-action.php',
                            method: 'post',
                            data:{action: 'checkNotification'},
                            success:function(response){
                                $("#checkNotification").html(response);
                            }
                    });
                }

                        
            });
        
        </script>
        <!-- Footer Area -->
            </div>
        </div>
    </div>
</body>
</html>