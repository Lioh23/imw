ALTER TABLE `membresia_membros` ADD `novo_convertido` CHAR(1) NOT NULL DEFAULT 'N' AFTER `status`;

INSERT INTO `gceu_funcoes` (`id`, `funcao`) VALUES (NULL, ' Novo Convertido');