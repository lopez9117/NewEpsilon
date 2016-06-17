<?php
//funcion con las reglas para validar los valores a pagar por cada sede
function validatepayment($registry, $lectura, $typereturn, $cn)
{
    $conminimo = mysql_query("SELECT valor_numero FROM variables_entorno WHERE id_variable='4'", $cn);
    $regminimo = mysql_fetch_array($conminimo);
    $minimo = $regminimo['valor_numero'];
    $idsede = $registry['erp'];
    $issval = $registry['val_iss'];
    $idservicio = $registry['idservicio'];
    $eps = $registry['ideps'];
    $idtecnica = $registry['id_tecnica'];
    $idestudio = $registry['idestudio'];
    $idestudiou = $registry['idestudio'];
    $uvr = $registry['uvr'];
    $idtipopaaciente = $registry['idtipo_paciente'];
    $codigo = $registry['cod_iss'];
    $valiss = validateuvr($issval, $uvr);
    $valiss = validatehonorarium($valiss, $idestudio, $cn);
    $pesopaciente = $registry['peso_paciente'];
    $idinforme = $registry['id_informe'];
    $cups = $registry['cups_iss'];
    $portatil = $registry['portatil'];
    $valsoat = $registry['val_soat'];
    $valsoat = convertsoat($minimo, $valsoat);
    $codsoat = $registry['cod_soat'];
    $biopsiadrenaje = $registry['typebiopsiadrenaje'];
//    if (strlen($codigo) >= 8) {
//        $codigo = validatecodigoiss($codigo, '1');
//        $codetocalculate = mysql_query("SELECT * FROM r_estudio where cod_iss='$codigo' LIMIT 1", $cn);
//        $newregistry = mysql_fetch_array($codetocalculate);
//        $issval = $newregistry['val_iss'];
//        $uvr = $newregistry['uvr'];
//        $idestudio = $newregistry['idestudio'];
//        $valiss = validateuvr($issval, $uvr);
//        $valiss = validatehonorarium($valiss, $idestudio, $cn);
//    }
    if ($idsede == 1) {
        $val = validateclinicadelnorte($eps, $valsoat, $valiss, $idtecnica, $idservicio, $idtipopaaciente, $idestudio, $cups, $idsede, $codigo, $lectura, $typereturn, $cn);
//        $val = 0;
    } elseif ($idsede == 3) {
        $val = validateleonxiii($valiss, $idtecnica, $idestudio, $idtipopaaciente, $eps, $idservicio, $pesopaciente, $codigo, $lectura, $idinforme, $idsede, $portatil, $biopsiadrenaje, $typereturn, $cn);
    } elseif ($idsede == 5 || $idsede == 35) {
        $val = validatehospitalmarcofidelsuarez($valiss, $idtecnica, $idestudio, $idestudiou, $pesopaciente, $idservicio, $codigo, $idsede, $idinforme, $cups, $lectura, $portatil, $typereturn, $cn);
    } elseif ($idsede == 9) {
        $val = validateipsuniversitariasedeambulatoria($valiss, $idtecnica, $idestudio, $pesopaciente, $codigo, $lectura, $idservicio, $portatil, $idinforme, $typereturn, $cn);
    } elseif ($idsede == 10) {
        $val = validatemetrosaludmanrique($valiss, $idtecnica, $idestudio, $pesopaciente, $codigo, $lectura, $idservicio, $portatil, $idinforme, $typereturn, $cn);
    } elseif ($idsede == 14) {
//        $val = validatecoomevaintegrados($valiss, $idservicio, $portatil, $idinforme, $cn);
        $val = 0;
    } elseif ($idsede == 32) {
        $val = validateclinicaconquistadores($valiss, $idtecnica, $idestudio, $lectura, $idservicio, $idsede, $cups, $idinforme, $portatil, $typereturn, $cn);
    } elseif ($idsede == 37) {
        $val = validatesaviasalud($valiss, $idservicio, $idestudio, $idtecnica, $idinforme, $portatil, $typereturn, $cn);
    } elseif ($idsede == 38) {
        $val = validatecoomeva($valiss, $idservicio, $idestudio, $idtecnica, $idinforme, $portatil, $typereturn, $cn);
    } elseif ($idsede == 18 || $idsede == 24 || $idsede == 42 || $idsede == 21 || $idsede == 19 || $idsede == 23 || $idsede == 22 || $idsede == 20) {
        $val = validatebarranquilla($valiss, $idservicio, $idinforme, $idestudio, $portatil, $typereturn, $cn);

    } elseif ($idsede == 31) {
        $val = validateapartado($valsoat, $idservicio, $portatil, $idinforme, $typereturn, $lectura, $cn);
    } elseif ($idsede == 43) {
        $val = $valiss;
    } elseif ($idsede == 47) {
        $val = validateparticular($valsoat, $typereturn);
    } elseif ($idsede == 49) {
        $val = validatefundacionmedicopreventivamagisterio($idservicio, $valiss, $idinforme, $portatil, $idtecnica, $idestudio, $typereturn, $cn);
    } elseif ($idsede == 17 || $idsede == 33) {
        $val = validatesanandres($valsoat, $idservicio, $portatil, $idinforme, $typereturn, $lectura, $cn);
    } elseif ($idsede == 57) {
        $val = validatesanrafalitagui($valiss, $idtipopaaciente, $portatil, $idservicio, $typereturn, $idinforme, $cn);

    } else {
        $val = 0;
    }
    return $val;
}

