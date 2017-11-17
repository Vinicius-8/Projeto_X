<?php

/**
 * @project: 5_Aulas_de_PHP
 * @name: Read.class 
 * @Description:Exemplo de CRUD, classe responsável pela ação do READ,
 * ou seja, realizar cadastros no Banco de Dados.
 * @copyright (c) 25/10/2017, Iury Gomes - IFTO
 * @author Iury Gomes de Oliveira 
 * @email iury.oliveira@ifto.edu.br
 * @version 1.0 
 */
class Read extends ConexaoBD {

    private $Select;    // Armazena o select que vai realizar a leitura
    private $Valores;   // Armazena os valores que serão substituidos no select
    private $Resultado; // Armazena o resultado das operações no banco 
    
    /** @var PDOStatement */
    private $sql_preparado;
    

        /** @var PDO */
    private $Conexao;

    /**
     * ExecutarRead: Executa uma leitura simplificada com Prepared Statments. Basta informar o nome da tabela,
     * os termos da seleção e os valores a serem lidos para executar.
     * @param STRING $Tabela = Nome da tabela
     * @param STRING $Termos = WHERE | ORDER | LIMIT :limit | OFFSET :offset
     * @param STRING $Valores = Os valores que serão substituidos na string do sql
     */
    public function ExecutarRead($Tabela, $Termos = null, $Valores = null) {

         if (!empty($Valores)):
            // Coloca uma string em um array
             $this->AlterarValores($Valores);
        endif;
       
        
        $this->Select = "SELECT senha FROM {$Tabela} {$Termos}";
        
        $this->Executar();
    }

    /**
     * getResultado: Retorna um array com todos os resultados obtidos. Envelope primário númérico. Para obter
     * um resultado chame o índice getResult()[0]!
     * 
     * @return ARRAY $this = Array ResultSet
     */
    public function getResultado() {
        return $this->Resultado;
    }

    /**
     * getLinhasAlteradas: Retorna o número de registros alterados pela sql executado!
     * @return INT $this->sql_preparado->rowCount() = Quantidade de registros alterados
     */
    public function getLinhasAlteradas() {
        return $this->sql_preparado->rowCount();
    }
    
     /**
     * AlterarValores: Altera apenas os valores que precisam ser substituidos
     * sem necessidade de alterar o sql montado anteriormente em getSintaxe
     * 
     */
    public function AlterarValores($Valores) {
        
        if (!empty($Valores)):

            // Coloca uma string em um array
            parse_str($Valores, $this->Valores);
        endif;
        
    }

    
    
    public function VerObjeto() {

        var_dump($this);
        echo '<hr>';
    }

    // MÉTODOS PRIVADOS ############################
    //Obtém o PDO e Prepara a query
    private function Connect() {
        
        // Obtendo conexão com o banco de dados
        $this->Conexao = parent::ObterConexao(); 
        
        // Preparando o SQL para ser executado pelo Banco
        $this->sql_preparado = $this->Conexao->prepare($this->Select);
        
        // Setando o retorno dos resultados como array
        $this->sql_preparado->setFetchMode(PDO::FETCH_ASSOC); 
    }

    //Cria a sintaxe da sql para usar o Prepared Statements
    private function getSintaxe() {

        // Se existirem valores para serem substituidos na string da sql
        // então eu posso realizar a montagem da sql
        if ($this->Valores):

            // foreach serve para percorrer cada posição do vetor
            // que contem os valores a serem substituidos
            foreach ($this->Valores as $Indices => $Valor):
                
                // Caso eu acrescente na sql os parametros de LIMIT ou OFFSET
                // os indices que contem os valores do limit ou offsset devem ser do tipo inteiro na sql
                // por isso é necessário fazer essa conversão de tipos aqui
                if ($Indices == 'limit' || $Indices == 'offset'):
                    $Valor = (int) $Valor;
                endif;
                
                // Utilizando operadores ternarios aqui
                // caso $Valor seja inteiro recebe PDO::PARAM_INT
                // caso $valor não seja inteiro recebe PDO::PARAM_STR
                
                $this->sql_preparado->bindValue(":{$Indices}", 
                                                $Valor, 
                                                ( is_int($Valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
                
                // LEMBREM-SE:
                // No bindValue temos:
                // 1º Argumento: É o link a ser substituido
                // 2º Argumento: É o valor a ser substituido
                // 3º Argumento: É o tipo de dado que está sendo informado

            endforeach;

        endif;
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Executar() {
        $this->Connect();
        try {
            
            $this->getSintaxe(); // Montando SQL
            $this->sql_preparado->execute(); // Exectuando SQL montado
            $this->Resultado = $this->sql_preparado->fetchAll(); // Armazenando os resulados em formato de Array
        } catch (PDOException $e) {
            $this->Resultado = null;
            echo $e->getMessage();
            trigger_error("Erro ao fazer leitura",$e->getCode());
        }
    }

}
