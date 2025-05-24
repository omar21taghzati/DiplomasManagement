<!-- Edit Profile Modal -->
<div class="modal fade" id="showEditProfileModal" tabindex="-1" aria-labelledby="EditProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-brown-header text-white">
                <h5 class="modal-title" id="EditProfileLabel">Edit Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="alert alert-success d-none" id="editProfileSuccess">Profile updated successfully</div>

                <form method="POST" id="editProfileForm" enctype="multipart/form-data">
                    @csrf

                    <!-- Profile Photo -->
                    <div class="mb-3 text-center">
                        <img src="" id="profilePreview" class="rounded-circle mb-2" width="100" height="100" alt="Profile Image">
                        <div>
                            <label class="form-label">Upload your photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/png, image/jpeg" onchange="previewImage(event)">
                            <p class="text-danger small" id="error_photo"></p>
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label>Full name</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <p class="text-danger small" id="error_name"></p>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                        <p class="text-danger small" id="error_email"></p>
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-3">
                        <label>Phone number</label>
                        <input type="text" name="phone"  id="phone"  class="form-control">
                        <p class="text-danger small" id="error_phone"></p>
                    </div>

                    <!-- About Me -->
                    <div class="mb-3">
                        <label>About me</label>
                        <textarea name="about" id="about" class="form-control" rows="3"></textarea>
                        <p class="text-danger small" id="error_about"></p>
                    </div>

                    <button type="submit" class="btn bg-brown-header text-white">Save profile</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('profilePreview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('editProfileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        axios.post("/profile/edit", formData)
            .then(response => {
                console.log(response);
                document.querySelectorAll('.text-danger').forEach(el => el.innerHTML = '');
                document.getElementById('editProfileSuccess').classList.remove('d-none');
                window.location.reload();
            })
            .catch(error => {
                if (error.response && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    console.log(errors);
                    for (const field in errors) {
                        console.log(field)
                        document.getElementById(`error_${field}`).innerText = errors[field][0];
                    }
                }
            });
    });

    document.getElementById('showEditProfileModal').addEventListener('hidden.bs.modal', function() {
        this.querySelector('form').reset();
        document.querySelectorAll('.text-danger').forEach(el => el.innerHTML = '');
        document.getElementById('editProfileSuccess').classList.add('d-none');
    });
</script>
@endpush
