<?php
require_once './config/config.php';

class Model {

    protected $db;

    function __construct() {
        $this->db = new PDO("mysql:host=" . DB_HOST . ";charset=utf8", DB_USER, DB_PASS);
        if ($this->db) {
            $this->createDatabaseIfNotExists();
            $this->db->exec("USE " . DB_NAME);
            $this->deploy();
        }
    }

    function createDatabaseIfNotExists() {
        $query = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
        $this->db->exec($query);
    }

    function deploy() {
        $query = $this->db->query("SHOW TABLES");
        $tables = $query->fetchAll();
        if (count($tables) == 0) {
            $sql = <<<END

				-- phpMyAdmin SQL Dump
				-- version 5.2.1
				-- https://www.phpmyadmin.net/
				--
				-- Host: 127.0.0.1
				-- Generation Time: Oct 03, 2024 at 07:04 PM
				-- Server version: 10.4.32-MariaDB
				-- PHP Version: 8.2.12

				SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
				START TRANSACTION;
				SET time_zone = "+00:00";


				/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
				/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
				/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
				/*!40101 SET NAMES utf8mb4 */;

				--
				-- Database: `destinos_turisticos`
				--

				-- --------------------------------------------------------

				--
				-- Table structure for table `attractions`
				--

				CREATE TABLE `attractions` (
				`id` int(11) NOT NULL,
				`name` varchar(100) NOT NULL,
				`location` varchar(255) NOT NULL,
				`price` decimal(10,2) DEFAULT NULL,
				`path_img` varchar(255) DEFAULT NULL,
				`description` text DEFAULT NULL,
				`open_time` time DEFAULT NULL,
				`close_time` time DEFAULT NULL,
				`website` varchar(255) DEFAULT NULL,
				`country_id` int(11) DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

				--
				-- Dumping data for table `attractions`
				--

				INSERT INTO `attractions` (`id`, `name`, `location`, `price`, `path_img`, `description`, `open_time`, `close_time`, `website`, `country_id`) VALUES
				(1, 'Torre Eiffel', 'Av. Gustave Eiffel, 75007 Paris', 25.00, 'images/66fdb1d10938c.jpg', 'La Torre Eiffel es el monumento más visitado de todo el mundo con más de 7 millones de visitantes anuales, por lo que se convierte en uno imprescindible que ver en París. Esta gran torre de hierro mide 300 metros de altura, lo que hace que se puede ver desde varios puntos de la ciudad. Para disfrutar de su silueta inconfundible cuatro lugares perfectos son Campo de Marte, la Pasarela Debilly, los Jardines del Trocadero y desde la rue de l’Université.', '09:00:00', '23:00:00', 'https://www.toureiffel.paris', 2),
				(2, 'Chichén Itzá', 'Chichén Itzá, 97751 Yucatán', 0.00, 'images/imagen-no-disponible.png', 'Chichén Itzá, ubicada en la península de Yucatán, México, es una de las más impresionantes ciudades mayas y un sitio arqueológico de renombre mundial. Declarada Patrimonio de la Humanidad por la UNESCO, su estructura más icónica es la Pirámide de Kukulkán, que durante los equinoccios muestra un impresionante juego de sombras que simula el descenso de una serpiente. Además de la pirámide, destacan el Templo de los Guerreros y el Juego de Pelota. Chichén Itzá es un destino fascinante que permite sumergirse en la rica historia y arquitectura de la antigua civilización maya.', '08:00:00', '17:00:00', 'https://www.inah.gob.mx/zonas/146-zona-arqueologica-de-chichen-itza', 15),
				(3, 'Big Ben', 'London SW1A 0AA', 0.00, 'images/66fdb27bb6f7b.jpg', 'El Big Ben es uno de los símbolos de Inglaterra y uno de los relojes más famosos de todo el mundo. Si visitas Londres no puedes perderte hacerte una foto con este monumento que forma parte del Palacio de Westminster que es la actual sede del Parlamento del Reino Unido. En el tour de Londres al completo está incluida esta parada que sin duda te va a sorprender, ya que el Big Ben realmente es una enorme campana de 14 toneladas que se encuentra en el interior de la torre, y el reloj mide nada más y nada menos que 7 metros de diámetro en cada una de sus caras.', '00:00:00', '00:00:00', 'https://www.parliament.uk/bigben/', 1),
				(4, 'Coliseo de Roma', 'asdasdasd', 35.00, 'images/66fdb1ec75dde.jpg', 'El Coliseo de Roma es el monumento más importante de la ciudad y está considerado como el monumento más visitado de Italia, recibiendo más de 6 millones de visitantes cada año. Es precisamente por ello, que este monumento también es uno de los lugares más visitados de toda Europa, por lo que si quieres conocerlo por dentro si o si tendrás que comprar tus entradas con antelación porque se agotan rápidamente y las colas de acceso siempre son muy largas.', '12:16:00', '16:33:00', 'https://colosseo.it/', 4),
				(5, 'Torre de Londres', 'London EC3N 4AB', 34.80, 'images/66fdb1fa945f8.jpg', 'La Torre de Londres es uno de los monumentos históricos más destacados e intrigantes que ver en Londres. Este castillo medieval se encuentra ubicado en la ribera norte del río Támesis y cuenta con una larga historia de casi mil años. En tu visita a la Torre de Londres es importante que sepas que ha tenido diversos usos desde residencia real, arsenal hasta fortaleza y prisión.\r\nLa verdad es que esta torre está envuelta de enigmas por lo que la mejor forma para descubrirlos es realizar el tour de los misterios y leyendas de Londres. Te advertimos que quizás se te pongan los pelos de punta.', '09:00:00', '17:30:00', 'https://www.hrp.org.uk/tower-of-london/', 1),
				(6, 'Abadía de Westminster', 'Deans, Yard London SW1P 3PA', 34.80, 'images/66fdb20b88a1a.jpg', 'Si quieres realizar un tour completo de Londres no puede faltar en tu itinerario visitar la Abadía de Westminster que su nombre completo es colegiata de San Pedro en Westminster. Este impresionante edificio de estilo gótico es uno de los edificios religiosos más importantes de todo Reino Unido y lugar de sepultura de numerosos monarcas ingleses a lo largo de la historia. Recuerda que con la London Pass tienes el acceso gratuito a la abadía.', '09:00:00', '17:00:00', 'https://tickets.westminster-abbey.org/', 1),
				(7, 'Jardines de Luxemburgo', '75006 Paris', 0.00, 'images/66fdb23d1abb2.jpg', 'Los Jardines de Luxemburgo se encuentran ubicados en el distrito XVI de París y para nosotros es una de las zonas verdes más bonitas de la capital francesa. Estos jardines fueron diseñados a principios del siglo XVII por órdenes de María de Médicis. Cuentan con una parte diseñada al estilo inglés y otra parte de estilo francés.', '00:00:00', '00:00:00', 'https://jardin.senat.fr/', 2);

				-- --------------------------------------------------------

				--
				-- Table structure for table `countries`
				--

				CREATE TABLE `countries` (
				`id` int(11) NOT NULL,
				`name` varchar(50) NOT NULL,
				`language` varchar(50) NOT NULL,
				`currency` varchar(50) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

				--
				-- Dumping data for table `countries`
				--

				INSERT INTO `countries` (`id`, `name`, `language`, `currency`) VALUES
				(1, 'Inglaterra', 'Inglés', 'Libra Esterlina (£)'),
				(2, 'Francia', 'Francés', 'Euro (€)'),
				(4, 'Italia', 'Italiano', 'Euro (€)'),
				(14, 'Argentina', 'Español', 'Peso Argentino ($)'),
				(15, 'Mexico', 'Español', 'Peso Mexicano ($)'),
				(19, 'Chile', 'Español', 'Pesos Chileno ($)');

				-- --------------------------------------------------------

				--
				-- Table structure for table `users`
				--

				CREATE TABLE `users` (
				`id` int(11) NOT NULL,
				`username` varchar(20) NOT NULL,
				`password` varchar(60) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

				--
				-- Dumping data for table `users`
				--

				INSERT INTO `users` (`id`, `username`, `password`) VALUES
				(1, 'webadmin', '$2y$10\$eppS3EexxLvu8dV/0wypFelPnm/fEOhd6kExOSp38jjwUsF7q6elS');

				--
				-- Indexes for dumped tables
				--

				--
				-- Indexes for table `attractions`
				--
				ALTER TABLE `attractions`
				ADD PRIMARY KEY (`id`),
				ADD UNIQUE KEY `name` (`name`),
				ADD KEY `pais_id` (`country_id`);

				--
				-- Indexes for table `countries`
				--
				ALTER TABLE `countries`
				ADD PRIMARY KEY (`id`),
				ADD UNIQUE KEY `name` (`name`) USING BTREE;

				--
				-- Indexes for table `users`
				--
				ALTER TABLE `users`
				ADD PRIMARY KEY (`id`),
				ADD UNIQUE KEY `username` (`username`);

				--
				-- AUTO_INCREMENT for dumped tables
				--

				--
				-- AUTO_INCREMENT for table `attractions`
				--
				ALTER TABLE `attractions`
				MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

				--
				-- AUTO_INCREMENT for table `countries`
				--
				ALTER TABLE `countries`
				MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

				--
				-- AUTO_INCREMENT for table `users`
				--
				ALTER TABLE `users`
				MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

				--
				-- Constraints for dumped tables
				--

				--
				-- Constraints for table `attractions`
				--
				ALTER TABLE `attractions`
				ADD CONSTRAINT `attractions_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);
				COMMIT;

				/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
				/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
				/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


				END;

            $this->db->query($sql); 
        }
    }
}
