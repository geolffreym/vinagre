<?php
/**
 * @name Gestor de Datos para ORACLE
 * @author Edgar Aviles Mejia
 * @copyright SIAFM
 **/
 class GestorORACLEException extends Exception
{
	public function __construct($mensaje, $codigo = 0) {
		parent::__construct('GestorORACLE | ' . $mensaje, $codigo);
	}
}

class GestorORACLE
{
	private $_conexion = null;
    private $_stid;
    private $_config = array(
		'servidor' => 'localhost:1527/desaal',
		'usuario' => 'apw',
		'contrasena' => 'apw$1'
        
	);

	public function __construct()
	{
        $this->conectar();
	}

	public function __clone()
	{
		throw new GestorORACLEException('No puedes clonar esta instancia de clase.');
	}

	public function __wakeup()
	{
		throw new GestorORACLEException('No puedes deserializar esta instancia de clase.');
	}

	public function __sleep()
	{
		throw new GestorORACLEException('No puedes serializar esta instancia de clase.');
	}

	function __destruct()
	{
		if ($this->_conexion) oci_close($this->_conexion);
	}

	/**
	 * Librerias_GestorORACLE::pasarConfig()
	 *
	 * @param array $config
	 * @return void
	 */
	public function pasarConfig($config)
	{
		if (is_array($config)) {
			foreach($config as $llave => $valor) {
				$this->_config[$llave] = $valor;
			}
		}
	}

	/**
	 * Librerias_GestorORACLE::conectar()
	 *
	 * @version 2.0
	 * @param array $config
	 * @return mixed Retorna el enlace de conexion
	 */
	public function conectar($config = null)
	{
		if ($config) $this->pasarConfig($config);
		$this->_conexion = oci_connect($this->_config['usuario'], $this->_config['contrasena'], $this->_config['servidor']);
        if($this->_conexion){
            return $this->_conexion;
        }else{
            $err = oci_error();
            throw new GestorORACLEException('Se produjo un error al conectar: ', $err['message']);
        }
	}

	/**
	 * Librerias_GestorORACLE::desconectar()
	 * @version 1.3
	 *
	 * @return Retorna true si cierra la conexion o false si falla
	 */
	public function desconectar()
	{
		if ($this->_conexion) {
			return oci_close($this->_conexion);
		} else {
			throw new GestorORACLEException('No hay conexión abierta para desconectar.', 101);
		}
	}

    /**
     * Librerias_GestorORACLE::obtener()
     * @param $consultaSQL
     * @param array $variables_vinculadas
     * @return mixed
     * @throws GestorORACLEException
     */
    public function obtener($consultaSQL, $variables_vinculadas = array())
	{
		if ($this->_conexion) {
			$resultado = oci_parse($this->_conexion,$consultaSQL);
            if(!$resultado){
                $err = oci_error($this->_conexion);
                throw new GestorORACLEException('oci_parse genero el siguiente error: ' . $err['message']. ' para la query ' .$consultaSQL, 102);
            }

            if(!empty($variables_vinculadas) && is_array($variables_vinculadas)){
                foreach($variables_vinculadas as $clave => $valor){
                    oci_bind_by_name($resultado, $clave, $variables_vinculadas[$clave], -1);
                }
            }

            $ejecutar = oci_execute($resultado);
            if(!$ejecutar){
                $err = oci_error($resultado);
                oci_rollback($this->_conexion);
                throw new GestorORACLEException('La consulta "' .$consultaSQL . '" dió el siguiente error: ' . $err['message'], $err['code']);
            }

            $i=0;
            while ( ($fila = oci_fetch_assoc($resultado)) !=false ) {
                $final[$i] = $fila;
                $i++;
            }
            oci_free_statement($resultado);
            return $final;

		} else {
			throw new GestorORACLEException('No hay conexión abierta para obtener regitros.', 101);
		}
	}

