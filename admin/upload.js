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