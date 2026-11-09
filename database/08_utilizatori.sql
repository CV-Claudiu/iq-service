-- IQ SERVICE - Ziua 14
-- Utilizatorii aplicației: cine lucrează în IQ SERVICE și cu ce rol.
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin, pe baza iq_service.
-- Parola de laborator a celor trei conturi de test: Parola123!
 
CREATE TABLE IF NOT EXISTS utilizatori (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nume         VARCHAR(150) NOT NULL,
    email        VARCHAR(150) NOT NULL UNIQUE,
    parola_hash  VARCHAR(255) NOT NULL,
    rol          ENUM('administrator', 'operator', 'agent') NOT NULL DEFAULT 'agent',
    activ        TINYINT(1) NOT NULL DEFAULT 1,
    creat_la     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 
INSERT INTO utilizatori (nume, email, parola_hash, rol) VALUES
('Ana Popescu',   'ana@iqservice.exemplu.ro',   '$2y$10$K3c91dJNhIi6kjqbZEu9OOsHKbIVrOxWOKhhGOLHv5SHWZKcaRUDK', 'administrator'),
('Mihai Ionescu', 'mihai@iqservice.exemplu.ro', '$2y$10$2ePorSwWwMNTHN/.XKAe5OOaZI3SYyhKKtilu05mPmXatOc/JyIza', 'operator'),
('Radu Stan',     'radu@iqservice.exemplu.ro',  '$2y$10$IHDvIgSRnD2dJPvOrwS4g.5/vE4zRMxC1ptqJ5p9WCe4UuS9yXAOm', 'agent');