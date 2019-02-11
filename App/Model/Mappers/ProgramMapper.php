<?php

namespace Model\Mappers;

class ProgramMapper extends DataMapper
{
    public function mapAll()
    {
        $programs = [];
        $sql = $this->DB->prepare( "SELECT * FROM program" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $program = $this->entityFactory->build( "Program" );
            $program->id               = $resp[ "id" ];
            $program->name             = $resp[ "name" ];
            $program->nice_name        = $resp[ "nice_name" ];
            $program->abbreviation     = $resp[ "abbreviation" ];
            $programs[] = $program;
        }

        return $programs;
    }
}
