<?php

class BDRepub {

    protected $BD;
    protected $HOST;
    protected $USUARIO;
    protected $PWD;
    protected $SGBD;
    protected $PORTA;
    private $connection;
    private $bdStatement;
    public $lastID;

    public function __construct($BD = 'a14017', $HOST = 'www2.bcc.unifal-mg.edu.br', $USUARIO = 'a14017', $PWD = 'a14017', $SGBD = 'mysql', $PORTA = '3306') {
        $this->BD = $BD;
        $this->HOST = $HOST;
        $this->USUARIO = $USUARIO;
        $this->PWD = $PWD;
        $this->SGBD = $SGBD;
        $this->PORTA = $PORTA;

        try {
            $this->connection = new PDO("mysql:dbname=a14017;host=www2.bcc.unifal-mg.edu.br;port=3306", "a14017", "a14017");
        } catch (Exception $e) {
            die('Não foi possível conectar-se com o banco de dados: ' . $BD . ' no endereço: ' . $HOST . ' porta: ' . $PORTA . '! ' . $e->getMessage());
        }
        
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bdStatement = $this->connection;
    }

    public function executeQuery($sql, $params) {
        $bd = new BDRepub();
        $ps = $bd->connection->prepare($sql); //preparedStatement

        $i = 1;
        foreach ($params as $param) {
            $ps->bindValue(":param" . $i, $param);
            $i++;
        }
        $ps->execute();
        $objetos = null;

        for ($i = 0; $obj = $ps->fetchObject(); $i++) {
            $objetos[$i] = $obj;
        }
        
        return $objetos;
    }

    public function executeNonQuery($sql, $params) {
        $bd = new BDRepub();
        $ps = $bd->connection->prepare($sql);
        
        $i = 1;
        foreach ($params as $param) {
            $ps->bindValue(":param" . $i, $param);
            $i++;
        }
        $result = $ps->execute();
        $this->lastID = $bd->connection->lastInsertId();

        return $result;
    }

}

?>