CREATE TABLE veiculo (
    id mediumint PRIMARY KEY AUTO_INCREMENT NOT NULL,
    placa varchar(7) UNIQUE NOT NULL,
    usuario_id mediumint,


    CONSTRAINT fk_usuario_veiculo FOREIGN KEY (usuario_id) REFERENCES usuario (id)
);

/* Insert */
/* INSERT INTO `veiculo`(`placa`, `usuario_id`) VALUES ('[value-1]','[value-2]'); */

INSERT INTO `veiculo` (`placa`, `usuario_id`) VALUES ('AAA1111', '4');
/* O id do visitante */