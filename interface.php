<?php

# Interface Aluno
interface IAluno {

    function getNome();
    function setNome($nome);
    function setResponsavel(Pessoa $responsavel);
}

# Classe Aluno
class Aluno implements IAluno {
    
    # Atribui o nome aluno
    function setNome($nome) {
        $this->nome = $nome;
    }

    # Retorna o nome do aluno
    function getNome(){
        return $this->nome;
    }
}

# Instancia novo Aluno
$joaninha = new Aluno;
echo $joaninha->getNome();
