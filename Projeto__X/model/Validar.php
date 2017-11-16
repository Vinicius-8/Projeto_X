<?php

/**
 * @projeto sistemaphp
 * @Nome Validar.class 
 * @Descrição Classe responsável por validar e manipular dados no sistema
 * @copyright (c) 06/11/2017, Iury Gomes - IFTO
 * @Autor Iury Gomes de Oliveira 
 * @email iury.oliveira@ifto.edu.br
 * @Versão 1.0 - 06/11/2017
 * @Métodos Email(), Url(), UrlAmigavel(), TimeStamp(), QuantidadeVisitas()  
 * @Métodos getDadosInvalidos(), getDadosValidos(), VerAtributos()   
 *     
 */
class Validar {

    private static $DadosInvalidos; // Usado para armazenanar dados invalidos
    private static $DadosValidos; // Usado para armazenar dados validados

    // MÉTODOS ESTÁTICOS - ######################################
    /**
     * Executa validação de formato de e-mail no padrão indicado pela RFC 822. 
     * A RFC 822 define o formato padrão para mensagens de texto. 
     * Se deve informar um e-mail na chamada do método 
     * @param string $Email Uma conta de e-mail para ser validado
     * @return boleano Retorna true para um email válido, ou false para um e-mail invalido
     * 
     */

    public static function Email( $Email) {

        self::$DadosInvalidos = (string)$Email;

        // filter_var: Filtra a variável com um especificado filtro
        if (filter_var(self::$DadosInvalidos, FILTER_VALIDATE_EMAIL)):
            self::$DadosValidos = self::$DadosInvalidos;
            return true;
        else:
            return false;
        endif;
    }

    /**
     * Executa validação de formato da URL no padrão indicado pela RFC 2396
     * A RFC 2396 define o fomato padrão de endereços de internet
     * Se deve informar uma URL na chamada do método
     * @param string $endereco Um endereço de email para ser validado
     * @return boleano Retorna true para uma URL válida, ou false para uma URL inválida
     */
    public static function Url(string $endereco) {

        self::$DadosInvalidos = $endereco;

        // filter_var: Filtra a variável com um especificado filtro
        if (filter_var(self::$DadosInvalidos, FILTER_VALIDATE_URL)):
            self::$DadosValidos = self::$DadosInvalidos;
            return true;
        else:
            return false;
        endif;
    }

    /**
     * Tranforma uma URL para um formato de URL amigável
     * @param string $endereco Uma string que contém uma URL não amigável
     * @return string $DadosValidos Uma URL no formato amigável
     */
    public static function UrlAmigavel(string $endereco) {

        self::$DadosInvalidos = $endereco;

        // Transformando DadosValidos para um vetor 
        self::$DadosValidos = array();

        



        // Posição do Vetor que armazenará caracteres estranhos
        self::$DadosValidos['estranhos'] = 
        'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';

        // Posição do Vetor que armazenará caracteres amigaveis
        self::$DadosValidos['amigaveis'] = 
        'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        // Posição do vetor que armazenará o vetor convertido
        self::$DadosValidos['url'] = "";

        //utf8_decode: Converte uma string com caracteres com UTF-8 para ISO-8859-1.
        // Os caracteres do padrão ISO-8859-1 são o conjunto de caracteres padrão da maioria dos navegadores. 
        // Dependendo dos caracteres estranhos na URL, pode ser necessário codificar para ISO-8859-1 para
        // que a conversão seja feita de forma correta
        // 
        //UTF-8: Significa 8-bit Unicode Transformation Format é um tipo de codificação binária
        //de comprimento variável criado por Ken Thompson e Rob Pike. Pode representar qualquer caracter universal
        //
        // strtr: Esta função vai substituir todos os caracteres estranhos pelos caracteres amigaveis,
        //caso sejam encontrados em $endereco
        self::$DadosValidos['url'] = strtr(utf8_decode(self::$DadosInvalidos), 
                                           utf8_decode(self::$DadosValidos['estranhos']), 
                                           self::$DadosValidos['amigaveis']);

        // strip_tags: Retira as tags HTML e PHP de uma string
        // trim: Retira espaço no ínicio e final de uma string
        self::$DadosValidos['url'] = strip_tags(trim(self::$DadosValidos['url']));

        // Substituindo espaço por hifen, além disso substituindo vários hifens por um único hifen
        self::$DadosValidos['url'] = str_replace(' ', '-', self::$DadosValidos['url']);
        self::$DadosValidos['url'] = str_replace(array('-----', '----', '---', '--'), '-', self::$DadosValidos['url']);

        // strtolower: Colocando os caracteres em caixa baixa
        // utf8_encode: retornando os caracteres para o padrão UTF8
        self::$DadosValidos['url'] = strtolower(utf8_encode(self::$DadosValidos['url']));

        return self::$DadosValidos['url'];
    }

    /**
     * Transforma uma data no formato DD/MM/YY em uma data no formato TIMESTAMP utilizado no MySQL
     * @param string $Data Dados em (d/m/Y) ou (d/m/Y H:i:s)
     * @return string $DadosValidos Data no formato timestamp
     */
    public static function Timestamp(string $Data) {

        // Dividindo a string de $Data em duas strings
        // separando data e hora em strings diferentes
        // Format se transforma em um vetor
        self::$DadosInvalidos = explode(' ', $Data);

        // Separando os valores das datas
        $DataSeparada = explode('/', self::$DadosInvalidos[0]);

        // Caso seja informado uma data sem horas
        // a função date obtem a hora atual
        if (empty(self::$DadosInvalidos[1])):
            $horas = date('H:i:s');
        endif;

        self::$DadosValidos = $DataSeparada[2] . '-' . $DataSeparada[1] . '-' . $DataSeparada[0] . ' ' . $horas;
        return self::$DadosValidos;
    }

    /**
     * Método que informa quantos usuários se conectaram no sistema online
     * a quantidade é verificada com base nos dados presentes no banco 
     * @param string $Tabela Nome da tabela a ser pesquisada no banco
     * @param string $Termos Termos a serem utilizados na pesquisa
     * @return INT Quantidade de usuários online
     */
    public static function QuantidadeVisitas(string $Tabela, string $Termos = null) {

        $UsuariosOnline = new Read();
            
        // Se $Termos é igual a null ele fará a leitura de toda a tabela
        // Se $Termos é diferente de null ele fará a leitura até a data e hora informada
        if ($Termos == null):
            $UsuariosOnline->ExecutarRead($Tabela);
        else:
            $UsuariosOnline->ExecutarRead($Tabela, $Termos);
        endif;

        return $UsuariosOnline->getResultado();
    }

// MÉTODOS PÚBLICOS - ######################################

    /**
     * Este método obtem o valor do atributo DadosValidos
     * @return string Retorna o valor dos atributo self::$DadosValidos
     */
    public function getDadosValidos() {
        return self::$DadosValidos;
    }

    /**
     * Este método obtem o valor do atributo DadosInvalidos
     * @return string Retorna o valor do atributo self::$DadosInvalidos
     */
    public function getDadosInvalidos() {
        return self::$DadosInvalidos;
    }

    /**
     * Mostra os valores atuais dos atributos staticos
     * self::$DadosValidos e self::$DadosInvalidos
     */
    public function VerAtributos() {

        echo "<hr>";
        echo "Atributos <br>";
        echo '$DadosValidos: ';
        var_dump(self::$DadosValidos);
        echo '$DadosInvalidos ';
        var_dump(self::$DadosInvalidos);
        echo "<hr>";
    }

}
