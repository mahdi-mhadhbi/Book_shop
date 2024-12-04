<?php
// src/Controller/EmailController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response;

class EmailController extends AbstractController
{
    #[Route('/send-test-email', name: 'send_test_email')]
    public function sendTestEmail(MailerInterface $mailer): Response
    {
        // Create a new email
        $email = (new Email())
            ->from('mehdimhadbi15@gmail.com')
            ->to('jrmahdy68@gmail.com') 
            ->subject('Test Email from Symfony')
            ->html('<p>This is a test email sent via Symfony using Mailtrap SMTP.</p>');

        // Send the email
        try {
            $mailer->send($email);
            return new Response('Email sent successfully');
            echo($email);
        } catch (\Exception $e) {
            return new Response('Failed to send email: ' . $e->getMessage());
        }
    }
}
