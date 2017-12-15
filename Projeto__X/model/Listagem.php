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
    private $preco,$aulas,$desc;
    function getNome() {
        return $this->nome;
    }

    function getThumb() {
        return $this->thumb;
    }

    function getPreco() {
        return $this->preco;
    }

    function getAulas() {
        return $this->aulas;
    }

    function getDesc() {
        return $this->desc;
    }

    function getForm() {
        return $this->form;
    }

    function getAlunos() {
        return $this->alunos;
    }

        private $form,$alunos; //-----------posteriormente
    
    public function __construct() {
        $this->read = new Read();
    }
    public function listagemParcial() {
        $this->read->setDaft("id,nome_curso,thumb");
        $this->read->ExecutarRead("curso");
        return $this->read->getResultado();
    }
    
    public function listagemCompleta($idCurso) {
        $this->read->setDaft("*");
        $this->read->ExecutarRead("curso","where id = {$idCurso}");
        $res = $this->read->getResultado();
        $this->aulas = count($this->getAllAulas($idCurso));
        $this->desc =$res[0]['descricao'];
        $this->nome =$res[0]['nome_curso'];
        $this->preco =$res[0]['preco'];
        $this->thumb =$res[0]['thumb'];
    }
    
    /**
     * 
     * @param string $idCurso id do Curso no BD
     * @return array array com todas as aulas
     */
    public function getAllAulas($idCurso){
        $this->read->setDaft("id,nome_aula,url");
        $this->read->ExecutarRead('aula', "where id_curso = '{$idCurso}'");
        return $this->read->getResultado();
    }
}
