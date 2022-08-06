<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class NT_Emails {
        public function render($key, $params = []) {
            ob_start();
            include __DIR__ . "/../../app/views/emails" . $key . ".php";
            $output = ob_get_clean();
            return $output;
        }

        /**
         * @param {string} to The recipient email address
         * @param {string} subject The email's subject
         * @param {string} body The email's body (HTML code)
         */
        public function send($params) {
            if(Options::get('ENABLE_EMAILS') === 'FALSE')
                return;

            $mail = new PHPMailer(true);
            try {
                $mail->IsSMTP();
                $mail->Mailer = 'smtp';
                $mail->SMTPAuth = true;

                $mail->Host = Options::get('SMTP_HOST');
                $mail->SMTPSecure = Options::get('SMTP_SECURITY'); 
                $mail->Port = Options::get('SMTP_PORT');  

                $mail->Username = Options::get('SMTP_USER');
                $mail->Password = Options::get('SMTP_PASS');

                $mail->IsHTML(true);
                $mail->SingleTo = true;

                $mail->From = Options::get('SMTP_FROM');
                $mail->FromName = Options::get('SMTP_NAME');

                $mail->addAddress($params['to']);

                $mail->Subject = $params['subject'];
                $mail->Body = $params['body'];
                $mail->CharSet = 'UTF-8';

                $mail->Send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }

