<nav>
    <ul>
        <li>
            <a href="/" class="nav-link" id="home">
                <i class='bx bx-home-alt-2'></i>
            </a>
        </li>
        <li>
            <a href="/news" class="nav-link" id="news">
                <i class='bx bxs-news'></i>
            </a>
        </li>
        <?php
            if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'admin') {
                echo "
                <li>
                    <a href=\"/category\" class=\"nav-link\">
                        <i class='bx bx-category'></i>
                    </a>
                </li>
                ";
            }
        ?>
        <?php
            if (isset($_SESSION['user_id'])) {
                echo "
                <li>
                    <a href=\"/news/create\" class=\"nav-link\">
                        <i class='bx bx-pen'></i>
                    </a>
                </li>
                ";
            }
        ?>
        <li>
            <a href="#" class="nav-link" id="theme">
                <i class='bx bxs-moon'></i>
                <i class='bx bxs-sun'></i>
            </a>
        </li>
    </ul>
    <br />
    <ul>
        <?php
            if (isset($_SESSION['user_id'])) {
                echo "
                    <li>
                        <a href=\"/profile\" class=\"nav-link\" id=\"profile\" alt=\"Register\">
                            <i class='bx bx-user'></i>
                        </a>
                    </li>
                    <li>
                        <a href=\"/logout\" class=\"nav-link\" id=\"log-out\">
                            <i class='bx bx-log-out'></i>
                        </a>
                    </li>
                ";
            } else {
                echo "
                    <li>
                        <a href=\"/register\" class=\"nav-link\" id=\"profile\">
                            <i class='bx bx-user'></i>
                        </a>
                    </li>
                ";
            }
        ?>
    </ul>
</nav>