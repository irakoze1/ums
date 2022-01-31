<?php

    require_once 'admin-db.php';

    $admin = new Admin();
    session_start();

    //Handle Admin Login Ajax Request
    if (isset($_POST['action']) && $_POST['action'] == 'adminLogin'){
        $username = $admin->test_input($_POST['username']);
        $password = $admin->test_input($_POST['password']);

        $hpassword = sha1($password);

        $loggedInAdmin = $admin->admin_login($username,$hpassword);

        if($loggedInAdmin != null){
            echo 'admin_login';
            $_SESSION['username'] = $username;
        }else{
            echo $admin->showMessage('danger', 'Username or Password is Incorrect');
        }
    }

    //Handle Fecth All Users Ajax Request
    if (isset($_POST['action']) && $_POST['action'] == 'fetchAllUsers'){
        $output = '';
        $data = $admin->FetchAllUsers(0);
        $path = '../assets/php/';

        if($data){
            $output .= '<table class="table table-striped table-bordered text-center">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Verified</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>';
                        foreach($data as $row){

                            if($row['photo'] != ''){
                                $uphoto = $path.$row['photo'];
                            }else{
                                $uphoto = '../assets/img/avatar.png';
                            }

                            $output .='<tr>
                                        <td>'.$row['id'].'</td>
                                        <td><img src="'.$uphoto.'" class="rounded-circle" width="40px" style="
                                        object-fit: cover;" /></td>
                                        <td>'.$row['name'].'</td>
                                        <td>'.$row['email'].'</td>
                                        <td>'.$row['phone'].'</td>
                                        <td>'.$row['gender'].'</td>
                                        <td>'.$row['verified'].'</td>
                                        <td>
                                            <a href="#" id="'.$row['id'].'" title="View Details" class="text-primary userDetailsIcon" data-toggle="modal" data-target="#showUserDetailsModal"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;

                                            <a href="#" id="'.$row['id'].'" title="Delete User" class="text-danger deleteUserIcon"><i class="fas fa-trash-alt fa-lg" ></i></a>&nbsp;
                                            
                                        </td>
                                        </tr>';
                        }
                        
                        $output .='</tbody>            
                                    </table>';
                        echo $output;
        }else{
            echo '<h3 class="text-center text-secondary">:(Non Any User Registered yet!</h3>';
        }
    }

    //Handle Display User In Details Ajax Request
    if (isset($_POST['details_id'])){
        $id = $_POST['details_id'];

        $data = $admin->fetchUserDetailsByID($id);

        echo json_encode($data);
    }

    //Handle Delete User Ajax Request
    if (isset($_POST['del_id'])){
        $id = $_POST['del_id'];

        $admin->userAction($id, 0);

    }

    //Handle Fecth All Users Ajax Request
    if (isset($_POST['action']) && $_POST['action'] == 'fetchAllDeletedUsers'){
        $output = '';
        $data = $admin->FetchAllUsers(1);
        $path = '../assets/php/';

        if($data){
            $output .= '<table class="table table-striped table-bordered text-center">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Verified</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>';
                        foreach($data as $row){

                            if($row['photo'] != ''){
                                $uphoto = $path.$row['photo'];
                            }else{
                                $uphoto = '../assets/img/avatar.png';
                            }

                            $output .='<tr>
                                        <td>'.$row['id'].'</td>
                                        <td><img src="'.$uphoto.'" class="rounded-circle" width="40px" style="
                                        object-fit: cover;" /></td>
                                        <td>'.$row['name'].'</td>
                                        <td>'.$row['email'].'</td>
                                        <td>'.$row['phone'].'</td>
                                        <td>'.$row['gender'].'</td>
                                        <td>'.$row['verified'].'</td>
                                        <td>

                                            <a href="#" id="'.$row['id'].'" title="Restore User" class="text-white restoreUserIcon badge badge-dark p-2">Restore</a>&nbsp;
                                            
                                        </td>
                                        </tr>';
                        }
                        
                        $output .='</tbody>            
                                    </table>';
                        echo $output;
        }else{
            echo '<h3 class="text-center text-secondary">:(Non Any User Deleted yet!</h3>';
        }
    }
    
    //Handle Restore Deleted User Ajax Request
    if (isset($_POST['res_id'])){
        $id = $_POST['res_id'];

        $admin->userAction($id, 1);

    }

    //Handle Fetch All Notes Ajax Request
    if (isset($_POST['action']) && $_POST['action'] == 'fetchAllNotes'){
        $output = '';
        $notes = $admin->fetchAllNotes();

        if($notes){
            $output .= '<table class="table table-striped table-bordered text-center">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Note Title</th>
                        <th>Written On</th>
                        <th>Updated On</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>';
                        foreach($notes as $row){
                            $output .='<tr>
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['name'].'</td>
                                        <td>'.$row['email'].'</td>
                                        <td>'.$row['title'].'</td>
                                        <td>'.$row['created_at'].'</td>
                                        <td>'.$row['updated_at'].'</td>
                                        <td>

                                            <a href="#" id="'.$row['id'].'" title="Delete Note" class="text-danger deletedNoteIcon"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;
                                            
                                        </td>
                                        </tr>';
                        }
                        
                        $output .='</tbody>            
                                    </table>';
                        echo $output;
        }else{
            echo '<h3 class="text-center text-secondary">:(Non Any Note Written yet!</h3>';
        }
    }

    //Handle Delete Note Ajax Request
    if (isset($_POST['note_id'])){
        $id = $_POST['note_id'];

        $admin->deleteNoteOfUser($id);

    }

    //Handle Fetch All Feedback of Users Ajax Request
    if (isset($_POST['action']) && $_POST['action'] == 'fetchAllFeedback'){
        $output = '';
        $feedback = $admin->fetchFeedback();

        if($feedback){
            $output .= '<table class="table table-striped table-bordered text-center">
                        <thead>
                        <tr>
                        <th>FID</th>
                        <th>UID</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Subject</th>
                        <th>Feedback</th>
                        <th>Sent On</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>';
                        foreach($feedback as $row){
                            $output .='<tr>
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['uid'].'</td>
                                        <td>'.$row['name'].'</td>
                                        <td>'.$row['email'].'</td>
                                        <td>'.$row['subject'].'</td>
                                        <td>'.$row['feedback'].'</td>
                                        <td>'.$row['created_at'].'</td>
                                        <td>

                                            <a href="#" fid="'.$row['id'].'"   id="'.$row['uid'].'" title="Reply" class="text-primay replyFeedbackIcon" data-toggle="modal" data-target="#showReplyModal"><i class="fas fa-reply fa-lg"></i></a>&nbsp;
                                            
                                        </td>
                                        </tr>';
                        }
                        
                        $output .='</tbody>            
                                    </table>';
                        echo $output;
        }else{
            echo '<h3 class="text-center text-secondary">:(Non Any Feedback Written yet!</h3>';
        }
    }

    //Handle Reply Feedback To USER Ajax Request
    if(isset($_POST['message'])){
        $uid = $_POST['uid'];
        $message = $admin->test_input($_POST['message']);
        $fid = $_POST['fid'];

        $admin->replyFeedback($uid, $message);
        $admin->feedbackReplied($fid);
    }

    //Handle Fetch Notification Ajax Request
    if(isset($_POST['action']) && $_POST['action'] == 'fetchNotification'){
        $notification = $admin->fetchNotification();
        $output = '';

        if($notification){
            foreach($notification as $row){
                $output .= '
                <div class="alert alert-dark" role="alert">
                    <button type="button" id="'.$row['id'].'" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="alert-heading">New Notification</h4>
                    <p class="mb-0 lead">'.$row['message'].' by '.$row['name'].'</p>
                    <hr class="my-2">
                    <p class="mb-0 float-left"><b>User E-Mail :</b> '.$row['email'].'</p>
                    <p class="mb-0 float-right">'.$admin->timeInAgo($row['created_at']).'</p>
                    <div class="clearfix"></div>
                </div>
                ';
            }
            echo $output;
        }else{
            echo '<h3 class="text-center text-secondary mt-5">No Any new Notification</h3>';
        }
    }

    //Handle Check Notification Ajax Request
    if (isset($_POST['action']) && $_POST['action'] == 'checkNotification'){
        if($admin->fetchNotification()){
            echo '<i class="fas fa-circle text-danger fa-sm"></i>';
        }else{
            echo '';
        }

    }

    //Handle Remove Notification Ajax Request
    if (isset($_POST['notification_id'])){
        $id = $_POST['notification_id'];

        $admin->removeNotification($id);

    }
   
    //Handle Export All USERS in Excel
    if(isset($_GET['export']) && $_GET['export'] == 'excel'){
        header("Content-type: application/xls");
        header("Content-Disposition: attachment; filename=users.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data = $admin->exportAllUsers();
        echo '<table border="1" align=center>';
        echo '<tr>
                <th>#</th>
                <th>Name</th>   
                <th>E-Mail</th> 
                <th>Phone</th> 
                <th>Gender</th> 
                <th>DOB</th> 
                <th>Joined ON</th>
                <th>Verified</th> 
                <th>Deleted</th> 
            </tr>';
            foreach($data as $row){
                echo '<tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['name'].'</td> 
                        <td>'.$row['email'].'</td> 
                        <td>'.$row['phone'].'</td> 
                        <td>'.$row['dob'].'</td> 
                        <td>'.$row['created_at'].'</td> 
                        <td>'.$row['verified'].'</td>  
                        <td>'.$row['deleted'].'</td> 
                    </tr>';
            }
           echo '</table>';
    }
?>