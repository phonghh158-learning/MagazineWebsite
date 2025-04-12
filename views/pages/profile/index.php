<?php

$title = "Thông tin tài khoản";
$css = "/assets/css/profile.css";

$avatar = $user->getAvatar();
$fullname = $user->getFullname();
$username = $user->getUsername();
$email = $user->getEmail();

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

                <section class="section" id="profile">
                    <div class="title"><p>Profile</p></div>

                    <form class="profile-form" action="/profile/update/avatar" method="POST" enctype="multipart/form-data">
                        <div class="profile-avatar" id="profile-avatar">
                            <img class="avatar-image" src="/'. $avatar .'" id="avatar-image" alt="Profile Picture">
                            <i class=\'bx bx-chevrons-right icon-to\' id="icon-to"></i>
                            <label class="avatar-upload" id="avatar-upload">
                                <input type="file" name="avatar_update" accept=".jpg, .jpeg, .png, .gif" hidden onchange="handleAvatarChange(this)">
                                <img src="" alt="avatar" id="avatar-update" class="avatar-update">
                                <div class="avatar-box">
                                    <i class=\'bx bx-upload\'></i>
                                    <p>Upload Avatar</p>
                                </div>
                            </label>
                        </div>
                        <div class="profile-buttons">
                            <input type="submit" value="Tải lên">
                        </div>
                    </form>

                    <br>

                    <form class="profile-form" action="/profile/update/information" method="POST">
                        <div class="profile-information">
                            <label for="fullname">Fullname</label>
                            <input type="text" name="fullname" id="fullname" value="' . $fullname . '" placeholder="Tên của bạn" class="information-input" required readonly>

                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" value="' . $username . '" placeholder="Username" class="information-input" required readonly>

                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="' . $email . '" placeholder="Email" class="information-input" required readonly>
                        </div>

                        <div class="profile-buttons">
                            <input type="reset" value="Reset">
                            <input type="submit" value="Submit">
                        </div>
                    </form>

                    <div class="profile-function" id="profile-function">
                        <i class=\'bx bx-edit\' id="profile-function-icon"></i>
                        <p>Chỉnh sửa thông tin</p>
                    </div>
                </section>
';

$js = "/assets/js/profile.js";
include_once __DIR__ . '/../../layout.php';
?>