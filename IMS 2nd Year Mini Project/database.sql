-- Create Database
CREATE DATABASE IF NOT EXISTS restaurant_qr_system;
USE restaurant_qr_system;

-- Create Categories Table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE,
    icon VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Menu Items Table
CREATE TABLE menu_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    category_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    full_description TEXT,
    ingredients TEXT,
    image_url VARCHAR(255),
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Create Orders Table
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    table_number VARCHAR(20) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    gst_amount DECIMAL(10, 2) NOT NULL,
    grand_total DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'preparing', 'ready', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create Order Items Table
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id)
);

-- Insert Categories
INSERT INTO categories (name, slug, icon) VALUES
('All Items', 'all', '🍽️'),
('Starters', 'starters', '🥗'),
('Main Course', 'mains', '🍛'),
('Desserts', 'desserts', '🍰'),
('Beverages', 'drinks', '🥤');

-- Insert Sample Menu Items
INSERT INTO menu_items (name, category_id, price, description, full_description, ingredients, image_url) VALUES
('Crispy Spring Rolls', 2, 180.00, 
 'Fresh vegetables wrapped in crispy pastry with sweet chili sauce', 
 'Delicious spring rolls filled with fresh vegetables, glass noodles, and herbs. Served with our signature sweet chili dipping sauce. Perfect as an appetizer or light snack.',
 'Cabbage, Carrots, Glass Noodles, Spring Onions, Ginger, Garlic',
 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=400&h=300&fit=crop'),

('Garlic Breadsticks', 2, 120.00,
 'Toasted bread with garlic butter and herbs',
 'Freshly baked breadsticks topped with aromatic garlic butter, parsley, and parmesan cheese. Crispy on the outside, soft on the inside.',
 'Bread, Butter, Garlic, Parsley, Parmesan',
 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?w=400&h=300&fit=crop'),

('Tomato Basil Soup', 2, 140.00,
 'Creamy tomato soup with fresh basil',
 'Rich and creamy tomato soup made with ripe tomatoes, fresh cream, and aromatic basil. Served with crispy croutons.',
 'Tomatoes, Cream, Basil, Onions, Garlic',
 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=400&h=300&fit=crop'),

('Grilled Chicken Steak', 3, 380.00,
 'Tender chicken with herbs, served with vegetables',
 'Perfectly grilled chicken breast marinated in herbs and spices. Served with seasonal vegetables, mashed potatoes, and our signature sauce.',
 'Chicken Breast, Herbs, Vegetables, Potatoes',
 'https://images.unsplash.com/photo-1532550907401-a500c9a57435?w=400&h=300&fit=crop'),

('Pasta Alfredo', 3, 280.00,
 'Creamy pasta with parmesan cheese and mushrooms',
 'Classic Italian pasta in rich alfredo sauce made with cream, butter, and parmesan. Topped with sautéed mushrooms and fresh herbs.',
 'Pasta, Cream, Parmesan, Mushrooms, Garlic',
 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=400&h=300&fit=crop'),

('Margherita Pizza', 3, 320.00,
 'Classic pizza with fresh mozzarella and basil',
 'Authentic Italian pizza with hand-tossed dough, tangy tomato sauce, fresh mozzarella, and basil leaves. Baked in a wood-fired oven.',
 'Pizza Dough, Tomato Sauce, Mozzarella, Basil',
 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=400&h=300&fit=crop'),

('Biryani Special', 3, 350.00,
 'Aromatic basmati rice with spiced chicken',
 'Traditional biryani prepared with fragrant basmati rice, tender chicken, and a blend of authentic spices. Served with raita and gravy.',
 'Basmati Rice, Chicken, Spices, Yogurt, Saffron',
 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=400&h=300&fit=crop'),

('Paneer Tikka Masala', 3, 300.00,
 'Cottage cheese in rich tomato gravy',
 'Grilled paneer cubes cooked in a creamy tomato-based curry with aromatic spices. Best enjoyed with naan or rice.',
 'Paneer, Tomatoes, Cream, Spices, Onions',
 'https://images.unsplash.com/photo-1567188040759-fb8a883dc6d8?w=400&h=300&fit=crop'),

('Chocolate Lava Cake', 4, 160.00,
 'Warm cake with molten chocolate center',
 'Decadent chocolate cake with a gooey molten center. Served warm with vanilla ice cream and chocolate sauce.',
 'Dark Chocolate, Butter, Eggs, Sugar, Flour',
 'https://images.unsplash.com/photo-1624353365286-3f8d62daad51?w=400&h=300&fit=crop'),

('Ice Cream Sundae', 4, 140.00,
 'Vanilla ice cream with chocolate sauce and nuts',
 'Classic sundae with premium vanilla ice cream, hot chocolate fudge, whipped cream, nuts, and a cherry on top.',
 'Vanilla Ice Cream, Chocolate Sauce, Nuts, Cream',
 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400&h=300&fit=crop'),

('Tiramisu', 4, 180.00,
 'Classic Italian dessert with coffee and mascarpone',
 'Traditional Italian dessert layered with coffee-soaked ladyfingers and mascarpone cream. Dusted with cocoa powder.',
 'Mascarpone, Ladyfingers, Coffee, Cocoa, Eggs',
 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=400&h=300&fit=crop'),

('Fresh Lime Soda', 5, 80.00,
 'Refreshing lime with soda water',
 'Freshly squeezed lime juice mixed with soda water and a hint of mint. Available in sweet or salty version.',
 'Fresh Lime, Soda, Mint, Sugar/Salt',
 'https://images.unsplash.com/photo-1546173159-315724a31696?w=400&h=300&fit=crop'),

('Mango Smoothie', 5, 120.00,
 'Fresh mango blended with yogurt',
 'Thick and creamy smoothie made with fresh mangoes, yogurt, and honey. Topped with fresh fruit.',
 'Fresh Mango, Yogurt, Honey, Milk',
 'https://images.unsplash.com/photo-1505252585461-04db1eb84625?w=400&h=300&fit=crop'),

('Cold Coffee', 5, 100.00,
 'Iced coffee with milk and ice cream',
 'Rich coffee blended with milk, ice cream, and ice. Topped with whipped cream and chocolate syrup.',
 'Coffee, Milk, Ice Cream, Chocolate Syrup',
 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&h=300&fit=crop');