<!-- JavaScript libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets/js/upload_file_script.js'); ?>"></script>

<script>
    // Search Image form upload folder
    function searchImages() {
        var input = document.querySelector('.search-input').value.toLowerCase();
        var items = document.querySelectorAll('.image-item');
        items.forEach(function(item) {
            var itemName = item.getAttribute('data-name').toLowerCase();
            if (itemName.includes(input)) {
                item.style.display = ''; // Show item
            } else {
                item.style.display = 'none'; // Hide item
            }
        });
    }
    $(document).ready(function() {
        $('input[name="fileNameInput"]').val('');
        $('#profilePreview').attr('src', "<?= base_url('assets/images/user_thume_img.png'); ?>");
        // Handle profile image selection and modal
        $('#okButton').on('click', function() {
            var fileInput = $('#modalProfileImage')[0];
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                var dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                $('#hiddenProfileImage')[0].files = dataTransfer.files;
                $('input[name="fileNameInput"]').val(file.name);
                $('#profilePreview').attr('src', URL.createObjectURL(file));
                $('#fileexampleModal').modal('hide');
            } else {
                alert('Please select an image to upload.');
            }
        });

        // Handle form submission
        $('#imageUploadForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var fileInput = $('#hiddenProfileImage')[0];
            if (fileInput.files.length > 0) {
                formData.append('profileImageFile', fileInput.files[0]);
            }

            // AJAX request for image and user info
            $.ajax({
                url: '<?= base_url("user/uploadUserInfo"); ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert(result.message);
                        $('#imageUploadForm')[0].reset();
                        $('input[name="fileNameInput"]').val('');
                        $('#profilePreview').attr('src', '<?= base_url('assets/images/user_thume_img.png'); ?>');
                        location.reload();
                    } else {
                        alert('Image upload failed: ' + result.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + errorThrown);
                }
            });
        });

        // Delete image
        $(document).on('click', '.delete-user', function() {
            var userId = $(this).data('id');
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: '<?= base_url("user/deletUser/") ?>' + userId,
                    type: 'POST',
                    success: function(response) {
                        var data = JSON.parse(response);
                        alert(data.message);
                        fetchUsers();
                    },
                    error: function() {
                        alert('An error occurred while deleting the user.');
                    }
                });
            }
        });

        // Handle image selection for setting profile image
        $(document).on('click', '.selectImageButton', function() {
            $('.selectImageButton').css('border', 'none');
            $(this).css('border', '2px solid red');
            var imageItem = $(this).closest('.image-item');
            $('input[name="fileNameInput"]').val(imageItem.data('name'));
            $('#profilePreview').attr('src', imageItem.data('path'));
            $('#fileexampleModal').modal('hide');
        });

        // Fetch users from the server and display them in the table
        function fetchUsers() {
            $.ajax({
                url: '<?= base_url("user/getUsers") ?>',
                method: 'GET',
                success: function(data) {
                    const users = JSON.parse(data);
                    let rows = '';
                    users.forEach(user => {
                        rows += `
                            <tr>
                                <td>${user.first_name}</td>
                                <td>${user.last_name}</td>
                                <td>${user.email}</td>
                                <td>${user.mobile_number}</td>
                                <td><img class="userIconIMGT" src="<?= base_url('uploads/'); ?>${user.profile_picture}" alt="Profile Picture"></td>
                                <td>
                                    <button class="btn btn-secondary edit-button" data-id="${user.id}">Edit</button>
                                    <button class="btn btn-danger delete-button delete-user" data-id="${user.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                    $('#userListTable tbody').html(rows);
                }
            });
        }

        // Edit user button click event
        $(document).on('click', '.edit-button', function() {
            const userId = $(this).data('id');
            $.ajax({
                url: '<?= base_url("user/getUserById/") ?>' + userId,
                method: 'GET',
                success: function(data) {
                    const user = JSON.parse(data);
                    $('#firstName').val(user.first_name);
                    $('#lastName').val(user.last_name);
                    $('#userEmail').val(user.email);
                    $('#userPhone').val(user.mobile_number);
                    $('#userId').val(user.id);
                    $('input[name="fileNameInput"]').val(user.profile_picture);

                    $('#profilePreview').attr('src', '<?= base_url('uploads/'); ?>' + user.profile_picture);
                }
            });
            window.scroll({
                top: 0,
                left: 0,
                behavior: 'smooth'
            });
        });

        // Fetch users when the page loads
        fetchUsers();
    });
</script>
</body>

</html>