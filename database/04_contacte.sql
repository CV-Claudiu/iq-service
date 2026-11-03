-- IQ SERVICE - Ziua 10
-- Tabelul persoanelor de contact. Fiecare contact aparține unui client (client_id).
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin: click pe baza iq_service, apoi fila SQL.
 
CREATE TABLE IF NOT EXISTS contacte (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    client_id  INT NOT NULL,
    nume       VARCHAR(150) NOT NULL,
    functie    VARCHAR(100),
    telefon    VARCHAR(20),
    email      VARCHAR(150),
    creat_la   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clienti(id)
);
 
INSERT INTO contacte (client_id, nume, functie, telefon, email) VALUES
(1, 'Andrei Pop',      'Director tehnic',     '0750 000 201', 'andrei.pop@automatizari.exemplu.ro'),
(1, 'Elena Rusu',      'Responsabil achiziții','0750 000 202', 'elena.rusu@automatizari.exemplu.ro'),
(2, 'Victor Neagu',    'Administrator',       '0750 000 203', 'victor@termoplast.exemplu.ro'),
(3, 'Cristina Dobre',  'Inginer mentenanță',  '0750 000 204', 'cristina.dobre@electrocontrol.exemplu.ro'),
(3, 'Mihai Stan',      'Șef secție',          '0750 000 205', NULL),
(4, 'Raluca Munteanu', 'Contabil',            '0750 000 206', 'contabilitate@moldovapanouri.exemplu.ro'),
(5, 'Dan Lungu',       'Director general',    '0750 000 207', 'dan.lungu@carpatiinstal.exemplu.ro'),
(7, 'Ioana Pavel',     'Inginer automatist',  '0750 000 208', 'ioana.pavel@somessenzori.exemplu.ro');
