<div class="container">
  <div class="row">
    <div class="col-12 col-md-12">
      <div class="selectprofile_option">
        <form id="imageUploadForm" enctype="multipart/form-data">
          <div class="form-group">
            <h1>User Info Form </h1>
          </div>
          <input type="hidden" class="form-control" name="userId" id="userId">
          <div class="form-group">
            <label for="first-name">First Name:</label>
            <input type="text" class="form-control" name="firstName" id="firstName" required>
          </div>
          <div class="form-group">
            <label for="first-name">Last Name:</label>
            <input type="text" class="form-control" name="lastName" id="lastName" required>
          </div>
          <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" class="form-control" name="userEmail" id="userEmail" required>
          </div>
          <div class="form-group">
            <label for="pwd">Phone:</label>
            <input type="number" class="form-control" name="userPhone" id="userPhone" required maxlength="10">
          </div>
          <div class="fileUploadInput">
            <label class="fileLable">Upload Profile Image</label>
            <input type="text" placeholder="No profile uploaded" name="fileNameInput" value="<?= isset($fileName) ? $fileName : ''; ?>" readonly>
            <input type="file" name="profileImage" id="hiddenProfileImage" style="display:none;">
            <ul>
              <li>
                <!-- <button type="button" class="delete-image" data-id="<?= $imageId; ?>">
                  <img src="<?//= base_url('assets/images/delete_icon.png'); ?>" />
                </button> -->
              </li>
              <li>|</li>
              <li>
                <button type="button" data-toggle="modal" data-target="#fileexampleModal" class="modalOpenbutton">
                  <img class="userIconIMG" id="profilePreview" src="<?= !empty($profilePicture) ? base_url('uploads/' . $profilePicture) : base_url('assets/images/user_thume_img.png'); ?>" alt="Profile Picture">
                </button>
              </li>
            </ul>

          </div>
          <small class="ImgNots">Note: You can only upload only JPG and PNG files</small>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">SAVE</button>
          </div>

        </form>
      </div>


      <!-- User List Table -->
      <h2>Users List</h2>
      <table class="table table-bordered" id="userListTable">
        <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Image</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- Dynamic user rows will be appended here -->
        </tbody>
      </table>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade cusModal_Me" id="fileexampleModal" tabindex="-1" role="dialog" aria-labelledby="fileexampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Upload Image</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Already Upload Images</button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="selectprofile_dropdoun">
              <div class="drop-zone">
                <span class="drop-zone__prompt">
                  <img src="<?= base_url('assets/images/file-add_icon.png'); ?>" class="fileIconSection" />
                  <h2>Select Files to Upload</h2>
                  <p>or Drag and Drop, Copy and Paste Files</p>
                </span>
                <input type="file" name="modalProfileImage" id="modalProfileImage" class="drop-zone__input" required accept="image/png, image/jpeg ,image/jpg">
              </div>
              <div class="modal-footer">
                <button type="button" class="cancelbTN" data-dismiss="modal">Cancel</button>
                <button type="button" id="okButton" class="btn btn-primary">OK</button>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="searchSection">
              <div class="search-box">
                <input type="text" class="search-input" placeholder="Search Images..." onkeyup="searchImages()">
                <button class="search-button">
                  <img src="<?= base_url('assets/images/search_icon.png'); ?>" />
                </button>
              </div>
              <h6 class="aler_mGESS">Already uploaded media</h6>
              <ul class="cusUl" id="imageList">
                <?php
                $uploadDir = 'uploads/';
                $images = glob($uploadDir . "*.{jpg,jpeg,png}", GLOB_BRACE);
                foreach ($images as $image) {
                  $imagePath = base_url($image);
                  $imageName = basename($image);
                  echo '<li class="image-item" data-name="' . $imageName . '" data-path="' . $imagePath . '">
                                                <button type="button" class="selectImageButton"><img src="' . $imagePath . '" class="img-fluid" /></button>
                                            </li>';
                }
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>