<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Helvetica, Arial, sans-serif;
        }
        h1 {
            text-transform: uppercase;
            text-align: center;
            color: #666;
            font-weight: lighter;
        }
        form {
            width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        input, button, textarea {
            position: relative;
            appearance: none;
            margin: 0;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 10px;
            width: 100%;
            border: 1px solid #C7C7C7;
            background-color: #fafafa;
            transition: background-color 0.3s, border-color 0.4s;
        }
        textarea {
            height: 100px;
            resize: none;
        }
        input:focus, textarea:focus, input:hover, textarea:hover {
            outline: none;
            border-color: #777;
        }
        button.account {
            display: block;
            border: none;
            background-color: #666;
            color: #fff;
            height: 50px;
            line-height: 50px;
            padding: 0;
            transition: all 0.3s;
            cursor: pointer;
        }
        .header {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .header button {
            background-color: #666;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        .header button:hover {
            background-color: #555;
        }
        .date-container {
            padding: 20px;
            text-align: center;
        }
        .recentOrders {
            padding: 20px;
            /* Adjust this value as needed */
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="{{ route('homeDoctor') }}">
            <button class="btn btn-light">← Back</button>
        </a>
    </div>

    <div class="date-container">
        <p class="date-label">Today's Date</p>
        <p class="date-value">{{ now()->format('Y-m-d') }}</p>
    </div>

    <div class="recentOrders">
        <div class="card-body">
            <form method="POST" action="{{ route('account.update') }}">
                @csrf
                @method('PUT')

                <h6 class="card-title">Edit Profile</h6>
                
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name:') }}</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->name }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address:') }}</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->email }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="contactNumber" class="col-md-4 col-form-label text-md-end">{{ __('Contact Number:') }}</label>
                    <div class="col-md-6">
                        <input id="contactNumber" type="text" class="form-control @error('contactNumber') is-invalid @enderror" name="contactNumber" value="{{ auth()->user()->contactNumber }}" required autocomplete="contactNumber">
                        @error('contactNumber')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender:') }}</label>
                    <div class="col-md-6">
                        <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" required>
                            <option value="" disabled>Select your Gender</option>
                            <option value="Male" {{ auth()->user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ auth()->user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Others" {{ auth()->user()->gender == 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="maykad" class="col-md-4 col-form-label text-md-end">{{ __('MYkad:') }}</label>
                    <div class="col-md-6">
                        <input id="maykad" type="text" class="form-control @error('maykad') is-invalid @enderror" name="maykad" value="{{ auth()->user()->maykad }}" required autocomplete="maykad" pattern="\d{12}" title="MYkad must be exactly 12 digits" oninput="validateMYkad()">
                        @error('maykad')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div id="maykad-error" class="invalid-feedback" style="display: none;">
                            <strong>MYkad must be exactly 12 digits</strong>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="dateOfBirth" class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth:') }}</label>
                    <div class="col-md-6">
                        <input id="dateOfBirth" type="date" class="form-control @error('dateOfBirth') is-invalid @enderror" name="dateOfBirth" value="{{ auth()->user()->dateOfBirth }}" required autocomplete="dateOfBirth">
                        @error('dateOfBirth')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="address1" class="col-md-4 col-form-label text-md-end">{{ __('Address 1:') }}</label>
                    <div class="col-md-6">
                        <input id="address1" type="text" class="form-control @error('address1') is-invalid @enderror" name="address1" value="{{ auth()->user()->address1 }}" required autocomplete="address1">
                        @error('address1')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="address2" class="col-md-4 col-form-label text-md-end">{{ __('Address 2:') }}</label>
                    <div class="col-md-6">
                        <input id="address2" type="text" class="form-control @error('address2') is-invalid @enderror" name="address2" value="{{ auth()->user()->address2 }}" required autocomplete="address2">
                        @error('address2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="postcode" class="col-md-4 col-form-label text-md-end">{{ __('Postcode:') }}</label>
                    <div class="col-md-6">
                        <input id="postcode" type="text" class="form-control @error('postcode') is-invalid @enderror" name="postcode" value="{{ auth()->user()->postcode }}" required autocomplete="postcode">
                        @error('postcode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="state" class="col-md-4 col-form-label text-md-end">{{ __('State:') }}</label>
                    <div class="col-md-6">
                        <select id="state" class="form-control @error('state') is-invalid @enderror" name="state" required>
                            <option value="" disabled>Select your state</option>
                            <option value="johor" {{ auth()->user()->state == 'johor' ? 'selected' : '' }}>Johor</option>
                            <option value="melaka" {{ auth()->user()->state == 'melaka' ? 'selected' : '' }}>Melaka</option>
                            <option value="selangor" {{ auth()->user()->state == 'selangor' ? 'selected' : '' }}>Selangor</option>
                            <option value="terengganu" {{ auth()->user()->state == 'terengganu' ? 'selected' : '' }}>Terengganu</option>
                            <option value="kedah" {{ auth()->user()->state == 'kedah' ? 'selected' : '' }}>Kedah</option>
                            <option value="kelantan" {{ auth()->user()->state == 'kelantan' ? 'selected' : '' }}>Kelantan</option>
                            <option value="pulau_pinang" {{ auth()->user()->state == 'pulau_pinang' ? 'selected' : '' }}>Pulau Pinang</option>
                            <option value="sabah" {{ auth()->user()->state == 'sabah' ? 'selected' : '' }}>Sabah</option>
                            <option value="sarawak" {{ auth()->user()->state == 'sarawak' ? 'selected' : '' }}>Sarawak</option>
                            <option value="perlis" {{ auth()->user()->state == 'perlis' ? 'selected' : '' }}>Perlis</option>
                            <option value="perak" {{ auth()->user()->state == 'perak' ? 'selected' : '' }}>Perak</option>
                            <option value="pahang" {{ auth()->user()->state == 'pahang' ? 'selected' : '' }}>Pahang</option>
                        </select>
                        @error('state')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('City:') }}</label>
                    <div class="col-md-6">
                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ auth()->user()->city }}" required autocomplete="city">
                        @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password:') }}</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password:') }}</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button class="button.account" type="submit" class="btn btn-primary">
                            {{ __('Save Changes') }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Delete Account Form -->
            <form method="POST" action="{{ route('account.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button class="button.account" type="submit" style="background-color: red;">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validateMYkad() {
            const mykadInput = document.getElementById('maykad');
            const mykadError = document.getElementById('maykad-error');
            const onlyNumbers = /^\d*$/;

            if (mykadInput.value.length === 12 && onlyNumbers.test(mykadInput.value)) {
                mykadError.style.display = 'none';
                mykadInput.classList.remove('is-invalid');
            } else {
                mykadError.style.display = 'block';
                mykadInput.classList.add('is-invalid');
            }

            // Prevent non-numeric input
            mykadInput.value = mykadInput.value.replace(/\D/g, '');
        }
    </script>
</body>
</html>
