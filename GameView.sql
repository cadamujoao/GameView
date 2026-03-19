CREATE DATABASE gameview;

USE gameview;


/* USUÁRIO --------------------------------------------------------------------*/

CREATE TABLE usuario(
idu INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
nomeu VARCHAR(30) NOT NULL UNIQUE,
emailu VARCHAR(320) NOT NULL UNIQUE,
senhau VARCHAR(100) NOT NULL,
imgu VARCHAR(50) DEFAULT "../includes/user.png",
validado boolean DEFAULT 0,
token_valida VARCHAR(100) DEFAULT null
);
	
	
/*---------------------------------------------------------------------------------*/




/* jogo --------------------------------------------------------------------------*/
	CREATE table jogo(
	idj INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idJogoApi INT,
	nomej VARCHAR(30) NOT NULL,
	descricao VARCHAR(2000),
	img VARCHAR(200),
	soma FLOAT NOT NULL DEFAULT 0,
	contador INT NOT NULL DEFAULT 0,
	media float
	);

/*------------------------------------------------------------------------------------------*/


/* ANÁLISES --------------------------------------------------------------------------------*/
create table analise(
codu INT NOT NULL,
codj INT NOT NULL,
PRIMARY KEY (codu, codj),
FOREIGN KEY (codu) REFERENCES usuario (idu) ON DELETE CASCADE,
FOREIGN KEY (codj) REFERENCES jogo (idj),
texto VARCHAR (400) NOT NULL,
nGeral INT NOT NULL,
nHistoria INT NOT NULL,
nGraficos INT NOT NULL,
nJogabilidade INT NOT NULL,
nPerformance INT NOT NULL,
CONSTRAINT ck_nGeral CHECK (nGeral BETWEEN 0 AND 100),
CONSTRAINT ck_nHistoria CHECK (nHistoria BETWEEN 0 AND 100),
CONSTRAINT ck_nGraficos CHECK (nGraficos BETWEEN 0 AND 100),
CONSTRAINT ck_nJogabilidade CHECK (nJogabilidade BETWEEN 0 AND 100),
CONSTRAINT ck_nPerformance CHECK (nPerformance BETWEEN 0 AND 100)
);

	CREATE TABLE avaliaAnalise(
	codu_avaliador INT NOT NULL,
	codu_dono INT NOT NULL,
	codj INT NOT NULL,
	notaAva BOOLEAN NOT NULL,
	PRIMARY KEY (codu_avaliador, codu_dono, codj),
	FOREIGN KEY (codu_avaliador) REFERENCES usuario (idu) ON DELETE CASCADE,
	FOREIGN KEY (codu_dono, codj) REFERENCES analise (codu, codj)
	);

/*---------------------------------------------------------------------------------------------*/

INSERT INTO usuario (nomeu, emailu, senhau, validado) VALUES ("aaa", "gameviewtcc@gmail.com", "$2y$10$yJv22GyM9BptPhMkRdpuPOCYKWPPmV2iE9qA2SNi30EzerHwlexSu", 1);

