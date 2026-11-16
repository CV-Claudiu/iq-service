-- IQ SERVICE - Ziua 17
-- Solicitările de service: cererile clienților, legate de client, echipament și tehnician.
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin: click pe baza iq_service, apoi fila SQL.
 
CREATE TABLE IF NOT EXISTS solicitari (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    client_id      INT NOT NULL,
    echipament_id  INT NULL,
    titlu          VARCHAR(150) NOT NULL,
    descriere      TEXT,
    prioritate     ENUM('mica', 'normala', 'urgenta') NOT NULL DEFAULT 'normala',
    status         ENUM('noua', 'in_lucru', 'rezolvata', 'inchisa') NOT NULL DEFAULT 'noua',
    agent_id       INT NULL,
    creat_de       INT NOT NULL,
    creat_la       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id)     REFERENCES clienti(id),
    FOREIGN KEY (echipament_id) REFERENCES echipamente(id),
    FOREIGN KEY (agent_id)      REFERENCES utilizatori(id),
    FOREIGN KEY (creat_de)      REFERENCES utilizatori(id)
);
 
INSERT INTO solicitari (client_id, echipament_id, titlu, descriere, prioritate, status, agent_id, creat_de, creat_la) VALUES
(2, 4,    'Centrala nu pornește',                  'Centrala afișează eroarea F28 de azi-dimineață.\nNu au apă caldă în birouri.', 'urgenta', 'in_lucru',  3,    2, '2026-11-02 08:45:00'),
(1, 1,    'Revizie anuală PLC linie de ambalare',  'Revizia programată din contract.',                                      'normala', 'noua',      3,    2, '2026-11-03 10:20:00'),
(4, 8,    'Invertorul afișează o avertizare',      'Avertizare de temperatură, apare la prânz.',                             'normala', 'noua',      NULL, 2, '2026-11-04 12:05:00'),
(7, 10,   'Senzorul de umiditate dă valori ciudate','Valori de peste 100% în depozit.',                                      'mica',    'rezolvata', 3,    2, '2026-11-04 15:30:00'),
(3, NULL, 'Ofertă pentru un tablou electric nou',  'Clientul își extinde hala și vrea o ofertă.',                            'mica',    'noua',      NULL, 2, '2026-11-05 09:10:00'),
(5, 9,    'Zgomot puternic la centrală',           'Se aude o bubuitură la pornire.',                                        'urgenta', 'noua',      NULL, 2, '2026-11-05 16:40:00');
