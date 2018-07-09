<?php

namespace Models\Services;

class UserMailer
{

    public $mailer;

    public function __construct( \Contracts\MailerInterface $mailer )
    {
        $this->setMailer( $mailer );
    }

    public function setMailer( $mailer )
    {
        $this->mailer = $mailer;
    }

    public function sendWelcomeEmail( $first_name, $email )
    {
        $this->mailer->setRecipientName( $first_name );
        $this->mailer->setRecipientEmailAddress( $email );
        $this->mailer->setSenderName( "JiuJitsuScout" );
        $this->mailer->setSenderEmailAddress( "partnersupport@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "Welcome to JiuJitsuScout!" );
        $this->mailer->setEmailBody( "Your profile on JiuJitsuScout is complete!" );
        #$this->mailer->mail();

        return true;
    }

    public function sendLeadCaptureNotification( $user_name, $user_email, $prospect_info = [] )
    {
        $this->mailer->setRecipientName( $user_name );
        $this->mailer->setRecipientEmailAddress( $user_email );
        $this->mailer->setSenderName( "JiuJitsuScout" );
        $this->mailer->setSenderEmailAddress( "notifications@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "New Lead Captured" );
        $this->mailer->setEmailBody( '
            <div>
                <table cellspacing=0 style="width: 300px; background: #f6f7f9; border-collapse: collapse; table-layout: fixed; border: 1px solid #CCCCCC; box-sizing: border-box; padding: 15px; display: block; margin-left: 20px;">
                    <tr>
                        <td style="font-weight: bold; padding: 15px;">Name:</td>
                        <td>' . $prospect_info[ "name" ] . '</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 15px;">Email:</td>
                        <td>' . $prospect_info[ "email" ] . '</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 15px;">Phone Number:</td>
                        <td>' . $prospect_info[ "number" ] . '</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 15px;">Source:</td>
                        <td><p sytle="max-width: 50ch;">' . $prospect_info[ "source" ] . '</p></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 15px;">Additional Info:</td>
                        <td><p sytle="max-width: 50ch;">' . $prospect_info[ "additional_info" ] . '</p></td>
                    </tr>
                </table>
                <table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-left: 20px; margin-top: 20px;">
                    <tr>
                        <td><a href="localhost/jiujitsuscout.com/account-manager/business/lead/' . $prospect_info[ "id" ] . '/" style="background: #77DD77; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">View in Account Manager</a></td>
                    </tr>
                </table>
            </div>
        ' );
        $this->mailer->mail();

        return true;
    }

}
