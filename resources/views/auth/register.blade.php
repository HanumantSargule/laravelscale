<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">

                    <h3 class="text-center mb-4">Create Account</h3>

                    <div id="errorBox"></div>

                    <form id="registerForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>
                    </form>

                    <p class="text-center mt-3">
                        Already have an account?
                        <a href="/login">Login</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('/api/register', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        let errorBox = document.getElementById('errorBox');
        errorBox.innerHTML = '';

        if (!data.status) {
            let errors = '<div class="alert alert-danger">';
            for (let key in data.errors) {
                errors += data.errors[key][0] + '<br>';
            }
            errors += '</div>';
            errorBox.innerHTML = errors;
        } else {
            errorBox.innerHTML =
                '<div class="alert alert-success">' + data.message + '</div>';
        }
    });
});
</script>

</body>
</html>
