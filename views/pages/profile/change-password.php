<?php

$title = 'Đổi mật khẩu';
$css = '/assets/css/profile.css';

$content = '
                <!-- Menu -->
                <div class="profile-bar" id="profile-bar">
                    <div id="menu-button">
                        <i class=\'bx bx-menu\'></i>
                    </div>
                    <a href="/profile" class="profile-bar-link">
                        <i class=\'bx bx-user\'></i>
                    </a>
                    <a href="/profile/change-password" class="profile-bar-link">
                        <i class=\'bx bx-lock-alt\'></i>
                    </a>
                    <a href="/your-posts" class="profile-bar-link">
                        <i class=\'bx bx-news\'></i>
                    </a>
                    <a href="/user-manager" class="profile-bar-link">
                        <i class=\'bx bxs-user-detail\'></i>
                    </a>
                </div>

                <section class="section" id="change-password">
                    <div class="title"><p>Change Password</p></div>
                    <form class="password-form" action="/profile/update/password" method="POST">
                        <label for="current-password">Current Password</label>
                        <input type="password" name="current_password" id="current-password" placeholder="Current Password" class="password-input" required>

                        <label for="new-password">New Password</label>
                        <input type="password" name="new_password" id="new-password" placeholder="New Password" class="password-input" required>

                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirm Password" class="password-input" required>

                        <div class="password-buttons">
                            <input type="reset" value="Reset">
                            <input type="submit" value="Submit">
                        </div>
                    </form>
                </section> 
';

$js = '/assets/js/profile.js';

include_once __DIR__ . '/../../layout.php';

?>