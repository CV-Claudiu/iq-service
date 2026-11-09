-- IQ SERVICE - Ziua 14
-- Nomenclatorul serviciilor oferite de firmă, fiecare cu prețul lui.
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin: click pe baza iq_service, apoi fila SQL.
 
CREATE TABLE IF NOT EXISTS servicii (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    denumire  VARCHAR(150) NOT NULL UNIQUE,
    pret      DECIMAL(10,2) NOT NULL
);
 
INSERT INTO servicii (denumire, pret) VALUES
('Constatare tehnică',              150.00),
('Revizie anuală centrală termică', 250.00),
('Intervenție la avarie',           300.00),
('Montaj echipament',               500.00),
('Punere în funcțiune',             200.00),
('Manoperă (oră)',                  120.00),
('Programare PLC (oră)',            180.00);