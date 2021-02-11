<?php
/**
 * Autor: Max Moura
 * Data : 10/02/2021
 * classe TExpressionc
 * classse abstrata para gerenciar expressões
 */

abstract class TSqlSelect {

    // operadores lógicos
    const AND_OPERATOR = 'AND ';
    const OR_OPERATOR = 'OR ';

    // marca método dump como obrigatório
    abstract public function dump();
}