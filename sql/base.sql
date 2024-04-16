-- /Create database pointeri_formulario;


CREATE TABLE IF NOT EXISTS remision_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_formulario INT(20),
    empresa VARCHAR(150),
    municipio VARCHAR(100),
    pozo VARCHAR(255),
    fecha DATE,
    solicitado_por VARCHAR(100),
    rig VARCHAR(100),
    transporte_empresa VARCHAR(255),
    conductor VARCHAR(100),
    cedula_conductor VARCHAR(20),
    celular_conductor VARCHAR(20),
    vehiculo_placa VARCHAR(10),
    vehiculo_tipo VARCHAR(255),
    observaciones Varchar(500),
    items_json JSON
);

CREATE TABLE IF NOT EXISTS ultimo_id_formulario (
    id INT PRIMARY KEY,
    ultimo_id INT (20)
);


INSERT INTO ultimo_id_formulario (id, ultimo_id) VALUES (0, 0);
