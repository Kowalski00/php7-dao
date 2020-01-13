<?php

class Usuario {

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getIdusuario(){
        return $this->idusuario;
    }
    public function setIdusuario($value){
        $this->idusuario = $value;
    }

    public function getDeslogin(){
        return $this->deslogin;
    }
    public function setDeslogin($value){
        $this->deslogin = $value;
    }

    public function getDessenha(){
        return $this->dessenha;
    }
    public function setDessenha($value){
        $this->dessenha = $value;
    }

    public function getDtcadastro(){
        return $this->dtcadastro;
    }
    public function setDtcadastro($value){
        $this->dtcadastro = $value;
    }

    public function loadById($id){
        $sql = new Sql();

        $results = $sql -> select("SELECT * FROM tb_usuarios WHERE id_usuario=:ID",array(
            ":ID"=>$id
        ));

        if (isset($results[0])){
            $this->setData($results[0]);
        }
    }

    public static function getList(){
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios ORDER BY des_login");
    }

    public static function search($login){
        $sql = new Sql();

        return $sql->select("SELECT * FROM  tb_usuarios WHERE des_login LIKE :SEARCH ORDER BY des_login",array(
            ':SEARCH'=>"%".$login."%"
        ));
    }

    public function login($login, $pass){
        $sql = new Sql();

        $results = $sql -> select("SELECT * FROM tb_usuarios WHERE des_login=:LOGIN AND des_senha=:PASS",array(
            ":LOGIN"=>$login,
            ":PASS"=>$pass
        ));

        if (isset($results[0])){

            $this->setData($results[0]);
        }
        else{
            throw new Exception("Login e/ou senha inválidos");
        }
    }
    public function setData($data){
        $this->setIdusuario($data['id_usuario']);
        $this->setDeslogin($data['des_login']);
        $this->setDessenha($data['des_senha']);
        $this->setDtcadastro(new DateTime($data['dt_cadastro']));
    }

    public function insert(){
        $sql = new Sql();
        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN,:PASS)",array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASS'=>$this->getDessenha()
        ));
        if(count($results)>0){
            $this->setData($results[0]);
        }
    }

    public function update($Login,$password){

        $this->setDeslogin($Login);
        $this->setDessenha($password);

        $sql = new Sql();

        $sql->query("UPDATE tb_usuarios SET des_login =:LOGIN, des_senha =:PASS WHERE id_usuario=:ID", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASS'=>$this->getDessenha(),
            ':ID'=>$this->getIdusuario()
        ));

    }

    public function __construct($Login = "",$Pass = ""){
        $this->setDeslogin($Login);
        $this->setDessenha($Pass);
    }

    public function __toString(){
        return json_encode(array(
            "id_usuario"=>$this->getIdusuario(),
            "des_login"=>$this->getDeslogin(),
            "des_senha"=>$this->getDessenha(),
            "dt_cadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
    ));
    }

}


?>