function validateclinicadelnorte($ideps, $valsoat, $valiss, $idtecnica, $idservicio, $idtipopaciente, $idestudio, $cups, $idsede, $cod_iss, $lectura, $typereturn, $cn)
{
    /*  DIFERENTES %, DE ACUERDO AL SERVICIO:
      TOMOGRAFIA 75% SOBRE LAS VENTAS,
      RESONANCIA 88% SOBRE LAS VENTAS,
      CPRES 100% SOBRE LAS VENTAS,
      ENDOSCOPIAS Y COLONOSCOPIAS 90% SOBRE LAS VENTAS,
      ESTUDIOS ESPECIALES 75% SOBRE LAS VENTAS,
      BIOPSIAS 90% SOBRE LAS VENTAS,
      ECOGRAFIAS 75% SOBRE LAS VENTAS,
      PLETISMOSGRAFIAS 95% SOBRE LAS VENTAS
      Y RAYOS X 75% SOBRE LAS VENTAS. */
    $val = 0;
    $valreturn = 0;
    if ($ideps == 53)//Ecoopsos
        //ok , quedam pemdienmtes insumos resonancia
    {
        $val = $valiss * 1.6;
        if ($idservicio == 10) {
            if ($idtecnica == 3) {
                //57220 Gadolinio 939 no tiene codigo en manual iss

//                $val = $val + 57220 + (527625 * 1.6);//527625 Corresponde al codigo 313322
                $val = $val;
            }
        } elseif ($idservicio == 2) {
            if ($idtecnica == 3 || $idtecnica == 6) {
                if ($idestudio == 22 || $idestudio == 91) {
//                    $val = $val + (29930 * 1.6);
                    $val = $val;
                }

//                $cantidadoptirray = validateoptirraytomografiasclinicanorte($idestudio, $cn);
//                $valoptirray = $cantidadoptirray * 2218;

//                $valconrray = 0;
//                if ($cups == 879420 || $cups == 879410) {
//                    $valconrray = 51865;
//                }
//                $valjeringa = 89275;
//                $valconector = 13329;

                $val = $val; //+ $valoptirray + $valconector + $valconrray + $valjeringa;
            }
        } elseif ($idservicio == 8) {
            $val = $val;
        } elseif ($idservicio == 4) {
            $valfluoro = 0;
            $regfluoroscopia = mysql_query("select * from r_estudio where cod_iss in (212330,212331,212332,212333,212334,212335,212336)", $cn);
            while ($resultado = mysql_fetch_array($regfluoroscopia)) {
                if ($idestudio == $resultado['idestudio']) {
                    $valfluoro = (45135 * 1.6);
                }
            }
            if ($cod_iss == 212330) {
                $val = $val;// + 51865;//valor del conrray
            } elseif ($cod_iss == 212331 || $cod_iss == 212332 || $cod_iss == 212333 || $cod_iss = 212334) {
                $val = $val; //+ 36306;//sulfato de bario
            } elseif ($cod_iss == 212335 || $cod_iss == 212336) {
                $val = $val;// + 23800;//bolsa travad para prepraraciones
                $val = $val;// + 36306;//sulfato de vario
            } elseif ($cod_iss == 212468 || $cod_iss == 212304) {
                $val = $val;// + (2218 * 50);//valor optirray
            } elseif ($cod_iss == 212453 || $cod_iss == 212454 || $cod_iss == 212303 || $cod_iss == 212321) {
                $val = $val;//; + 51865;//CONARRAY
            }
            $val = $val;// + $valfluoro;
        }
    } elseif ($ideps == 27)//Coosalud
        //coopsalud ok, pendiente validar valor de resonancia contrastada ya que sale con el valor de las simples´{
    {
        if ($idtipopaciente == 1 || $idtipopaciente == 3) {
            $val = $valiss * 1.52;
            if ($idservicio == 10) {
                if ($idtecnica == 3) {
                    $val = $valiss; //+ 57220 + 193000;
                } else {
                    $val = $valiss * 1.15;
                }
            } elseif ($idservicio == 2) {
                if ($idtecnica == 3 || $idtecnica == 6) {
                    $val = $val; //+ 57220 + 193000;
                }
            }

        } elseif ($idtipopaciente == 2) {
            if ($idservicio == 2) {
                $val = $valiss * 1.15;
                if ($idtecnica == 3 || $idtecnica == 6) {
                    $val = $val;// + 57220 + 193000;
                }
            } elseif ($idservicio == 10) {
                if ($idtecnica == 3) {
                    $val = $valiss;
                } else {
                    $val = $valiss * 1.15;// + 57220 + 193000;
                }
            } else {
                $val = $valiss * 1.25;
            }
        }
    } elseif ($ideps == 103)//Fundacion Medico Preventiva
    {
//        if ($idtipopaciente == 1 || $idtipopaciente == 3) {
//            $val = $valiss * 1.48;
//            if ($idservicio == 10) {
//                if ($idtecnica == 3) {
//                    $val = $val; //+ 57220 + 211050;
//                }
//            } elseif ($idservicio = 2) {
//                if ($idtecnica == 3 || $idtecnica == 6) {
//                    $val = $val; //+ 57220 + 211050;
//                }
//            }
//
//        } elseif ($idtipopaciente == 2) {
//            $val = $valiss * 1.15;
//            if ($idservicio == 2) {
//                if ($idtecnica == 3 || $idtecnica == 6) {
//                    $val = $val;//57220 + 211050;
//                }
//            } elseif ($idservicio == 10) {
//                if ($idtecnica = 3) {
//                    $val = $val;// 57220 + 211050;
//                }
//            }
//        }

        $val = $valsoat;

    } elseif ($ideps == 22)//Nueva Eps
    {
//        $val = $valiss * 1.497;
        $val = $valiss + 1.542;
    } elseif ($ideps == 7)//Coomeva || $ideps == 964 no entra dentro de esta contrataacion
    {
        $val = $valiss * 1.53;
    } elseif ($ideps == 276) {
        if ($idtipopaciente == 1 || $idtipopaciente == 3) {
            $val = $valiss * 1.60;
        } elseif ($idtipopaciente == 2) {
            $val = $valiss * 1.15;
        }
    } elseif ($ideps == 2 || $ideps == 190)//Salud Total
    {
        $val = $valsoat;
    } elseif ($ideps == 217 || $ideps == 216) // Savia Salud y alianza medellin antioquia
    {
        $val = $valiss * 1.48;

        if ($idservicio == 10) {
            if ($idtecnica == 3) {
                $val = $val; //+ 57220 + (527625 * 1.48);//527625 Corresponde al codigo 313322
            }
        } elseif ($idservicio == 2) {
            if ($idtecnica == 3 || $idtecnica == 6) {
                if ($idestudio == 22 || $idestudio == 91) {
                    $val = $val;// + (29930 * 1.48);
                }

//                $cantidadoptirray = validateoptirraytomografiasclinicanorte($idestudio, $cn);
//                $valoptirray = $cantidadoptirray * 2178;

//                $valconrray = 0;
//                if ($cups == 879420 || $cups == 879410) {
//                    $valconrray = 51865;
//                }
//                $valjeringa = 91930;
//                $valconector = 13588;

                $val = $val;//+ $valoptirray + $valconector + $valconrray + $valjeringa;
            }
        } elseif ($idservicio == 8) {
            $val = $val;
        } elseif ($idservicio == 4) {
//            $valfluoro = 0;
//            $regfluoroscopia = mysql_query("select * from r_estudio where cod_iss in (212330,212331,212332,212333,212334,212335,212336)", $cn);
//            while ($resultado = mysql_fetch_array($regfluoroscopia)) {
//                if ($idestudio == $resultado['idestudio']) {
//                    $valfluoro = (45135 * 1.48);
//                }
//            }
            if ($cod_iss == 212330) {
                $val = $val; //+ 51865;//valor del conrray

            } elseif ($cod_iss == 212331 || $cod_iss == 212332 || $cod_iss == 212333 || $cod_iss = 212334) {
                $val = $val;// + 36306;//sulfato de bario
            } elseif ($cod_iss == 212335 || $cod_iss == 212336) {
                $val = $val;// + 32239;//bolsa travad para prepraraciones
                $val = $val;// + 36306;//sulfato de vario
            } elseif ($cod_iss == 212468 || $cod_iss == 212304) {
                $val = $val;// + (2178 * 50);//valor optirray
            } elseif ($cod_iss == 212453 || $cod_iss == 212454 || $cod_iss == 212303 || $cod_iss == 212321) {
                $val = $val + 51865;//CONARRAY
            }
            $val = $val; //+ $valfluoro;
        }

    } elseif ($ideps == 28)//Caprecom
    {
//        $val = $valsoat * 0.8;
        $val = $valsoat;
    } elseif ($ideps == 40 || $ideps == 225 || $ideps == 39)//Sura || $ideps == 152
    {
        $val = $valiss * 1.5;

        if ($idservicio == 10) {
            if ($idtecnica == 3) {
                $val = $val;// + 57220 + (527625 * 1.5);//527625 Corresponde al codigo 313322
            }
        } elseif ($idservicio == 2) {
            if ($idtecnica == 3 || $idtecnica == 6) {
                if ($idestudio == 22 || $idestudio == 91) {
                    $val = $val; //+ (29930 * 1.5);
                }

//                $cantidadoptirray = validateoptirraytomografiasclinicanorte($idestudio, $cn);
//                $valoptirray = $cantidadoptirray * 2178;
//
//                $valconrray = 0;
//                if ($cups == 879420 || $cups == 879410) {
//                    $valconrray = 51865;
//                }
//                $valjeringa = 91930;
//                $valconector = 13588;

                $val = $val;// + $valoptirray + $valconector + $valconrray + $valjeringa;
            }
        } elseif ($idservicio == 8) {
            $val = $val;
        } elseif ($idservicio == 4) {
//            $valfluoro = 0;
//            $regfluoroscopia = mysql_query("select * from r_estudio where cod_iss in (212330,212331,212332,212333,212334,212335,212336)", $cn);
//            while ($resultado = mysql_fetch_array($regfluoroscopia)) {
//                if ($idestudio == $resultado['idestudio']) {
//                    $valfluoro = (45135 * 1.5);
//                }
//            }
            if ($cod_iss == 212330) {
                $val = $val;// + 51865;//valor del conrray

            } elseif ($cod_iss == 212331 || $cod_iss == 212332 || $cod_iss == 212333 || $cod_iss = 212334) {
                $val = $val;// + 36306;//sulfato de bario
            } elseif ($cod_iss == 212335 || $cod_iss == 212336) {
                $val = $val;// + 32239;//bolsa travad para prepraraciones
                $val = $val;// + 36306;//sulfato de vario
            } elseif ($cod_iss == 212468 || $cod_iss == 212304) {
                $val = $val;// + (2178 * 50);//valor optirray
            } elseif ($cod_iss == 212453 || $cod_iss == 212454 || $cod_iss == 212303 || $cod_iss == 212321) {
                $val = $val;// + 51865;//CONARRAY
            }
            $val = $val;// + $valfluoro;
        }
    } elseif ($ideps == 49)//seguros generales suramericana soat
    {
        $val = $valsoat;
    } elseif ($ideps == 33)//Universidad de Antioquia
    {
        $val = $valiss * 1.555;
        if ($idservicio == 10) {
            if ($idtecnica == 3) {
                $val = $val;// + 57220 + (527625 * 1.5);//527625 Corresponde al codigo 313322
            }
        } elseif ($idservicio == 2) {
            if ($idtecnica == 3 || $idtecnica == 6) {
                if ($idestudio == 22 || $idestudio == 91) {
                    $val = $val;// + (29930 * 1.5);
                }
//                $cantidadoptirray = validateoptirraytomografiasclinicanorte($idestudio, $cn);
//                $valoptirray = $cantidadoptirray * 2178;
//
//                $valconrray = 0;
//                if ($cups == 879420 || $cups == 879410) {
//                    $valconrray = 51865;
//                }
//                $valjeringa = 91930;
//                $valconector = 13588;

                $val = $val;// + $valoptirray + $valconector + $valconrray + $valjeringa;
            }
        } elseif ($idservicio == 8) {
            $val = $val;
        } elseif ($idservicio == 4) {
//            $valfluoro = 0;
//            $regfluoroscopia = mysql_query("select * from r_estudio where cod_iss in (212330,212331,212332,212333,212334,212335,212336)", $cn);
//            while ($resultado = mysql_fetch_array($regfluoroscopia)) {
//                if ($idestudio == $resultado['idestudio']) {
//                    $valfluoro = (45135 * 1.48);
//                }
//            }
            if ($cod_iss == 212330) {
                $val = $val;// + 51865;//valor del conrray

            } elseif ($cod_iss == 212331 || $cod_iss == 212332 || $cod_iss == 212333 || $cod_iss = 212334) {
                $val = $val;// + 36306;//sulfato de bario
            } elseif ($cod_iss == 212335 || $cod_iss == 212336) {
                $val = $val;// + 32239;//bolsa travad para prepraraciones
                $val = $val;// + 36306;//sulfato de vario
            } elseif ($cod_iss == 212468 || $cod_iss == 212304) {
                $val = $val;// + (2178 * 50);//valor optirray
            } elseif ($cod_iss == 212453 || $cod_iss == 212454 || $cod_iss == 212303 || $cod_iss == 212321) {
                $val = $val;// + 51865;//CONARRAY
            }
            $val = $val;// + $valfluoro;
        }
    } elseif ($ideps == 66)//Empresas Publicas de Medellin
    {
        $val = $valsoat * 0.8;
    } elseif ($ideps == 43 || $ideps == 188)//Qbe Seguros
    {
        $val = $valsoat;
    } elseif ($ideps == 215)//Seguros Bolivar
    {
        $val = $valsoat;
    } elseif ($ideps == 80)//Previsora Compañia de Seguros
    {
        $val = $valsoat;
    } elseif ($ideps == 58)//Seguro de Vida del estado
    {
        $val = $valsoat;
    } elseif ($ideps == 274)//seguros de vida del estado estudiantil
    {
        $val = $valsoat * 0.9;
    } elseif ($ideps == 227)//Axa Colpatria seguros
    {
        $val = $valsoat;
    } elseif ($ideps == 275)//axa colpatria arl
    {
        if ($idtipopaciente == 1 || $idtipopaciente == 3) {
            $val = $valiss * 1.5;
        } elseif ($idtipopaciente == 2) {
            $val = $valiss * 1.15;
        }
    } elseif
    ($ideps == 86
    )//Colmena
    {
        $val = $valsoat;
    } elseif ($ideps == 208)//Compañia Mundial de Seguros
    {
//        $val = $valsoat * 0.8;
        $val = $valsoat;
    } elseif ($ideps == 46)//Positiva de Seguros
    {
        $val = $valsoat * 0.9;
    } elseif ($ideps == 26) {
        $val = $valsoat;

    } elseif ($ideps == 84) {
        $val = $valsoat;
    } elseif ($ideps == 12) {
        if ($idtipopaciente == 1 || $idtipopaciente == 3) {
            $val = $valiss * 1.4883;
        } elseif ($idtipopaciente == 2) {
            $val = $valiss * 1.13;
        }
    } elseif ($ideps == 278)//libertyseguros arp
    {
        $val = $valiss * 1.682;
    } elseif ($ideps == 78) {
        $val = $valsoat;
    } elseif ($ideps == 24) //direccion seccional de salud de antioquia
    {
        $val = $valsoat;
    } elseif ($ideps == 279)//cardif colombiana
    {
        $val = $valsoat;
    } elseif ($ideps == 30) {
        $val = $valsoat * 0.75;
    } elseif ($ideps == 140) {
        $val = $valsoat;
    } else {
        $val = $valsoat;
    }

    $val = validatelectura($val, $lectura, $idservicio);

    if ($idservicio == 1 || $idservicio == 3 || $idservicio == 51 || $idservicio == 2 || $idservicio == 4) {
        $valreturn = $val * 0.75;
    } elseif ($idservicio == 10) {
        $valreturn = $val * 0.85;
    } elseif ($idservicio == 9 || $idservicio == 8 || $idservicio == 7) {
        $valreturn = $val * 0.90;
    }

    return $valreturn;

    //PARA LOS PACIENTES DECOOMEVA Q SE REALICEN RNM SE PAGARA A LA CLINICA EL 8%
}

