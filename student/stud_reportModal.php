<div class="modal fade" id="message_form_modal" tabindex="-1" aria-labelledby="message_form_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Send a Message</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="report_form">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input class="form-control" type="email" name="report_email" id="report_email" placeholder="msg_email" required>
                        <label for="msg_email">Your email</label>
                    </div>
                    <div class="form-floating">
                        <input class="form-control" type="text" name="report_text" id="report_text" placeholder="msg_text" maxlength="100" required>
                        <label for="msg_text">Message</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <input class="btn btn-primary" type="submit" id="report_submit" value="Send message">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var reportModal = new bootstrap.Modal(document.getElementById('message_form_modal'));

    //MODAL TOGGLE
    function showModal() {
        reportModal.show();
    }
    
    //REPORT SENDING
    $(document).ready(function(){
        $(document.getElementById("report_submit")).click(function(e){//BUTTON SUBMISSION
            e.preventDefault();
            var serialData = (($("#report_form")).serialize()); //SERIALIZATION
            $.post("stud_functions.php","func=report&"+serialData, (function(){//AJAX SENDING
                reportModal.hide(); //MODAL CLOSE
                $('#toast_report_success').toast('show'); //NOTIFICATION SHOW (TOAST)
            }));
        })
    });
</script>