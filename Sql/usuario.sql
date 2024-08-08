CREATE TABLE usuario (
    nome varchar(255) NOT NULL,
    cpf varchar(255) unique,
    cnpj varchar(255) unique,
    id mediumint PRIMARY KEY AUTO_INCREMENT NOT NULL,
    email varchar(255) unique NOT NULL,
    senha varchar(255) NOT NULL,
    acesso enum(
        'doorman',
        'staff',
        'enterprise',
        'visitor'
    ) NOT NULL DEFAULT 'visitor'
);

/* Insert */
/* INSERT INTO `usuario`(`nome`, `cpf`, `cnpj`, `id`, `email`, `senha`, `acesso`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]'); */

INSERT INTO
    `usuario` (
        `nome`,
        `cpf`,
        `email`,
        `senha`,
        `acesso`
    )
VALUES (
        'Teste1',
        '111.111.111-11',
        'teste1@gmail.com',
        '1',
        'Doorman'
    );

INSERT INTO
    `usuario` (
        `nome`,
        `cpf`,
        `email`,
        `senha`,
        `acesso`
    )
VALUES (
        'Teste2',
        '222.222.222-22',
        'teste2@gmail.com',
        '2',
        'Staff'
    );

INSERT INTO
    `usuario` (
        `nome`,
        `cpf`,
        `email`,
        `senha`,
        `acesso`
    )
VALUES (
        'Teste3',
        '333.333.333-33',
        'teste3@gmail.com',
        '3',
        'Enterprise'
    );

INSERT INTO
    `usuario` (
        `nome`,
        `cpf`,
        `email`,
        `senha`,
        `acesso`
    )
VALUES (
        'Teste4',
        '444.444.444-44',
        'teste4@gmail.com',
        '4',
        'Visitor'
    );