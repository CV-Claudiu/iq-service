-- IQ SERVICE - Ziua 12
-- Nomenclatorul categoriilor de echipamente.
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin: click pe baza iq_service, apoi fila SQL.
 
CREATE TABLE IF NOT EXISTS categorii (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    denumire  VARCHAR(100) NOT NULL UNIQUE
);
 
INSERT INTO categorii (denumire) VALUES
('Centrală termică - gaz'),
('Pompe de căldură aer-apă'),
('Panouri solare termice'),
('Invertor'),
('Tablou electric'),
('Automat programabil (PLC)'),
('Senzor'),
('Sistem de ventilație'),
('Sistem de climatizare'),
('Sistem de încălzire în pardoseală'),
('Sistem de încălzire prin radiatoare'),
('Sistem de încălzire prin convectoare'),
('Sistem de încălzire prin calorifere'),
('Sistem de încălzire prin panouri radiante'),
('Sistem de încălzire prin pompe de căldură'),
('Sistem de încălzire prin centrale termice pe gaz'),
('Sistem de încălzire prin centrale termice pe lemne'),
('Sistem de încălzire prin centrale termice pe peleți'),
('Sistem de încălzire prin centrale termice pe biomasă');