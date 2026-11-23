-- IQ SERVICE - Ziua 20
-- Activitățile: tot ce facem pentru un client (telefoane, vizite, e-mailuri, intervenții).
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin, pe baza iq_service.
 
CREATE TABLE IF NOT EXISTS activitati (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    client_id        INT NOT NULL,
    solicitare_id    INT NULL,
    utilizator_id    INT NOT NULL,
    tip              ENUM('telefon', 'vizita', 'email', 'interventie', 'alta') NOT NULL,
    data_activitate  DATETIME NOT NULL,
    durata_minute    INT NULL,
    descriere        TEXT NOT NULL,
    creat_la         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id)     REFERENCES clienti(id),
    FOREIGN KEY (solicitare_id) REFERENCES solicitari(id),
    FOREIGN KEY (utilizator_id) REFERENCES utilizatori(id)
);
 
INSERT INTO activitati (client_id, solicitare_id, utilizator_id, tip, data_activitate, durata_minute, descriere) VALUES
(2, 1,    2, 'telefon',     '2026-11-02 08:40:00', 5,    'Clientul anunță că centrala nu pornește, eroarea F28.'),
(2, 1,    3, 'vizita',      '2026-11-02 11:00:00', 90,   'Am verificat centrala. Senzorul de presiune e defect, am comandat piesa.'),
(7, 4,    3, 'interventie', '2026-11-05 10:00:00', 45,   'Senzorul de umiditate a fost recalibrat, valorile sunt corecte.'),
(1, NULL, 2, 'email',       '2026-11-06 09:15:00', NULL, 'Am trimis clientului programarea pentru revizia anuală.'),
(4, NULL, 2, 'telefon',     '2026-11-06 14:30:00', 10,   'Clientul întreabă de o ofertă pentru extinderea instalației fotovoltaice.');
