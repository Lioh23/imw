INSERT INTO `regras` (`id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES
(138, 'contabilidade-irrf', '2025-07-18 21:23:04', '2025-07-18 21:23:04', NULL),
(137, 'menu-contabilidade', '2025-07-18 21:23:04', '2025-07-18 21:23:04', NULL);

INSERT INTO `perfil_regra` (`id`, `perfil_id`, `regra_id`, `created_at`, `updated_at`) VALUES (NULL, '3', '137', '2025-07-18 18:40:04', '2025-07-18 18:40:04');

INSERT INTO `perfil_regra` (`id`, `perfil_id`, `regra_id`, `created_at`, `updated_at`) VALUES (NULL, '3', '138', '2025-07-18 18:40:04', '2025-07-18 18:40:04');