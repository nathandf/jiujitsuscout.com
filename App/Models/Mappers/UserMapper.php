<?php

namespace Models\Mappers;

use Models\User;

class UserMapper extends DataMapper
{

    public function create( User $user )
    {
        $id = $this->insert(
            "user",
            [ "first_name", "last_name", "email", "phone_id", "role", "account_id", "current_business_id", "password", "terms_conditions_agreement" ],
            [ $user->first_name, $user->last_name, $user->email, $user->phone_id, $user->role, $user->account_id, $user->current_business_id, $user->password, $user->terms_conditions_agreement ]
        );
        $user->id = $id;

        return $user;
    }

  public function mapAll()
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $users = [];
    $sql = $this->DB->prepare( "SELECT * FROM user" );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $user = $entityFactory->build( "User" );
      $this->populateUser( $user, $resp );
      $users[] = $user;
    }

    return $users;
  }

  public function mapFromID( User $user, $id )
  {
    $sql = $this->DB->prepare( "SELECT * FROM user WHERE id = :id" );
    $sql->bindParam( ":id", $id );
    $sql->execute();
    $resp = $sql->fetch( \PDO::FETCH_ASSOC );
    $this->populateUser( $user, $resp );
    return $user;
  }

  public function mapFromToken( User $user, $token )
  {
    $resp = $this->getAllWhere( "user", "token", $token );
    $this->populateUser( $user, $resp );
    return $user;
  }

  public function mapFromEmail( User $user, $email )
  {
    $resp = $this->getAllWhere( "user", "email", $email );
    $this->populateUser( $user, $resp );
    return $user;
  }

  public function mapAllFromAccountID( $account_id )
  {
    $entityFactory = $this->container->getService( "entity-factory" );
    $users = [];
    $sql = $this->DB->prepare( 'SELECT * FROM user WHERE account_id = :account_id' );
    $sql->bindParam( ":account_id", $account_id );
    $sql->execute();
    while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
      $user = $entityFactory->build( "user" );
      $this->populateUser( $user, $resp );
      $users[] =  $user;
    }

    return $users;
  }

    public function getAllEmails()
    {
        $emails = [];
        $sql = $this->DB->prepare( "SELECT email FROM user" );
        $sql->execute();

        while ( $resp = $sql->fetch( \PDO::FETCH_ASSOC ) ) {
            $emails[] = $resp[ "email" ];
        }

        return $emails;
    }

  public function updateUserByID( $id, $prospect )
  {
      $this->update( "user", "first_name", $prospect->first_name, "id", $id );
      $this->update( "user", "last_name", $prospect->last_name, "id", $id );
      $this->update( "user", "email", $prospect->email, "id", $id );
  }

  public function updatePhoneIDByID( $phone_id, $id )
  {
    $this->update( "user", "phone_id", $phone_id, "id", $id );
  }

  public function updateAddressIDByID( $address_id, $id )
  {
    $this->update( "user", "address_id", $address_id, "id", $id );
  }

  public function updateTokenByID( $token, $id )
  {
    $this->update( "user", "token", $token, "id", $id );
  }

  public function updateTokenByEmail( $token, $email )
  {
    $this->update( "user", "token", $token, "email", $email );
  }

  public function updateCurrentBusinessIDByID( $business_id, $user_id )
  {
    $this->update( "user", "current_business_id", $business_id, "id", $user_id );
  }

    public function updatePasswordByID( $password, $id )
    {
        $this->update( "user", "password", $password, "id", $id );
    }

  public function updatePassword( $id, $email_to_verify, $new_password )
  {
    $user_email = $this->get( $id, "email" )[ "email" ];
  	if ( $user_email != $email_to_verify ) {
  		return false;
  	} else {
  		$new_password = password_hash( $new_password, PASSWORD_BCRYPT );
  		$sql = $this->DB->prepare( 'UPDATE business_user SET password = :password WHERE id = :id' );
  		$sql->bindParam(':id', $id);
  		$sql->bindParam(':password', $new_password);
  		$sql->execute();
      return true;
    }
  }

  public function deleteByID( $id ) {
    $sql = $this->DB->prepare('DELETE FROM business_user WHERE id = :id');
    $sql->bindParam(':id', $id);
    $sql->execute();
  }

  public function checkEmailAvailability( $email_to_check )
	{
		$unavailable_emails = [];
		$email_to_check = strtolower( $email_to_check );
    $emails = $this->getAllColumn( "email" );
		foreach ( $emails as $email ) {
			$unavailable_emails[] = strtolower( trim( $email ) );
		}

		if ( !in_array( $email_to_check, $unavailable_emails ) ) {
			return true;
		} else {
			return false;
		}
	}

    private function populateUser( \Models\User $user, $data )
    {
        $user->id = $data[ "id" ];
        $user->user_type = $data[ "user_type" ];
        $user->first_name = $data[ "first_name" ];
        $user->last_name = $data[ "last_name" ];
        $user->email = $data[ "email" ];
        $user->phone_id = $data[ "phone_id" ];
        $user->role = $data[ "role" ];
        $user->account_id = $data[ "account_id" ];
        $user->current_business_id = $data[ "current_business_id" ];
        $user->password = $data[ "password" ];
        $user->token = $data[ "token" ];
    }


}
