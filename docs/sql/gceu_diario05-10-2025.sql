
CREATE TABLE `gceu_diario` (
  `id` bigint(20) NOT NULL,
  `gceu_id` bigint(20) NOT NULL,
  `membro_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `presenca` tinyint(4) NOT NULL,
  `data` date NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `gceu_diario`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `gceu_diario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;