function validateleonxiii($valiss, $idtecnica, $idestudio, $idpaciente, $eps, $idservicio, $pesop, $cod_iss, $lectura, $idinforme, $idsede, $portatil, $biopsiadrenaje, $typereturn, $cn)
{
    // ISS+19,34% TODOS LOS SERVICIOS(HEMODINAMIA,RX,ECOGRAFIAS, TAC, EE,BX)
    /*BIOPSIAS RENALES ESTAN POR PAQUETE $686,800
     --> PACIENTES DE ALIAZZA ISS2000+10%,
     -->RNM PACIENTES DE SAVIA Y SURA ISS2000+10%,
     --> TODOS LOS PACIENTES AMBULATORIOS ISS2000+10%*/
    $valespacios = 0;
    $valcompro = 0;
    $valproyeccion = 0;
    $valportatil = 0;
    $valreconstruccion = 0;
    $salaymateriales = validatesalaymateriales($idestudio, $cn);
    if ($idservicio == 2) {
        $valespacios = validateespaciosadicionales($idinforme, $cn);
        $valreconstruccion = valreconstruccion('1', $cn);
        $isangio = validateangioresonacia($idestudio, $cn);
    }
    if ($idservicio == 1) {
        $concomparativas = validatecompartivas($idinforme, $cn);
        $conproyecion = validateproyeccion($idinforme, $cn);
        $valcompro = $concomparativas;
        $valproyeccion = $conproyecion * 8040;
        if ($portatil == 1) {
            $valportatil = 14865;
        }
    }
    if ($idservicio == 3 || $idservicio == 51) {
        if ($portatil == 1) {
            $valportatil = 14865;
        }
    }
    if ($idservicio == 7 && ($idestudio == 260 || $idestudio == 1017 || $cod_iss == 'A00228')) {
        $val = 686800;
        return $val;
    } else {
        if ($biopsiadrenaje == 'B') {
            //biopsias 213469
            $val = 36715;
        } elseif ($biopsiadrenaje == 'D') {
            //drenajes 213465
            $val = 85340;
        } else {
            $val = $valiss;
        }

        if ($idpaciente == 2) {
            $val = $val * 0.9;
            $valespacios = $valespacios * 0.9;
            $valcompro = $valcompro * 0.9;
            $valproyeccion = $valproyeccion * 0.9;
            $valportatil = $valportatil * 0.9;
            $valreconstruccion = $valreconstruccion * 0.9;
            $salaymateriales = $salaymateriales * 0.9;
        } elseif ($eps == 216) {
            $val = $val * 1.1;
            $valespacios = $valespacios * 1.1;
            $valproyeccion = $valproyeccion * 1.1;
            $valcompro = $valcompro * 1.1;
            $valportatil = $valportatil * 1.1;
            $valreconstruccion = $valreconstruccion * 1.1;
            $salaymateriales = $salaymateriales * 1.1;
        } else if ($idservicio == 10) {
            if ($eps == 217 || $eps == 1 || $eps == 39 || $eps == 40 || $eps == 49 || $eps == 75 || $eps == 76 || $eps == 152 || $eps == 225) {
                $val = $val * 1.07;
                $salaymateriales = $salaymateriales * 1.07;
            } elseif ($eps == 22) {
                $val = $val * 1.1;
                $salaymateriales = $salaymateriales * 1.1;
            }
        } else {
            $val = $val * 1.1934;
            $valespacios = $valespacios * 1.1934;
            $valproyeccion = $valproyeccion * 1.1934;
            $valcompro = $valcompro * 1.1934;
            $valportatil = $valportatil * 1.1934;
            $valreconstruccion = $valreconstruccion * 1.1934;
            $salaymateriales = $salaymateriales * 1.1934;
        }
        if ($idtecnica == 3 || $idtecnica == 6) {
            if ($idservicio == 10) {
//                $val = validatecontrastedvaluesleonx($pesop, $idservicio, $idestudio, $cn);
                if ($idpaciente == 2) {
                    $val = 474862;
                } elseif ($eps == 217 || $eps == 1 || $eps == 39 || $eps == 40 || $eps == 49 || $eps == 75 || $eps == 76 || $eps == 152 || $eps == 225 || $eps == 22) {
                    $val = 580388;
                } else {
                    $val = 629668;
                }
            }
        }
    }
    $val = $val + $salaymateriales;//+ $valespacios + $valcompro + $valportatil + $salaymateriales;
//    if ($isangio) {
//        $val = $val + $valreconstruccion;
//    }
    $val = validatelectura($val, $lectura, $idservicio);
    return validatetypereturn($typereturn, $val, $valportatil, $valcompro, $valproyeccion, $valespacios, $valreconstruccion);
}

