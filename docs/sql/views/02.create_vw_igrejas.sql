CREATE OR REPLACE VIEW vw_igrejas AS
	SELECT 
	   igreja.id
	  ,igreja.nome
	  ,igreja.cidade
	  ,igreja.pastor
		,igreja.ativo
	  ,igreja.deleted_at
	  ,distrito.id distrito_id
	  ,distrito.nome distrito
	  ,distrito.deleted_at distrito_deleted_at
	  ,regiao.id regiao_id
	  ,regiao.nome regiao
	  ,regiao.deleted_at regiao_deleted_at

	  FROM (SELECT * FROM instituicoes_instituicoes WHERE tipo_instituicao_id = 1) igreja
	  
 LEFT JOIN (SELECT * FROM instituicoes_instituicoes WHERE tipo_instituicao_id = 2) distrito
		ON distrito.id = igreja.instituicao_pai_id
	
 LEFT JOIN (SELECT * FROM instituicoes_instituicoes WHERE tipo_instituicao_id = 3) regiao
 		ON regiao.id = distrito.instituicao_pai_id;