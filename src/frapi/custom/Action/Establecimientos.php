<?php

/**
 * Action Establecimientos 
 * 
 * dddd
 * 
 * @link http://getfrapi.com
 * @author Frapi <frapi@getfrapi.com>
 * @link /establecimientos
 */
class Action_Establecimientos extends Frapi_Action implements Frapi_Action_Interface {

    /**
     * Required parameters
     * 
     * @var An array of required parameters.
     */
    protected $requiredParams = array();

    /**
     * The data container to use in toArray()
     * 
     * @var A container of data to fill and return in toArray()
     */
    private $data = array();

    /**
     * To Array
     * 
     * This method returns the value found in the database 
     * into an associative array.
     * 
     * @return array
     */
    public function toArray() {
        return $this->data;
    }

    /**
     * Default Call Method
     * 
     * This method is called when no specific request handler has been found
     * 
     * @return array
     */
    public function executeAction() {
        $valid = $this->hasRequiredParameters($this->requiredParams);
        if ($valid instanceof Frapi_Error) {
            throw $valid;
        }

        return $this->toArray();
    }

    /**
     * Get Request Handler
     * 
     * This method is called when a request is a GET
     * 
     * @return array
     */
    public function executeGet() {
        /* $valid = $this->hasRequiredParameters($this->requiredParams);
          if ($valid instanceof Frapi_Error) {
          return $valid;
          } */

        $sql = "SELECT E.ESTABLECIMIENTO_ID, E.NOMBRE, E.IMAGEN, COUNT(*) AS NO_PROMOCIONES
                FROM ESTABLECIMIENTO E
                LEFT JOIN PROMOCION P ON P.ESTABLECIMIENTO_ID=E.ESTABLECIMIENTO_ID
                WHERE P.FECHA_INICIO<=NOW() AND P.FECHA_FIN>=NOW() AND E.ACTIVO=1";


        $id = $this->getParam('id', self::TYPE_INT);
        $tipo = $this->getParam('tipo', self::TYPE_INT);

        if (isset($id) || isset($tipo)) {
            $sql.=" AND";
            if (isset($id)) {
                $sql.=" E.ESTABLECIMIENTO_ID=" . $id;
            } elseif (isset($tipo)) {
                $sql.=" E.TIPO_ESTABLECIMIENTO_ID =" . $tipo;
            }
        }

        $sql.=" GROUP BY E.ESTABLECIMIENTO_ID";

        $db = Frapi_Database::getInstance("default");
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $arreglo=array();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            
            foreach ($result as $data) {

                $arreglo[]=array(
                'ESTABLECIMIENTO_ID' => (int)$data['ESTABLECIMIENTO_ID'],
                'NOMBRE' => $data['NOMBRE'],
                'IMAGEN' => $data['IMAGEN'],
                'NO_PROMOCIONES' => (int)$data['NO_PROMOCIONES']
                );
            }
           
            $this->data[] = array('ESTABLECIMIENTO' => $arreglo);
        } else {
            throw new Frapi_Error('SIN_RESULTADOS');
        }

        $db = null;

        return $this->toArray();
    }

    /**
     * Post Request Handler
     * 
     * This method is called when a request is a POST
     * 
     * @return array
     */
    public function executePost() {
        $valid = $this->hasRequiredParameters($this->requiredParams);
        if ($valid instanceof Frapi_Error) {
            throw $valid;
        }


        $sql = "SELECT * FROM ESTABLECIMIENTO";


        $id = $this->getParam('id', self::TYPE_INT);
        $tipo = $this->getParam('tipo', self::TYPE_INT);

        if (isset($id) || isset($tipo)) {
            $sql.=" WHERE";
            if (isset($id)) {
                $sql.=" ESTABLECIMIENTO_ID =" . $id;
            } elseif (isset($tipo)) {
                $sql.=" TIPO_ESTABLECIMIENTO_ID =" . $tipo;
            }
        }

        $db = Frapi_Database::getInstance("default");
        $stmt = $db->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $this->data[] = array('ESTABLECIMIENTO' =>
                    array(
                        'ESTABLECIMIENTO_ID' => $data['ESTABLECIMIENTO_ID'],
                        'NOMBRE' => $data['NOMBRE'],
                        'TELEFONO' => $data['TELEFONO'],
                        'AVATAR' => $data['AVATAR'],
                        'CONTACTO' => $data['CONTACTO'],
                        'EMAIL' => $data['EMAIL'],
                        'TIPO_ESTABLECIMIENTO_ID' => $data['TIPO_ESTABLECIMIENTO_ID'],
                        'ACTIVO' => $data['ACTIVO'],
                        'LEALTAD' => $data['LEALTAD'],
                        'KEYWORDS' => $data['KEYWORDS']
                    )
                );
            }
        } else {
            throw new Frapi_Error('SIN_RESULTADOS');
        }

        $db = null;


        return $this->toArray();
    }

    /**
     * Put Request Handler
     * 
     * This method is called when a request is a PUT
     * 
     * @return array
     */
    public function executePut() {
        $valid = $this->hasRequiredParameters($this->requiredParams);
        if ($valid instanceof Frapi_Error) {
            throw $valid;
        }

        $sql = "SELECT * FROM ESTABLECIMIENTO";


        $this->
                $id = $this->getParam('id', self::TYPE_INT);
        $tipo = $this->getParam('tipo', self::TYPE_INT);
        $tipo = $this->getParam('tipo', self::TYPE_INT);
        $tipo = $this->getParam('tipo', self::TYPE_INT);
        $tipo = $this->getParam('tipo', self::TYPE_INT);

        if (isset($id) || isset($tipo)) {
            $sql.=" WHERE";
            if (isset($id)) {
                $sql.=" ESTABLECIMIENTO_ID =" . $id;
            } elseif (isset($tipo)) {
                $sql.=" TIPO_ESTABLECIMIENTO_ID =" . $tipo;
            }
        }

        $db = Frapi_Database::getInstance("default");
        $stmt = $db->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $this->data[] = array('ESTABLECIMIENTO' =>
                    array(
                        'ESTABLECIMIENTO_ID' => $data['ESTABLECIMIENTO_ID'],
                        'NOMBRE' => $data['NOMBRE'],
                        'TELEFONO' => $data['TELEFONO'],
                        'AVATAR' => $data['AVATAR'],
                        'CONTACTO' => $data['CONTACTO'],
                        'EMAIL' => $data['EMAIL'],
                        'TIPO_ESTABLECIMIENTO_ID' => $data['TIPO_ESTABLECIMIENTO_ID'],
                        'ACTIVO' => $data['ACTIVO'],
                        'LEALTAD' => $data['LEALTAD'],
                        'KEYWORDS' => $data['KEYWORDS']
                    )
                );
            }
        } else {
            throw new Frapi_Error('SIN_RESULTADOS');
        }

        $db = null;

        return $this->toArray();
    }

    /**
     * Delete Request Handler
     * 
     * This method is called when a request is a DELETE
     * 
     * @return array
     */
    public function executeDelete() {
        $valid = $this->hasRequiredParameters($this->requiredParams);
        if ($valid instanceof Frapi_Error) {
            throw $valid;
        }

        return $this->toArray();
    }

    /**
     * Head Request Handler
     * 
     * This method is called when a request is a HEAD
     * 
     * @return array
     */
    public function executeHead() {
        $valid = $this->hasRequiredParameters($this->requiredParams);
        if ($valid instanceof Frapi_Error) {
            throw $valid;
        }

        return $this->toArray();
    }

}
