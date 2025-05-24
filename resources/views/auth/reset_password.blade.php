<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
</head>

<body>
    <div class="cotainer">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    <div class="card-header">Forgot Password</div>

                    <div class="card-body">

                        <form action="" method="POST">
                            @csrf
                            @if (session()->has('status'))
                                <div>{{ session()->get('status') }}</div>
                            @endif
                            {{-- email --}}
                            <div class="form-group row">

                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                    Address</label>

                                <div class="col-md-6">

                                    <input type="text" id="email_address" class="form-control" name="email"
                                        required autofocus>

                                    @error('email')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror

                                </div>

                            </div>
                            {{-- button reset password --}}
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    reset
                                </button>
                            </div>
                        </form>



                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
