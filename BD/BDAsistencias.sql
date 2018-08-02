DROP DATABASE BDAsistencias;

CREATE OR REPLACE DATABASE BDAsistencias;

ALTER DATABASE BDAsistencias CHARSET=utf8;

ALTER DATABASE BDAsistencias COLLATE=utf8_spanish_ci;

USE BDAsistencias;

CREATE OR REPLACE TABLE Persona(
	idPersona				INTEGER			NOT NULL			PRIMARY KEY			AUTO_INCREMENT,
	NombrePersona			VARCHAR(50)		NOT NULL,
	ApellidoPersona			VARCHAR(50)		NOT NULL,
	CarnetPersona			VARCHAR(15)		NOT NULL,
	CorreoPersona			VARCHAR(50)
)ENGINE = InnoDB CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE Usuario(
	idUsuario				TINYINT			NOT NULL			PRIMARY KEY			AUTO_INCREMENT,
	NombreUsuario			VARCHAR(10)		NOT NULL,
	ContraseniaUsuario		Text			NOT NULL,
	idPersona				INTEGER			NOT NULL,
	RolUsuario				VARCHAR(15)		NOT NULL,
	INDEX (idPersona),
	FOREIGN	KEY	(idPersona)
        REFERENCES Persona(idPersona)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
)ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish_ci;

CREATE TABLE Curso(
	idCurso					INTEGER			NOT NULL			PRIMARY KEY			AUTO_INCREMENT,
	SemestreCurso			TINYINT			NOT NULL,
	AnioCurso				SMALLINT		NOT NULL,
	CodigoCarreraCurso		VARCHAR(15)		NOT NULL,
	NombreCurso				VARCHAR(50)		NOT NULL,
	CodigoCurso				VARCHAR(15)		NOT NULL,
	SeccionCurso			CHAR(1)			NOT NULL,
	CatedraticoCurso		INTEGER			NOT NULL
)ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish_ci;

CREATE TABLE CursosAsignados(
	idCursosAsignados		INTEGER			NOT NULL			PRIMARY KEY			AUTO_INCREMENT,
	idCurso					INTEGER			NOT NULL,
	idPersona				INTEGER			NOT NULL
)ENGINE = InnoDB CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE FechaAsistencia(
	idFechaAsistencia		INTEGER			NOT NULL			PRIMARY KEY			AUTO_INCREMENT,
	FechaFechaAsistencia	DATE			NOT NULL,
	CursoFechaAsistencia	INTEGER			NOT NULL,
	CatedraticoFechaAsistencia	INTEGER			NOT NULL,
	EstadoFechaAsistencia	VARCHAR(15)			NOT NULL
)ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish_ci;

CREATE TABLE AsistenciaMarcada(
	idAsistenciaMarcada			INTEGER			NOT NULL			PRIMARY KEY			AUTO_INCREMENT,
	FechaAsistenciaMarcada			INTEGER			NOT NULL,
	EstudianteAsistenciaMarcada	INTEGER			NOT NULL
)ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish_ci;