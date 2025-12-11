-- Mood-Based Film Recommendation Database
-- Create database
CREATE DATABASE IF NOT EXISTS mood_film_recommendation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mood_film_recommendation;

-- Films table
CREATE TABLE IF NOT EXISTS films (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    thumbnail VARCHAR(500) NOT NULL,
    mood VARCHAR(50) NOT NULL,
    energy_level INT NOT NULL CHECK (energy_level BETWEEN 1 AND 5),
    platform VARCHAR(100) NOT NULL,
    platform_url VARCHAR(500) NOT NULL,
    description TEXT,
    year INT,
    genre VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin (username: admin, password: admin123)
-- Password hash generated using PHP password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO admin_users (username, password) VALUES 
('admin', '$2y$10$X9pL9cOvzgD6EZWeCSugRuyFAUNAlbXNkevRuY8lXgkCLlW2nGHD2'); -- password: admin123

-- Insert sample films (60 films with different moods and energy levels)
INSERT INTO films (title, thumbnail, mood, energy_level, platform, platform_url, description, year, genre) VALUES
-- Energi Mood (Energy Level 4-5)
('Avengers: Endgame', 'https://via.placeholder.com/300x450/FF0000/FFFFFF?text=Avengers', 'energi', 5, 'netflix', 'https://www.netflix.com', 'Superhero action film', 2019, 'Action'),
('Mad Max: Fury Road', 'https://via.placeholder.com/300x450/FF4500/FFFFFF?text=Mad+Max', 'energi', 5, 'primevideo', 'https://www.primevideo.com', 'Post-apocalyptic action', 2015, 'Action'),
('John Wick', 'https://via.placeholder.com/300x450/8B0000/FFFFFF?text=John+Wick', 'energi', 5, 'netflix', 'https://www.netflix.com', 'Action thriller', 2014, 'Action'),
('Fast & Furious 9', 'https://via.placeholder.com/300x450/DC143C/FFFFFF?text=Fast+9', 'energi', 5, 'vidio', 'https://www.vidio.com', 'Action racing film', 2021, 'Action'),
('The Matrix', 'https://via.placeholder.com/300x450/000080/FFFFFF?text=Matrix', 'energi', 4, 'netflix', 'https://www.netflix.com', 'Sci-fi action', 1999, 'Sci-Fi'),
('Inception', 'https://via.placeholder.com/300x450/191970/FFFFFF?text=Inception', 'energi', 4, 'primevideo', 'https://www.primevideo.com', 'Mind-bending thriller', 2010, 'Thriller'),
('Mission: Impossible', 'https://via.placeholder.com/300x450/800080/FFFFFF?text=MI', 'energi', 5, 'netflix', 'https://www.netflix.com', 'Spy action film', 1996, 'Action'),
('The Dark Knight', 'https://via.placeholder.com/300x450/000000/FFFFFF?text=Dark+Knight', 'energi', 4, 'primevideo', 'https://www.primevideo.com', 'Superhero film', 2008, 'Action'),
('Gladiator', 'https://via.placeholder.com/300x450/8B4513/FFFFFF?text=Gladiator', 'energi', 4, 'netflix', 'https://www.netflix.com', 'Epic historical drama', 2000, 'Drama'),
('300', 'https://via.placeholder.com/300x450/FFD700/000000?text=300', 'energi', 5, 'vidio', 'https://www.vidio.com', 'Epic war film', 2006, 'Action'),

-- Semangat Mood (Energy Level 3-5)
('Rocky', 'https://via.placeholder.com/300x450/FF6347/FFFFFF?text=Rocky', 'semangat', 5, 'netflix', 'https://www.netflix.com', 'Inspirational sports film', 1976, 'Drama'),
('The Pursuit of Happyness', 'https://via.placeholder.com/300x450/FFA500/000000?text=Happyness', 'semangat', 4, 'primevideo', 'https://www.primevideo.com', 'Inspirational drama', 2006, 'Drama'),
('Remember the Titans', 'https://via.placeholder.com/300x450/FF8C00/FFFFFF?text=Titans', 'semangat', 4, 'netflix', 'https://www.netflix.com', 'Sports drama', 2000, 'Drama'),
('The Karate Kid', 'https://via.placeholder.com/300x450/FF7F50/FFFFFF?text=Karate+Kid', 'semangat', 4, 'vidio', 'https://www.vidio.com', 'Martial arts drama', 1984, 'Drama'),
('Coach Carter', 'https://via.placeholder.com/300x450/FF4500/FFFFFF?text=Coach', 'semangat', 5, 'netflix', 'https://www.netflix.com', 'Sports drama', 2005, 'Drama'),
('A Beautiful Mind', 'https://via.placeholder.com/300x450/FFD700/000000?text=Beautiful+Mind', 'semangat', 3, 'primevideo', 'https://www.primevideo.com', 'Biographical drama', 2001, 'Drama'),
('The Blind Side', 'https://via.placeholder.com/300x450/FFA500/000000?text=Blind+Side', 'semangat', 4, 'netflix', 'https://www.netflix.com', 'Sports drama', 2009, 'Drama'),
('Whiplash', 'https://via.placeholder.com/300x450/FF6347/FFFFFF?text=Whiplash', 'semangat', 5, 'primevideo', 'https://www.primevideo.com', 'Music drama', 2014, 'Drama'),
('Rudy', 'https://via.placeholder.com/300x450/FF8C00/FFFFFF?text=Rudy', 'semangat', 4, 'vidio', 'https://www.vidio.com', 'Sports drama', 1993, 'Drama'),
('The Shawshank Redemption', 'https://via.placeholder.com/300x450/FF7F50/FFFFFF?text=Shawshank', 'semangat', 3, 'netflix', 'https://www.netflix.com', 'Prison drama', 1994, 'Drama'),

-- Bahagia Mood (Energy Level 2-4)
('The Intouchables', 'https://via.placeholder.com/300x450/FFD700/000000?text=Intouchables', 'bahagia', 3, 'netflix', 'https://www.netflix.com', 'Comedy drama', 2011, 'Comedy'),
('The Grand Budapest Hotel', 'https://via.placeholder.com/300x450/FFA500/000000?text=Budapest', 'bahagia', 3, 'primevideo', 'https://www.primevideo.com', 'Comedy drama', 2014, 'Comedy'),
('Amélie', 'https://via.placeholder.com/300x450/FF6347/FFFFFF?text=Amelie', 'bahagia', 2, 'netflix', 'https://www.netflix.com', 'Romantic comedy', 2001, 'Comedy'),
('The Secret Life of Walter Mitty', 'https://via.placeholder.com/300x450/FF8C00/FFFFFF?text=Walter+Mitty', 'bahagia', 3, 'vidio', 'https://www.vidio.com', 'Adventure comedy', 2013, 'Comedy'),
('Little Miss Sunshine', 'https://via.placeholder.com/300x450/FF7F50/FFFFFF?text=Sunshine', 'bahagia', 3, 'netflix', 'https://www.netflix.com', 'Comedy drama', 2006, 'Comedy'),
('The Lego Movie', 'https://via.placeholder.com/300x450/FFD700/000000?text=Lego', 'bahagia', 4, 'primevideo', 'https://www.primevideo.com', 'Animated comedy', 2014, 'Animation'),
('Zootopia', 'https://via.placeholder.com/300x450/FFA500/000000?text=Zootopia', 'bahagia', 4, 'netflix', 'https://www.netflix.com', 'Animated comedy', 2016, 'Animation'),
('Paddington', 'https://via.placeholder.com/300x450/FF6347/FFFFFF?text=Paddington', 'bahagia', 2, 'vidio', 'https://www.vidio.com', 'Family comedy', 2014, 'Comedy'),
('The Princess Bride', 'https://via.placeholder.com/300x450/FF8C00/FFFFFF?text=Princess+Bride', 'bahagia', 3, 'netflix', 'https://www.netflix.com', 'Romantic comedy', 1987, 'Comedy'),
('Sing', 'https://via.placeholder.com/300x450/FF7F50/FFFFFF?text=Sing', 'bahagia', 4, 'primevideo', 'https://www.primevideo.com', 'Musical comedy', 2016, 'Animation'),

-- Romantis Mood (Energy Level 1-3)
('The Notebook', 'https://via.placeholder.com/300x450/FF69B4/FFFFFF?text=Notebook', 'romantis', 2, 'netflix', 'https://www.netflix.com', 'Romantic drama', 2004, 'Romance'),
('Pride and Prejudice', 'https://via.placeholder.com/300x450/FF1493/FFFFFF?text=P%26P', 'romantis', 1, 'primevideo', 'https://www.primevideo.com', 'Period romance', 2005, 'Romance'),
('La La Land', 'https://via.placeholder.com/300x450/FFB6C1/FFFFFF?text=La+La+Land', 'romantis', 3, 'netflix', 'https://www.netflix.com', 'Musical romance', 2016, 'Musical'),
('Before Sunrise', 'https://via.placeholder.com/300x450/FF69B4/FFFFFF?text=Sunrise', 'romantis', 1, 'vidio', 'https://www.vidio.com', 'Romantic drama', 1995, 'Romance'),
('The Fault in Our Stars', 'https://via.placeholder.com/300x450/FF1493/FFFFFF?text=Fault+Stars', 'romantis', 2, 'netflix', 'https://www.netflix.com', 'Romantic drama', 2014, 'Romance'),
('500 Days of Summer', 'https://via.placeholder.com/300x450/FFB6C1/FFFFFF?text=500+Days', 'romantis', 2, 'primevideo', 'https://www.primevideo.com', 'Romantic comedy', 2009, 'Romance'),
('Eternal Sunshine of the Spotless Mind', 'https://via.placeholder.com/300x450/FF69B4/FFFFFF?text=Eternal', 'romantis', 2, 'netflix', 'https://www.netflix.com', 'Romantic sci-fi', 2004, 'Romance'),
('Her', 'https://via.placeholder.com/300x450/FF1493/FFFFFF?text=Her', 'romantis', 1, 'vidio', 'https://www.vidio.com', 'Romantic sci-fi', 2013, 'Romance'),
('Call Me by Your Name', 'https://via.placeholder.com/300x450/FFB6C1/FFFFFF?text=Call+Me', 'romantis', 1, 'netflix', 'https://www.netflix.com', 'Romantic drama', 2017, 'Romance'),
('The Shape of Water', 'https://via.placeholder.com/300x450/FF69B4/FFFFFF?text=Shape+Water', 'romantis', 2, 'primevideo', 'https://www.primevideo.com', 'Romantic fantasy', 2017, 'Fantasy'),

-- Tenang Mood (Energy Level 1-2)
('The Tree of Life', 'https://via.placeholder.com/300x450/87CEEB/000000?text=Tree+Life', 'tenang', 1, 'netflix', 'https://www.netflix.com', 'Philosophical drama', 2011, 'Drama'),
('Lost in Translation', 'https://via.placeholder.com/300x450/4682B4/FFFFFF?text=Translation', 'tenang', 1, 'primevideo', 'https://www.primevideo.com', 'Drama', 2003, 'Drama'),
('Paterson', 'https://via.placeholder.com/300x450/5F9EA0/FFFFFF?text=Paterson', 'tenang', 1, 'netflix', 'https://www.netflix.com', 'Drama', 2016, 'Drama'),
('A Ghost Story', 'https://via.placeholder.com/300x450/708090/FFFFFF?text=Ghost+Story', 'tenang', 1, 'vidio', 'https://www.vidio.com', 'Drama', 2017, 'Drama'),
('The Grandmaster', 'https://via.placeholder.com/300x450/2F4F4F/FFFFFF?text=Grandmaster', 'tenang', 2, 'netflix', 'https://www.netflix.com', 'Martial arts drama', 2013, 'Drama'),
('Arrival', 'https://via.placeholder.com/300x450/4682B4/FFFFFF?text=Arrival', 'tenang', 2, 'primevideo', 'https://www.primevideo.com', 'Sci-fi drama', 2016, 'Sci-Fi'),
('Her', 'https://via.placeholder.com/300x450/5F9EA0/FFFFFF?text=Her+2', 'tenang', 1, 'netflix', 'https://www.netflix.com', 'Sci-fi drama', 2013, 'Sci-Fi'),
('The Revenant', 'https://via.placeholder.com/300x450/708090/FFFFFF?text=Revenant', 'tenang', 2, 'vidio', 'https://www.vidio.com', 'Survival drama', 2015, 'Drama'),
('Moonlight', 'https://via.placeholder.com/300x450/2F4F4F/FFFFFF?text=Moonlight', 'tenang', 1, 'netflix', 'https://www.netflix.com', 'Coming-of-age drama', 2016, 'Drama'),
('The Artist', 'https://via.placeholder.com/300x450/4682B4/FFFFFF?text=Artist', 'tenang', 1, 'primevideo', 'https://www.primevideo.com', 'Silent film', 2011, 'Drama'),

-- Galau Mood (Energy Level 1-3)
('Blue Valentine', 'https://via.placeholder.com/300x450/4169E1/FFFFFF?text=Blue+Valentine', 'galau', 2, 'netflix', 'https://www.netflix.com', 'Romantic drama', 2010, 'Drama'),
('Requiem for a Dream', 'https://via.placeholder.com/300x450/0000CD/FFFFFF?text=Requiem', 'galau', 3, 'primevideo', 'https://www.primevideo.com', 'Psychological drama', 2000, 'Drama'),
('Melancholia', 'https://via.placeholder.com/300x450/191970/FFFFFF?text=Melancholia', 'galau', 1, 'netflix', 'https://www.netflix.com', 'Drama', 2011, 'Drama'),
('Manchester by the Sea', 'https://via.placeholder.com/300x450/000080/FFFFFF?text=Manchester', 'galau', 1, 'vidio', 'https://www.vidio.com', 'Drama', 2016, 'Drama'),
('Her', 'https://via.placeholder.com/300x450/4169E1/FFFFFF?text=Her+3', 'galau', 2, 'netflix', 'https://www.netflix.com', 'Romantic sci-fi', 2013, 'Romance'),
('Eternal Sunshine of the Spotless Mind', 'https://via.placeholder.com/300x450/0000CD/FFFFFF?text=Eternal+2', 'galau', 2, 'primevideo', 'https://www.primevideo.com', 'Romantic sci-fi', 2004, 'Romance'),
('Lost in Translation', 'https://via.placeholder.com/300x450/191970/FFFFFF?text=Translation+2', 'galau', 1, 'netflix', 'https://www.netflix.com', 'Drama', 2003, 'Drama'),
('The Perks of Being a Wallflower', 'https://via.placeholder.com/300x450/000080/FFFFFF?text=Wallflower', 'galau', 2, 'vidio', 'https://www.vidio.com', 'Coming-of-age drama', 2012, 'Drama'),
('A Single Man', 'https://via.placeholder.com/300x450/4169E1/FFFFFF?text=Single+Man', 'galau', 1, 'netflix', 'https://www.netflix.com', 'Drama', 2009, 'Drama'),
('Brokeback Mountain', 'https://via.placeholder.com/300x450/0000CD/FFFFFF?text=Brokeback', 'galau', 2, 'primevideo', 'https://www.primevideo.com', 'Romantic drama', 2005, 'Romance');

