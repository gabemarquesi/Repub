<?php

include_once '../repub.persistencia/bd_repub.php';
include_once 'imagemControlador.php';
include_once 'quartoControlador.php';
include_once 'perguntaControlador.php';
include_once 'telefoneControlador.php';
include_once '../repub.modelos/anuncio.php';
include_once '../repub.modelos/imagem.php';
include_once '../repub.modelos/quarto.php';

class AnuncioControlador {

    public $bd;

    function __construct() {
        $this->bd = new BDRepub();
    }

    public function get($ID) {
        $sql = "SELECT * FROM a14017.anuncios WHERE id = :param1";
        $params[] = $ID;
        $obj = $this->bd->executeQuery($sql, $params);
        $anuncio = null;

        if (count($obj) > 0) {
            $anuncio = new Anuncio($obj[0]->id, $obj[0]->titulo, $obj[0]->endereco, $obj[0]->ativo, $obj[0]->nome, $obj[0]->garagem, $obj[0]->descricao, $obj[0]->valorMedioContas, $obj[0]->internet, $obj[0]->bairro, $obj[0]->cidadeID, $obj[0]->donoID);
        }

        $cidadeControlador = new CidadeControlador();
        $anuncio->cidade = $cidadeControlador->get($obj[0]->cidadeID);

        $imagemControlador = new ImagemControlador();
        $anuncio->imagemCapa = $imagemControlador->get($obj[0]->imagemcapa);

        $sql = "SELECT imagemID FROM imagens_anuncio WHERE anuncioID = :param1";
        $params = array($ID);

        foreach ($this->bd->executeQuery($sql, $params) as $result) {
            $imagem = $imagemControlador->get($result->imagemID);
            if ($imagem != null) {
                $anuncio->imagens[] = $imagem;
            }
        }

        $quartoControlador = new QuartoControlador();

        $sql = 'SELECT quartoId FROM anuncio_quartos WHERE anuncioID = :param1';
        $params = array($ID);

        foreach ($this->bd->executeQuery($sql, $params) as $result) {
            $quarto = $quartoControlador->get($result->id);
            if ($quarto != null) {
                $anuncio->quartos[] = $quarto;
            }
        }

        $perguntaControlador = new PerguntaControlador();

        $sql = 'SELECT perguntaID FROM anuncio_perguntas WHERE anuncioID=:param1';
        $params = array($ID);

        foreach ($this->bd->executeQuery($sql, $params) as $result) {
            $pergunta = $perguntaControlador->get($result->id);
            if ($pergunta != null) {
                $anuncio->perguntas[] = $pergunta;
            }
        }

        $telefoneControlador = new TelefoneControlador();

        $sql = 'SELECT telefoneID FROM anuncio_telefones WHERE anuncioID=:param1';
        $params = array($ID);

        foreach ($this->bd->executeQuery($sql, $params) as $result) {
            $telefone = $telefoneControlador->get($result->id);
            if ($telefone != null) {
                $anuncio->telefone[] = $telefone;
            }
        }

        return $anuncio;
    }

    public function getByUsuario($usuarioID) {
        $sql = "SELECT id FROM a14017.anuncios WHERE donoID = :param1";
        $params[] = $usuarioID;
        $anuncios = null;

        foreach ($this->bd->executeQuery($sql, $params) as $result) {
            $anuncios[] = $this->get($result->id);
        }

        return $anuncios;
    }

    public function create($anuncio) {
        if ($anuncio == null) {
            throw new Exception('Um anúncio não-nulo precisa ser fornecido!');
        }

        $ex = Anuncio::validate($anuncio);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "INSERT INTO a14017.anuncios (titulo, endereco, ativo, nome,
                    garagem, descricao, valorMedioContas, internet, bairro, cidadeID, donoID, imagemCapa)
                    VALUES (:param1, :param2, :param3, :param4, :param5, 
                    :param6, :param7, :param8, :param9, ':param10, :param11, :param12);";

        $params = array($anuncio->titulo, $anuncio->endereco, $anuncio->ativo,
            $anuncio->nome, $anuncio->garagem, $anuncio->descricao,
            $anuncio->valorMedioContas, $anuncio->internet,
            $anuncio->bairro, $anuncio->cidade->id, $anuncio->donoID, $anuncio->imagemCapa->id);

        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o create.');
        }

        $anuncioCriado = $this->get($this->bd->lastID);

        foreach ($anuncio->imagens as $imagem) {
            $sql = "INSERT INTO a14017.imagens_anuncios (imagemID, anuncioID) VALUES (:param1, :param2)";
            $params = array($imagem->id, $anuncioCriado->id);

            if (!$this->bd->executeNonQuery($sql, $params)) {
                $this->delete($anuncioCriado->id);
                throw new Exception('Ocorreu um erro durante o create.');
            }
        }

