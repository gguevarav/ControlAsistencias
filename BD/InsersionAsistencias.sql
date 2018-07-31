USE BDAsistencias;

-- Super administrador
INSERT INTO Persona (NombrePersona, ApellidoPersona, CarnetPersona, CorreoPersona)
              VALUES('Administrador', 'administrador', '4890-13-2950', 'gguevarav@miumg.edu.gt');
					 
INSERT INTO Usuario (NombreUsuario, ContraseniaUsuario, idPersona, RolUsuario)
              VALUES('admin', '21232f297a57a5a743894a0e4a801fc3', 1, 'Superadmin');
			  
-- Primer usuario
INSERT INTO Persona (NombrePersona, ApellidoPersona, CarnetPersona, CorreoPersona)
			  VALUES('Gemis Daniel', 'Guevara Villeda', '4890-13-2950', 'gguevarav@miumg.edu.gt');

INSERT INTO Usuario (NombreUsuario, ContraseniaUsuario, idPersona, RolUsuario)
              VALUES('gguevara', 'e60c177bc95bb0d56e2f95ac372bde51', 2, 'Administrador');

INSERT INTO Usuario (NombreUsuario, ContraseniaUsuario, idPersona, RolUsuario)
              VALUES('gguevara-c', 'e60c177bc95bb0d56e2f95ac372bde51', 2, 'Catedratico');
			  
INSERT INTO Usuario (NombreUsuario, ContraseniaUsuario, idPersona, RolUsuario)
              VALUES('gguevara-e', 'e60c177bc95bb0d56e2f95ac372bde51', 2, 'Estudiante');