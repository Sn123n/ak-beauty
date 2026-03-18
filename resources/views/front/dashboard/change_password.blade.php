@include('front.dashboard.header')
<div class="main dashboard">
    <section class="change-password">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="password-form">
                        <h3>Change Password</h3>
                        <form id="password-form" action="{{ route('update.password') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">Current Password *</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password *</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" required minlength="8">
                                <small class="text-muted">Password must be at least 8 characters long</small>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password *</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Update Password</button>
                                <a href="{{ route('user.dashboard') }}" class="btn btn-outline">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    $('#password-form').submit(function(e) {
        var newPassword = $('#new_password').val();
        var confirmPassword = $('#confirm_password').val();
        
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('New password and confirm password do not match');
            return false;
        }
        
        if (newPassword.length < 8) {
            e.preventDefault();
            alert('Password must be at least 8 characters long');
            return false;
        }
    });
});
</script>

@include('front.dashboard.footer')
