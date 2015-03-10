<?php

include_once('error.php');

class Routes {
	
    /*
    *   can all routes
    */
    public function get_routes($param){

        try {

            $sql = "SELECT *
                    FROM rotas r
                    WHERE r.excluido = b'0' 
                    ORDER BY r.dt_cadastro;";

            $stmt = DB::prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (Exception $ex) {
            Error::write($ex->getMessage(), $ex->getLine(), $ex->getFile());
            throw new Exception('Não foi possível efetuar a operação');
        }
    }

    /*
    *   can a route
    */
    public function get_route($param){

        if(!isset($param) or empty($param))
                throw new Exception('Não foi possivel encontrar o ID.');

        try {

            $sql = "SELECT *
                    FROM rotas r
                    WHERE r.excluido = b'0'
                    AND r.id_rota = :id;";

            $stmt = DB::prepare($sql);
            $stmt->bindParam(":id", $param);
            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (Exception $ex) {
            Error::write($ex->getMessage(), $ex->getLine(), $ex->getFile());
            throw new Exception('Não foi possível efetuar a operação');
        }
    }

    /*
    *   can a route list reference your search
    */
    public function post_routeMap($param){

        if(!isset($param) || empty($param))
            throw new Exception('Não foi possivel encontrar a rota.');

        if((!isset($param->autonomia) || !is_numeric($param->autonomia)) 
            || (!isset($param->valor_litro) || !is_numeric($param->valor_litro)))
            throw new Exception('O valor da autonomia ou valor_litro nao é valido.');

        if((!isset($param->origem) || strlen($param->origem) == 0) 
            || (!isset($param->destino) || strlen($param->destino) == 0))
            throw new Exception('O valor do destino ou origem nao é valido!');
            
        try {

            $sql = "SELECT *, FORMAT((r.distancia / :autonomia) * :valor_litro,2) as custo
                    FROM rotas r
                    WHERE r.origem = :origem AND r.destino = :destino
                    ORDER BY r.distancia;";

            $stmt = DB::prepare($sql);
            $stmt->bindParam(":origem", $param->origem);
            $stmt->bindParam(":destino", $param->destino);
            $stmt->bindParam(":autonomia", $param->autonomia);
            $stmt->bindParam(":valor_litro", $param->valor_litro);
            $stmt->execute();

            return $stmt->fetchAll();

            $this->post_save($param);

        
        } catch (Exception $ex) {
            Error::write($ex->getMessage(), $ex->getLine(), $ex->getFile());
            throw new Exception('Não foi possível efetuar a operação');
        }
    }

    /*
    *   save a route.
    */
    public function post_save($param){

        if(!isset($param))
            throw new Exception('Não é possível efetuar essa operação');

        if(!isset($param->distancia) || !is_numeric($param->distancia))
            throw new Exception('O valor da distancia não é valido!');

        if((!isset($param->distancia) || strlen($param->origem) == 0) 
            || (!isset($param->destino) || strlen($param->destino) == 0))
            throw new Exception('O valor do destino ou origem nao é valido!');

        if(!isset($param->nome) || empty($param->nome))
            throw new Exception('O valor do nome nao é valido!');

        try {

            $sql = "INSERT INTO rotas (origem, destino, distancia, nome)
                    VALUES (:origem, :destino, :distancia, :nome);";

            $stmt = DB::prepare($sql);
            $stmt->bindParam(":origem", $param->origem);
            $stmt->bindParam(":destino", $param->destino);
            $stmt->bindParam(":distancia", $param->distancia);
            $stmt->bindParam(":nome", $param->nome);
            $stmt->execute();

            return DB::lastInsertId();
            
        } catch (Exception $ex) {
            Error::write($ex->getMessage(), $ex->getLine(), $ex->getFile());
            throw new Exception('Não foi possível efetuar a operação');
        }
    }
}

