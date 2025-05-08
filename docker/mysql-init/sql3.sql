
ALTER TABLE radar.ativos_fisicos ADD cod_ativo_fisico varchar(100) NULL;
ALTER TABLE radar.ativos_fisicos ADD `anos_depreciar` INT(4) NULL;
ALTER TABLE radar.ativos_fisicos MODIFY COLUMN ano_aquisicao int(4) NULL;
ALTER TABLE radar.ativos_fisicos MODIFY COLUMN expectativa_vida int(4) NULL;
ALTER TABLE radar.ativos_fisicos MODIFY COLUMN regra_depreciacao int(3) NULL;
ALTER TABLE radar.ativos_fisicos MODIFY COLUMN taxa_perda_ano int(3) NULL;
ALTER TABLE radar.ativos_fisicos ADD valor_depreciacao FLOAT NULL;

ALTER TABLE radar.ativos_fisicos MODIFY COLUMN valor_depreciacao float(10,2) NULL;
ALTER TABLE radar.ativos_fisicos MODIFY COLUMN valor_ativo float(10,2) NULL;
ALTER TABLE radar.ativos_fisicos MODIFY COLUMN custo_instalacao float(10,2) NULL;
ALTER TABLE radar.ativos_fisicos MODIFY COLUMN custo_comissionamento float(10,2) NULL;

CREATE TABLE radar.capex (
	id INT auto_increment NOT NULL,
	motivo_escolha_ativo_fisico TEXT NULL,
	atualizacao_patrimonial json NULL,
	melhorias_reformas json NULL,
	created_at TIMESTAMP NULL,
	updated_at TIMESTAMP NULL,
	CONSTRAINT capex_pk PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

ALTER TABLE radar.capex ADD ativo_fisico_id INT NULL;
ALTER TABLE radar.capex ADD CONSTRAINT capex_ativos_fisicos_FK FOREIGN KEY (ativo_fisico_id) REFERENCES radar.ativos_fisicos(id);

CREATE TABLE radar.estudos (
	id INT auto_increment NOT NULL,
	ativo_fisico_id INT NULL,
	capex_id INT NULL,
	opex_id INT NULL,
	created_at TIMESTAMP NULL,
	updated_at TIMESTAMP NULL,
	CONSTRAINT estudos_pk PRIMARY KEY (id),
	CONSTRAINT estudos_ativos_fisicos_FK FOREIGN KEY (ativo_fisico_id) REFERENCES radar.ativos_fisicos(id),
	CONSTRAINT estudos_capex_FK FOREIGN KEY (capex_id) REFERENCES radar.capex(id),
	CONSTRAINT estudos_opex_FK FOREIGN KEY (opex_id) REFERENCES radar.opex(id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

ALTER TABLE radar.ativos_fisicos ADD estudo_id INT NULL;
ALTER TABLE radar.capex ADD estudo_id INT NULL;

