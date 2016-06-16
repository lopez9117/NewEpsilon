<?php
/*
 * Este fichero contiene la definición de la clase tantaQRCode
 * Integra dos librerías para la generación de códigos QR, en concreto
 * PHP QR Code y BarCodeQR.
 * Ambas nos gustaban. La primera por no depender de un generador externo
 * tipo Google Chart, y la segunda por la inclusión de métodos destinados
 * a la generación de distintos formatos de qr code
 *
 * Por tanto en Tanta hemos decidido mezclarlas
 *
 * @name tantaQRCode
 * @version 1.0
 * @author carlos.revillo@tantacom.com
 * @see http://phpqrcode.sourceforge.net/
 * @see http://www.shayanderson.com/php/php-qr-code-generator-class.htm
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * Este software es gratuito y se distribuye SIN NINGUNA GARANTÍA
 */

include 'phpqrcode/qrlib.php';
include 'BarcodeQR/BarcodeQR.php';

class tantaQRCode extends BarcodeQR
{
    // Por defecto tratará de crear los qrs en la subcarpeta qrs
    // Asegurate de que el usuario que ejecuta el servidor web 
    // tenga permisos de escritura sobre ella.     
    const FOLDER = 'qrs';

    public function draw( $size = 150, $filename, $type )
    {
        QRcode::png( $this->_data,  self::FOLDER . "/{$filename}.png" );
        return $filename;
    } 
}
?>
