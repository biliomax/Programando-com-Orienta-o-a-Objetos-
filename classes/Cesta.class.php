<?php
class Cesta {

    private $itens;

    # Adciona Itens na cesta
    function AdcionaItem(Produto $item){
        $this->itens[] = $item;
    }

    # Exibe a lista de produtos
    function ExibeLista(){
        foreach ($this->itens as $item){
            $item->ImprimeEtiqueta();
            echo '<br>';
        }
    }

    # Calcula o valor total da cesta
    function CalculaTotal(){
        
        foreach ($this->itens as $item){
            $total += $item->Preco;
        }
        return 'R$: '.$total;
    }
}