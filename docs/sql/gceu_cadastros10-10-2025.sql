
CREATE TABLE `gceu_cadastros` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `anfitriao` varchar(150) NOT NULL,
  `contato` varchar(15) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `congregacao_id` bigint(20) UNSIGNED NOT NULL,
  `instituicao_id` bigint(20) UNSIGNED NOT NULL,
  `cep` varchar(10) NOT NULL,
  `endereco` varchar(120) DEFAULT NULL,
  `numero` varchar(11) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `uf` varchar(30) DEFAULT NULL,
  `data_de_criacao` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `gceu_cadastros`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `gceu_cadastros`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;