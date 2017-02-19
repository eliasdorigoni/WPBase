<?php
if (!defined('ABSPATH')) exit;

if (!function_exists('fechaTextual')) {
    /**
     * Calcula la diferencia entre dos timestamps y retorna un array con las
     * unidades temporales más altas, en orden descendente (año, mes, semana, dia. etc).
     * Sirve para calcular las fechas de "hace x minutos" o "en x semanas".
     * Maneja automáticamente los singulares y plurales.
     * 
     * @param  integer $timestamp Tiempo a comparar, en el pasado o futuro
     * @param  integer $unidades  Unidades temporales a mostrar. 
     *                            Ej: 1 puede devolver "hora", 2 puede devolver
     *                            "semanas" y "dias".
     * @param  integer $comparar  Fecha a comparar. Por defecto, time().
     * @return array              Array de 2 o más valores.
     *                            El primero es un booleano que indica si el tiempo está
     *                            en el futuro. El resto son las unidades temporales.
     */
    function fechaTextual($timestamp = 0, $unidades = 2, $comparar = 0) {
        if (!is_numeric($timestamp)) return array();
        if (!$comparar) $comparar = time();
        $diferencia = $comparar - $timestamp;
        $fechaEsFutura = ($diferencia < 0) ? true : false;

        $valores = array(
            'año'     => 0,
            'mes'     => 0,
            'semana'  => 0,
            'dia'     => 0,
            'hora'    => 0,
            'minuto'  => 0,
            'segundo' => 0,
            );

        $constantes = array(
            'año'     => YEAR_IN_SECONDS,
            'mes'     => MONTH_IN_SECONDS,
            'semana'  => WEEK_IN_SECONDS,
            'dia'     => DAY_IN_SECONDS,
            'hora'    => HOUR_IN_SECONDS,
            'minuto'  => MINUTE_IN_SECONDS,
            'segundo' => 1
            );

        foreach ($constantes as $k => $constante) {
            if ($diferencia > $constante) {
                $valores[$k] = floor($diferencia / $constante);
                $diferencia = $diferencia % $constante;
            }
        }

        $retorno = array($fechaEsFutura);

        $plural = array(
            'año'     => 'años',
            'mes'     => 'meses',
            'semana'  => 'semanas',
            'dia'     => 'dias',
            'hora'    => 'horas',
            'minuto'  => 'minutos',
            'segundo' => 'segundos'
            );

        while ($unidades > 0) {
            foreach ($valores as $k => $v) {
                if ($v != 0) {
                    $retorno[] = $v . ' ' . plural($v, $k, $plural[$k]);
                    unset($valores[$k]);
                    break;
                }
                unset($valores[$k]);
            }
            $unidades--;
        }

        return $retorno;
    }
}

if (!function_exists('eliminarDuplicadosDeArray')) {
    /**
     * Elimina los valores de $array1 que estén en $array2 y reordena las
     * claves. Retorna $array1 sin las claves que coincidan en $array2.
     * @param  array  $array1 Array a retornar.
     * @param  array  $array2 Array de referencia para buscar los duplicados.
     * @return array          Retorna $array1 sin los valores de $array2
     */
    function eliminarDuplicadosDeArray($array1 = array(), $array2 = array()) {
        if (is_array($array1) && is_array($array2)) {
            foreach ($array2 as $valor) {
                $clave = array_search($valor, $array1);
                if($clave !== false) {
                    unset($array1[$clave]);
                }
            }
            array_values($array1);
        }
        return $array1;
    }
}
