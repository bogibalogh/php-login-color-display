CREATE DATABASE IF NOT EXISTS adatok;
USE adatok;

CREATE TABLE IF NOT EXISTS tabla (
    Sor INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL,
    Titkos VARCHAR(255) NOT NULL
);

INSERT INTO tabla (Username, Titkos) VALUES
('katika@gmail.com', 'piros'),
('arpi40@freemail.hu', 'zold'),
('zsanettka@hotmail.com', 'sarga'),
('hatizsak@protonmail.com', 'kek'),
('terpeszterez@citromail.hu', 'fekete'),
('nagysanyi@gmail.hu', 'feher');
