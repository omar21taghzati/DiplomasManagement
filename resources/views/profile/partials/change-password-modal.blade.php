{{-- <div class="modal fade" id='showChangePasswordModal' tabindex="-1" aria-labelledby="Change Password" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Wider modal -->
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-brown-header text-white">
                <h5 class="modal-title" id="RequestModalLabel">Change Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="alert alert-success" style="display: none;" id='msg'>Password Changed successfully
                </div>

                <form method="POST" id='changePassword'>


                    <div class="mb-3">
                        <label>Current Password</label>
                        <input type="password" name="current_password" class="form-control">
                        <p class="text-red-500 text-xs mt-2 text-danger" id='error_current_password'></p>
                    </div>
                    {{-- <div class="mb-3 position-relative">
                        <label>Current Password</label>
                        <div class="position-relative">
                            <input type="password" name="current_password" class="form-control pe-5"
                                id="currentPasswordInput">
                            <i class="fa fa-eye position-absolute top-50 translate-middle-y end-0 me-3 text-muted"
                                style="cursor: pointer;" id="toggleCurrentPassword"></i>
                        </div>
                        <p class="text-red-500 text-xs mt-2 text-danger" id='error_current_password'></p>
                    </div> --}}


{{-- <div class="mb-3">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control">
                        <p class="text-red-500 text-xs mt-2 text-danger" id='error_new_password'></p>
                    </div>


                    <div class="mb-3">
                        <label>Confirmed Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control">
                        <p class="text-red-500 text-xs mt-2 text-danger" id='error_confirmed_password'></p>
                    </div>

                    <button type="submit" class="btn bg-brown-header text-white">save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}


<div class="modal fade" id='showChangePasswordModal' tabindex="-1" aria-labelledby="Change Password" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-brown-header text-white">
                <h5 class="modal-title" id="RequestModalLabel">Change Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="alert alert-success" style="display: none;" id='msg'>Password Changed successfully
                </div>

                <form method="POST" id='changePassword'>

                    {{-- Current Password --}}
                    <div class="mb-3 position-relative">
                        <label>Current Password</label>
                        <input type="password" name="current_password" class="form-control pe-5" id="currentPassword">
                        <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                            style="cursor: pointer;" onclick="togglePassword('currentPassword', this)"></i>
                        <p class="text-danger text-xs mt-2" id='error_current_password'></p>
                    </div>

                    {{-- New Password --}}
                    <div class="mb-3 position-relative">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control pe-5" id="newPassword">
                        <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                            style="cursor: pointer;" onclick="togglePassword('newPassword', this)"></i>
                        <p class="text-danger text-xs mt-2" id='error_new_password'></p>
                    </div>

                    {{-- Confirmed Password --}}
                    <div class="mb-3 position-relative">
                        <label>Confirmed Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control pe-5" id="confirmPassword">
                        <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                            style="cursor: pointer;" onclick="togglePassword('confirmPassword', this)"></i>
                        <p class="text-danger text-xs mt-2" id='error_confirmed_password'></p>
                    </div>
                    
                    <button type="submit" class="btn bg-brown-header text-white">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('changePassword').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            // console.log(e.target);
            const formData = new FormData(form);
            // console.log(formData);
            axios.post("/password/change", formData)
                .then(response => {
                    // console.log(response);
                    document.querySelectorAll('.text-danger').forEach(el => el.innerHTML = '');
                    if (response.data.error) {
                        document.getElementById('error_current_password').innerText = response.data.error;
                    } else {
                        document.getElementById('msg').style.display = "block";
                        window.location.reload();
                    }
                    // $('#showFormRequestModal').modal('hide');

                })
                .catch(error => {
                    if (error.response && error.response.data.errors) {
                        const errors = error.response.data.errors;
                        console.log(errors);
                        if (errors.current_password) {
                            document.getElementById('error_current_password').innerText = errors
                                .current_password[0];
                        }
                        if (errors.new_password) {
                            document.getElementById('error_new_password').innerText = errors.new_password[0];
                        }
                        if (errors.new_password_confirmation) {
                            document.getElementById('error_confirmed_password').innerText = errors
                                .new_password_confirmation[0];
                        }

                    } else {
                        console.error('Unexpected error:', error);
                    }
                });

        });

        document.getElementById('showChangePasswordModal').addEventListener('hidden.bs.modal', function() {
            this.querySelector('form').reset(); // Reset form fields
            document.getElementById('msg-success').style.display = "none";
            this.querySelectorAll('.text-danger').forEach(el => el.innerHTML = ''); // Clear error messages
        });

        // Toggle password visibility function
        function togglePassword(id, icon) {
            const input = document.getElementById(id);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>
@endpush
