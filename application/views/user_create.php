<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
    <style>
        .upload-popup { display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; border: 1px solid #ddd; padding: 20px; width: 400px; }
        .tab { cursor: pointer; display: inline-block; padding: 10px 20px; background: #f1f1f1; margin-right: 5px; }
        .tab.active { background: #ddd; }
    </style>
</head>
<body>
    <h1>Create User</h1>

    <?php echo form_open_multipart('user/store'); ?>
        <div>
            <label>First Name</label>
            <input type="text" name="first_name">
        </div>
        <div>
            <label>Last Name</label>
            <input type="text" name="last_name">
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email">
        </div>
        <div>
            <label>Mobile Number</label>
            <input type="text" name="mobile_number">
        </div>
        <div>
            <label>Profile Picture</label>
            <input type="text" id="selected-file" readonly>
            <button type="button" onclick="openUploadPopup()">Upload File</button>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    <?php echo form_close(); ?>

    <div class="upload-popup" id="upload-popup">
        <div>
            <span class="tab active" onclick="showTab(1)">Upload</span>
            <span class="tab" onclick="showTab(2)">Select Existing</span>
        </div>
        <div id="tab1" style="display: block;">
            <form action="upload" class="dropzone" id="my-dropzone"></form>
        </div>
        <div id="tab2" style="display: none;">
            <input type="text" id="search-file" placeholder="Search files..." oninput="searchFiles()">
            <ul id="file-list"></ul>
        </div>
        <button type="button" onclick="closeUploadPopup()">Close</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script>
        function openUploadPopup() {
            document.getElementById('upload-popup').style.display = 'block';
        }

        function closeUploadPopup() {
            document.getElementById('upload-popup').style.display = 'none';
        }

        function showTab(tabIndex) {
            document.getElementById('tab1').style.display = tabIndex === 1 ? 'block' : 'none';
            document.getElementById('tab2').style.display = tabIndex === 2 ? 'block' : 'none';
        }

        function searchFiles() {
            const query = document.getElementById('search-file').value;
            fetch('/user/load_uploaded_files')
                .then(response => response.json())
                .then(files => {
                    const filteredFiles = files.filter(file => file.includes(query));
                    document.getElementById('file-list').innerHTML = filteredFiles.map(file => `<li>${file}</li>`).join('');
                });
        }

        Dropzone.options.myDropzone = {
            maxFiles: 1,
            init: function() {
                this.on("success", function(file, response) {
                    document.getElementById('selected-file').value = file.name;
                    closeUploadPopup();
                });
            }
        };
    </script>
</body>
</html>
