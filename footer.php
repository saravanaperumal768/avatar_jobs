<?php
$log_name=$_SESSION["uname"];  
    ?>
 
 <!-- Wrapper End-->
    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="row">
                <!-- <div class="col-lg-6">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="terms-of-service.html">Terms of Use</a></li>
                    </ul>
                </div> -->
                <div class="col-lg-12 text-center">
                    <span class="mr-1">
                        Copyright
                        <script>document.write(new Date().getFullYear())</script>© <a href="index.php" class="">Avatar Global Services</a>
                        All Rights Reserved.
                    </span>
                </div>
            </div>
        </div>
    </footer>    <!-- Backend Bundle JavaScript -->
    
    <script src="assets/js/backend-bundle.min.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="assets/js/customizer.js"></script>
    
    <script src="assets/js/sidebar.js"></script>
    
    <!-- Flextree Javascript-->
    <script src="assets/js/flex-tree.min.js"></script>
    <script src="assets/js/tree.js"></script>
    
    <!-- Table Treeview JavaScript -->
    <script src="assets/js/table-treeview.js"></script>
    
    <!-- SweetAlert JavaScript -->
    <script src="assets/js/sweetalert.js"></script>
    
    <!-- Vectoe Map JavaScript -->
    <script src="assets/js/vector-map-custom.js"></script>
    
    <!-- Chart Custom JavaScript -->
    <script src="assets/js/chart-custom.js"></script>
    <script src="assets/js/charts/01.js"></script>
    <script src="assets/js/charts/02.js"></script>
    
    <!-- slider JavaScript -->
    <script src="assets/js/slider.js"></script>
    
    <!-- Emoji picker -->
    <script src="assets/vendor/emoji-picker-element/index.js" type="module"></script>
    
    
    <!-- app JavaScript -->
    <script src="assets/js/app.js"></script>  </body>

    <script>
    $(document).ready(function() {
        // Delete selected records when the delete button is clicked
        $('#deleteSelected').click(function() {
            var selectedIDs = [];

            // Loop through checked checkboxes to collect IDs
            $('input[type=checkbox]:checked').each(function() {
                // Extract the ID from checkbox value
                var id = $(this).val();
                selectedIDs.push(id);
            });

            // Perform deletion via AJAX
            $.ajax({
                type: 'POST',
                url: 'delete_multiple_jobs.php',
                data: {
                    selectedIDs: selectedIDs
                },
                success: function(response) {
                    // Handle success message or refresh the page
                    alert('Selected jobs deleted successfully');
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    alert('Error deleting jobs');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Delete selected records when the delete button is clicked
        $('#iteration_deleteSelected').click(function() {

            var selectedIDs = [];

            // Loop through checked checkboxes to collect IDs
            $('input[type=checkbox]:checked').each(function() {
                // Extract the ID from checkbox value
                var id = $(this).val();
                selectedIDs.push(id);
            });

            // Perform deletion via AJAX
            $.ajax({
                type: 'POST',
                url: 'iteration_delete_multiple_jobs.php',
                data: {
                    selectedIDs: selectedIDs
                },
                success: function(response) {
                    // Handle success message or refresh the page
                    alert('Selected jobs deleted successfully');
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    alert('Error deleting jobs');
                }
            });
        });
    });
</script>


<script type="text/javascript">
      $("form").on("change", ".file-upload-field", function(){ 
    $(this).parent(".file-upload-wrapper").attr("data-text",         $(this).val().replace(/.*(\/|\\)/, '') );
});
    </script>

    <script>
     $(document).ready(function(){
             $('#upload-file').change(function() {
                var filename = $(this).val();
                $('#file-upload-name').html(filename);
                if(filename!=""){
                    setTimeout(function(){
                        $('.upload-wrapper').addClass("uploaded");
                    }, 600);
                    setTimeout(function(){
                        $('.upload-wrapper').removeClass("uploaded");
                        $('.upload-wrapper').addClass("success");
                    }, 1600);
                }
            });
        });
    </script>

    <script>
  $(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + "\" alt=\" File" + (file.name ? file.name : "") +"\"/>" +
            "<br/><span class=\"remove\">Remove image</span>" +
            "</span>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
          
          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/
          
        });
        fileReader.readAsDataURL(f);
      }
      console.log(files);
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});

     </script>   

<script>
    function copyToClipboard(filelink) {
        // Create a temporary textarea element
        var tempTextArea = document.createElement("textarea");

        // Set its value to the passed filelink
        tempTextArea.value = filelink;

        // Append the textarea to the document
        document.body.appendChild(tempTextArea);

        // Select the text inside the textarea
        tempTextArea.select();

        // Execute the copy command
        document.execCommand("copy");

        // Remove the temporary textarea
        document.body.removeChild(tempTextArea);

        // Alert the user
        alert("Copied to clipboard: " + filelink);
    }
</script>

<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
</script>


<!-- Ensure jQuery library is included -->


<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
$(document).ready(function() {
    let isOpen = sessionStorage.getItem('notificationOpen') === 'true'; // Check if the notification panel was open before refresh

    // Function to handle updating notification count display
    function updateNotificationCount(count) {
        const numberElement = $('.number');
        if (!isOpen) {
            if (count > 0) {
                numberElement.text(count).show();
            } else {
                numberElement.hide();
            }
        } else {
            numberElement.hide();
        }
    }

    // Function to fetch notifications
    function fetchNotifications() {
        $.ajax({
            url: 'fetch_notifications.php?logname=' + logname,
            method: 'GET',
            success: function (data) {
                const notificationContainer = $('#notificationContainer');
                notificationContainer.empty();

                if (data.length > 0) {
                    data.forEach(notification => {
                        notificationContainer.append('<div>' + notification.clientname + ' - ' + notification.assigned_by + '</div>');
                    });

                    updateNotificationCount(data.length);
                } else {
                    notificationContainer.append('<div>No new notifications.</div>');
                    updateNotificationCount(0);
                }
            },
            error: function (error) {
                console.error('Error fetching notifications:', error);
            }
        });
    }

    // Click event listener for the notification link
    $('.notification').on('click', function(event) {
        event.preventDefault();
        isOpen = !isOpen;
        sessionStorage.setItem('notificationOpen', isOpen); // Save the open state to sessionStorage

        updateNotificationCount(0);
    });

    // Fetch notifications initially
    fetchNotifications();

    // Fetch notifications every few seconds
    setInterval(fetchNotifications, 10000);
});

// -------------------------------------

$(document).ready(function() {
    let isOpen2 = sessionStorage.getItem('notificationOpen2') === 'true'; // Check if the second notification panel was open before refresh

    // Function to handle updating notification count display for the second notification
    function updateNotificationCount2(count) {
        const numberElement = $('.number2');
        if (!isOpen2) {
            if (count > 0) {
                numberElement.text(count).show();
            } else {
                numberElement.hide();
            }
        } else {
            numberElement.hide();
        }
    }

    // Function to fetch notifications for the second notification
    function fetchNotifications2() {
        $.ajax({
            url: 'fetch_notifications2.php', // Adjust URL for fetching notifications
            method: 'GET',
            success: function (data) {
                
                const notificationContainer = $('#notificationContainer2');
                notificationContainer.empty();

                if (data.length > 0) {
                    data.forEach(notification => {
                        notificationContainer.append('<div>' + notification.clientname + ' - ' + notification.assigned_by + '</div>');
                    });

                    updateNotificationCount2(data.length);
                } else {
                    notificationContainer.append('<div>No new notifications.</div>');
                    updateNotificationCount2(0);
                }
            },
            error: function (error) {
                console.error('Error fetching notifications:', error);
            }
        });
    }

    // Click event listener for the second notification link
    $('.notification2').on('click', function(event) {
        event.preventDefault();
        isOpen2 = !isOpen2;
        sessionStorage.setItem('notificationOpen2', isOpen2); // Save the open state to sessionStorage

        updateNotificationCount2(0);
    });

    // Fetch notifications initially for the second notification
    fetchNotifications2();

    // Fetch notifications every few seconds for the second notification
    setInterval(fetchNotifications2, 10000);
});


</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const searchInputs = document.querySelectorAll('.data-table + #searchInput');
  searchInputs.forEach(function (searchInput) {
    const rows = searchInput.closest('.data-table').querySelectorAll('tbody tr');

    function filterRows() {
      const searchText = searchInput.value.toLowerCase();
      rows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchText)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    searchInput.addEventListener('keyup', filterRows);
  });
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const assignedToFilter = document.getElementById('assignedToFilter');
        const rows = document.querySelectorAll('.data-table tbody tr');

        assignedToFilter.addEventListener('change', function () {
            const selectedMemberId = assignedToFilter.value;
            rows.forEach((row) => {
                const memberId = row.querySelector('.assignedToColumn').dataset.memberId;
                if (!selectedMemberId || selectedMemberId === memberId) {
                    row.style.display = ''; // Show rows that match the filter
                } else {
                    row.style.display = 'none'; // Hide rows that don't match
                }
            });
        });
    });
