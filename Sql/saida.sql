CREATE TABLE saida (
    id mediumint AUTO_INCREMENT PRIMARY KEY NOT NULL,
    usuario_id mediumint,
    veiculo_id mediumint,
    horario DATETIME NOT NULL,


    CONSTRAINT fk_saida_usuario FOREIGN KEY (usuario_id) REFERENCES usuario (id),
    CONSTRAINT fk_saida_veiculo FOREIGN KEY (veiculo_id) REFERENCES veiculo (id)
);

/* Insert */
/* INSERT INTO saida (usuario_id, veiculo_id, horario) VALUES ('1','1', STR_TO_DATE('00/00/0000 00:00', '%d/%m/%Y %H:%i')); */

INSERT INTO
    saida (veiculo_id, horario)
VALUES (
        '1',
        STR_TO_DATE(
            '06/05/2024 20:34',
            '%d/%m/%Y %H:%i'
        )
    );