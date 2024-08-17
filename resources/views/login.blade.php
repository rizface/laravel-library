<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Library Login</title>
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
        .login-form {
            width: 100%;
            max-width: 400px;
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
    <div class="login-form">
        <h3 class="text-center mb-4">Library Login</h3>
        <form method="POST" action="{{route('process.login')}}">
            @csrf
            <div class="mb-3">
                <label for="id_num" class="form-label">NIM / NIP</label>
                <input name="id_num" type="text" class="form-control" id="id_num" placeholder="NIM / NIP">
                <span class="text-danger">
                    {{$errors->any() ? $errors->first('id_num') : ''}}
                </span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="Enter your password">
                <span class="text-danger">
                    {{$errors->any() ? $errors->first('password') : ''}}
                </span>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
