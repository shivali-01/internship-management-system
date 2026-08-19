-- Internship Portal Database Schema
-- Create the database first if not exists: CREATE DATABASE internship_portal;

USE internship_portal;

-- Companies Table
CREATE TABLE IF NOT EXISTS companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    industry VARCHAR(100) NOT NULL,
    description TEXT,
    website VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Internships Table
CREATE TABLE IF NOT EXISTS internships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    duration VARCHAR(100) NOT NULL,
    stipend DECIMAL(10,2) NOT NULL,
    last_date_to_apply DATE NOT NULL,
    description TEXT NOT NULL,
    requirements TEXT,
    skills_required TEXT,
    vacancies INT DEFAULT 1,
    internship_type VARCHAR(50) DEFAULT 'Full-time',
    status VARCHAR(20) DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

-- Sample Data (Optional)
-- INSERT INTO companies (company_name, email, password, phone, address, industry, description, website)
-- VALUES ('Tech Corp', 'hr@techcorp.com', 'password_hash_here', '9876543210', 'New Delhi', 'IT', 'Leading tech firm', 'www.techcorp.com');