        foreach ($anuncio->quartos as $quarto) {
            $sql = "INSERT INTO a14017.anuncio_quartos (quartoID, anuncioID) VALUES (:param1, :param2)";
            $params = array($quarto->id, $anuncioCriado->id);

            if (!$this->bd->executeNonQuery($sql, $params)) {
                $this->delete($anuncioCriado->id);
                throw new Exception('Ocorreu um erro durante o create.');
            }
        }

        foreach ($anuncio->telefone as $telefone) {
            $sql = "INSERT INTO a14017.anuncio_telefones (telefoneID, anuncioID) VALUES (:param1, :param2)";
            $params = array($telefone->id, $anuncioCriado->id);

            if (!$this->bd->executeNonQuery($sql, $params)) {
                $this->delete($anuncioCriado->id);
                throw new Exception('Ocorreu um erro durante o create.');
            }
        }

        return $anuncioCriado;
    }

    public function delete($id) {
        $sql = "DELETE FROM a14017.anuncios WHERE id = :param1";
        $params = array($id);

        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o delete.');
        }
    }

    private function updateImagens($anuncio) {
        $sql = "DELETE FROM a14017.imagens_anuncio WHERE anuncioID = :param1";
        $params = array($anuncio->id);

        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o update.');
        }

        foreach ($anuncio->imagens as $imagem) {
            $sql = "INSERT INTO a14017.imagens_anuncios (imagemID, anuncioID) VALUES (:param1, :param2)";
            $params = array($imagem->id, $anuncio->id);

            if (!$this->bd->executeNonQuery($sql, $params)) {
                throw new Exception('Ocorreu um erro durante o update.');
            }
        }
    }

    private function updatePerguntas($anuncio) {
        $sql = "DELETE FROM a14017.anuncio_perguntas WHERE anuncioID = :param1";
        $params = array($anuncio->id);

        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o update.');
        }

        foreach ($anuncio->perguntas as $pergunta) {
            $sql = "INSERT INTO a14017.anuncio_perguntas (perguntaID, anuncioID) VALUES (:param1, :param2)";
            $params = array($pergunta->id, $anuncio->id);

            if (!$this->bd->executeNonQuery($sql, $params)) {
                throw new Exception('Ocorreu um erro durante o update.');
            }
        }
    }

    private function updateQuartos($anuncio) {
        $sql = "DELETE FROM a14017.anuncio_quartos WHERE anuncioID = :param1";
        $params = array($anuncio->id);

        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o update.');
        }

        foreach ($anuncio->quartos as $quarto) {
            $sql = "INSERT INTO a14017.anuncio_perguntas (quartoID, anuncioID) VALUES (:param1, :param2)";
            $params = array($quarto->id, $anuncio->id);

            if (!$this->bd->executeNonQuery($sql, $params)) {
                throw new Exception('Ocorreu um erro durante o update.');
            }
        }
    }

    private function updateTelefones($anuncio) {
        $sql = "DELETE FROM a14017.anuncio_telefones WHERE anuncioID = :param1";
        $params = array($anuncio->id);

        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o update.');
        }

        foreach ($anuncio->telefone as $telefone) {
            $sql = "INSERT INTO a14017.anuncio_telefones (telefoneID, anuncioID) VALUES (:param1, :param2)";
            $params = array($telefone->id, $anuncio->id);

            if (!$this->bd->executeNonQuery($sql, $params)) {
                throw new Exception('Ocorreu um erro durante o update.');
            }
        }
    }

    public function update(Anuncio $anuncio) {
        if ($anuncio == null) {
            throw new Exception('Um anúncio não-nulo precisa ser fornecido!');
        }

        $ex = Anuncio::validate($anuncio);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "UPDATE a14017.anuncios 
                    SET titulo=:param1, endereco=:param2, ativo=:param3, nome=:param4,;
                        garagem=:param5, descricao=:param6,
                        valormediocontas=:param7, internet=:param8,
                        bairro=:param9, cidadeID=:param10, donoID=:param11,
                        imagemcapa = :param12
                    WHERE id = :param13";

        $params = array($anuncio->titulo, $anuncio->endereco, $anuncio->ativo, $anuncio->nome,
            $anuncio->garagem, $anuncio->descricao, $anuncio->valorMedioContas, $anuncio->internet,
            $anuncio->bairro, $anuncio->cidade->id, $anuncio->donoID, $anuncio->imagemCapa, $anuncio->id);

        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o update.');
        }

        $this->updateImagens($anuncio);
        $this->updatePerguntas($anuncio);
        $this->updateQuartos($anuncio);
        $this->updateTelefones($anuncio);

        $novoAnuncio = $this->get($anuncio->id);

        return $novoAnuncio;
    }

}
