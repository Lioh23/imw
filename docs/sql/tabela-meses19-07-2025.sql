

CREATE TABLE `meses` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `meses` (`id`, `descricao`) VALUES
(1, 'Janeiro'),
(2, 'Fevereiro'),
(3, 'Março'),
(4, 'Abril'),
(5, 'Maio'),
(6, 'Junho'),
(7, 'Julho'),
(8, 'Agosto'),
(9, 'Setembro'),
(10, 'Outubro'),
(11, 'Novembro'),
(12, 'Dezembro');


ALTER TABLE `meses`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `meses`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;
