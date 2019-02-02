<?php

namespace Model\Services;

class QuickBoi
{
    private $id_string;
    private $application_namespace;
    private $entity_namepsace;
    private $entity_class_name;
    private $entity_properties = [];
    private $mapper_namespace;
    private $mapper_class_name;
    private $repository_class_name;
    private $repository_namespace;

    public function buildModel( $model_name )
    {
        $this->buildModelNames( $model_name );
        $this->createEntityFile();
        $this->createRepositoryFile();
        $this->createMapperFile();
    }

    public function buildModelNames( $model_name )
    {
        if ( preg_match( "/[^a-zA-Z -]/", $model_name ) ) {
            throw new \Exception( "String can only contain characters a-z upper or lower case, spaces, and hyphens (-)" );
        }

        // Create the string with which classes will be registered with the container
        // and with which class names and tables will be built.
        $id_string = $this->formatIdString( $model_name );
        $this->setIdString( $id_string );

        // build entity, repository, and mapper class name
        $this->setEntityClassName( $this->formatClassNameFromIdString( $id_string ) )
            ->setRepositoryClassName( $this->formatClassNameFromIdString( $id_string ) )
            ->setMapperClassName( $this->formatClassNameFromIdString( $id_string ) );
    }

    public function setApplicationNamespace( $namespace )
    {
        $this->application_namespace = $namespace;
        return $this;
    }

    private function getApplicationNamespace()
    {
        if ( isset( $this->application_namespace ) === false ) {
            throw new \Exception( "Application namespace has not been set" );
        }

        return $this->application_namespace;
    }

    private function formatIdString( $string )
    {
        return strtolower( preg_replace( "/[-]+/", "-", preg_replace( "/[\s]+/", "-", trim( $string ) ) ) );
    }

    private function setIdString( $string )
    {
        $this->id_string = $string;
        return $this;
    }

    private function formatClassNameFromIdString( $id_string )
    {
        return str_replace( " ", "", ucwords( str_replace( "-", " ", $id_string ) ) );
    }

    public function setEntityNamespace( $namespace )
    {
        $this->entity_namespace = $namespace;
        return $this;
    }

    public function getEntityNamespace()
    {
        if ( !isset( $this->entity_namespace ) ) {
            throw new \Exception( "Entity namespace has not been set" );
        }

        return $this->entity_namespace;
    }

    public function setEntityClassName( $name )
    {
        $this->entity_class_name = $name;
        return $this;
    }

    public function setRepositoryNamespace( $namespace )
    {
        $this->repository_namespace = $namespace;
        return $this;
    }

    public function getRepositoryNamespace()
    {
        if ( !isset( $this->repository_namespace ) ) {
            throw new \Exception( "Repository namespace has not been set" );
        }

        return $this->repository_namespace;
    }

    private function setRepositoryClassName( $name )
    {
        $this->repository_class_name = $name . "Repository";
        return $this;
    }

    public function setMapperNamespace( $namespace )
    {
        $this->mapper_namespace = $namespace;
        return $this;
    }

    public function getMapperNamespace()
    {
        if ( !isset( $this->mapper_namespace ) ) {
            throw new \Exception( "Mapper namespace has not been set" );
        }

        return $this->mapper_namespace;
    }

    private function setMapperClassName( $name )
    {
        $this->mapper_class_name = $name . "Mapper";
        return $this;
    }

    private function formatDirnameFromClassName( $class_name )
    {
        $dirname = str_replace( "\\", "/", $class_name );
        return $dirname;
    }

    private function checkFile( $filename )
    {
        if ( file_exists( $filename ) ) {
            throw new \Exception( "Entity already exists" );
        }

        return;
    }

    private function createFile( $filename, $contents )
    {
        $this->checkFile( $filename, $contents );
        file_put_contents( $filename, $contents );
    }

    private function createEntityFile()
    {
        $filename = $this->formatDirnameFromClassName( $this->getApplicationNamespace() ) . "/" . $this->formatDirnameFromClassName( $this->entity_namespace ) . "/" . $this->entity_class_name . ".php";
        $filename = "./" . preg_replace( "/[\/]+/", "/", $filename );

        $contents = "<?php\n\nnamespace {$this->getEntityNamespace()};\n\nuse Contracts\EntityInterface;\n\nclass {$this->entity_class_name} implements EntityInterface\n{\n\n}";

        $this->createFile( $filename, $contents );
    }

    private function createRepositoryFile()
    {
        $filename = $this->formatDirnameFromClassName( $this->getApplicationNamespace() ) . "/" . $this->formatDirnameFromClassName( $this->repository_namespace ) . "/" . $this->repository_class_name . ".php";
        $filename = "./" . preg_replace( "/[\/]+/", "/", $filename );

        $contents = "<?php\n\nnamespace {$this->getRepositoryNamespace()};\n\nclass {$this->repository_class_name} extends Repository\n{\n\n}";

        $this->createFile( $filename, $contents );
    }

    private function createMapperFile()
    {
        $filename = $this->formatDirnameFromClassName( $this->getApplicationNamespace() ) . "/" . $this->formatDirnameFromClassName( $this->mapper_namespace ) . "/" . $this->mapper_class_name . ".php";
        $filename = "./" . preg_replace( "/[\/]+/", "/", $filename );

        $contents = "<?php\n\nnamespace {$this->getMapperNamespace()};\n\nclass {$this->mapper_class_name} extends DataMapper\n{\n\n}";

        $this->createFile( $filename, $contents );
    }

    public function addEntityPropery( array $property )
    {
        $this->entity_properties[] = $property;
    }

    public function getEntityProp()
    {
        return $this->entity_properties;
    }
}
