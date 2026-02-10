<?php

namespace App\Controllers;

class EmailController extends BaseController
{
    public function send()
    {
        $email = \Config\Services::email();

        $email->setTo('recipient@example.com');
        $email->setFrom('your_email@gmail.com', 'Your Name');
        $email->setSubject('Test Email from CodeIgniter 4');
        $email->setMessage('<h2>Hello!</h2><p>This is a test email sent from your CI4 app.</p>');

        if ($email->send()) {
            return 'Email sent successfully!';
        } else {
            return $email->printDebugger(['headers']);
        }
    }
}
