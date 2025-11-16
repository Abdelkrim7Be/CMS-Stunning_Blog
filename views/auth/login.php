<div class="auth-card">
    <div class="auth-header">
        <h2><i class="fas fa-lock"></i> Admin Login</h2>
        <p class="mb-0">Welcome to CMS Stunning Blog</p>
    </div>
    <div class="auth-body">
        <form action="/login" method="POST">
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-key"></i> Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
    </div>
</div>