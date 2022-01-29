<?php

    require_once 'session.php';

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';
    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    //Handle Add New Note Ajax 
    if(isset($_POST['action']) && $_POST['action'] == 'add_note'){
        $title = $cuser->test_input(($_POST['title']));
        $note = $cuser->test_input(($_POST['note']));

        $cuser->add_new_note($cid,$title,$note);
        $cuser->notification($cid, 'admin','Note Added');
    }

    //Handle Display All Notes of an User
    if(isset($_POST['action']) && $_POST['action'] == 'display_notes'){
        $output = '';

        $notes = $cuser->get_notes($cid);

        if($notes){
            $output .= '<table class="table table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>';
                foreach ($notes as $row) {
                    $output .='<tr>
                            <td>'.$row['id'].'</td>
                            <td>'.$row['title'].'</td>
                            <td>'.substr($row['note'],0,75).'...</td>
                            <td>
                            <a href="#" id="'.$row['id'].'" title="View Details" class="text-success infoBtn">
                                <i class="fas fa-info-circle fa-lg"></i>&nbsp;
                            </a>
                            <a href="#" id="'.$row['id'].'" title="Edit Note" class="text-primary editBtn">
                                <i class="fas fa-edit fa-lg" data-toggle="modal" data-target="#editNoteModal"></i>&nbsp;
                            </a>
                            <a href="#" id="'.$row['id'].'" title="Delete Note" class="text-danger deleteBtn">
                                <i class="fas fa-trash-alt fa-lg"></i>
                            </a>
                            </td>
                        </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
        }else{
            echo '<h3 class="text-center text-secondary">:( you have not written any not yet! Write your first note now!</h3>';
        }
    }

    //Handle Edit Note of an User Ajax Request
    if(isset($_POST['edit_id'])){
        $id = $_POST['edit_id'];

        $row = $cuser->edit_note($id);
        echo json_encode($row);
    }

    //Handle Update note of an user Ajax Request
    
    if(isset($_POST['action']) && $_POST['action'] == 'update_note'){
        $id = $cuser->test_input($_POST['id']);
        $title = $cuser->test_input($_POST['title']);
        $note = $cuser->test_input($_POST['note']);

        $cuser->update_note($id,$title,$note);
        $cuser->notification($cid, 'admin','Note Updated');
    }

    //Handle Delete note of an user Ajax Request

    if(isset($_POST['del_id'])){
        $id = $_POST['del_id'];

        $cuser->delete_note($id);
        $cuser->notification($cid, 'admin','Note Deleted');
    }

    //Hande Display a Note on an User Ajax Request
    if(isset($_POST['info_id'])){
        $id = $_POST['info_id'];

        $row = $cuser->edit_note($id);
        echo json_encode($row);
    }

    //Handle Profile Update Ajax Request
    if(isset($_FILES['image'])){
        $name = $cuser->test_input($_POST['name']);
        $gender = $cuser->test_input($_POST['gender']);
        $dob = $cuser->test_input($_POST['dob']);
        $phone = $cuser->test_input($_POST['phone']);

        $oldImage = $_POST['oldimage'];
        $folder = 'uploads/';


        if(isset($_FILES['image']['name']) && ($_FILES['image']['name'] != "")){
            $newImage = $folder.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $newImage);

            if($oldImage != null){
                unlink($oldImage);
            }
        }
        else{
            $newImage = $oldImage;
        }
        $cuser->update_profile($name, $gender, $dob, $phone, $newImage, $cid);
        $cuser->notification($cid, 'admin','Profil Updated');
    }

    //Handle Change Password Ajax Request
    if(isset($_POST['action']) && $_POST['action'] == 'change_pass'){
        $currentPass = $_POST['curpass'];
        $newPass = $_POST['newpass'];
        $cnewPass = $_POST['cnewpass'];

        $hnewpass = password_hash($newPass,PASSWORD_DEFAULT);

        if($newPass != $cnewPass){
            echo $cuser->showMessage('danger','Password did not matched!');
        }else{
            if(password_verify($currentPass, $cpass)){
                $cuser->change_password($hnewpass,$cid);
                echo $cuser->showMessage('success','Password Changed Successfully!');
                $cuser->notification($cid, 'admin','Password changed');
            }else{
                echo $cuser->showMessage('danger','Current Password is Wrong!');
            }
        }
    }

    //Handle Verify E-Mail Ajax Request
    if(isset($_POST['action']) && $_POST['action'] == 'verify_email'){
        try{
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = Database::USERNAME;
            $mail->Password = Database::PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;


            $mail->SetFrom(Database::USERNAME,'Irakoze Tititof');
            $mail->AddAddress($cemail);

            $mail->IsHTML(true);
            $mail->Subject = 'E-mail Verification';
            $mail->Body = '<h3>Click the below link to verify your E-Mail.<br>
                <a href="http://localhost:8888/user-system/verify-email.php?email='.$cemail.'">http://localhost:8888/user-system/verify-email.php?email='.$cemail.'</a>
                <br>Irakoze<br>Tititof</h3>';

                $mail->Send();
                echo $cuser->showMessage('success', 'Verification link sent to your E-Mail. Please Check Your mail!');
        }
        catch(Exception $e){
            echo $cuser->showMessage('danger','Something went wrong please try again later!');
        }
    }

    //Handle Send Feedback to Admin Ajax Request
    if(isset($_POST['action']) && $_POST['action'] == 'feedback'){
        $subject = $cuser->test_input($_POST['subject']);
        $feedback = $cuser->test_input($_POST['feedback']);

        $cuser->send_feedback($subject, $feedback, $cid);
        $cuser->notification($cid, 'admin','Feedback Written');
    }

?>