-- IQ SERVICE - Ziua 21
-- 18 solicitări în plus, ca lista să aibă mai multe pagini. Doar pentru laborator.
-- Se rulează O SINGURĂ DATĂ în phpMyAdmin, pe baza iq_service, după 09_solicitari.sql.
 
INSERT INTO solicitari (client_id, echipament_id, titlu, descriere, prioritate, status, agent_id, creat_de, creat_la) VALUES
(1, 2,    'Siguranța sare la pornirea liniei',      'Sare siguranța de 32 A la pornire.',          'urgenta', 'inchisa',   3,    2, '2026-10-01 09:00:00'),
(2, 5,    'Revizie pompă de căldură',              'Revizia de toamnă.',                          'normala', 'inchisa',   3,    2, '2026-10-03 10:30:00'),
(3, 6,    'Tabloul secundar se încălzește',        'Miros de plastic ars la tablou.',             'urgenta', 'inchisa',   3,    2, '2026-10-06 08:15:00'),
(4, 7,    'Curățarea panourilor fotovoltaice',     'Producția a scăzut după praful din vară.',    'mica',    'inchisa',   3,    2, '2026-10-08 13:00:00'),
(5, 9,    'Presiune scăzută în instalație',        'Presiunea scade sub 1 bar peste noapte.',     'normala', 'inchisa',   3,    2, '2026-10-10 11:45:00'),
(7, 11,   'PLC-ul stației de pompare se resetează','Se resetează de două ori pe zi.',             'urgenta', 'inchisa',   3,    2, '2026-10-13 07:50:00'),
(8, 12,   'Pompa de căldură nu atinge temperatura','În birouri sunt doar 18 grade.',              'normala', 'rezolvata', 3,    2, '2026-10-15 09:20:00'),
(1, 3,    'Senzorul de temperatură nu raportează', 'Lipsește valoarea în sistem de ieri.',        'mica',    'rezolvata', 3,    2, '2026-10-20 14:10:00'),
(2, 4,    'Instruire personal pentru centrală',    'Clientul are un administrator nou.',          'mica',    'inchisa',   3,    2, '2026-10-22 10:00:00'),
(3, NULL, 'Ofertă pentru iluminat de siguranță',   'Cerință nouă de la pompieri.',                'normala', 'noua',      NULL, 2, '2026-10-27 12:30:00'),
(4, 8,    'Invertorul se oprește la prânz',        'Se oprește când e soare puternic.',           'urgenta', 'in_lucru',  3,    2, '2026-10-29 12:05:00'),
(5, NULL, 'Mutarea centralei în altă încăpere',    'Clientul renovează birourile.',               'mica',    'noua',      NULL, 2, '2026-11-01 09:40:00'),
(7, 10,   'Verificare anuală senzori',             'Verificarea din contract.',                   'normala', 'noua',      3,    2, '2026-11-06 08:30:00'),
(8, 12,   'Zgomot la unitatea exterioară',         'Vibrații puternice la pornire.',              'normala', 'in_lucru',  3,    2, '2026-11-06 15:15:00'),
(1, 1,    'Actualizare program PLC',               'Clientul adaugă un produs nou pe linie.',     'normala', 'noua',      NULL, 2, '2026-11-07 10:00:00'),
(2, NULL, 'Ofertă pentru al doilea boiler',        'Vor apă caldă și în hală.',                   'mica',    'noua',      NULL, 2, '2026-11-08 11:20:00'),
(3, 6,    'Contor electric nou',                   'Montaj contor pentru hala nouă.',             'normala', 'noua',      NULL, 2, '2026-11-09 09:10:00'),
(4, 7,    'Un panou fotovoltaic fisurat',          'S-a văzut după grindină.',                    'urgenta', 'noua',      NULL, 2, '2026-11-10 16:45:00');
