@extends($layout)

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-brown-header text-white">
                        <h3 class="mb-0">{{ $user->name }}</h3>
                    </div>

                    <div class="card-body">
                        <div class="text-center mb-4">
                            {{-- Display user's profile image with alt text and fallback --}}
                            @php
                                use Illuminate\Support\Str;

                                $photo = $user->photo;
                                $photoUrl = $photo
                                    ? (Str::contains($photo, 'images')
                                        ? asset('storage/' . $photo)
                                        : $photo)
                                    : asset('storage/images/woman.png');
                            @endphp
                            <img src="{{ $photoUrl }}" alt="{{ $user->name }}'s Profile Picture"
                                class="rounded-circle img-thumbnail" width="150" height="150" loading="lazy">
                        </div>

                        <div class="profile-details mb-4">
                            <p><strong>Email:</strong> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                            <p><strong>Phone Number:</strong> {{ $user->phone ?? 'N/A' }}</p>
                            <p><strong>Birth Date:</strong> {{ $user->date_naissance ?? 'N/A' }}</p>
                            <div>
                                <strong>Biography:</strong>
                                <p class="text-muted">{{ $user->about ?? 'No biography provided.' }}</p>
                            </div>
                        </div>

                        <hr>

                        <h4 class="text-center mt-4 mb-3">Settings Options</h4>

                        <div class="d-flex justify-content-center gap-4 settings-options">
                            {{-- <button type="button" class="btn btn-sm text-decoration-none text-center text-brown" aria-label="Change Password">
                            <i class="fas fa-key fa-2x" aria-hidden="true"
                                data-bs-target='#showChangePasswordModal' data-bs-toggle='modal'></i>
                            <p class="mb-0 mt-2">Change Password</p>
                        </button> --}}
                            <button type="button" class="btn btn-sm d-flex flex-column align-items-center text-primary"
                                aria-label="Change Password" data-bs-toggle="modal"
                                data-bs-target="#showChangePasswordModal">
                                <i class="fas fa-key fa-2x" aria-hidden="true"></i>
                                <span class="mt-1 small">Change Password</span>
                            </button>

                            {{-- <a href="" class="text-decoration-none text-center text-brown" aria-label="Edit Profile">
                                <i class="fas fa-cog fa-2x" aria-hidden="true"></i>
                                <p class="mb-0 mt-2">Edit Profile</p>
                            </a> --}}
                            <button type="button"
                                class="btn btn-sm d-flex flex-column align-items-center text-primary show-edit-profile"
                                aria-label="EditProfileLabel" data-bs-toggle="modal" data-bs-target="#showEditProfileModal">
                                <i class="fas fa-cog fa-2x" aria-hidden="true"></i>
                                <p class="mb-0 mt-2">Edit Profile</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('profile.partials.change-password-modal')
    @include('profile.partials.edit-modal')

    @push('scripts')
        {{-- <script>
            $(document).ready(function() {
                $('.show-edit-profile').on('click', function(e) {
                    const user = @json($user);

                    $('#name').val(user.name);
                    $('#email').val(user.email);
                    $('#phone').val(user.phone);
                    $('#about').val(user.about);

                    if (user.photo) {
                        if(user.photo.firstContain('images'))
                          const defaultPhoto =  "{{ asset(user.photo) }}";
                        $('#profilePreview').attr('src', defaultPhoto);
                        else
                        $('#profilePreview').attr('src', user.photo);

                    } else {
                        const defaultPhoto = user.role === 'gestionnaire' ?
                            "{{ asset('images/woman.png') }}" :
                            "{{ asset('images/man.png') }}";
                        $('#profilePreview').attr('src', defaultPhoto);
                    }
                });
            });
        </script> --}}

        <script>
            $(document).ready(function() {
                $('.show-edit-profile').on('click', function(e) {
                    const user = @json($user);
                    $('#name').val(user.name);
                    $('#email').val(user.email);
                    $('#phone').val(user.phone);
                    $('#about').val(user.about);

                    const photo = user.photo;
                    let photoUrl;

                    if (photo) {
                        if (photo.includes('images')) {
                            photoUrl = '{{ asset('storage') }}/' + photo;
                        } else {
                            photoUrl = photo;
                        }
                    } else {
                        photoUrl = '{{ asset('storage/images/woman.png') }}';
                    }

            
                    $('#profilePreview').attr('src', photoUrl);
                });
            });
        </script>
    @endpush
@endsection
