-- Users Table
CREATE TABLE Users (
    id CHAR(36) PRIMARY KEY UNIQUE NOT NULL,
    username NVARCHAR(255) UNIQUE NOT NULL,
    fullname NVARCHAR(255) NOT NULL,
    email NVARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password NVARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    avatar NVARCHAR(255) NULL,
    bio TEXT NULL,
    status ENUM('active', 'banned', 'deleted') DEFAULT 'active',
    remember_token NVARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Categories Table
CREATE TABLE Categories (
    id CHAR(36) PRIMARY KEY UNIQUE NOT NULL,
    name NVARCHAR(255) NOT NULL UNIQUE,
    icon VARCHAR(255) NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Magazine Posts Table
CREATE TABLE Magazine_Posts (
    id CHAR(36) PRIMARY KEY UNIQUE NOT NULL,
    title NVARCHAR(255) NOT NULL,
    thumbnail NVARCHAR(255) NULL,
    paragraphs LONGTEXT NOT NULL,
    status ENUM('public', 'pending', 'deleted') DEFAULT 'pending',
    category_id CHAR(36),
    author_id CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES Categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES Users(id) ON DELETE SET NULL
);

-- Magazine Post Reviews Table
CREATE TABLE Reviews (
    id CHAR(36) PRIMARY KEY UNIQUE NOT NULL,
    post_id CHAR(36),
    user_id CHAR(36),
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (post_id) REFERENCES Magazine_Posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);

