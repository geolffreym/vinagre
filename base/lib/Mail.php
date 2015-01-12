<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 31/03/14
 * Time: 12:26
 * To change this template use File | Settings | File Templates.
 */
namespace core\lib;

use core\App;

App::__load__ ( 'phpmailer', 'lib/Mail/Amazon_SES' );

class Mail extends PHPMailer
{

    public function __construct ()
    {
        $this->exceptions = FALSE;
        $this->IsSMTP ();
        $this->SMTPAuth = TRUE;
        $this->Host     = SES_HOST;
        $this->Port     = SES_PORT;
        $this->Username = SES_USER;
        $this->Password = SES_PASSWORD;
        $this->CharSet  = 'UTF-8';
    }

    public function setFrom ( $address = 'info@test.com', $name = 'Me' )
    {
        parent::SetFrom ( $address, $name );
    }

    public function addAddress ( $address )
    {
        if ( !is_array ( $address ) ) {
            throw new \Exception(
                'Array of email as needed'
            );
        }

        foreach ( $address as $title => $mail ) {
            parent::AddAddress ( $mail, $title );
        }
    }

    public function setSubject ( $subject = 'Notification' )
    {
        $this->Subject = $subject;
    }

    public function bodyTemplate ( $template, $data = NULL )
    {
        $template = App::__render__ ( $template, $data );
        parent::IsHTML ( TRUE );
        parent::MsgHTML ( $template );
    }

    public function send ()
    {
        return parent::Send ();
    }
}