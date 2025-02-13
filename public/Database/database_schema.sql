-- Créer la base de données
CREATE DATABASE event_managementF;

-- Se connecter à la base de données
\c event_managementf;




-- Table principale des utilisateurs
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    role VARCHAR(50) NOT NULL CHECK (role IN ('admin', 'organizer', 'participant')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des administrateurs héritant de users
CREATE TABLE admins (
    admin_level INTEGER NOT NULL CHECK (admin_level BETWEEN 1 AND 3)
) INHERITS (users);

-- Table des organisateurs héritant de users
CREATE TABLE organizers (
    company_name VARCHAR(255),
    website VARCHAR(255)
) INHERITS (users);

-- Table des participants héritant de users
CREATE TABLE participants (
    phone_number VARCHAR(20),
    address TEXT
) INHERITS (users);

-- Assurer l'unicité des emails à travers toutes les tables enfants
CREATE UNIQUE INDEX unique_email ON users(email);

-- Table des catégories d'événements
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- Table des événements
CREATE TABLE events (
    id SERIAL PRIMARY KEY,
    organizer_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    category_id INTEGER REFERENCES categories(id) ON DELETE SET NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date TIMESTAMP NOT NULL,
    location VARCHAR(255),
    total_tickets INTEGER NOT NULL,
    tickets_sold INT DEFAULT 0,
    price DECIMAL(10, 2) NOT NULL,
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des tickets
CREATE TABLE tickets (
    id SERIAL PRIMARY KEY,
    event_id INTEGER REFERENCES events(id) ON DELETE CASCADE,
    ticket_number VARCHAR(50) UNIQUE NOT NULL,
    status VARCHAR(20) DEFAULT 'available' CHECK (status IN ('available', 'sold', 'reserved'))
);

-- Table des réservations
CREATE TABLE reservations (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    ticket_id INTEGER REFERENCES tickets(id) ON DELETE CASCADE,
    reservation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'active' CHECK (status IN ('active', 'canceled'))
);

-- Table des codes promo
CREATE TABLE promo_codes (
    id SERIAL PRIMARY KEY,
    event_id INTEGER REFERENCES events(id) ON DELETE CASCADE,
    code VARCHAR(50) UNIQUE NOT NULL,
    discount_percentage INTEGER NOT NULL CHECK (discount_percentage BETWEEN 1 AND 100),
    valid_from TIMESTAMP,
    valid_to TIMESTAMP
);

-- ✅ Ajout d'index pour optimiser les requêtes
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_events_organizer_id ON events(organizer_id);
CREATE INDEX idx_tickets_event_id ON tickets(event_id);
CREATE INDEX idx_reservations_user_id ON reservations(user_id);