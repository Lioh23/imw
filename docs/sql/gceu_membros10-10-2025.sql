
CREATE TABLE `gceu_membros` (
  `id` bigint(20) NOT NULL,
  `gceu_cadastro_id` bigint(20) UNSIGNED NOT NULL,
  `membro_id` char(36) DEFAULT NULL,
  `gceu_funcao_id` int(4) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `gceu_membros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gceu_funcao_id` (`gceu_funcao_id`),
  ADD KEY `membro_id` (`membro_id`),
  ADD KEY `gceu_cadastro_id` (`gceu_cadastro_id`);


ALTER TABLE `gceu_membros`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;


ALTER TABLE `gceu_membros`
  ADD CONSTRAINT `gceu_membros_ibfk_1` FOREIGN KEY (`gceu_funcao_id`) REFERENCES `gceu_funcoes` (`id`),
  ADD CONSTRAINT `gceu_membros_ibfk_2` FOREIGN KEY (`gceu_cadastro_id`) REFERENCES `gceu_cadastros` (`id`);
COMMIT;
