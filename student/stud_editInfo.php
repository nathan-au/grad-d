<style>.row-margin-05 { margin-top: 0.5em; }</style>

<div class="div_child align-items-center" style="background:rgb(245,245,245);height:auto;">
    <br><br>
    <form action="" id="edit_form">
        <fieldset <?php echo(func_checkEditPerm("fieldset"));?>>
            <div class="row">
                <div class="col-lg-1 col-md-0"></div>
                <div class="col-lg-10 col-md-12">
                    <div class="card">
                        <h5 class="card-header">Memorable Moments</h5>
                        <div class="card-body">
                            <p>It's your time to shine! Tell us some key highlights you've had in highschool! Please remember to keep it appropriate as teachers will be reviewing the following. <br>
                            Maximum Character Count: <b><?php echo(func_getSettingsInfo("mem_mom_char_lim"));?></b>. You can check your count by clicking on the word count to switch it to character count.</p>
                            <textarea id="edit_mem_moment"></textarea>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-1 col-md-0"></div>
                <div class="col-lg-5 col-md-12">
                    <br>
                    <div class="card">
                        <h5 class="card-header">Scholarships</h5>
                        <div class="card-body">
                            Let us know the name of some scholarships you've earned and accepted!
                            <br>Press the "Add Scholarship" button to create an input field.
                            <br><button class="btn btn-success add-item-btn" style="width:30%;"><b>Add scholarship</b></button>
                            <div id="edit_div_scholarships"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <br>
                    <div class="card">
                        <h5 class="card-header">Post-Secondary Destination</h5>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="mem_moment">Where do you plan on going? School? Gap year?</label>
                                <input type="text" class="form-control" rows="5" id='edit_future_plans[f_plans_school]' name='edit_future_plans[f_plans_school]'>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="mem_moment">What job/program/goal will you be going for? Don't include "Bachelors of..."</label>
                                <input type="text" class="form-control" rows="5" id='edit_future_plans[f_plans_course]' name='edit_future_plans[f_plans_course]'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br>
        <div class="col-12 text-center">
            <button id="studDataSubmit" class="align-items-center btn btn-primary" <?php echo(func_checkEditPerm("fieldset"));?>>Save Changes</button>
        </div>
        <br>
    </form>
</div>


<script>
    //TINY MCE
    tinymce.init({
        selector: '#edit_mem_moment',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace wordcount',
        toolbar: 'undo redo | fontfamily fontsize | bold italic underline | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | wordcount',
        <?php echo(func_checkEditPerm("tinyMCE"));?>
    });


    //LOAD ALL DATA
    $(document).ready(function(){
        func_inputDataStud();
    });
    function func_inputDataStud(){
        var data = <?php echo json_encode(func_collectInfo(getUserInfo('stud_id')))?>;
        if((typeof data["stud_future_plans"]) == "object"){
            var data_future_plans = (data["stud_future_plans"]);
        } else {
            var data_future_plans = JSON.parse(data["stud_future_plans"]);
        }
        var data_scholarships = data["stud_scholarships"];
        //MEM MOMENT
        document.getElementById("edit_mem_moment").value = data["stud_mem_moment"];
        //SCHOLARSHIPS
        for(var i=0;i<data_scholarships.length;i++) {
            createField(data_scholarships[i]);
        }
        //FUTURE PLANS
        document.getElementById("edit_future_plans[f_plans_school]").value = data_future_plans["f_plans_school"];
        document.getElementById("edit_future_plans[f_plans_course]").value = data_future_plans["f_plans_course"];
    }


    //SAVE ALL DATA
    $(document).ready(function(){
        $(document.getElementById("studDataSubmit")).click(function(e){
            var max = <?php echo(func_getSettingsInfo("mem_mom_char_lim"));?>;
            var numChars = tinymce.activeEditor.plugins.wordcount.body.getCharacterCount();
            e.preventDefault();
            if (numChars > max) { //IF OVER CHAR LIMIT, DON'T SEND
                alert("Maximum " + max + " characters allowed.");
            } else { //IF UNDER CHAR LIMIT, GOOD TO SEND.
                var serialData = ($("#edit_form")).serialize(); //SERIALIZATION
                tinymceData = "edit_mem_moment="+tinymce.get("edit_mem_moment").getContent() //GET TINYMCE DATA
                $.post("stud_functions.php","func=submit&"+tinymceData+"&"+serialData, (function(){ //SENDS THE DATA OVER TO STUD_FUNCTIONS VIA POST
                    $("#slideshowFrame").load("stud_showPresent.php", function(responseTxt, statusTxt, xhr){ //RELOADS THE IFRAME HTML
                        if(statusTxt == "success")
                            $('#toast_submit_success').toast('show'); 
                        if(statusTxt == "error")
                            alert("Error: " + xhr.status + ": " + xhr.statusText + ". Contact an admin using the report feature.");
                    });
                }));
            }
        })
    });


    //SCHOLARSHIPS INITIALIZE
    let template_schol_input = document.createElement("input");
    template_schol_input.type = "text";
    template_schol_input.className = "form-control col-11";
    template_schol_input.name = "edit_scholarships[]";
    template_schol_input.placeholder = "Type a scholarship here";
    let template_schol_remove = document.createElement("span");
    template_schol_remove.className = "btn btn-danger remove-item-btn col-1";
    template_schol_remove.innerHTML = "<b>-</b>";
    let template_schol_div = document.createElement("div");
    template_schol_div.className = "row-margin-05 entry input-group";

    function createField(data){
        const clone_div = template_schol_div.cloneNode(true);
        let clone_input = template_schol_input.cloneNode(true);
        clone_input.value = data;
        clone_div.appendChild(clone_input);
        clone_div.appendChild(template_schol_remove.cloneNode(true));
        document.getElementById("edit_div_scholarships").appendChild(clone_div)
    }

    
    //SCHOLARSHIPS ADD
    $(document).ready(function(){
        $(".add-item-btn").click(function(e){
            e.preventDefault();
            const clone_div = template_schol_div.cloneNode(true);
            clone_div.appendChild(template_schol_input.cloneNode(true));
            clone_div.appendChild(template_schol_remove.cloneNode(true));
            $("#edit_div_scholarships").append(clone_div);
        });
    });


    //SCHOLARSHIPS REMOVE
    $(document).on("click", ".remove-item-btn", function(e){
        e.preventDefault();
        let input_div = $(this).parent();
        $(input_div).remove();
    });
</script>