function validatehospitalmarcofidelsuarez($valiss, $idtecnica, $idestudio, $idestudiou, $pesop, $idservicio, $cod_iss, $idsede, $idinforme, $cups, $lectura, $portatil, $typereturn, $cn)
{
    // ISS+37%
    $val = 0;
    $valespacios = 0;
    $valportatil = 0;
    $valcompro = 0;
    $valproyeccion = 0;
    $valreconstruccion = 0;
    if ($idservicio == 2) {
        $valespacios = validateespaciosadicionales($idinforme, $cn);
        $valreconstruccion = valreconstruccion('1', $cn);
        $isangio = validateangioresonacia($idestudio, $cn);
    }
    if ($idservicio == 1) {
        $concompro = validatecompartivas($idinforme, $cn);
        $conproyecion = validateproyeccion($idinforme, $cn);
        $valcompro = $concompro;
        $valproyeccion = $conproyecion * 8040;
        if ($portatil == 1) {
            $valportatil = 14865;
        }
    }
    if ($idservicio == 3 || $idservicio == 51) {
        if ($portatil == 1) {
            $valportatil = 8660;
        }
    }
    $valespacios = $valespacios * 1.37;
    $valportatil = $valportatil * 1.37;
    $valcompro = $valcompro * 1.37;
    $valproyeccion = $valproyeccion * 1.37;
    $valreconstruccion = $valreconstruccion * 1.37;
    $salaymateriales = validatesalaymateriales($idestudio, $cn) * 1.37;
    if ($idestudiou == 183 || $idestudiou == 465 || $idestudiou == 1112) {
        $val = 356933;
        return $val;
    } elseif ($idtecnica == 3 || $idtecnica == 6) {
        if ($idservicio == 10) {
//            $val = validatecontrastedvaluemarcofidelandconquistadores($idsede, $idservicio, $idestudio, $cups, $idinforme, $cn);
            $val = 629688;
        } else {
            $reconstruccion = 0;
            $val = $valiss * 1.37;
            if ($idtecnica == 6) {
                $reconstruccion = valreconstruccion('1', $cn) * 1.37;
            }
            if ($idservicio = 2) {
                $conangios = mysql_query("SELECT idestudio FROM r_estudio WHERE nom_estudio LIKE '%angiotomografia%' AND idestado=1 AND idservicio=2;", $cn);
                while ($arrayangios = mysql_fetch_array($conangios)) {
                    if ($idestudiou == $arrayangios['idestudio']) {
                        $reconstruccion = valreconstruccion('1', $cn) * 1.37;
                    }
                }

            }
            //$valcontraste = validatecontrastedvaluemarcofidelandconquistadores($idsede, $idservicio, $idestudio, $cups, $idinforme, $cn);
            $val = $val; //+ $reconstruccion + $valespacios; //$valcontraste +
        }
        return $val;
    } elseif ($idservicio == 7) {
        $val = $valiss * 1.37;
        $val = $val + validatebiopsiasinsumos($idinforme, $idsede, $cn);
        return $val;
    } else {
        if ($idestudio == 1089) {
            $val = 51755;
        } else {
            $val = $valiss * 1.37;
        }
        $val = validatelectura($val, $lectura, $idservicio);
        $val = $val + $salaymateriales;
//        if ($isangio) {
//            $val = $val + $valreconstruccion;
//        }
        //  $val = $val + $valportatil + $valespacios + $valcompro;
        return validatetypereturn($typereturn, $val, $valportatil, $valcompro, $valproyeccion, $valespacios, $valreconstruccion);
    }
}

