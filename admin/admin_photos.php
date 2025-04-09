<?php


?>
<!doctype html>
<html>
<head>
    <script>
        function readyUpload(){
            var fileName = document.getElementById("fileNameType").value;
            var year = document.getElementById("grade").value;

            // if (fileName == "fsl" && year == "9"){
            //     move_uploaded_file(, dest)
            // }
           
        }
    </script>
</head>
<body>
    <form method = "POST" action = 'admin_uploads3.php' id = "zipForm" enctype="multipart/form-data">
        <select id="grade" name = "grade">
            <option value="blank" selected = "selected" disabled>please select a grade</option>
            <option value="9">Grade 9</option>
            <option value="10">Grade 10</option>
            <option value="11">Grade 11</option>
            <option value="12">Grade 12</option>
            <option value="13">Grad</option>
        </select>

        <select id="fileNameType" name = "fileNameType">
                <option value="blank"  selected = "selected"  disabled>please select your file format</option>
                    <option value="fsl">firstname lastname</option>
                    <option value="lsf">lastname firstname</option>
                    <option value="fcl">firstname, lastname</option>
                    <option value="lcf">lastname, firstname</option>
        </select>

        upload:
        <input type='file' id='fileToUpload' name = 'fileToUpload'><br>

        <input type='submit' name="submit">

        <!-- <button type="button" onclick ="jsPage()">SUBMIT</button> -->


        <!-- if (document.getElementById("grade").value = "G"){
                <select name="nameType">
                    <option value="9">firstname lastname</option>
                    <option value="10">lastname firstname</option>
                    <option value="11">firstname, lastname</option>
                    <option value="12">lastname, firstname</option>
                </select>
                
            } -->
</form>
<script type="text/javascript" src="upload.js"></script>

<script>
    function jsPage(){
        alert ("in");
        var myForm = document.getElementById('zipForm');  // Our HTML form's ID
var myFile = document.getElementById('fileToUpload');  // Our HTML files' ID
//var statusP = document.getElementById('status');
var grade = document.getElementById('grade').value;
var fileNameType = document.getElementById('fileNameType').value;



if (grade != "blank" && fileNameType!= "blank"){

  myForm.onsubmit = function(event) {
    event.preventDefault();

    //statusP.innerHTML = 'Uploading...';

    // Get the files from the form input
    var files = myFile.files;

    // Create a FormData object
    var formData = new FormData();

    // Select only the first file from the input array
    var file = files[0];

    // Add the file to the AJAX request
    formData.append('fileToUpload', file, file.name);

    // Set up the request
    var xhr = new XMLHttpRequest();

    // Open the connection
    xhr.open('POST', '/gradD/admin/admin_uploads3.php?grade='+grade+'&fileNameType='+fileNameType, true);

    // Set up a handler for when the task for the request is complete
  //   xhr.onload = function () {
  //     if (xhr.status == 200) {
  //       statusP.innerHTML = 'Upload copmlete!';
  //     } else {
  //       statusP.innerHTML = 'Upload error. Try again.';
  //     }
  //   };

    // Send the data.
    xhr.send(formData);
  }
}

    }
    </script>

</body>
</html>
