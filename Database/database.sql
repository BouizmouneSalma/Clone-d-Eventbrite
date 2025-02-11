-- Table principale (utilisateur de base)
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'participant', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table pour les administrateurs (hérite de users)
CREATE TABLE admins (
    id SERIAL PRIMARY KEY REFERENCES users(id),
    admin_specific_field VARCHAR(255) 
) INHERITS (users);

-- Table pour les organisateurs (hérite de users)
CREATE TABLE organizers (
    id SERIAL PRIMARY KEY REFERENCES users(id),
    organizer_specific_field VARCHAR(255)
) INHERITS (users);

-- Table pour les participants (hérite de users)
CREATE TABLE participants (
    id SERIAL PRIMARY KEY REFERENCES users(id),
    participant_specific_field VARCHAR(255) 
) INHERITS (users);


-- Categories table
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL
);

-- Events table
CREATE TABLE events (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    date TIMESTAMP NOT NULL,
    location VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    capacity INTEGER NOT NULL,
    organizer_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE, 
    category_id INTEGER NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
    is_validated BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tickets table
CREATE TABLE tickets (
    id SERIAL PRIMARY KEY,
    event_id INTEGER NOT NULL REFERENCES events(id) ON DELETE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE, 
    quantity INTEGER NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tags table
CREATE TABLE tags (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL
);

-- Event_tags table (Many-to-Many Relationship between events and tags)
CREATE TABLE event_tags (
    event_id INTEGER NOT NULL REFERENCES events(id) ON DELETE CASCADE,
    tag_id INTEGER NOT NULL REFERENCES tags(id) ON DELETE CASCADE,
    PRIMARY KEY (event_id, tag_id)
);

-- Ajouter un index sur le rôle des utilisateurs pour des recherches rapides
CREATE INDEX idx_users_role ON users(role);
