<?php 
$title = "Đăng ký tài khoản";
$css = '/assets/css/auth.css'; 

$content = '
    <section class="register-section">
        <div class="title">
            <p>Register</p>
        </div>
        <form class="register-form" method="POST" action="/register">
            <label for="fullname">Họ và tên</label>
            <input type="text" id="fullname" name="fullname" required>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
                            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
                            
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" required>
                            
            <label for="confirm-password">Xác nhận mật khẩu</label>
            <input type="password" id="confirm-password" name="confirm-password" required>
                            
            <button type="submit">Register</button>
        </form>

        <br>
        <p>Nếu đã có tài khoản<p>
        <div class="section-button">
            <a href="/login">
                Đăng nhập
            </a>
        </div>
    </section>
';

include __DIR__ . '/../layout.php';

?>