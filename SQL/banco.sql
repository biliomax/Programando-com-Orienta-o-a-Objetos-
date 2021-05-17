CREATE TABLE aluno (id INTEGER, nome VARCHAR(40), endereco VARCHAR(40),
telefone VARCHAR(40), cidade VARCHAR(40));

CREATE TABLE inscricao (id serial, ref_aluno INTEGER, ref_turma INTEGER,
nota FLOAT, frequencia FLOAT, cancelada BOOLEAN, concluida BOOLEAN);

CREATE TABLE turma (id INTEGER, dia_semana INTEGER, turno CHAR(1),
professor VARCHAR(40), sala VARCHAR(40), data_inicio DATE,
encerrada BOOLEAN, ref_curso INTEGER);

CREATE TABLE curso (id INTEGER, descricao VARCHAR(40), duracao INTEGER);