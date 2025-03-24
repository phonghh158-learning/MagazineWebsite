<?php 
$title = "Đăng nhập";
$css = '/assets/css/auth.css'; 

$content = '
    <section class="login-section">
        <div class="title">
            <p>Login</p>
        </div>
        <form class="login-form" method="POST" action="/login">
            <label for="login-email">Email</label>
            <input type="text" id="login-email" name="email" required>
                        
            <label for="login-password">Password</label>
            <input type="password" id="login-password" name="password" required>
                        
            <button type="submit">Login</button>
        </form>
    </section>
';

include __DIR__ . '/../layout.php';

?>