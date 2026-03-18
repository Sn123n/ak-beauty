@extends('admin.layouts.header')

@section('content')
    <div class="content">

        <!-- Start Content-->

        <div class="container-fluid">



            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-header">

                            <div class="d-flex justify-content-between align-items-center">

                                <h4 class="header-title">Add User</h4>

                                <a href="{{ route('users.index') }}" class="btn btn-primary">Manage User</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"
                                id="userform">
                                @csrf
                                <input type="hidden" name="role_id" id="role_id" value="2">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6">

                                        <div class="mb-3">

                                            <label for="email" class="form-label">Email</label>

                                            <input type="email" id="email" name="email" class="form-control"
                                                value="{{ old('email') }}">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="text" id="password" name="password" class="form-control"
                                                value="{{ old('password') }}">
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">

                                        <div class="mb-3">

                                            <label for="name" class="form-label">Name</label>

                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ old('name') }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="moblie" class="form-label">Mobile Number</label>
                                            <input type="text" id="phone" name="phone" class="form-control"
                                                value="{{ old('phone') }}" maxlength="10"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,10)">

                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">

                                        <div class="mb-3">

                                            <label for="moblie" class="form-label">Gender</label>

                                            <select id="gender" name="gender" class="form-control form-select">
                                                <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="moblie" class="form-label">Date Of Birth</label>
                                            <input type="date" id="dob" name="dob" class="form-control"
                                                value="{{ old('dob') }}">
                                            @error('dob')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Country</label>
                                            <select name="country" id="country_name" class="form-control form-select">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->location_id }}"
                                                        {{ old('country') == $country->location_id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <div class="mb-3">
                                            <label for="state" class="form-label">State</label>
                                            <select class="form-control form-select" id="state_name" name="state">
                                                <option value="">Select State</option>
                                                @if (old('state'))
                                                    <option value="{{ old('state') }}" selected>{{ old('state_name') }}
                                                    </option>
                                                @endif
                                            </select>
                                            @error('state')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <div class="mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <select class="form-control form-select" id="city_name" name="city">
                                                <option value="">Select City</option>
                                                @if (old('city'))
                                                    <option value="{{ old('city') }}" selected>{{ old('city_name') }}
                                                    </option>
                                                @endif
                                            </select>
                                            @error('city')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="pincode" class="form-label">Pincode</label>
                                            <input type="number" id="pincode" name="pincode" class="form-control"
                                                value="{{ old('pincode') }}">
                                            @error('pincode')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control" name="address" id="address">{{ old('address') }}</textarea>
                                            @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Image</label>

                                            <input type="file" id="image" name="image" class="form-control">
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label ">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                    Deactive</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-12">

                                        <div class="">

                                            <button type="submit" class="btn btn-primary">Submit</button>

                                        </div>

                                    </div>

                                </div> <!-- end row-->

                            </form>

                        </div> <!-- end card-body -->

                    </div> <!-- end card -->

                </div><!-- end col -->

            </div><!-- end row -->

        </div> <!-- container -->
    </div> <!-- content -->

    @include('admin.layouts.footer')
    <script>
      document.addEventListener("DOMContentLoaded", function() {
    let form = document.getElementById("userform");

    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent immediate form submission
        let isValid = validateForm();

        let email = document.getElementById("email").value.trim();
        if (!email) {
            showError("email", "Email is required.");
            isValid = false;
        } else if (!validateEmail(email)) {
            showError("email", "Enter a valid email address.");
            isValid = false;
        } else {
            checkDuplicateEmail(email, (exists) => {
                if (exists) {
                    showError("email", "This email is already exist.");
                } else {
                    removeError("email");

                    if (isValid) {
                        form.submit();
                    }
                }
            });

            return; // Wait for AJAX response
        }
    });

    function validateForm() {
        let isValid = true;

        let fields = [
            { id: "password", message: "Password is required.", minLength: 6 },
            { id: "name", message: "Name is required." },
            { id: "phone", message: "Mobile number is required.", exactLength: 10 },
            { id: "gender", message: "Gender is required.", select: true },
            { id: "dob", message: "Date of Birth is required." },
            { id: "country_name", message: "Country is required.", select: true },
            { id: "state_name", message: "State is required.", select: true },
            { id: "city_name", message: "City is required.", select: true },
            { id: "pincode", message: "Pincode is required.", minLength: 6 },
            { id: "address", message: "Address is required." }
        ];

        fields.forEach(field => {
            let element = document.getElementById(field.id);
            let value = element.value.trim();

            if (!value || (field.select && value === "")) {
                showError(field.id, field.message);
                isValid = false;
            } else if (field.minLength && value.length < field.minLength) {
                showError(field.id, `${field.message.split(" is required")[0]} must be at least ${field.minLength} characters.`);
                isValid = false;
            } else if (field.exactLength && value.length !== field.exactLength) {
                showError(field.id, `${field.message.split(" is required")[0]} must be exactly ${field.exactLength} digits.`);
                isValid = false;
            } else {
                removeError(field.id);
            }
        });

        return isValid;
    }

    function validateEmail(email) {
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function checkDuplicateEmail(email, callback) {
        fetch("{{ route('checkemail') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => callback(data.exists))
        .catch(error => console.error("Error:", error));
    }

    function showError(id, message) {
        let element = document.getElementById(id);
        removeError(id);
        let errorDiv = document.createElement("div");
        errorDiv.className = "text-danger";
        errorDiv.innerText = message;
        element.insertAdjacentElement("afterend", errorDiv);
    }

    function removeError(id) {
        let element = document.getElementById(id);
        let nextElement = element.nextElementSibling;
        if (nextElement && nextElement.classList.contains("text-danger")) {
            nextElement.remove();
        }
    }

    // ** Add event listeners to remove error on input change **
    let inputFields = ["password", "name", "phone", "email", "dob", "pincode", "address"];
    let selectFields = ["gender", "country_name", "state_name", "city_name"];

    inputFields.forEach(id => {
        let element = document.getElementById(id);
        element.addEventListener("input", function() {
            removeError(id);
        });
    });

    selectFields.forEach(id => {
        let element = document.getElementById(id);
        element.addEventListener("change", function() {
            removeError(id);
        });
    });
});

    </script>
    

    <script>
        $(document).ready(function() {
            $('#country_name').on('change', function() {
                var country_id = $(this).val();
                var stateDropdown = $('#state_name');
                var cityDropdown = $('#city_name');

                if (country_id) {
                    $.ajax({
                        url: "{{ route('fetch_states_by_country') }}",
                        method: 'GET',
                        data: {
                            country_id: country_id
                        },
                        success: function(response) {
                            stateDropdown.empty().append(
                                '<option value="">Select State</option>');
                            cityDropdown.empty().append('<option value="">Select City</option>')
                                .prop('disabled', true);

                            response.states.forEach(function(state) {
                                stateDropdown.append('<option value="' + state
                                    .location_id + '">' + state.name + '</option>');
                            });

                            stateDropdown.prop('disabled', false); // Enable state dropdown
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                } else {
                    stateDropdown.empty().append('<option value="">Select State</option>').prop('disabled',
                        true);
                    cityDropdown.empty().append('<option value="">Select City</option>').prop('disabled',
                        true);
                }
            });

            $('#state_name').on('change', function() {
                var state_id = $(this).val();
                var cityDropdown = $('#city_name');

                if (state_id) {
                    $.ajax({
                        url: "{{ route('fetch_cities_by_state') }}",
                        method: 'GET',
                        data: {
                            state_id: state_id
                        },
                        success: function(response) {
                            cityDropdown.empty().append(
                                '<option value="">Select City</option>');

                            response.cities.forEach(function(city) {
                                cityDropdown.append('<option value="' + city
                                    .location_id + '">' + city.name + '</option>');
                            });

                            cityDropdown.prop('disabled', false); // Enable city dropdown
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                } else {
                    cityDropdown.empty().append('<option value="">Select City</option>').prop('disabled',
                        true);
                }
            });
        });

        $(document).ready(function() {
            var oldCountry = "{{ old('country') }}";
            var oldState = "{{ old('state') }}";
            var oldCity = "{{ old('city') }}";

            if (oldCountry) {
                $("#country_name").val(oldCountry).trigger('change');
            }

            if (oldState) {
                setTimeout(function() {
                    $("#state_name").val(oldState).trigger('change');
                }, 1000);
            }

            if (oldCity) {
                setTimeout(function() {
                    $("#city_name").val(oldCity);
                }, 2000);
            }
        });
    </script>
@endsection
