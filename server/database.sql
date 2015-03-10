CREATE database 'logistic';

USE logistic;

CREATE TABLE rotas(
	id_rota INTEGER NOT NULL AUTO_INCREMENT,
	nome VARCHAR(45) NULL,
	origem VARCHAR(45) NULL,
	destino VARCHAR(45) NULL,
	distancia NUMERIC(12,4) NOT NULL DEFAULT 0,
	dt_cadastro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	excluido BIT(1) NOT NULL DEFAULT b'0',
	CONSTRAINT rotas_pkey PRIMARY KEY(id_rota)
);

INSERT INTO rotas (nome, origem, destino, distancia) VALUES ('rota teste', 'A', 'B', 35.5000);
INSERT INTO rotas (nome, origem, destino, distancia) VALUES ('Franca > Ribeirao', 'C', 'D', 100.0000);
INSERT INTO rotas (nome, origem, destino, distancia) VALUES ('Franca > Sao Paulo', 'Franca', 'Sao Paulo', 535.0000);
