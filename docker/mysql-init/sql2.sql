CREATE TABLE inflacoes (
	id INT auto_increment NOT NULL,
	ano json NULL,
	inflacao FLOAT NULL,
	created_at TIMESTAMP NULL,
	updated_at TIMESTAMP NULL,
	CONSTRAINT inflacoes_pk PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

CREATE TABLE creditos (
	id INT auto_increment NOT NULL,
	qtd_estudos INT NULL,
	valor FLOAT NULL,
	created_at TIMESTAMP NULL,
	updated_at TIMESTAMP NULL,
	CONSTRAINT creditos_pk PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

ALTER TABLE empresas ADD user_id INT NULL;

CREATE TABLE ativos_fisicos (
	id INT auto_increment NOT NULL,
	setor_tag varchar(220) NULL,
	nome_ativo varchar(220) NULL,
	ano_aquisicao INT NULL,
	expectativa_vida INT NULL,
	regra_depreciacao INT NULL,
	taxa_perda_ano INT NULL,
	valor_ativo FLOAT NULL,
	custo_instalacao FLOAT NULL,
	custo_comissionamento FLOAT NULL,
	created_at TIMESTAMP NULL,
	updated_at TIMESTAMP NULL,
	CONSTRAINT ativos_fisicos_pk PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

CREATE TABLE opex (
	id INT auto_increment NOT NULL,
	estudo_id INT NULL,
	ano INT NULL,
	operadores FLOAT NULL,
	energia FLOAT NULL,
	total_operacao FLOAT NULL,
	mantenedores_manutencao_planejada FLOAT NULL,
	materiais_servicos_manutencao_planejada FLOAT NULL,
	total_manutencao_planejada FLOAT NULL,
	mantenedores_manutencao_n_planejada FLOAT NULL,
	materiais_servicos_manutencao_n_planejada FLOAT NULL,
	total_manutencao_n_planejada FLOAT NULL,
	taxa_inflacao FLOAT NULL,
	fator_multiplicador_sugerido FLOAT NULL,
	created_at TIMESTAMP NULL,
	updated_at TIMESTAMP NULL,
	CONSTRAINT opex_pk PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

ALTER TABLE inflacoes MODIFY COLUMN ano int NULL;
ALTER TABLE inflacoes MODIFY COLUMN inflacao VARCHAR(20) NULL;

CREATE TABLE creditos_users (
	id INT auto_increment NOT NULL,
	user_id INT NULL,
	credito_id INT NULL,
	created_at TIMESTAMP NULL,
	updated_at TIMESTAMP NULL,
	qtd_credtio_disponivel INT NULL,
	CONSTRAINT creditos_users_pk PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

ALTER TABLE creditos MODIFY COLUMN valor float(10, 2) NULL;

ALTER TABLE creditos ADD ilimitado ENUM('1', '0') DEFAULT '0' NULL;




