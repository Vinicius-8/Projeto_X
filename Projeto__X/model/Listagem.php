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
    private $preco,$aulas,$desc,$nomeAutor,$sobrenome,$nasc;
    private $form,$alunos; 
    
    public function __construct() {
        $this->read = new Read();
    }
    /**
     * O metodo listagemParcial pega algumas informações do banco de dados
     * @return array nome, id, thumb
     */
    public function listagemParcial() {
        $this->read->setDaft("id,nome_curso,thumb");
        $this->read->ExecutarRead("curso");
        return $this->read->getResultado();
    }
    
    /**
     * O metodo listagemCompleta pega todas as informações relacionadas ao curso informado
     * @param string $idCurso id do curso a ser extraido
     */
    public function listagemCompleta($idCurso) {
        $this->read->setDaft("curso.id,nome_curso,preco,descricao,thumb,nome,sobrenome,data_nasc");
        $this->read->ExecutarRead("curso","inner join professor on curso.id_professor = professor.idNum where curso.id = '{$idCurso}'");
        $res = $this->read->getResultado();
        $this->aulas = count($this->getAllAulas($idCurso));
        $this->form = count($this->getAllForms($idCurso));
        $this->alunos = count($this->getAllAlunos($idCurso));
        $this->desc =$res[0]['descricao'];
        $this->nome =$res[0]['nome_curso'];
        $this->preco =$res[0]['preco'];
        $this->thumb =$res[0]['thumb'];
        $this->nomeAutor = $res[0]['nome'];
        $this->nasc = $res[0]['data_nasc'];
        $this->sobrenome = $res[0]['sobrenome'];
    }
    
    /**
     * O metodo getAllAulas captura todas as aulas do banco de dados
     * @param string $idCurso id do Curso no BD
     * @return array array com todas as aulas
     */
    public function getAllAulas($idCurso){
        $this->read->setDaft("id,nome_aula,url");
        $this->read->ExecutarRead('aula', "where id_curso = '{$idCurso}'");
        return $this->read->getResultado();
    }
    
    /**
     * O metodo getAllForms captura todos os formulários do banco de dados
     * @param string $idCurso id do curso a procurar os formularios
     * @return array vetor com id,nome_form,url;
     */
    public function getAllForms($idCurso) {
        $this->read->setDaft('id,nome_form,url');
        $this->read->ExecutarRead('formulario',"where id_curso = '{$idCurso}'");
        return $this->read->getResultado();
    }
    /**
     * O metodo getAllAlunos captura todos os alunos inscritos no curso informado
     * @param string $idCurso id do curso a procurar os alunos
     * @return array vetor do tipo id_aluno
     */
    public function getAllAlunos($idCurso) {
        $this->read->setDaft('id_aluno');
        $this->read->ExecutarRead('inscrito_em',"where id_curso = '{$idCurso}'");
        return $this->read->getResultado();
    }
    
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
    function getNomeAutor() {
        return $this->nomeAutor;
    }

    function getSobrenome() {
        return $this->sobrenome;
    }

    function getNasc() {
        return $this->nasc;
    }


}
