<?php
// IQ SERVICE - conexiunea la baza de date prin PDO
 
function getConnection(array $config): PDO
{
    $dsn = 'mysql:host=' . $config['DB_HOST']
         . ';port='      . $config['DB_PORT']
         . ';dbname='    . $config['DB_NAME']
         . ';charset=utf8mb4';
 
    $optiuni = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
 
    return new PDO($dsn, $config['DB_USER'], $config['DB_PASS'], $optiuni);
}
