<?php


/**
 * A classe aluno é a abstração do aluno cadastrado no site
 *
 * @author Vinicius
 * @copyright (c) 15/11/2017, Vinícius Vieira de Araújo 
 * 
 */
class Aluno {
    private $cpf,$nome,$sobrenome,$nasc,$email,$telefone,$senha;
    
    /**
     *
     * @param int $cpf CPF do Aluno
     * @param string $nome Nome do aluno
     * @param strin $sobrenome  Sobrenome do Aluno
     * @param int $nasc Data de nascimento do Aluno
     * @param string $email E-mail do Aluno
     * @param int $telefone Telefone do Aluno
     * @param string $senha Senha do Aluno
     */
    
    function __construct($cpf,$nome, $sobrenome, $nasc, $email, $telefone, $senha) {
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->nasc = $nasc;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->senha = $senha;
        $this->cpf = $cpf;
    }
    
    public function getVetorAluno() {
        return array('cpf'=> $this->cpf,'nome'=> $this->nome,
                    'sobrenome'=> $this->sobrenome,
                    'data_nasc'=> $this->nasc,
                    'email'=> $this->email,
                    'telefone'=> $this->telefone,
                    'senha'=> $this->senha);
    }
    
    
    function getNome() {
        return $this->nome;
    }

    function getSobrenome() {
        return $this->sobrenome;
    }

    function getNasc() {
        return $this->nasc;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getSenha() {
        return $this->senha;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

    function setNasc($nasc) {
        $this->nasc = $nasc;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }



}
