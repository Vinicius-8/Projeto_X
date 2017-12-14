<?php

/**
 * A classe listagem lista todos os cursos presentes no banco de dados
 *
 * @author Vinicius
 */
class Listagem {
    /**
     * Variavel do tipo Read
     * @var Read 
     */
    private $read;
    /*
     * variares para a listagem parcial
     * @var string 
     */
    private $nome,$thumb;
    
    public function __construct() {
        $this->read = new Read();
    }
    public function listagemParcial() {
        $this->read->setDaft("id,nome_curso,thumb");
        $this->read->ExecutarRead("curso");
        return $this->read->getResultado();
    }
}
