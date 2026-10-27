-- IQ SERVICE - Ziua 7
-- Adăugăm coloana „activ”: 1 = client activ, 0 = client dezactivat.
-- Clienții NU se șterg din baza de date; doar se dezactivează.
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin: click pe baza iq_service, apoi fila SQL.
 
ALTER TABLE clienti
    ADD COLUMN activ TINYINT(1) NOT NULL DEFAULT 1;
