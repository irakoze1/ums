<?php
     require_once "assets/php/header.php";
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php if($verified == 'Not Verified!'): ?>
                    <div class="alert alert-danger alert-dismissible text-center mt-2 m-0">
                        <button class="close" type="button" data-dismiss="alert">&times;</button>
                        <strong>Your email is not verified! We've sent you an E-mail verification link on your E-mail, check & verify now!</strong>
                    </div>
                    <?php endif; ?>
                    <h4 class="text-center text-primary mt-2">Write Your Notes Here  Access Anytime  Anywhere!</h4>
            </div>
        </div>
        <div class="card border-primary">
            <h5 class="card-header bg-primary d-flex justify-content-between">
                <span class="text-light lead align-self-center">All Notes</span>
                <a href="#" data-toggle="modal" data-target="#addNoteModal" class="btn btn-light"> <i class="fas fa-plus-circle fa-lg"></i> &nbsp; Add New Note</a>
            </h5>

            <div class="card-body">
                <div class="table-responsive" id="showNote">
                    <div class="text-center load mt-5">Please Wait...</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Add New Note Modal -->
    <div class="modal fade" id="addNoteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title text-light">Add New Note</h4>
                    <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                </div>
                    <div class="modal-body">
                        <form action="#" method="POST" id="add-note-form" class="px-3">
                            <div class="form-group">
                                <input type="text" name="title" placeholder="Enter Title" class="form-control form-control-lg" required>
                            </div>
                            <div class="form-group">
                                <textarea name="note" class="form-control form-control-lg" placeholder="Write Tour Note Here..." rows="6" required></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="addNote" id="addNoteBtn" value="Add Note" class="btn btn-success btn-block btn-lg">
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    <!-- End Add New Note Modal -->


    <!-- Start Edit New Note Modal -->
    <div class="modal fade" id="editNoteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title text-light">Edit Note</h4>
                    <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                </div>
                    <div class="modal-body">
                        <form action="#" method="POST" id="edit-note-form" class="px-3">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <input type="text" name="title" id="title" placeholder="Enter Title" class="form-control form-control-lg" required>
                            </div>
                            <div class="form-group">
                                <textarea name="note" id="note" class="form-control form-control-lg" placeholder="Write Tour Note Here..." rows="6" required></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="editNote" id="editNoteBtn" value="Update Note" class="btn btn-info btn-block btn-lg">
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    <!-- End Edit New Note Modal -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha512-c4wThPPCMmu4xsVufJHokogA9X4ka58cy9cEYf5t147wSw0Zo43fwdTy/IC0k1oLxXcUlPvWZMnD8be61swW7g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.4/datatables.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $("table").DataTable();

            //Addnew note Ajax Request
            $("#addNoteBtn").click(function(e){
                if($("#add-note-form")[0].checkValidity()){
                    e.preventDefault();
                    $("#addNoteBtn").val('Please wait...');
                    
                    $.ajax({
                        url:'assets/php/process.php',
                        method: 'post',
                        data: $("#add-note-form").serialize()+'&action=add_note',
                        success: function(response){
                            $("#addNoteBtn").val('Add Note');
                            $("#add-note-form")[0].reset();
                            $("#addNoteModal").modal('hide');
                            Swal.fire({
                                title:'Note added successfully!',
                                type:'success'
                            });
                            displayAllNotes();
                        }
                    });
                }
            });

            //Delete a note of an User
            $("body").on("click", ".deleteBtn", function(e){
                e.preventDefault();
                del_id = $(this).attr('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'assets/php/process.php',
                            method: 'post',
                            data:{del_id :del_id},
                            success:function(response){
                                Swal.fire(
                                'Deleted!',
                                'Note deleted successfully!',
                                'success'
                                )

                                displayAllNotes();
                            }
                        });
                    }
                    })
            });

            //Display note of an User
            $("body").on("click", ".infoBtn", function(e){
              e.preventDefault();

              info_id = $(this).attr('id');
              
              $.ajax({
                      url:'assets/php/process.php',
                      method: 'post',
                      data:{info_id : info_id},
                      success:function(response){
                      data = JSON.parse(response);
                      Swal.fire({
                          title: '<strong>Note : ID('+data.id+')</strong>',
                          type: 'info',
                          html: '<b>Title : </b>'+data.title+'<br><br><b>Note : </b>'+data.note+
                              '<br><br><b>Written On : </b>'+data.created_at+'<br><br><b>Updated On : </b>'+data.updated_at,
                          showCloseButton: true,
                      });
                  }
                  });
              });


            //Display note of an User
            $("body").on("click", ".editBtn", function(e){
                e.preventDefault();

                edit_id = $(this).attr('id');
                
                $.ajax({
                    url:'assets/php/process.php',
                    method: 'post',
                    data:{edit_id : edit_id},
                    success:function(response){
                    data = JSON.parse(response);
                    $("#id").val(data.id);
                    $("#title").val(data.title);
                    $("#note").val(data.note);
                }
                })
            });

            //Update a note of An user
            $("#editNoteBtn").click(function(e){
                if($("#edit-note-form")[0].checkValidity()){
                    e.preventDefault();
                    $("#editNoteBtn").val('Please wait...');
                    
                    $.ajax({
                        url:'assets/php/process.php',
                        method: 'post',
                        data: $("#edit-note-form").serialize()+'&action=update_note',
                        success: function(response){
                            $("#editNoteBtn").val('Edit Note');
                            $("#edit-note-form")[0].reset();
                            $("#editNoteModal").modal('hide');
                            Swal.fire({
                                title:'Note updated successfully!',
                                type:'success'
                            });
                            displayAllNotes();
                        }
                    });
                }
            });

            displayAllNotes();
            
            //Display all notes of User
            function displayAllNotes(){
                $.ajax({
                    url:'assets/php/process.php',
                        method: 'post',
                        data:{action: 'display_notes'},
                        success:function(response){
                            $("#showNote").html(response);
                            $("table").DataTable({
                                order: [0, 'desc']
                            });
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

            //Checking User is Logged in or not
            $.ajax({
                url: 'assets/php/action.php',
                method: 'post',
                data: {action :  'checkUser'},
                success: function(response){
                    if(response === 'Bye!!'){
                        Window.location = 'index.php';
                    }
                }
            });
        });
        </script>
    </body>
<html>