<?php

    require_once 'assets/php/admin-header.php'

?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card my-2 border-success">
                    <div class="card-header bg-success text-white">
                        <h4 class="m-0">Total Registred Users</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="showAllUsers">
                            <p class="text-center align-self-center lead">Please Wait...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Area -->

                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                
                //Fetch All Users Ajax
                fetchAllUsers();
                function fetchAllUsers(){
                    $.ajax({
                        url: 'assets/php/admin-action.php',
                        method: 'post',
                        data: { action: 'fetchAllUsers' },
                        success: function(response){
                            $("#showAllUsers").html(response);
                        }
                    });
                }

            });
        </script>
    </body>
</html>