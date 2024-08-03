CREATE OR REPLACE VIEW vw_rol_membros AS
	SELECT
		 mr.numero_rol
		,mr.membro_id
		,mm.nome membro
		,mr.regiao_id
		,mr.distrito_id
		,mr.igreja_id
		,mm.congregacao_id
		,cc.nome congregacao
		,mr.status
		,mm.data_nascimento
		,mr.dt_recepcao 
		,mr.dt_exclusao 
		,nt.id notificacao_transferencia_id
		,mm.has_errors
	
  	  FROM  membresia_rolpermanente mr
		
INNER JOIN membresia_membros mm
	    ON mm.id = mr.membro_id
	   AND mm.vinculo = 'M'
	   AND mr.lastrec = 1
	   
 LEFT JOIN congregacoes_congregacoes cc 
 		ON cc.id = mm.congregacao_id 
			 
 LEFT JOIN notificacoes_transferencias nt 
 		ON nt.membro_id = mm.id
 	   AND nt.dt_aceite IS NULL
 	   AND nt.dt_rejeicao IS NULL
 	   AND nt.deleted_at IS NULL
 
LEFT JOIN instituicoes_instituicoes nt_id
	   ON nt_id.id = nt.igreja_destino_id;