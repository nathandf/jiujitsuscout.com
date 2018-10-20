<?php

namespace Controllers;

use \Core\Controller;

class Disciplines extends Controller
{

    public function before()
    {

    }

    public function indexAction()
    {
        $disciplineRepo = $this->load( "discipline-repository" );
        $disciplines = $disciplineRepo->getAll();

        foreach ( $disciplines as $discipline ) {
            $discipline->url = preg_replace( "/[ ]/", "-", $discipline->name );
        }

        $this->view->assign( "disciplines", $disciplines );
        $this->view->setTemplate( "disciplines/home.tpl" );
        $this->view->render( "App/Views/Disciplines.php" );
    }

    public function disciplineAction()
    {
        $disciplineRepo = $this->load( "discipline-repository" );
        $discipline = $disciplineRepo->getByName( preg_replace( "/[-]+/", " ", $this->params[ "discipline" ] ) );

        $this->view->assign( "discipline", $discipline );
        $this->view->setTemplate( "disciplines/discipline.tpl" );
        $this->view->render( "App/Views/Disciplines.php" );
    }

    public function nearMeAction()
    {
        $disciplineRepo = $this->load( "discipline-repository" );
        $discipline = $disciplineRepo->getByName( preg_replace( "/[-]+/", " ", $this->params[ "discipline" ] ) );

        $this->view->assign( "discipline", $discipline );
        $this->view->setTemplate( "disciplines/discipline.tpl" );
        $this->view->render( "App/Views/Disciplines.php" );
    }
}
