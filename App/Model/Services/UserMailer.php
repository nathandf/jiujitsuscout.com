<?php

namespace Model\Services;

class UserMailer
{

    public $mailer;
    public $configs;
    private $userRepo;

    public function __construct(
        \Contracts\MailerInterface $mailer,
        \Model\Services\UserRepository $userRepo,
        \Conf\Config $Config
    ) {
        $this->setMailer( $mailer );
        $this->userRepo = $userRepo;
        $this->configs = $Config::$configs[ "email_settings" ][ $Config::getEnv() ];
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
        $this->mailer->setSenderEmailAddress( "jiujitsuscout@gmail.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "Welcome to JiuJitsuScout!" );
        $this->mailer->setEmailBody(
            "<p>Your JiuJitsuScout account has been created!</p>

            <p>Here's few more things that need to be done before your profile starts generating leads.</p>

            <ul>
                <li>Add your logo</li>
                <li>Update your business's location</li>
                <li>Tell your profile visitors about your business</li>
                <li>Answer some frequently asked questions</li>
                <li>Upload some images of your business</li>
                <li>Upload a video of your classes in action!</li>
            </ul>

            <p>Log in to you account to get started.</p>

            <table cellspacing=0 style=\"border-collapse: collapse; table-layout: fixed; display: table; margin-left: 20px; margin-top: 20px;\">
                <tr>
                    <td><a href=\"https://www.jiujitsuscout.com/account-manager/\" style=\"background: #0667D4; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;\">Log in</a></td>
                </tr>
            </table>"
        );
        $this->mailer->mail();

        return true;
    }

    public function sendLeadCaptureNotification( $user_name, $user_email, $prospect_info = [] )
    {
        $this->mailer->setRecipientName( $user_name );
        $this->mailer->setRecipientEmailAddress( $user_email );
        $this->mailer->setSenderName( "JiuJitsuScout" );
        $this->mailer->setSenderEmailAddress( "noreply@jiujitsuscout.com" );
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
                        <td><a href="' . $this->configs[ "url_prefix" ] . 'account-manager/business/lead/' . $prospect_info[ "id" ] . '/" style="background: #0667D4; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">View in Account Manager</a></td>
                    </tr>
                </table>
            </div>
        ' );
        $this->mailer->mail();

        return true;
    }

    public function sendLeadCapturePurchaseRequiredNotification( $user_name, $user_email, $prospect_info = [] )
    {
        $this->mailer->setRecipientName( $user_name );
        $this->mailer->setRecipientEmailAddress( $user_email );
        $this->mailer->setSenderName( "JiuJitsuScout" );
        $this->mailer->setSenderEmailAddress( "noreply@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "New Lead Captured | Action Required" );
        $this->mailer->setEmailBody( '
            <div>
                <table cellspacing=0 style="width: 300px; table-layout: fixed; box-sizing: border-box; display: block; margin-left: 20px;">
                    <tr>
                        <td><p>Someone is interested in visiting your business! Log into your account manager to purchase or pass on this lead.</p></td>
                    </tr>
                </table>
                <table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-left: 20px; margin-top: 20px;">
                    <tr>
                        <td><a href="' . $this->configs[ "url_prefix" ] . 'account-manager/business/lead/' . $prospect_info[ "id" ] . '/" style="background: #0667D4; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">View in Account Manager</a></td>
                    </tr>
                </table>
            </div>
        ' );
        $this->mailer->mail();

        return true;
    }

    public function sendLeadPurchaseNotification( $user_name, $user_email, $prospect_info = [] )
    {
        $this->mailer->setRecipientName( $user_name );
        $this->mailer->setRecipientEmailAddress( $user_email );
        $this->mailer->setSenderName( "JiuJitsuScout" );
        $this->mailer->setSenderEmailAddress( "noreply@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "Lead Purchased" );
        $this->mailer->setEmailBody( '
            <div>
                <table cellspacing=0 style="width: 300px; table-layout: fixed; box-sizing: border-box; display: block; margin-left: 20px;">
                    <tr>
                        <h3>Lead Purchase Confirmation</h3>
                    </tr>
                    <tr>
                        <td><p>' . $prospect_info[ "name" ] . ' is interested in your services! Call and text them immediately to schedule a visit to your business.</p></td>
                    </tr>
                </table>
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
                </table>
                <table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-left: 20px; margin-top: 20px;">
                    <tr>
                        <td><a href="' . $this->configs[ "url_prefix" ] . 'account-manager/business/lead/' . $prospect_info[ "id" ] . '/" style="background: #0667D4; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">View in Account Manager</a></td>
                    </tr>
                </table>
            </div>
        ' );
        $this->mailer->mail();

        return true;
    }

    public function sendInsufficientFundsNotification( $user_name, $user_email )
    {
        $this->mailer->setRecipientName( $user_name );
        $this->mailer->setRecipientEmailAddress( $user_email );
        $this->mailer->setSenderName( "JiuJitsuScout" );
        $this->mailer->setSenderEmailAddress( "noreply@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "You're capturing leads!" );
        $this->mailer->setEmailBody( '
            <div>
                <table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-left: 20px; margin-top: 20px;">
                    <tr>
                        <td><p>People are interested in taking your classes and signing up on your JiuJitsuScout Profile! Fund your account to gain access to these leads.</p></td>
                    </tr>
                    <tr>
                        <td><a href="' . $this->configs[ "url_prefix" ] . 'account-manager/business/" style="background: #0667D4; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">Account Manager</a></td>
                    </tr>
                </table>
            </div>
        ' );
        $this->mailer->mail();

        return true;
    }

    public function sendReviewNotification( $user_name, $user_email, $reviewer_info = [] )
    {
        $this->mailer->setRecipientName( $user_name );
        $this->mailer->setRecipientEmailAddress( $user_email );
        $this->mailer->setSenderName( "JiuJitsuScout" );
        $this->mailer->setSenderEmailAddress( "noreply@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "Your Business was Reviewed" );
        $this->mailer->setEmailBody( '
            <div>
                <table cellspacing=0 style="width: 300px; background: #f6f7f9; border-collapse: collapse; table-layout: fixed; border: 1px solid #CCCCCC; box-sizing: border-box; padding: 15px; display: block; margin-left: 20px;">
                    <tr>
                        <td style="font-weight: bold; padding: 15px;">Name:</td>
                        <td>' . $reviewer_info[ "name" ] . '</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 15px;">Email:</td>
                        <td>' . $reviewer_info[ "email" ] . '</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 15px;">Rating:</td>
                        <td>' . $reviewer_info[ "rating" ] . '</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 15px;">Review:</td>
                        <td><p sytle="max-width: 50ch;">' . $reviewer_info[ "review" ] . '</p></td>
                    </tr>
                </table>
            </div>
        ' );
        $this->mailer->mail();

        return true;
    }

    public function sendAppointmentConfirmationNotification( $user_name, $user_email, $appointment_timestamp, $prospect_info = [] )
    {
        $prospect_name = ucwords( $prospect_info[ "name" ] );
        $this->mailer->setRecipientName( $user_name );
        $this->mailer->setRecipientEmailAddress( $user_email );
        $this->mailer->setSenderName( $prospect_name );
        $this->mailer->setSenderEmailAddress( "noreply@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( $prospect_info[ "name" ] . " Confirmed Their Appointment" );
        $this->mailer->setEmailBody( '
            <div>
                <h2 style="margin-bottom: 20px;">' . $prospect_name . ' has confirmed their appointment for ' . date( "l, M jS @ g:iA", $appointment_timestamp ) . '.</h2>
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
                        <td>' . $prospect_info[ "phone" ] . '</td>
                    </tr>
                </table>

                <table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-left: 20px; margin-top: 20px;">
                    <tr>
                        <td><a href="' . $this->configs[ "url_prefix" ] . 'account-manager/business/lead/' . $prospect_info[ "id" ] . '/" style="background: #0667D4; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">View in Account Manager</a></td>
                    </tr>
                </table>
            </div>
        ' );
        $this->mailer->mail();

        return true;
    }

    public function sendAppointmentRescheduleNotification( $user_name, $user_email, $prospect_info = [] )
    {
        $this->mailer->setRecipientName( $user_name );
        $this->mailer->setRecipientEmailAddress( $user_email );
        $this->mailer->setSenderName( "JiuJitsuScout" );
        $this->mailer->setSenderEmailAddress( "noreply@jiujitsuscout.com" );
        $this->mailer->setContentType( "text/html" );
        $this->mailer->setEmailSubject( "Appointment Reschedule Requested: " . $prospect_info[ "name" ] );
        $this->mailer->setEmailBody( '
            <div>
                <h2 style="margin-bottom: 20px;">' . $prospect_info[ "name" ] . ' would like to reschedule their appointment.</h2>
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
                        <td>' . $prospect_info[ "phone" ] . '</td>
                    </tr>
                </table>

                <table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-left: 20px; margin-top: 20px;">
                    <tr>
                        <td><a href="' . $this->configs[ "url_prefix" ] . 'account-manager/business/lead/' . $prospect_info[ "id" ] . '/" style="background: #0667D4; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">View in Account Manager</a></td>
                    </tr>
                </table>
            </div>
        ' );
        $this->mailer->mail();

        return true;
    }

    public function sendSelfScheduleNotification( $user_id, array $prospect_info )
    {
        $message = '
            <div>
                <h2 style="margin-bottom: 20px;">' . $prospect_info[ "name" ] . ' would like to reschedule their appointment.</h2>
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
                        <td>' . $prospect_info[ "phone" ] . '</td>
                    </tr>
                </table>

                <table cellspacing=0 style="border-collapse: collapse; table-layout: fixed; display: table; margin-left: 20px; margin-top: 20px;">
                    <tr>
                        <td><a href="' . $this->configs[ "url_prefix" ] . 'account-manager/business/lead/' . $prospect_info[ "id" ] . '/" style="background: #0667D4; color: #FFFFFF; text-align: center; border-radius: 3px; display: block; width: 300px; height: 40px; line-height: 40px; font-size: 15px; font-weight: 600; text-decoration: none;">View in Account Manager</a></td>
                    </tr>
                </table>
            </div>
        ';

        $user_ids = [];

        if ( !is_array( $user_id ) ) {
            $user_ids[] = $user_id;
        }
        
        foreach ( $user_ids as $user_id ) {
            $user = $this->userRepo->get( [ "*" ], [ "id" => $user_id ], "single" );
            if ( !is_null( $user ) ) {
                $this->mailer->setRecipientName( $user->getFullName() );
                $this->mailer->setRecipientEmailAddress( $user->email );
                $this->mailer->setSenderName( "JiuJitsuScout" );
                $this->mailer->setSenderEmailAddress( "noreply@jiujitsuscout.com" );
                $this->mailer->setContentType( "text/html" );
                $this->mailer->setEmailSubject( $prospect_info[ "name" ] . " is interested in visiting " . $prospect_info[ "time" ] );
                $this->mailer->setEmailBody( $message );
                $this->mailer->mail();
            }
        }

        return;
    }
}