function validateclinicaconquistadores($valiss, $idtecnica, $idestudio, $lectura, $idservicio, $idsede, $cups, $idinforme, $portatil, $typereturn, $cn)
{
    //ISS + 7 % PARA TODOS LOS SERVICIOS
    //PARA LOS PACIENTES DECOOMEVA Q SE REALICEN RNM SE PAGARA A LA CLINICA EL 10 %

    $valreconstruccion = 0;
    if ($idservicio == 2) {
        $valespacios = validateespaciosadicionales($idinforme, $cn);
        $valreconstruccion = valreconstruccion('1', $cn);
        $isangio = validateangioresonacia($idestudio, $cn);
    }
    if ($idservicio == 1) {
        $valcompro = validatecompartivas($idinforme, $cn);
        $valproyeccion = validateproyeccion($idinforme, $cn);
    }
    $valcompro = $valcompro * 1.07;
    $valportatil = validateportatil($portatil, $idservicio) * 1.07;
    $valespacios = $valespacios * 1.07;
    $valproyeccion = $valproyeccion * 1.07;
    $val = $valiss * 1.07;
    $valreconstruccion = $valreconstruccion * 1.07;
    $salaymateriales = validatesalaymateriales($idestudio, $cn) * 1.07;
//    if ($idtecnica == 3 || $idtecnica == 6) {
//        if ($idservicio = 2) {
//            $conangios = mysql_query("SELECT idestudio FROM r_estudio WHERE nom_estudio LIKE '%angiotomografia%' AND idestado=1 AND idservicio=2;", $cn);
//            while ($arrayangios = mysql_fetch_array($conangios)) {
//                if ($idestudio == $arrayangios['idestudio']) {
//                    $reconstruccion = $valreconstruccion;
//                }
//            }
//        }
//        // $valcontraste = validatecontrastedvaluemarcofidelandconquistadores($idsede, $idservicio, $idestudio, $cups, $idinforme, $cn);
//        $val = $val + $reconstruccion; // $valcontraste +
//    }
    if ($idestudio == 183 || $idestudio == 1112) {

        $val = $val + $valreconstruccion;
    }
    $val = $val + $salaymateriales;
    //$val = $val + $valespacios + $valportatil + $valcompro;
//    if ($isangio) {
//        $val = $val + $valreconstruccion;
//    }
    $val = validatelectura($val, $lectura, $idservicio);
    return validatetypereturn($typereturn, $val, $valportatil, $valcompro, $valproyeccion, $valespacios, $valreconstruccion);
}

function validateipsuniversitariasedeambulatoria($valiss, $idtecnica, $idestudio, $pesop, $cod_iss, $lectura, $idservicio, $portatil, $idinforme, $typereturn, $cn)
{
    //ISS-7%

    $val = 0;
    if ($idservicio == 1) {
        $valcompro = validatecompartivas($idinforme, $cn);
        $valproyeccion = validateproyeccion($idinforme, $cn);
    }
    $valcompro = $valcompro * 0.93;
    $valportatil = validateportatil($portatil, $idservicio) * 0.93;
    $valproyeccion = $valproyeccion * 0.93;
    $salaymateriales = validatesalaymateriales($idestudio, $cn) * 0.93;
    if ($idtecnica == 1 || $idtecnica == 2) {

        $val = ($valiss * 0.93);
    } elseif ($idtecnica == 3) {
        $valcontrasted = $valiss * 0.93;
        $val = validatecontrastedvalues($valcontrasted, $pesop, $cod_iss, $cn);
    }
    $val = $val + $salaymateriales;
    $val = validatelectura($val, $lectura, $idservicio);
    //$val = $val + $valportatil + $valcompro;
    return validatetypereturn($typereturn, $val, $valportatil, $valcompro, $valproyeccion, 0, 0);
}

function validatemetrosaludmanrique($valiss, $idtecnica, $idestudio, $pesop, $cod_iss, $lectura, $idservicio, $portatil, $idinforme, $typereturn, $cn)
{
    //ISS+6%

    $val = 0;
    $valportatil = validateportatil($portatil, $idservicio) * 1.08;
    if ($idservicio == 1) {
        $valcompro = validatecompartivas($idinforme, $cn);
        $valproyeccion = validateproyeccion($idinforme, $cn);
    }
    $valcompro = $valcompro * 1.08;
    $valproyeccion = $valproyeccion * 1.10;
    $salaymateriales = validatesalaymateriales($idestudio, $cn) * 1.08;

    $val = ($valiss * 1.08);

    $val = $val + $salaymateriales;
    $val = $val; //+ $valportatil + $valcompro;
    $val = validatelectura($val, $lectura, $idservicio);
    return validatetypereturn($typereturn, $val, $valportatil, $valcompro, $valproyeccion, 0, 0);
}

//function validatecoomevaintegrados($valiss, $idservicio, $portatil, $idinforme, $cn)
//{
//    //ISS+7,12 ECOGRAFIAS ISS-17 RX
//
//    if ($idservicio == 3 || $idservicio == 51) {
//        $val = $valiss * 1.0712;
//        $valportatil = validateportatil($portatil, $idservicio) * 1.0712;
//        $val = $val + $valportatil;
//        return $val;
//    }
//    if ($idservicio == 1) {
//        $val = $valiss * 0.83;
//        $valportatil = validateportatil($portatil, $idservicio) * 0.83;
//
//        $valcompro = validatecompartivayproyeccion($idinforme, $cn) * 0.83;
//
//        $val = $val + $valportatil + $valcompro;
//        return $val;
//    } else {
//        $val = $valiss;
//        return $val;
//    }
//}

function validatesaviasalud($valiss, $idservicio, $idestudio, $idtecnica, $idinforme, $portatil, $typereturn, $cn)
{
    //ISS - 16% TODOS LOS PROCEDIMIENTOS
    //CONTRASTES ESTAN POR PAQUETES

    if ($idservicio == 3 || $idservicio == 51) {
        $val = $valiss * 1.05;
    } else {
        $val = $valiss * 0.85;
    }
    if ($idservicio == 2) {
        $conespacios = validateespaciosadicionales($idinforme, $cn);
        $valespacios = $conespacios * 20615;
        if ($idestudio == 183 || $idestudio == 1112) {
            $valreconstruccion = valreconstruccion('1', $cn) * 0.85;
            $val = $val + $valreconstruccion;
        }

    }
    if ($idservicio == 1) {
        $valcompro = validatecompartivas($idinforme, $cn);
        $valproyecciones = validateproyeccion($idinforme, $cn);

    }
    $valcompro = $valcompro * 0.85;
    $valproyeccion = $valproyecciones * 0.85;
    $valportatil = validateportatil($portatil, $idservicio) * 0.85;
    $valespacios = $valespacios * 0.85;
    if ($idtecnica == 3) {
        //validar valores contrastados desde la base de datos
        $constrastesavia = mysql_query("SELECT contrastesavia FROM r_estudio where idestudio='$idestudio'", $cn);
        $valorcontraste = mysql_fetch_array($constrastesavia);
        $valor = $valorcontraste['contrastesavia'];

        $val = $val + $valor;
    }
    $val = $val;// + $valespacios + $valportatil + $valcompro;
    return validatetypereturn($typereturn, $val, $valportatil, $valcompro, $valproyeccion, $valespacios, 0);
}

