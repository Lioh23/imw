INSERT INTO `regras` (`id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES ('146', 'financeiro-por-categoria', '2025-08-09 15:27:04', '2025-08-09 15:27:04', NULL);

INSERT INTO `perfil_regra` (`id`, `perfil_id`, `regra_id`, `created_at`, `updated_at`) VALUES (NULL, '3', '146', '2025-08-09 15:29:55', '2025-08-09 15:29:55');

CREATE TABLE `financeiro_plano_contas_categoria` (
  `id` tinyint(4) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `financeiro_plano_contas_categoria` (`id`, `nome`) VALUES
(1, 'Ação Social'),
(2, 'Clérigos'),
(3, 'Construção'),
(4, 'RH');


ALTER TABLE `financeiro_plano_contas_categoria`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `financeiro_plano_contas_categoria`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `financeiro_plano_contas` ADD `plano_contas_categoria_id` TINYINT NOT NULL DEFAULT '0' AFTER `essencial`;


    private $fatorProvaCriar;
    private $fatorSimulacao;
    
    
    setFatorProvaCriar
    getFatorProvaCriar
    
    
    getLinkEspelho()
