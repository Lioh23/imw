
CREATE TABLE `gceu_cartas_pastorais` (
  `id` bigint(20) NOT NULL,
  `instituicao_id` bigint(20) UNSIGNED NOT NULL,
  `pessoa_id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `introducao` varchar(500) NOT NULL,
  `conteudo` longtext NOT NULL,
  `data_criacao` date NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `gceu_cartas_pastorais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gceu_cadastro_id_palavra pastoral` (`gceu_cadastro_id`),
  ADD KEY `membro_id_palavras_pastorais` (`pessoa_id`);

ALTER TABLE `gceu_cartas_pastorais`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;


ALTER TABLE `gceu_cartas_pastorais` ADD `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `updated_at`;
ALTER TABLE `gceu_cartas_pastorais` ADD `status` VARCHAR(1) NOT NULL DEFAULT 'A' AFTER `data_criacao`;