function validatecoomeva($valiss, $idservicio, $idestudio, $idtecnica, $idinforme, $portatil, $typereturn, $cn)
{
    $val = $valiss;
    if ($idservicio == 2) {
        $conespacios = validateespaciosadicionales($idinforme, $cn);
        $valespacios = $conespacios * 20615;
    }
    if ($idservicio == 1) {
        $valcompro = validatecompartivas($idinforme, $cn);
        $valproyeccion = validateproyeccion($idinforme, $cn);
    }
    $valportatil = validateportatil($portatil, $idservicio);
    if ($idservicio == 1) {
        $valportatil = $valportatil * 1.8466;
    }
    if ($idservicio == 3) {
        $valportatil = $valportatil * 1.926;
    }
    if ($idservicio == 51) {
        $valportatil = $valportatil * 1.4204;
    }

    $valcompro = $valcompro * 1.8466;
    $valproyeccion = $valproyeccion * 1.8466;
    $valespacios = $valespacios * 1.816;
    $consulta = mysql_query("SELECT coomevasimple,coomevacontraste FROM r_estudio where idestudio='$idestudio'", $cn);
    $resultado = mysql_fetch_array($consulta);
    $valorcontraste = $resultado['coomevacontraste'];
    $valorsimple = $resultado['coomevasimple'];
    if ($idtecnica == 3) {
        $val = $valorcontraste;

    } elseif ($idtecnica == 1 || $idtecnica == 2) {
        if ($idservicio == 2) {
            $coninformeheader = mysql_query("SELECT rih.id_paciente,rli.fecha FROM r_informe_header rih INNER JOIN r_log_informe rli ON rih.id_informe=rli.id_informe
                                             WHERE rih.id_informe='$idinforme' AND rli.id_estadoinforme=5", $cn);
            $informeheader = mysql_fetch_array($coninformeheader);
            $idpaciente = $informeheader['id_paciente'];
            $fecha = $informeheader['fecha'];

            $conloginforme = mysql_query("SELECT * FROM r_log_informe rli INNER JOIN r_informe_header rih ON rli.id_informe=rih.id_informe
                                        WHERE rih.id_paciente='$idpaciente' AND  rli.fecha='$fecha' AND rli.id_estadoinforme=5 AND rih.id_tecnica=3", $cn);
            $loginforme = mysql_fetch_array($conloginforme);
            $count = count($loginforme);
            if ($count >= 2) {
                $val = $valorsimple * 0.60;
            }
        } else {
            $val = $valorsimple;
        }
    }
    //$val = $val + $valespacios + $valcompro + $valportatil;
    return validatetypereturn($typereturn, $val, $valportatil, $valcompro, $valproyeccion, $valespacios, 0);
}

function validatebarranquilla($valiss, $idservicio, $idinforme, $idestudio, $portatil, $typereturn, $cn)
{
    $val = 0;
    $valespacios = 0;
    $valreconstruccion = 0;
    if ($idservicio == 2) {
        $val = $valiss;
        $valespacios = validateespaciosadicionales($idinforme, $cn);
        $valreconstruccion = valreconstruccion('1', $cn);
    } else {
        if ($idservicio == 1) {
            $concomparativas = validatecompartivas($idinforme, $cn) * 0.95;
            $conproyecion = validateproyeccion($idinforme, $cn) * 0.95;
            $valportatil = validateportatil($portatil, $idservicio) * 0.95;
        } elseif ($idservicio == 3) {
            $valportatil = validateportatil($portatil, $idservicio) * 0.95;
        }
        $val = $valiss * 0.95;
    }
    return validatetypereturn($typereturn, $val, $valportatil, $concomparativas, $conproyecion, $valespacios, $valreconstruccion);
}


function validateapartado($valsoat, $idservicio, $portatil, $idinforme, $typereturn, $lectura, $cn)
{
//soat-40%
    $val = $valsoat * 0.60;
    $valportatil = 0;
    $valcomparativas = 0;
    $valproyecciones = 0;

    if ($idservicio == 1) {
        $valportatil = validateportatil($portatil, $idservicio);
        $valcomparativas = validatecompartivas($idinforme, $cn);
        $valproyecciones = validateproyeccion($idinforme, $cn);
    } elseif ($idservicio == 3 || $idservicio == 51) {
        $valportatil = validateportatil($portatil, $idservicio);
    } elseif ($idservicio == 2) {
        $valespacios = validateespaciosadicionales($idinforme, $cn);
        $valreconstruccion = valreconstruccion('2', $cn);
    }
    $val = validatelectura($val, $lectura, $idservicio);
    return validatetypereturn($typereturn, $val, $valportatil, $valcomparativas, $valproyecciones, $valespacios, $valreconstruccion);
}

function validatesanandres($valsoat, $idservicio, $portatil, $idinforme, $typereturn, $lectura, $cn)
{
    //soat -20%
    $val = $valsoat * 0.8;
    $valportatil = 0;
    $valcomparativas = 0;
    $valproyecciones = 0;
    if ($idservicio == 1) {
        $valportatil = validateportatil($portatil, $idservicio);
        $valcomparativas = validatecompartivas($idinforme, $cn);
        $valproyecciones = validateproyeccion($idinforme, $cn);
    } elseif ($idservicio == 3 || $idservicio == 51) {
        $valportatil = validateportatil($portatil, $idservicio);
    } elseif ($idservicio == 2) {
        $valespacios = validateespaciosadicionales($idinforme, $cn);
        $valreconstruccion = valreconstruccion('2', $cn);
    }
    $val = validatelectura($val, $lectura, $idservicio);
    return validatetypereturn($typereturn, $val, $valportatil, $valcomparativas, $valproyecciones, $valespacios, $valreconstruccion);
}

function validateturbo()
{

}

function validatefundacionmedicopreventivamagisterio($idservicio, $valiss, $idinforme, $portatil, $idtecnica, $idestudio, $typereturn, $cn)
{
    $val = 0;
    $valespacios = 0;
    $valreconstruccion = 0;
    $valportatil = 0;
    $concomparativas = 0;
    $conproyecion = 0;
    if ($idservicio == 2) {
        $val = $valiss * 0.95;
        $valespacios = validateespaciosadicionales($idinforme, $cn) * 0.95;
        $valreconstruccion = valreconstruccion('1', $cn) * 0.95;
        if ($idestudio == 183 || $idestudio == 1112) {

            $val = $val + $valreconstruccion;
        }
        if ($idtecnica == 3) {
            $val = $val + 169000;
        }
    } elseif ($idservicio == 1) {
        $val = $valiss * 0.95;
        $concomparativas = validatecompartivas($idinforme, $cn) * 0.95;
        $conproyecion = validateproyeccion($idinforme, $cn) * 0.95;
        $valportatil = validateportatil($portatil, $idservicio) * 0.95;
    } elseif ($idservicio == 20) {
        $val = $valiss * 0.95;
    } elseif ($idservicio == 3 || $idservicio == 51) {
        $val = $valiss * 1.20;
        $valportatil = validateportatil($portatil, $idservicio) * 1.20;
    } elseif ($idservicio == 10) {
        $val = $valiss * 1.04;
        if ($idtecnica == 3) {
            $val = 527625 * 1.04;
        }
    } else {
        if ($idservicio == 3) {
            $valportatil = validateportatil($portatil, $idservicio) * 0.95;
        }
        $val = $valiss * 0.95;
    }
    return validatetypereturn($typereturn, $val, $valportatil, $concomparativas, $conproyecion, $valespacios, $valreconstruccion);
}


function validatesanrafalitagui($valiss, $tipopaciente, $portatil, $idservicio, $typereturn, $idinforme, $cn)
{
    $val = 0;


    if ($idservicio == 1) {
        $valportatil = validateportatil($portatil, $idservicio);
        $valcomparativa = validatecompartivas($idinforme, $cn);
        $valproyecciones = validateproyeccion($idinforme, $cn);

    }

    if ($idservicio == 3 || $idservicio == 51) {
        $valportatil = validateportatil($portatil, $idservicio);
    }

    if ($idservicio == 2) {
        $valreconstruccion = valreconstruccion(1, $cn);
        $valespacios = validateespaciosadicionales($idinforme, $cn);
    }

    if ($tipopaciente == 1 || $tipopaciente == 3) {
        $val = $valiss * 1.20;
    } elseif ($tipopaciente == 2) {
        $val = $valiss * 1.10;
    }
    return validatetypereturn($typereturn, $val, $valportatil, $valcomparativa, $valproyecciones, $valespacios, $valreconstruccion);
}


function validateparticular($valsoat, $typereturn)
{
    $val = $valsoat * 0.6;
    return validatetypereturn($typereturn, $val, 0, 0, 0, 0, 0);
}

function validateuvr($valiss, $uvr)
{
    $val = $valiss;
    if ($uvr == 'T') {
        $val = $val * 1270;
    }
    return $val;
}

function validatehonorarium($valiss, $idestudio, $cn)
{
    $val = $valiss;
    $estudio = mysql_query("SELECT * from r_estudio where idestudio='$idestudio'", $cn);
    $arrayestudio = mysql_fetch_array($estudio);
    $honorario = $arrayestudio['honorario'];
    if ($honorario != null && $honorario != 0 && $honorario != 9103 && $honorario != 9104) {
        $honorario = $honorario / 100;
        $val = $val + ($val * $honorario);
    } elseif ($honorario == 9103 or $honorario == 9104) {
        $estudiohonorario = mysql_query("SELECT * from r_estudio where cod_iss='$honorario'", $cn);
        $arrayestudiohonorario = mysql_fetch_array($estudiohonorario);
        $valmateriales = $arrayestudiohonorario['val_materiales'];
        $valsala = $arrayestudiohonorario['val_sala'];
        $valestudio = $arrayestudiohonorario['val_iss'];
        $uvr = $arrayestudiohonorario['uvr'];
        $valestudioiss = validateuvr($valestudio, $uvr);
        $val = $val + $valmateriales + $valsala + $valestudioiss;
    }
    return $val;
}

function validatecontrastedvaluesleonx($pesopaciente, $idservicio, $idestudio, $cn)
{
    $valreturn = 0;
    if ($idservicio == 2) {
        $valoptiray = 50;
        //    $tomogrfias = array(213601, 213602, 213603, 213604, 213605, 213606, 213608);
        $concontrasted50 = mysql_query("select idestudio from r_estudio where idservicio=2 and cups_iss in(879112,879113,879131,879121,879116,879122)", $cn);
        while ($resultado = mysql_fetch_array($concontrasted50)) {
            if ($idestudio == $resultado['idestudio']) {
                $valoptiray = 50;
            }
        }
        $contrasted = mysql_query("SELECT idestudio FROM r_estudio WHERE idservicio=2 and cups_iss in(879301,879510,879520,879150,879420,879410)", $cn);
        while ($result = mysql_fetch_array($contrasted)) {
            if ($idestudio == $result['idestudio']) {
                if ($pesopaciente >= 0 && $pesopaciente <= 35) {
                    $valoptiray = 50;
                } elseif ($pesopaciente >= 36 && $pesopaciente <= 44) {
                    $valoptiray = 75;
                } elseif ($pesopaciente >= 45 && $pesopaciente <= 58) {
                    $valoptiray = 100;
                } elseif ($pesopaciente >= 59 && $pesopaciente <= 69) {
                    $valoptiray = 125;
                } elseif ($pesopaciente >= 70 && $pesopaciente <= 80) {
                    $valoptiray = 150;
                } elseif ($pesopaciente >= 85 && $pesopaciente <= 93) {
                    $valoptiray = 175;
                } elseif ($pesopaciente >= 94) {
                    $valoptiray = 200;
                }
            }
        }
        $valconrray = 0;
        if ($idestudio == 879420 || $idestudio == 879410) {
            $valconrray = 15;
        }
        $valconrray = $valconrray * 639;
        $valpayoptiray = $valoptiray * 1415;
        $valconector = 11475;
        $valreturn = $valreturn + $valpayoptiray + $valconrray + $valconector;
        return $valreturn;

    } elseif ($idservicio == 10) {
        $valreturn = 629668;
        return $valreturn;
    }
}

function validatecontrastedvaluemarcofidelandconquistadores($idsede, $idservicio, $idestudio, $cups, $idinforme, $cn)
{
    $valreturn = 0;
    if ($idservicio == 2) {
        $valoptiray = 50;
        //    $tomogrfias = array(213601, 213602, 213603, 213604, 213605, 213606, 213608);
        $concontrasted50 = mysql_query("select idestudio from r_estudio where idservicio=2 and cups_iss in(879112,879113,879131,879121,879116,879122)", $cn);
        while ($resultado = mysql_fetch_array($concontrasted50)) {
            if ($idestudio == $resultado['idestudio']) {
                $valoptiray = 50;
            }
        }
        $contrasted = mysql_query("SELECT idestudio FROM r_estudio WHERE idservicio=2 and cups_iss in(879301,879510,879520,879150,879420,879410,879161)", $cn);
        while ($result = mysql_fetch_array($contrasted)) {
            if ($idestudio == $result['idestudio']) {
                $valoptiray = 100;
            }
        }

        $valconrray = 0;
        if ($cups == 879420 || $cups == 879410) {
            if ($idsede == 32) {
                $valconrray = 33880;
            } elseif ($idsede == 5 || $idsede == 35) {
                $valconrray = 48649;
            }
        }

        $valjeringa = 0;
        if ($idsede == 5 || $idsede == 35) {
            $coninformeheader = mysql_query("SELECT rih.id_paciente,rli.fecha FROM r_informe_header rih INNER JOIN r_log_informe rli ON rih.id_informe=rli.id_informe
                                             WHERE rih.id_informe='$idinforme' AND rli.id_estadoinforme=5", $cn);
            $informeheader = mysql_fetch_array($coninformeheader);
            $idpaciente = $informeheader['id_paciente'];
            $fecha = $informeheader['fecha'];

            $conloginforme = mysql_query("SELECT count(*) as cant FROM r_log_informe rli INNER JOIN r_informe_header rih ON rli.id_informe=rih.id_informe
                                        WHERE rih.id_paciente='$idpaciente' AND  rli.fecha='$fecha' AND rli.id_estadoinforme=5 AND rih.id_tecnica=3", $cn);
            $loginforme = mysql_fetch_array($conloginforme);
            $count = $loginforme['cant'];
            if ($count >= 2) {
                $valoptiray = 150;
            }
        }

        if ($idsede == 32) {
            $valpayoptiray = $valoptiray * 1540;
            $valconector = 13838;
            $valreturn = $valreturn + $valpayoptiray + $valconrray + $valconector;
        } elseif ($idsede == 5 || $idsede == 35) {
            if ($valoptiray == 50) {
                $valopaytiray = 87568;
            } elseif ($valoptiray == 100) {
                $valopaytiray = 175137;
            } elseif ($valoptiray == 150) {
                $valopaytiray = 262705;
            }
            $valconector = 16541;
            $valjeringa = 111060;
            $valreturn = $valreturn + $valopaytiray + $valconrray + $valjeringa + $valconector;
        }

        return $valreturn;

    } elseif ($idservicio == 10) {
        $valreturn = 629688;
        return $valreturn;
    }
}

function validatebiopsiasinsumos($idinforme, $idsede, $cn)
{
    //consulta de los insumos utilizados durante el procedimiento
    $coninsumosbiosias = mysql_query("SELECT insumos,eco_biopsia,cantidadinsumos FROM r_informe_facturacion where id_informe='$idinforme'", $cn);
    $insumos = mysql_fetch_array($coninsumosbiosias);
    $insumosproce = $insumos['insumos'];
    $ecobiopsia = $insumos['eco_biopsia'];
    $cantidadinsumos = $insumos['cantidadinsumos'];
    $valinsumos = 0;
    if ($ecobiopsia != 0) {
        $sql = mysql_query("SELECT * FROM r_estudio WHERE idestudio='$ecobiopsia'", $cn);
        $regestudio = mysql_fetch_array($sql);
        $valeco = 0;
        if ($idsede == 1) {
            $valeco = $regestudio['val_iss'];
            $valinsumos = $valeco;
        } elseif ($idsede == 3) {
            $valeco = $regestudio['val_iss'];
            $valinsumos = $valeco * 1.1934;
        } elseif ($idsede == 5 || $idsede == 35) {
            $valeco = $regestudio['val_iss'];
            $valinsumos = $valeco * 1.37;
        } elseif ($idsede == 32) {
            $valeco = $regestudio['val_iss'];
            $valinsumos = $valeco * 1.37;
        } else {
            $valeco = $regestudio['val_iss'];
            $valinsumos = $valeco * 1.07;
        }
    }
    if ($insumosproce != '' && $insumosproce != null) {
        $arrayinsumos = explode('-', $insumos['insumos']);
        $arrayinsumoscant = explode('-', $cantidadinsumos);
        $conarray = count($arrayinsumos);
        for ($i = 0; $i < $conarray; $i++) {
            //consulta de el valor de insumos por sede
            $idinsumo = $arrayinsumos[$i];
            $cantinsumo = $arrayinsumoscant[$i];
            $coninsumosede = mysql_query("SELECT valorinsumo from r_sede_insumos WHERE idsede='$idsede' and idinsumo='$idinsumo'", $cn);
            $insumosede = mysql_fetch_array($coninsumosede);
            $valinsumosede = $insumosede['valorinsumo'] * $cantinsumo;
            $valinsumos = $valinsumos + $valinsumosede;
        }
    }
    return $valinsumos;
}

function validatesalaymateriales($idestudio, $cn)
{
    $valreturn = 0;
    $estudio = mysql_query("SELECT * from r_estudio where idestudio='$idestudio'", $cn);
    $arraylist = mysql_fetch_array($estudio);
    if ($arraylist['materiales'] != null && strcmp($arraylist['materiales'], "") !== 0) {
        $valmateriales = $arraylist['val_materiales'];
        $valreturn = $valreturn + $valmateriales;
    }
    if ($arraylist['sala'] != null && strcmp($arraylist['sala'], "") !== 0) {
        $valsala = $arraylist['val_sala'];
        $valreturn = $valreturn + $valsala;
    }
    return $valreturn;
}

function validatecodigoiss($cod_iss, $parameter)
{
    $cod = $cod_iss;
    $codeshow = $cod_iss;
    if (strlen($cod_iss) >= 8) {
        list($codetoshow, $codetocalculate) = explode("-", $cod_iss);
        $cod = $codetocalculate;
        $codeshow = $codetoshow;
    }
    if ($parameter == 1) {
        return $cod;
    } else {
        return $codeshow;
    }

}

function validatelectura($val, $lectura, $servicio)
{
    $valreturn = $val;
    if ($servicio == 1 && $lectura == '2') {
        $valreturn = $valreturn * 0.75;
    }
    return $valreturn;
}

function valreconstruccion($manual, $cn)
{
    $conreconstruccion = mysql_query("SELECT val_iss,val_soat FROM r_estudio WHERE idestudio='878'", $cn);
    $arrayreconstruccion = mysql_fetch_array($conreconstruccion);
    $reconstruccioniss = $arrayreconstruccion['val_iss'];
    $reconstruccionsoat = $arrayreconstruccion['val_soat'];
    if ($manual == 1) {
        return $reconstruccioniss;
    } else {
        return $reconstruccionsoat;
    }
}

function validateespaciosadicionales($idinforme, $cn)
{
    $conadicionalesecografias = mysql_query("SELECT espacios_tomografia FROM r_informe_facturacion WHERE id_informe='$idinforme'", $cn);
    $cant = mysql_num_rows($conadicionalesecografias);
    $cantespacios = 0;
    if ($cant == 1) {
        $cantespacios = 1;
    }
    $valespacios = $cantespacios * 20615;//213610

    return $valespacios;
}

function validateproyeccion($idinforme, $cn)
{
    $conproyeccion = mysql_query("SELECT proyeccion FROM r_informe_facturacion WHERE id_informe='$idinforme'", $cn);
    $cant = mysql_num_rows($conproyeccion);
    $proyeccion = 0;
    if ($cant == 1) {
        $proyeccion = 1;
    }
    $cant = $proyeccion;
    return $cant;
}

function validatecompartivas($idinforme, $cn)
{
    $concomparacion = mysql_query("SELECT comparativa FROM r_informe_facturacion WHERE id_informe='$idinforme'", $cn);
    $cant = mysql_num_rows($concomparacion);
    $comparativa = 0;
    if ($cant == 1) {
        $regcomparativa = mysql_fetch_array($concomparacion);
        $comparativa = $regcomparativa['comparativa'];
    }
    $cant = $comparativa * 8040;
    return $cant;
}

function validateangioresonacia($idestudio, $cn)
{
    $answer = false;
    $conangios = mysql_query("SELECT idestudio FROM r_estudio WHERE idservicio=2 AND nom_estudio LIKE '%angiotomografia%' OR nom_estudio LIKE '%angiotac%'", $cn);
    while ($row = mysql_fetch_array($conangios)) {
        if ($idestudio == $row['idestudio']) {
            $answer = true;
        }
    }
    return $answer;
}


function validateportatil($portatil, $idservicio)
{
    $valportatil = 0;
    if ($portatil == 1) {
        if ($idservicio == 1) {
            $valportatil = 14865;
        }
        if ($idservicio == 3 || $idservicio == 51) {
            $valportatil = 8660;
        }
    }
    return $valportatil;
}

function validateoptirraytomografiasclinicanorte($idestudio, $cn)
{
    $valoptiray = 0;
    $concontrasted50 = mysql_query("select idestudio from r_estudio where idservicio=2 and cups_iss in(879112,879113,879131,879121,879116,879122,879150)", $cn);
    while ($resultado = mysql_fetch_array($concontrasted50)) {
        if ($idestudio == $resultado['idestudio']) {
            $valoptiray = 50;
        }
    }
    $contrasted = mysql_query("SELECT idestudio FROM r_estudio WHERE idservicio=2 and cups_iss in(879301,879510,879520,879420,879410,879161) OR nom_estudio LIKE '%angiotomografia%' OR nom_estudio LIKE '%angiotac%'", $cn);
    while ($result = mysql_fetch_array($contrasted)) {
        if ($idestudio == $result['idestudio']) {
            $valoptiray = 100;
        }
    }
    return $valoptiray;
}

function convertsoat($minimolegal, $puntos)
{
    $valdia = $minimolegal / 30;
    $valsoat = $valdia * $puntos;
    return $valsoat;
}

function validatetypereturn($typereturn, $val, $valportatil, $valcomparativa, $valproyeccion, $valespacios, $valreconstruccion)
{
    if ($typereturn == 'valor') {
        return $val;
    } elseif ($typereturn == 'portatil') {
        return $valportatil;
    } elseif ($typereturn == 'comparativa') {
        return $valcomparativa;
    } elseif ($typereturn == 'proyeccion') {
        return $valproyeccion;
    } elseif ($typereturn == 'espacios') {
        return $valespacios;
    } elseif ($typereturn == 'reconstruccion') {
        return $valreconstruccion;
    }
}

?>