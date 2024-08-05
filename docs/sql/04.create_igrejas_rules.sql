INSERT INTO regras (nome) values
	('igreja-index'),
	('igreja-cadastrar'),
	('igreja-atualizar'),
	('igreja-editar'),
	('igreja-excluir');

INSERT INTO perfil_regra (perfil_id, regra_id)
select
	 (select id from perfils where nome = 'Administrador') perfil_id
	,regras.id regra_id
FROM regras WHERE nome LIKE 'igreja-%';

INSERT INTO perfil_regra (perfil_id, regra_id)
select
	 (select id from perfils where nome = 'Pastor') perfil_id
	,regras.id regra_id
FROM regras WHERE nome LIKE 'igreja-%';

INSERT INTO perfil_regra (perfil_id, regra_id)
select
	 (select id from perfils where nome = 'Secretario') perfil_id
	,regras.id regra_id
FROM regras WHERE nome LIKE 'igreja-%';

INSERT INTO perfil_regra (perfil_id, regra_id)
select
	 (select id from perfils where nome = 'Administrador do Sistema') perfil_id
	,regras.id regra_id
FROM regras WHERE nome LIKE 'igreja-%';