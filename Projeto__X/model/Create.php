<?php

/**
 * @project: 5_Aulas_de_PHP
 * @name: Create.class 
 * @Description: Exemplo de CRUD, classe responsável pela ação do CREATE,
 * ou seja, realizar cadastros no Banco de Dados. 
 * @copyright (c) 25/10/2017, Iury Gomes - IFTO
 * @author Iury Gomes de Oliveira 
 * @email iury.oliveira@ifto.edu.br
 * @version 1.0 
 */
class Create extends ConexaoBD {

    private $Tabela; // Tabela a ser inserida no banco
    private $Dados;  // Dados a serem inseridos na tabela
    private $Resultado; // Resultado para averiguar se o cadastro foi realizado

    /** @var PDOStatement */
    private $sql_preparado; // Objeto PDOStatement, responsável pela query preparada

    /** @var PDO */
    private $Conexao; // Objeto PDO, responsáve por armazenar a conexão com o banco de dados

    /**
     * ExeCreate: Executa um cadastro simplificado no banco de dados utilizando prepared statements.
     * Basta informar o nome da tabela e um array atribuitivo com nome da coluna e valor!
     * 
     * @param STRING $Tabela = Informe o nome da tabela no banco
     * @param ARRAY $Dados = Informe um array atribuitivo. ( Nome Da Coluna => Valor )
     */

    public function ExecutarCreate($Tabela, array $Dados) {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;
        
        $this->getSintaxe();
        $this->Executar();
    }

    /**
     * getResultado: Retorna o ID do registro inserido ou FALSE caso nem um registro seja inserido! 
     * @return INT $Variavel = lastInsertId OR FALSE
     */
    public function getResultado() {
        return $this->Resultado;
    }

    public function VerObjeto() {

        var_dump($this);
        echo '<hr>';
    }

    // METODOS PRIVADOS ####################################
    // Obtém o PDO e Prepara a query
    // Coloquei o nome connect para não aplicar polimorfismo na classe conectar da classe ConexaoBD
    private function Connect() {
        
        $this->Conexao = parent::ObterConexao(); // Pegando conexão com o banco
        
        // Preparando o sql para ser inserido no banco
        $this->sql_preparado = $this->Conexao->prepare($this->sql_preparado);
       
    }

    //Cria a sintaxe generica para uma query, que será passará pelo Prepared Statement posteriormente
    private function getSintaxe() {
        
        // implode: Junta elementos de uma matriz em uma string
        // array_keys: extrai os índices de um vetor
        // $colunas: são as colunas do vetor
        // $valores: valores a serem substituidos no vetor
        $colunas = implode(', ', array_keys($this->Dados));
        //var_dump($colunas);
        
        $valores = ':' . implode(', :', array_keys($this->Dados));
        //var_dump($valores);
        
        $this->sql_preparado = "INSERT INTO {$this->Tabela} ({$colunas}) VALUES ({$valores})";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Executar() {
        $this->Connect();
        try {
            
            // Existe uma diferença aqui, não foi necessário executar o bindValue ou bindParam, pois a propria 
            // classe PDO vai identificar os links que precisam ser substituidos no sql preparado
            
            $this->sql_preparado->execute($this->Dados);
            
            $this->Resultado = $this->Conexao->lastInsertId(); // Capturando respostas do banco
             
        } catch (PDOException $e) {
            
            $this->Resultado = null;
            echo $e->getMessage();
            trigger_error("Erro ao cadastrar",$e->getCode());
        }
    }

}
