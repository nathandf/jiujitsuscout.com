<?php

namespace Model\Services;

use \Model\Services\UserRepository;
use \Model\Services\AccountUserRepository;
use \Model\Services\BusinessUserRepository;
use \Model\Services\LandingPageNotificationRecipientRepository;
use \Model\Services\UserEmailSignatureRepository;
use \Model\Services\NoteRepository;
/**
* Class UserDestroyer
*
* @package Model\Services
*
* @property \Model\Services\UserRepository
* @property \Model\Services\AccountUserRepository
* @property \Model\Services\BusinessUserRepository
* @property \Model\Services\LandingPageNotificationRecipientRepository
* @property \Model\Services\UserEmailSignatureRepository
* @property \Model\Services\NoteRepository
*/

class UserDestroyer
{
    public function __construct(
        UserRepository $userRepo,
        AccountUserRepository $accountUserRepo,
        BusinessUserRepository $businessUserRepo,
        LandingPageNotificationRecipientRepository $landingPageNotificationRecipientRepo,
        UserEmailSignatureRepository $userEmailSignatureRepository,
        NoteRepository $noteRepo
    ) {
        $this->userRepo = $userRepo;
        $this->accountUserRepo = $accountUserRepo;
        $this->businessUserRepo = $businessUserRepo;
        $this->landingPageNotificationRecipientRepo = $landingPageNotificationRecipientRepo;
        $this->userEmailSignatureRepository = $userEmailSignatureRepository;
        $this->noteRepo = $noteRepo;
    }

    public function destroy( $user_id )
    {
        $this->userRepo->delete( [ "id" ], [ $user_id ] );
        $this->accountUserRepo->delete( [ "user_id" ], [ $user_id ] );
        $this->businessUserRepo->delete( [ "user_id" ], [ $user_id ] );
        $this->landingPageNotificationRecipientRepo->delete( [ "user_id" ], [ $user_id ] );
        $this->userEmailSignatureRepository->delete( [ "user_id" ], [ $user_id ] );
        $this->noteRepo->delete( [ "user_id" ], [ $user_id ] );
    }
}