</script>

<script>
const input = document.createElement("input");
input.type = "time";
input.min = "9:00";
input.max = "01:00";
input.value = "19:00";

if (input.validity.valid && input.type === "time") {
  // <input type=time> reversed range supported
} else {
  // <input type=time> reversed range unsupported
}

</script>
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
<script>
$(document).ready(function(){
    // Function to update username based on first name
    $('#fname').keyup(function(){
        var firstName = $(this).val();
        $('#username').val(firstName + '@avatarstaff');
    });

    // Function to check username availability
    $('#username').keyup(function(){
        var username = $(this).val();
        $.ajax({
            url: 'check_username.php', // Change this to the URL of your PHP script that checks the username
            method: 'POST',
            data: {username: username},
            success: function(response) {
                if (response === 'exists') {
                    $('#username-error').text('Username already exists');
                } else {
                    $('#username-error').text('');
                }
            }
        });
    });
});
</script>



<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"> </script> -->
<script>
    $(document).ready(function ()
{
	//Fade in delay for the background overlay (control timing here)
	$("#bkgOverlay").delay(1800).fadeIn(400);
  //Fade in delay for the popup (control timing here)
	$("#delayedPopup").delay(2000).fadeIn(400);
	
	//Hide dialouge and background when the user clicks the close button
	$("#btnClose").click(function (e)
	{
		HideDialog();
		e.preventDefault();
	});
});
//Controls how the modal popup is closed with the close button
function HideDialog()
{
	$("#bkgOverlay").fadeOut(400);
	$("#delayedPopup").fadeOut(300);
}

</script>
<script>
    document.getElementById('assignedToClients').addEventListener('change', function() {
    var filterValue = this.value.toLowerCase();
    var rows = document.querySelectorAll('table tr');

    rows.forEach(function(row) {
        var clientNameCell = row.querySelector('.clientname');
        if (clientNameCell) {
            var clientName = clientNameCell.textContent.toLowerCase();
            if (filterValue === "" || clientName.includes(filterValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});

    </script>

</html>