    /**
     * Ejecutar una sentencia sql
     * Lucas 15:10 - Asi os digo que hay gozo
     * delante de los angeles de Dios por un
     * pecador que se arrepiente
     * @param $sql
     * @param array $variables_vinculadas
     * @param $ultimo_id
     * @return bool|string
     * @throws GestorORACLEException
     */
    public function ejecutar($sql,$variables_vinculadas = array(), $ultimo_id = null){
        if($this->_conexion){
            try{
                $stid = oci_parse($this->_conexion,$sql);
                if(!$stid){
                    $err = oci_error($this->_conexion);
                    throw new GestorORACLEException('oci_parse genero el siguiente error: ' . $err['message']. ' para la query ' .$sql, 102);
                }


                if(!empty($variables_vinculadas) && is_array($variables_vinculadas)){

                    /**
                     * arreglo multidimentcional, p.e
                     * $a[0] = array(1,2,3)
                     * $a[1] = array(1,2,3)
                     */
                    if(count($variables_vinculadas) != count($variables_vinculadas, COUNT_RECURSIVE)){
                        foreach($variables_vinculadas as $indice => $vinculadas){
                            foreach($vinculadas as $clave => $valor){
                                oci_bind_by_name($stid, $clave, $variables_vinculadas[$indice][$clave], -1);
                            }

                            // para retornar el id de la fila
                            if(!empty($ultimo_id)){
                                oci_bind_by_name($stid, $ultimo_id, $id_fila, 20, SQLT_INT);
                            }

                            $ejecutar = oci_execute($stid );
                            if(!$ejecutar){
                                $err = oci_error($stid);
                                oci_rollback($this->_conexion);
                                throw new GestorORACLEException('La consulta "' .$sql . '" dió el siguiente error: ' . $err['message'], $err['code']);
                            }
                        }
                    } else { // arreglo de 1 dimension
                        foreach($variables_vinculadas as $clave => $valor){
                            oci_bind_by_name($stid, $clave, $variables_vinculadas[$clave], -1);
                        }

                        // para retornar el id de la fila
                        if(!empty($ultimo_id)){
                            oci_bind_by_name($stid, $ultimo_id, $id_fila, 20, SQLT_INT);
                        }

                        $ejecutar = oci_execute($stid);
                        if(!$ejecutar){
                            $err = oci_error($stid);
                            oci_rollback($this->_conexion);
                            throw new GestorORACLEException('La consulta "' .$sql . '" dió el siguiente error: ' . $err['message'], $err['code']);
                        }
                    }
                } else {
                    // para retornar el id de la fila
                    if(!empty($ultimo_id)){
                        oci_bind_by_name($stid, $ultimo_id, $id_fila, 20, SQLT_INT);
                    }

                    $ejecutar = oci_execute($stid);
                    if(!$ejecutar){
                        $err = oci_error($stid);
                        oci_rollback($this->_conexion);
                        throw new GestorORACLEException('La consulta "' .$sql . '" dió el siguiente error: ' . $err['message'], $err['code']);
                    }
                }


                $comit = oci_commit($this->_conexion);
                oci_free_statement($stid);
                if(!$comit){
                    $err = oci_error($this->_conexion);
                    throw new GestorORACLEException("Hubo un error: " .$err['message']);
                }

                if(!empty($id_fila))
                    return $id_fila;

                return $comit;

            } catch (Exception $e){
                throw new GestorORACLEException('La consulta dio el siguiente error: ' . $e->getMessage());
            }

            $this->desconectar();

            return '1';
        }
    }

    public function ejecutarProcedimiento($procedimiento, $valores){
        if($this->_conexion){
            foreach($valores as $valor){
                $sentencia = "agregar_remision(p_ru_cod => :p_ru_cod,
                   p_rme_cod => :p_rme_cod,
                   p_fecha => :p_fecha,
                   p_cdi_cod => :p_cdi_cod,
                   p_no_cliente => :p_no_cliente,
                   p_estado => :p_estado,
                   p_no_cia => :p_no_cia);";
            }
        }
    }

}

?>