<?php

// carrega as classes necessárias
include_once 'app.ado/TExpression.class.php';
include_once 'app.ado/TCriteria.class.php';
include_once 'app.ado/TFilter.class.php';

// aqui vemos um exemplo de critério utilizando o operador lógico OR
// a idade deve ser menor que 16 OU mairo que 60
$criteria = new TCriteria;
$criteria->add(new TFilter('idade', '<', 16), TExpression::OR_OPERATOR);
$criteria->add(new TFilter('idade', '>', 60), TExpression::OR_OPERATOR);
echo $criteria->dump();
echo "<br>\n";

// aqui vemos um exemplo de critério utilizando o operador de comparação AND
// juntamente com os operadores de conjunto IN (dentro de conjunto) e NOT IN (fora do conjunto)
// a idade deve está dentro do conjunto (24,25,26) e deve está fora do conjunto (10)
$criteria = new TCriteria;
$criteria->add(new TFilter('idade', 'IN', array(24,25,26)));
$criteria->add(new TFilter('idade', 'NOT IN', array(10)));
echo $criteria->dump();
echo "<br>\n";

// aqui vemos um exemplo de critério utilizando o operador de comparação LIKE
// o nome deve iniciar por "pedro" ou debe iniciar por "maria"
$criteria = new TCriteria;
$criteria->add(new TFilter('nome', 'like', 'pedro%'), TExpression::OR_OPERATOR);
$criteria->add(new TFilter('nome', 'like', 'maria%'), TExpression::OR_OPERATOR);
echo $criteria->dump();
echo "<br>\n";

// aqui vemos um exemplo de critério utilizando o operadores "=" e IS NOT
// neste caso, o telefone não pode conter valor nulo (IS NOT NULL)
// e o sexo deve ser feminino
$criteria = new TCriteria;
$criteria->add(new TFilter('telefone', 'IS NOT', 'NULL'));
$criteria->add(new TFilter('sexo', '=', 'F'));
echo $criteria->dump();
echo "<br>\n";

// aqui vemos o uso dos operadores de comparação IN e NOT IN juntamnete com
// conjunto de strings. Neste caso, a UF deve estar entre (RS, SC e PR) E 
// não debe estar entre (AC e PI)
$criteria = new TCriteria;
$criteria->add(new TFilter('UF', 'IN', array('RS', 'SC', 'PR')));
$criteria->add(new TFilter('UF', 'NOT IN', array('AC', 'PI')));
echo $criteria->dump();
echo "<br>\n";

// neste caso temos o uso de um critério composto
// o primeiro critério aponta para sexo='F'
// (sexo feminino) e a idade > 18 (maior de idade)
$criteria1 = new TCriteria;
$criteria1->add(new TFilter('Sexo', '=', 'F'));
$criteria1->add(new TFilter('idade', '>', '18'));


// o segundo critério aponta para sexo='M' (masculino)
// (sexo feminino) e a idade > 18 (maior de idade)
$criteria2 = new TCriteria;
$criteria2->add(new TFilter('Sexo', '=', 'M'));
$criteria2->add(new TFilter('idade', '>', '16'));

// agora juntamos os dois critérios utilizando o operador lógico OR (ou). O resultador
// deve conter "mulheres maiores de 18" OU "homens menores de 16"
$criteria = new TCriteria;
$criteria->add($criteria1, TExpression::OR_OPERATOR);
$criteria->add($criteria2, TExpression::OR_OPERATOR);
echo $criteria->dump();
echo " <br>\n";