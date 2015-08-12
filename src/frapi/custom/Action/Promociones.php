<?php

/**
 * Action Promociones 
 * 
 * Array
 * 
 * @link http://getfrapi.com
 * @author Frapi <frapi@getfrapi.com>
 * @link /promociones
 */
class Action_Promociones extends Frapi_Action implements Frapi_Action_Interface {

    /**
     * Required parameters
     * 
     * @var An array of required parameters.
     */
    protected $requiredParams = array('establecimiento_id');

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

        
        $id = $this->getParam('establecimiento_id', self::TYPE_INT);
        
        if(isset($id)){
        $sql = "SELECT P.PROMOCION_ID, P.DESCRIPCION, VALOR AS AHORRO, AVG(R.PUNTEO) AS RATING, 
                (SELECT COUNT(*) FROM REVIEW WHERE COMENTARIO<>'' AND PROMOCION_ACTIVIDAD_ID=P.PROMOCION_ID AND TIPO=1) AS NO_COMENTARIOS
                FROM PROMOCION P
                LEFT JOIN REVIEW R ON R.PROMOCION_ACTIVIDAD_ID=P.PROMOCION_ID AND R.TIPO=1
                WHERE P.FECHA_INICIO<=NOW() AND P.FECHA_FIN>=NOW() AND P.ESTABLECIMIENTO_ID=" . $id;

        $sql.=" GROUP BY P.PROMOCION_ID";

        $db = Frapi_Database::getInstance("default");
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $arreglo=array();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $arreglo[]=array(
                        'PROMOCION_ID' => (int)$data['PROMOCION_ID'],
                        'DESCRIPCION' => $data['DESCRIPCION'],
                        'AHORRO' => round((float)$data['AHORRO'],2),
                        'RATING' => round((float)$data['RATING'],1),
                        'NO_COMENTARIOS' => (int)$data['NO_COMENTARIOS']
                    );
            }
            $this->data[] = array('PROMOCIONES' => $arreglo);
        } else {
            throw new Frapi_Error('SIN_RESULTADOS');
        }
        $db = null;
        }else{
            throw new Frapi_Error('FALTAN_PARAMETROS');
        }


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
        return $this->toArray();
    }

}
