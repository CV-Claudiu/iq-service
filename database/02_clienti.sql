-- IQ SERVICE - Ziua 4
-- Tabelul clienților și câteva date de test (firme fictive).
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin: click pe baza iq_service, apoi fila SQL.
 
CREATE TABLE IF NOT EXISTS clienti (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    denumire  VARCHAR(150) NOT NULL,
    oras      VARCHAR(100) NOT NULL,
    telefon   VARCHAR(20),
    email     VARCHAR(150),
    creat_la  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 
INSERT INTO clienti (denumire, oras, telefon, email) VALUES
('Automatizări Industriale SRL', 'Cluj-Napoca', '0740 000 101', 'office@automatizari.exemplu.ro'),
('Termoplast Service SRL',       'București',   '0740 000 102', 'contact@termoplast.exemplu.ro'),
('Electro Control SA',           'Timișoara',   '0740 000 103', 'office@electrocontrol.exemplu.ro'),
('Moldova Panouri SRL',          'Iași',        '0740 000 104', 'vanzari@moldovapanouri.exemplu.ro'),
('Carpați Instal SRL',           'Brașov',      '0740 000 105', 'office@carpatiinstal.exemplu.ro'),
('Port Energy SRL',              'Constanța',   '0740 000 106', 'contact@portenergy.exemplu.ro'),
('Someș Senzori SRL',            'Cluj-Napoca', '0740 000 107', 'office@somessenzori.exemplu.ro'),
('Dâmbovița Tech SRL',           'București',   '0740 000 108', 'office@dambovitatech.exemplu.ro');
