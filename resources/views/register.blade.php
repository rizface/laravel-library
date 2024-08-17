<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Library Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .register-form {
            width: 100%;
            max-width: 500px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    @include('sweetalert::alert')
    <div class="register-form">
        <h3 class="text-center mb-4">Library Registration</h3>
        <form method="POST" action="{{route('process.register')}}">
            @csrf
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input name="firstname" type="text" class="form-control" id="firstname" required placeholder="Enter your first name">
                <span class="text-danger">
                    {{$errors->any() ? $errors->first('firstname') : ''}}
                </span>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Enter your last name">
            </div>
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input name="nim" type="text" class="form-control" id="nim" required placeholder="Enter your student ID (NIM)">
                <span class="text-danger">
                    {{$errors->any() ? $errors->first('nim') : ''}}
                </span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="password" required placeholder="Enter your password">
                <span class="text-danger">
                    {{$errors->any() ? $errors->first('password') : ''}}
                </span>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Password Confirmation</label>
                <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" required placeholder="Enter your password confirmation">
                <span class="text-danger">
                    {{$errors->any() ? $errors->first('password_confirmation') : ''}}
                </span>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>