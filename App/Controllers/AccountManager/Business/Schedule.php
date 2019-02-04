<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Schedule extends Controller
{

    public function before()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $this->businessRepo = $this->load( "business-repository" );
        $userRepo = $this->load( "user-repository" );
        $scheduleRepo = $this->load( "schedule-repository" );

        // If user not validated with session or cookie, send them to sign in
        if ( !$userAuth->userValidate() ) {
            $this->view->redirect( "account-manager/sign-in" );
        }

        // User is logged in. Get the user object from the UserAuthenticator service
        $this->user = $userAuth->getUser();

        // Get AccountUser reference
        $accountUser = $accountUserRepo->get( [ "*" ], [ "user_id" => $this->user->id ], "single" );

        // Grab account details
        $this->account = $accountRepo->get( [ "*" ], [ "id" => $accountUser->account_id ], "single" );

        // Grab business details
        $this->business = $this->businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Verify that this business owns this landing page
        $schedules = $scheduleRepo->getAllByBusinessID( $this->business->id );
        $schedule_ids = [];
        foreach ( $schedules as $schedule ) {
            $schedule_ids[] = $schedule->id;
        }
        if ( isset( $this->params[ "id" ] ) && !in_array( $this->params[ "id" ], $schedule_ids ) ) {
            $this->view->redirect( "account-manager/business/schedules/" );
        }

        // Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->buildPixel() );

        // Set data for the view
        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/schedules/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $scheduleRepo = $this->load( "schedule-repository" );
        $courseScheduleRepo = $this->load( "course-schedule-repository" );
        $courseRepo = $this->load( "course-repository" );

        $schedule = $scheduleRepo->getByID( $this->params[ "id" ] );
        $courseSchedules = $courseScheduleRepo->getAllByScheduleID( $this->params[ "id" ] );
        $course_ids = [];
        $courses = [];
        $coursesByDay = [
            "monday" => [],
            "tuesday" => [],
            "wednesday" => [],
            "thrusday" => [],
            "friday" => [],
            "saturday" => [],
            "sunday" => []
        ];

        foreach ( $courseSchedules as $courseSchedule  ) {

            $course_ids[] = $courseSchedule->course_id;
            $course = $courseRepo->getByID( $courseSchedule->course_id );
            $courses[] = $course;

            switch ( $course->day ) {
                case "monday":
                    $coursesByDay[ "monday" ][] = $course;
                    break;
                case "tuesday":
                    $coursesByDay[ "tuesday" ][] = $course;
                    break;
                case "wednesday":
                    $coursesByDay[ "wednesday" ][] = $course;
                    break;
                case "thursday":
                    $coursesByDay[ "thursday" ][] = $course;
                    break;
                case "friday":
                    $coursesByDay[ "friday" ][] = $course;
                    break;
                case "saturday":
                    $coursesByDay[ "saturday" ][] = $course;
                    break;
                case "sunday":
                    $coursesByDay[ "sunday" ][] = $course;
                    break;
            }
        }

        if ( $input->exists() && $input->issetField( "remove_course" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "course_id" => [
                        "name" => "Course ID",
                        "required" => true,
                        "in_array" => $course_ids
                    ]
                ],

                "remove_course" /* error index */
            ) )
        {
            // Get the id of the courseSchedule with the submitted course_id and current schedule id
            foreach ( $courseSchedules as $courseSchedule ) {
                if ( $courseSchedule->course_id == $input->get( "course_id" ) ) {
                    $courseScheduleRepo->removeByID( $courseSchedule->id );
                }
            }

            $this->view->redirect( "account-manager/business/schedule/" . $this->params[ "id" ] . "/" );
        }

        $this->view->assign( "schedule", $schedule );
        $this->view->assign( "courses", $courses );
        $this->view->assign( "coursesByDay", $coursesByDay );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->setFlashMessages( $this->session->getFlashMessages( "flash_messages" ) );

        $this->view->setTemplate( "account-manager/business/schedule/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Schedule.php" );
    }


    public function newAction()
    {
        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/schedule/" . $this->params[ "id" ] . "/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $scheduleRepo = $this->load( "schedule-repository" );

        if ( $input->exists() && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "create_schedule" => [
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Schedule Name",
                        "required" => true,
                        "min" => 1,
                        "max" => 200,
                    ],
                    "description" => [
                        "name" => "Description",
                        "required" => true,
                        "min" => 1,
                        "max" => 1000
                    ]
                ],

                "create_schedule" /* error index */
            ) )
        {
            $schedule = $scheduleRepo->create( $this->business->id, $input->get( "name" ), $input->get( "description" ) );
            $this->view->redirect( "account-manager/business/schedule/" . $schedule->id . "/" );
        }

        $inputs = [];

        // update_landing_page
        if ( $input->issetField( "create_schedule" ) ) {
            $inputs[ "create_schedule" ][ "name" ] = $input->get( "name" );
            $inputs[ "create_schedule" ][ "description" ] = $input->get( "description" );
        }

        // Input values submitted from form
        $this->view->assign( "inputs", $inputs );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/schedule/new.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Schedule.php" );
    }

    public function editAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/schedules/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $scheduleRepo = $this->load( "schedule-repository" );
        $courseScheduleRepo = $this->load( "course-schedule-repository" );
        $courseRepository = $this->load( "course-repository" );

        // Get this schedules details
        $schedule = $scheduleRepo->getByID( $this->params[ "id" ] );

        if ( $input->exists() && $input->issetField( "update_schedule" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Schedule Name",
                        "required" => true,
                        "max" => 256
                    ],
                    "description" => [
                        "name" => "Description",
                        "max" => 1000
                    ]
                ],

                "update_schedule" /* error index */
            ) )
        {
            $scheduleRepo->updateByID( $this->params[ "id" ], $input->get( "name" ), $input->get( "description" ) );

            $this->view->redirect( "account-manager/business/schedule/" . $this->params[ "id" ] . "/edit" );
        }

        if ( $input->exists() && $input->issetField( "delete_schedule" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ]
                ],

                "delete_schedule" /* error index */
            ) )
        {
            $scheduleRepo->removeByID( $this->params[ "id" ] );
            $courseScheduleRepo->removeByScheduleID( $this->params[ "id" ] );

            $this->view->redirect( "account-manager/business/schedules/" );
        }

        $inputs = [];

        // update_landing_page
        if ( $input->issetField( "update_schedule" ) ) {
            $inputs[ "update_schedule" ][ "name" ] = $input->get( "name" );
            $inputs[ "update_schedule" ][ "description" ] = $input->get( "description" );
        }

        // Input values submitted from form
        $this->view->assign( "inputs", $inputs );

        $this->view->assign( "schedule", $schedule );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/schedule/edit.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Schedule.php" );
    }

    public function chooseClassAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/schedules/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $courseRepo = $this->load( "course-repository" );
        $scheduleRepo = $this->load( "schedule-repository" );
        $courseScheduleRepo = $this->load( "course-schedule-repository" );

        $schedule = $scheduleRepo->getByID( $this->params[ "id" ] );
        $courseSchedules = $courseScheduleRepo->getAllByScheduleID( $this->params[ "id" ] );

        $course_schedule_course_ids = [];

        foreach ( $courseSchedules as $courseSchedule ) {
            $course_schedule_course_ids[] = $courseSchedule->course_id;
        }

        $course_ids = [];
        $courses = [];
        $coursesByDay = [
            "monday" => [],
            "tuesday" => [],
            "wednesday" => [],
            "thrusday" => [],
            "friday" => [],
            "saturday" => [],
            "sunday" => []
        ];

        // Load all courses for business
        $courses = $courseRepo->getAllByBusinessID( $this->business->id );

        foreach ( $courses as $key => $course  ) {

            if ( !in_array( $course->id, $course_schedule_course_ids ) ) {
                $course_ids[] = $course->id;

                switch ( $course->day ) {
                    case "monday":
                        $coursesByDay[ "monday" ][] = $course;
                        break;
                    case "tuesday":
                        $coursesByDay[ "tuesday" ][] = $course;
                        break;
                    case "wednesday":
                        $coursesByDay[ "wednesday" ][] = $course;
                        break;
                    case "thursday":
                        $coursesByDay[ "thursday" ][] = $course;
                        break;
                    case "friday":
                        $coursesByDay[ "friday" ][] = $course;
                        break;
                    case "saturday":
                        $coursesByDay[ "saturday" ][] = $course;
                        break;
                    case "sunday":
                        $coursesByDay[ "sunday" ][] = $course;
                        break;
                }
            } else {
                unset( $courses[ $key ] );
            }
        }

        if ( $input->exists() && $input->issetField( "add_class" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "course_ids" => [
                        "name" => "Course",
                        "required" => true
                    ]
                ],

                "add_class" /* error index */
            ) )
        {
            // Verify that all course ids belong to businessness. If not, send
            $courseScheduleCount = 0;
            foreach ( $input->get( "course_ids" ) as $course_id ) {
                if ( in_array( $course_id, $course_ids ) ) {
                    $courseScheduleRepo->create( $course_id, $schedule->id );
                    $courseScheduleCount++;
                }
            }

            $this->session->addFlashMessage( "Classes Added ({$courseScheduleCount})");
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/schedule/" . $schedule->id . "/" );
        }

        $this->view->assign( "courses", $courses );
        $this->view->assign( "schedule", $schedule );
        $this->view->assign( "coursesByDay", $coursesByDay );

        // Redirect user to create a class if none exist
        if ( count( $courses ) < 1 ) {
            $this->view->redirect( "account-manager/business/schedule/" . $this->params[ "id" ] . "/create-class" );
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/schedule/choose-class.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Schedule.php" );
    }

    public function createClassAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/schedules/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $courseRepo = $this->load( "course-repository" );
        $scheduleRepo = $this->load( "schedule-repository" );
        $courseScheduleRepo = $this->load( "course-schedule-repository" );
        $disciplineRepo = $this->load( "discipline-repository" );

        $current_schedule = $scheduleRepo->getByID( $this->params[ "id" ] );
        $schedules = $scheduleRepo->getAllByBusinessID( $this->business->id );
        $schedules_ids = [];

        // Put all schedules_ids in an array to check that all submitted schedules ids submitted are valid
        foreach ( $schedules as $schedule ) {
            $schedule_ids[] = $schedule->id;
        }

        $disciplines = $disciplineRepo->getAll();
        $discipline_ids = [];

        // Put all discipline_ids in an array to check that all submitted discipline ids submitted are valid
        foreach ( $disciplines as $discipline ) {
            $discipline_ids[] = $discipline->id;
        }

        if ( $input->exists() && $input->issetField( "create_class" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Schedule Name",
                        "required" => true,
                        "min" => 1
                    ],
                    "description" => [
                        "name" => "Description",
                        "min" => 1,
                        "max" => 1000
                    ],
                    "discipline_id" => [
                        "name" => "Discipline ID",
                        "required" => true,
                        "in_array" => $discipline_ids
                    ],
                    "day" => [
                        "name" => "Weekday",
                        "required" => true,
                        "in_array" => [ "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday" ]
                    ],
                    "start_Hour" => [
                        "required" => true
                    ],
                    "start_Minute" => [
                        "required" => true
                    ],
                    "start_Meridian" => [
                        "required" => true
                    ],
                    "end_Hour" => [
                        "required" => true
                    ],
                    "end_Minute" => [
                        "required" => true
                    ],
                    "end_Meridian" => [
                        "required" => true
                    ],
                    "schedule_ids" => [
                        "name" => "Schedule ID",
                        "is_array" => true
                    ]
                ],

                "create_class" /* error index */
            ) )
        {
            $start_time = $input->get( "start_Hour" ) . ":" . $input->get( "start_Minute" ) . $input->get( "start_Meridian" );
            $end_time = $input->get( "end_Hour" ) . ":" . $input->get( "end_Minute" ) . $input->get( "end_Meridian" );

            $course = $courseRepo->create( $this->business->id, $input->get( "discipline_id" ), trim( $input->get( "name" ) ), trim( $input->get( "description" ) ), $input->get( "day" ), $start_time, $end_time );
            foreach ( $input->get( "schedule_ids" ) as $schedule_id ) {
                $courseScheduleRepo->create( $course->id, $schedule_id );
            }

            $this->session->addFlashMessage( "Class created" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/schedule/" . $this->params[ "id" ] . "/" );
        }

        $this->view->assign( "current_schedule", $current_schedule );
        $this->view->assign( "schedules", $schedules );
        $this->view->assign( "disciplines", $disciplines );
        $this->view->assign( "weekdays", [ "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday" ] );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/schedule/create-class.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Schedule.php" );
    }

}
