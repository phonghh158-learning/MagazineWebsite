<?php

    return [
        'secret_key_256' => 'SB2si9Mj191106051412LS20hfa1Qiwml3gEQMHongPhongHoang',
        'host' => '127.0.0.1',
        'database' => 'magazine_db',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ]

?>