DROP DATABASE BDAsistencias;

CREATE OR REPLACE DATABASE BDAsistencias;

ALTER DATABASE BDAsistencias CHARSET=utf8;

ALTER DATABASE BDAsistencias COLLATE=utf8_spanish_ci;

USE BDAsistencias;

CREATE TABLE CursosAsignados(
	idCursosAsignados		INTEGER			NOT NULL			PRIMARY KEY			AUTO_INCREMENT,
	PrimerCursoAsignado		INTEGER			NOT NULL,
	SegundoCursoAsignado	INTEGER			NOT NULL,
	TercerCurdoAsignado		INTEGER			NOT NULL,
	CuartoCursoAsignado		INTEGER			NOT NULL,
	QuintoCursoAsignado		INTEGER			NOT NUlL
)ENGINE = InnoDB CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE Persona(
	idPersona				INTEGER			NOT NULL			PRIMARY KEY			AUTO_INCREMENT,
	NombrePersona			VARCHAR(50)		NOT NULL,
	ApellidoPersona			VARCHAR(50)		NOT NULL,
	CarnetPersona			VARCHAR(15)		NOT NULL,
	CorreoPersona			VARCHAR(50),
	idCursosAsignados		TINYINT
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
	SeccionCurso			CHAR(1)			NOT NULL
)ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish_ci;

CREATE TABLE Asitencia(
	idAsistencia			INTEGER			NOT NULL			PRIMARY KEY			AUTO_INCREMENT,
	FechaAsistencia			DATE			NOT NULL,
	idUsuario				TINYINT			NOT NULL,
	FechaHoraMarcajeAsistencia	DATETIME	NOT NULL,
	INDEX (idUsuario),
	FOREIGN	KEY	(idUsuario)
        REFERENCES Usuario(idUsuario)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
)ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish_ci;

CREATE TABLE Bitacora(
	idBitacora				INTEGER			NOT NULL			PRIMARY KEY			AUTO_INCREMENT,
	FechaBitacora			DATETIME		NOT NULL,
	FechaActivadaBitacora	DATE			NOT NULL,
	UsuarioBitacora			DATE			NOT NULL
)ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish_ci;