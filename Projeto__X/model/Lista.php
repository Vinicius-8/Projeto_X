<?php

/**
 * A Classe é responsável por inserir, ler e manipular os dados do curso
 *
 * @author Vinicius
 */

class Lista {
    
    private $idUsuario; //id do usuario na tabela (aluno ou professor3)
    private $tipo;  //aluno ou professor
    private $nome, $preco;//nome e preço na tabela cursos
    private $aulas,$form,$alunos,$desc,$thumb;//atributos da tabela cursos
    /**
     *
     * @var Read 
     */
    private $read;
    
    
    /**
     * 
     * @param type $idUsuario ID do usuario em sua respectiva tabela
     * @param boolean $tipo  tipo de usuario (professor ou aluno) professor = true
     */
    function __construct($idUsuario, $tipo) {
        $this->idUsuario = $idUsuario;
        $this->tipo = $tipo;
        $this->read = new Read();
    }
    
    /**
     * O metodo getData é responsável por pegar todos os atributos do curso
     * @return array
     */
    public function getData($idCurso) {
        $this->read->setDaft("*");
        $this->read->ExecutarRead('curso', "where id = '{$idCurso}' and id_professor = '{$this->idUsuario}' ");
        $res = $this->read->getResultado();
        $this->aulas = count($this->getAllAulas($idCurso));
        $this->desc =$res[0]['descricao'];
        $this->nome =$res[0]['nome_curso'];
        $this->preco =$res[0]['preco'];
        $this->thumb =$res[0]['thumb'];
        return $res;
    }
    
    /**
     * O metodo getAllCursos procura no BD por todos os cursos de um professor
     * @return array vetor com o nome do curso e id
     */
    public function getAllCursos() {
        $this->read->setDaft("id,nome_curso,thumb");
        $this->read->ExecutarRead("curso ", "where id_professor = '{$this->idUsuario}'");
        return $this->read->getResultado();
    }
    
    /**
     * O metodo insertAula, insere uma aula fornecida pelo usuário no BD
     * @param type $nome_aula Nome da aula
     * @param type $url Link da aula
     * @param type $id_curso id do curso correspondente a aula
     */
    public function insertAula($nome_aula, $url,$id_curso) {
        $datos = array('nome_aula'=>$nome_aula,'url'=>$url,'id_curso'=>$id_curso);
        $create = new Create();
        $create->ExecutarCreate('aula',$datos);
    }
    
    public function getAllAulas($idCurso){
        $this->read->setDaft("id,nome_aula,url");
        $this->read->ExecutarRead('aula', "where id_curso = '{$idCurso}'");
        return $this->read->getResultado();
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
