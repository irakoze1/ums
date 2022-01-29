<?php

    session_start();
    if(isset($_POST['username'])){
        header("Location:admin-dashboard.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css" integrity="sha512-+C1cmvw5D0Pfm6Gt9em3zp3OyebHM4wo05D38a0kXm7C1MRZZ9oPTbSX3KoRxAA0b2oHCqrcJEPikiXjsNXgtw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        html,body{ height: 100%;}
    </style>
</head>
<body class="bg-dark">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-lg-5">
                <div class="card border-danger shadow-lg">
                    <div class="card-header bg-danger">
                        <h3 class="m-0 text-white"><i class="fas fa-user-cog"></i>&nbsp;Admin Panel Login</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" class="px-3" id="admin-login-form">
                            <div id="adminLoginAlert"></div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-lg rounded-0" placeholder="Username" required autofocus>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-lg rounded-0" placeholder="Password" required>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="admin-login" class="btn btn-danger btn-block btn-lg rounded-0" value="Login" id="adminLoginBtn">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha512-c4wThPPCMmu4xsVufJHokogA9X4ka58cy9cEYf5t147wSw0Zo43fwdTy/IC0k1oLxXcUlPvWZMnD8be61swW7g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){

            $("#adminLoginBtn").click(function(e){
                if($("#admin-login-form")[0].checkValidity()){
                    e.preventDefault();

                    $(this).val('Please Wait...');
                    $.ajax({
                        url: 'assets/php/admin-action.php',
                        method: 'post',
                        data: $("#admin-login-form").serialize()+'&action=adminLogin',
                        success:function(response){
                            $("#adminLoginBtn").val('Login');
                            if(response === 'admin_login'){

                                window.location = 'admin-dashboard.php';
                                
                            }else{
                                $("#adminLoginAlert").html(response);
                            }
                        }
                    });
                }
            });

        });
    </script>
</body>
</html>