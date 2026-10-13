-- IQ SERVICE - Ziua 3
-- Creează baza de date a proiectului și un utilizator dedicat aplicației.
-- Se rulează o singură dată, din phpMyAdmin (fila SQL), conectat ca root.
-- Parola de mai jos este o parolă de LABORATOR, valabilă doar pe laptop.
-- Pe un server real se folosește altă parolă, trecută doar în fișierul .env.
 
CREATE DATABASE IF NOT EXISTS iq_service
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
 
CREATE USER IF NOT EXISTS 'iq_user'@'localhost' IDENTIFIED BY 'IqLab2026!';
CREATE USER IF NOT EXISTS 'iq_user'@'127.0.0.1' IDENTIFIED BY 'IqLab2026!';
 
GRANT ALL PRIVILEGES ON iq_service.* TO 'iq_user'@'localhost';
GRANT ALL PRIVILEGES ON iq_service.* TO 'iq_user'@'127.0.0.1';
 
FLUSH PRIVILEGES;
