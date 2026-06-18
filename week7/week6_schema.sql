-- Week 6 Schema: Normalized tables with relationships

-- Drop old tables in correct order (child first, then parent)
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS ratings;

-- Orders table
CREATE TABLE orders (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order items (line items for each order)
CREATE TABLE order_items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    order_id INT(11) NOT NULL,
    book_id INT(11) NOT NULL,
    quantity INT(11) NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- User ratings / reviews for books
CREATE TABLE ratings (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    book_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    rating DECIMAL(2,1) NOT NULL CHECK (rating >= 0.5 AND rating <= 5.0),
    review TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_rating (book_id, user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data for testing
INSERT INTO books (title, author, genre, price, stock, rating) VALUES
('The Alchemist', 'Paulo Coelho', 'Fiction', 12.99, 15, 4.5),
('Atomic Habits', 'James Clear', 'Productivity', 15.50, 8, 4.8),
('Rich Dad Poor Dad', 'Robert Kiyosaki', 'Business', 9.99, 3, 4.2),
('Clean Code', 'Robert C. Martin', 'Science', 29.99, 20, 4.6),
('The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', 10.99, 12, 4.1),
('Sapiens', 'Yuval Noah Harari', 'Science', 18.99, 7, 4.7),
('Deep Work', 'Cal Newport', 'Productivity', 14.99, 5, 4.4),
('Think and Grow Rich', 'Napoleon Hill', 'Business', 8.99, 25, 4.0);
