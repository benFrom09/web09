<?php

namespace Framework\Mail;

use phpDocumentor\Reflection\Types\Boolean;
use PHPMailer\PHPMailer\PHPMailer;
use PhpParser\Node\Expr\Cast\Bool_;

class Mail 
{
    /**
     * Undocumented variable
     *
     * @var PHPMailer
     */
    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer();
        $this->setUp();
    }

    public function setUp() {

        $environment = $_ENV['APP_ENV'];

        $this->mail->isSMTP();
        $this->mail->Mailer = 'smtp';
        $this->mail->SMTPAuth = $environment !== 'production' ? false : true;
        $this->mail->SMTPAutoTLS = false; 
        $this->mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];

        $this->mail->Host = $_ENV['SMTP_HOST'];
        $this->mail->Port = $_ENV['SMTP_PORT'];

        

        if($environment === 'local') {
            $this->mail->SMTPDebug = 2;
        }

        //authentication

        $this->mail->Username = $_ENV['EMAIL_USERNAME'];
        $this->mail->Password = $_ENV['EMAIL_PASSWORD'];


        $this->mail->isHTML(true);
        

        $this->mail->From = $_ENV['ADMIN_EMAIL'];
        $this->mail->FromName = $_ENV['APP_NAME'];
    }

    public function send(array $data = []):Bool {

        $this->mail->addAddress($data['to'],$data['name']);
        $this->mail->Subject = $data['subject'];
        $this->mail->Body = make_email($data['view'],['data' =>$data['body']]);
        return $this->mail->send();
    }
}