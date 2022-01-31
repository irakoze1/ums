<?php
    require_once 'assets/php/admin-header.php';
?>

            <div class="row my-2 justify-content-center">
                <div class="col-lg-6 mt-4" id="showNotification">

                </div>
            </div>

        <!-- Footer Area -->
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){

            //Fetch notification of an user
            fetchNotification();
            function fetchNotification(){
                $.ajax({
                    url:'assets/php/admin-action.php',
                        method: 'post',
                        data:{action: 'fetchNotification'},
                        success:function(response){
                            $("#showNotification").html(response);
                        }
                });
            }

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

            //Delete a notification
            $("body").on("click", ".close", function(e){
                e.preventDefault();
                notification_id = $(this).attr('id');

                $.ajax({
                            url:'assets/php/admin-action.php',
                            method: 'post',
                            data:{notification_id :notification_id},
                            success:function(response){
                                checkNotification();
                                fetchNotification();
                            }
                        });
            });


        });
    </script>
</body>
</html>