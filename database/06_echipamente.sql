-- IQ SERVICE - Ziua 12
-- Echipamentele clienților. Fiecare echipament aparține unui client și are o categorie.
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin, DUPĂ 05_categorii.sql.
 
CREATE TABLE IF NOT EXISTS echipamente (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    client_id       INT NOT NULL,
    categorie_id    INT NOT NULL,
    denumire        VARCHAR(150) NOT NULL,
    serie           VARCHAR(50),
    data_instalare  DATE,
    observatii      VARCHAR(255),
    creat_la        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id)    REFERENCES clienti(id),
    FOREIGN KEY (categorie_id) REFERENCES categorii(id)
);
 
INSERT INTO echipamente (client_id, categorie_id, denumire, serie, data_instalare, observatii) VALUES
(1, 6, 'PLC linie de ambalare',             'PLC-2201', '2023-05-10', 'Linia 2, hala A'),
(1, 5, 'Tablou electric principal',         'TE-0107',  '2021-11-03', NULL),
(1, 7, 'Senzor de temperatură hală',        'ST-3310',  '2024-02-20', NULL),
(2, 1, 'Centrală în condensare 35 kW',      'CT-88412', '2022-10-01', 'Revizie anuală în octombrie'),
(2, 2, 'Pompă de căldură aer-apă 12 kW',    'PC-5521',  '2024-04-18', NULL),
(3, 5, 'Tablou electric secundar',          'TE-0219',  '2020-06-15', NULL),
(4, 3, 'Panouri fotovoltaice acoperiș 20 kW','PV-1020', '2023-07-01', '48 de panouri'),
(4, 4, 'Invertor trifazat 20 kW',           'INV-7781', '2023-07-01', NULL),
(5, 1, 'Centrală termică birouri',          'CT-10233', NULL,         'Data instalării necunoscută'),
(7, 7, 'Senzor de umiditate depozit',       'SU-0042',  '2025-01-09', NULL),
(7, 6, 'PLC stație de pompare',             'PLC-4410', '2022-03-22', NULL),
(8, 2, 'Pompă de căldură sol-apă 16 kW',    'PC-6602',  '2025-03-14', NULL);
