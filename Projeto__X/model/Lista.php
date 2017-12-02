<?php

/**
 * A Classe é responsável por inserir, ler e manipular os dados do curso
 *
 * @author Vinicius
 */
require '../../include/Defines.php';
require '../../model/ConexaoBD.php';
require '../../model/Read.php';
class Lista {
    
    private $idProfessor,$idCurso;
    private $nome, $preco;
    private $aulas,$form,$alunos,$desc,$thumb;
    
    function __construct($idProfessor, $idCurso) {
        $this->idProfessor = $idProfessor;
        $this->idCurso = $idCurso;
        $this->getData();
    }
    
    public function getData() {
        $read = new Read();
        $read->setDaft("*");
        $read->ExecutarRead('curso', "where id = '{$this->idCurso}' and id_professor = '{$this->idProfessor}' ");
        $res = $read->getResultado();
        $this->alunos = $res[0]['quant_alunos'];
        $this->aulas =$res[0]['numero_aulas'];
        $this->desc =$res[0]['descricao'];
        $this->form =$res[0]['numero_form'];
        $this->nome =$res[0]['nome_curso'];
        $this->preco =$res[0]['preco'];
        $this->thumb =$res[0]['thumb'];
        return $res;
    }
    
    function getAulas() {
        return $this->aulas;
    }

    function getForm() {
        return $this->form;
    }

    function getAlunos() {
        return $this->alunos;
    }

    function getDesc() {
        return $this->desc;
    }
    function getNome() {
        return $this->nome;
    }

    function getPreco() {
        return $this->preco;
    }

    function getThumb() {
        return $this->thumb;
    }




}
