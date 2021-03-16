<?php
/*
 * classe TLoggerTXT
 * implementa o algoritmo de LOG em TXT 
 */

 class TLoggerTXT extends TLogger {
     /*
      * método write()
      * escreve uma mensagem no arquivo de LOG
      * @param $message = mensagem a ser escrita
      */

      public function write($message){

        $time = date("Y-m-d H:i:s");

        // monta a string
        $text = "$time :: $message\n";

        // adiciona ao final do arquivo
        $handler = fopen($this->filename, 'a');
        fwrite($handler, $text);
        fclose($handler);
    }
 }