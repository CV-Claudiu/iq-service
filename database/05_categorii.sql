-- IQ SERVICE - Ziua 12
-- Nomenclatorul categoriilor de echipamente.
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin: click pe baza iq_service, apoi fila SQL.
 
CREATE TABLE IF NOT EXISTS categorii (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    denumire  VARCHAR(100) NOT NULL UNIQUE
);
 
INSERT INTO categorii (denumire) VALUES
('Centrală termică'),
('Pompă de căldură'),
('Panou fotovoltaic'),
('Invertor'),
('Tablou electric'),
('Automat programabil (PLC)'),
('Senzor'),
('Sistem de ventilație');
