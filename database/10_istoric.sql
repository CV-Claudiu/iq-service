-- IQ SERVICE - Ziua 18
-- Istoricul solicitărilor: fiecare schimbare de status (și fiecare notă) rămâne scrisă aici.
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin, pe baza iq_service.
 
CREATE TABLE IF NOT EXISTS solicitari_istoric (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    solicitare_id  INT NOT NULL,
    utilizator_id  INT NOT NULL,
    status_vechi   ENUM('noua', 'in_lucru', 'rezolvata', 'inchisa') NOT NULL,
    status_nou     ENUM('noua', 'in_lucru', 'rezolvata', 'inchisa') NOT NULL,
    nota           TEXT,
    creat_la       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (solicitare_id) REFERENCES solicitari(id),
    FOREIGN KEY (utilizator_id) REFERENCES utilizatori(id)
);
