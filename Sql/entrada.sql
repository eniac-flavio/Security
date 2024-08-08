CREATE TABLE entrada (
    id mediumint AUTO_INCREMENT PRIMARY KEY NOT NULL,
    usuario_id mediumint,
    veiculo_id mediumint,
    horario DATETIME NOT NULL,


    CONSTRAINT fk_entrada_usuario FOREIGN KEY (usuario_id) REFERENCES usuario (id),
    CONSTRAINT fk_entrada_veiculo FOREIGN KEY (veiculo_id) REFERENCES veiculo (id)
);

/* Insert */
/* INSERT INTO entrada (usuario_id, veiculo_id, horario) VALUES ('1','1', STR_TO_DATE('00/00/0000 00:00', '%d/%m/%Y %H:%i')); */

INSERT INTO
    entrada (usuario_id, horario)
VALUES (
        '4',
        STR_TO_DATE(
            '06/05/2024 20:30',
            '%d/%m/%Y %H:%i'
        )
    );