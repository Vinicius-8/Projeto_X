<?php

/**
 * @project: 5_Aulas_de_PHP
 * @name: ConexaoBD.class 
 * @Description: Exemplo de Conexão com Banco de Dados usando o Padrão Singleton
 * Retorna um objeto PDO pelo método estático ObterConexao()
 * O Padrão de Projeto Singleton faz com que temos uma unica instancia de objeto
 * executando na memoria. Para maiores informações sobre acesso ao MySQL utilizando PDO
 * acesse: http://php.net/manual/pt_BR/ref.pdo-mysql.connection.php
 * @copyright (c) 17/10/2017, Iury Gomes - IFTO
 * @author Iury Gomes de Oliveira 
 * @email iury.oliveira@ifto.edu.br 
 * @version 1.0 
 */
class ConexaoBD {

    private static $dsn = null; // USADO APENAS PARA DEPURAÇÃO DA CONEXÃO
    
    private static $Host = HOST; // Local onde está o banco
    private static $Usuario = USUARIO; // usuario de acesso ao banco
    private static $Senha = SENHA; // senha de acesso ao banco
    private static $Banco = BANCO; // nome do banco
    /** @var PDO */
    private static $Conexao = null; 
    // Só vamos executar a conexão se $Conexao = null, se $Conexão != null, 
    // usamos a conexão já criada, isso é singleton

    /**
     * Conecta com o banco de dados com o padrão singleton.
     * Retorna um objeto PDO
     */
    private static function Conectar() {
        try {
            if (self::$Conexao == null):
                
                // Montando DSN para conexão com o banco
                // DSN = Data Source Name
                $dsn = 'mysql:host=' . self::$Host . ';dbname=' . self::$Banco;
                
                self::$dsn=$dsn; // PARA DEPURAÇÃO
                
                // Setando codificação UTF-8 no Banco de Dados
                // As configurações precisam ser repassadas em forma de Array, por isso as CHAVES
                // MYSQL_ATTR_INIT_COMMAND é o índice que de configuração que desejamos acessar
                
                $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
                
                self::$Conexao = new PDO($dsn, self::$Usuario, self::$Senha, $options);
            endif;
        } catch (PDOException $erro) {
            trigger_error("Não foi possivel realizar conexão com o banco",E_USER_ERROR);
            die;
        }
        
     
        
        // Tratamento de erros no PDO
        //
        // O PDO oferece 3 alternativas para manipulação de erros.
        //
        // PDO::ERRMODE_SILENT
        // Esse é o tipo padrão utilizado pelo PDO, basicamente o PDO seta
        // internamente o código de um determinado erro, podendo ser resgatado
        // através dos métodos PDO::errorCode() e PDO::errorInfo().
        //
        // PDO::ERRMODE_WARNING
        // Além de armazenar o código do erro, este tipo de manipulação de erro
        // irá enviar uma mensagem E_WARNING, sendo este muito utilizado durante
        // a depuração e/ou teste da aplicação.
        //
        // PDO::ERRMODE_EXCEPTION
        // Além de armazenar o código de erro, este tipo de manipulação de erro irá
        // lançar uma exceção PDOException, esta alternativa é recomendada, principalmente
        //  por deixar o código mais limpo e legível.

        
        
        self::$Conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Conexao;
    }

    /** Retorna um objeto PDO Singleton. */
    static function ObterConexao() {
        return self::Conectar();
    }
    
    public function VerAtributos(){
        echo "<hr>";
        echo "Dados de conexão com o banco <br>";
        echo "HOST: ";
        var_dump(self::$Host);
        echo "USUARIO: ";
        var_dump(self::$Usuario);
        echo "SENHA: ";
        var_dump(self::$Senha);
        echo "BANCO: ";
        var_dump(self::$Banco);
        echo "DSN: ";
        var_dump(self::$dsn);
        echo "CONEXAO: ";
        var_dump(self::$Conexao);
      
    }

    public function VerObjeto() {

        var_dump($this);
        echo '<hr>';
    }

}
