
CREATE TABLE `gceu_funcoes` (
  `id` tinyint(4) NOT NULL,
  `funcao` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `gceu_funcoes` (`id`, `funcao`) VALUES
(1, 'Lider'),
(2, 'Supervisor'),
(3, 'Coordenador'),
(4, 'Secretário'),
(5, 'Integrante');

ALTER TABLE `gceu_funcoes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `gceu_funcoes`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;
