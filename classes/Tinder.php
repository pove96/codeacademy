<?php

class Tinder {

    private $users;
    private $matches;

    /**
     *  Mysql Database Instance
     * @var type MysqlDatabase
     */
    private $db;

    /**
     * User Repository Class Injection
     * @var UserRepository
     */
    private $repo;

    /**
     * Session Class Injection
     * @var Session
     */
    private $session;

    /**
     * Current User
     * @var User
     */
    private $user;

    /**
     *
     * @var ModelTinderData
     */
    private $modelData;

    /**
     *  Array of liked User objects
     * @var User[]
     */
    private $liked;

    /**
     *  Array of viewed User objects
     * @var User[]
     */
    private $viewed;

    public function __construct(MysqlDatabase $db, UserRepository $repo, Session $session) {
        $this->db = $db;
        $this->repo = $repo;
        $this->session = $session;

        $this->modelData = new ModelTinderData($db, 'tinder_data');

        $this->viewed = [];
        $this->liked = [];
        $this->matches = [];

        $this->user = $session->getCurrentUser();
        if ($this->user) {
            $this->viewed = $this->loadViewedEmails();
            $this->liked = $this->loadLikedEmails($this->user->getEmail());
        }
    }

    public function loadViewedEmails() {
        $viewed_records = $this->modelData->load($this->user->getEmail());
        foreach ($viewed_records as $record) {
            $this->viewed[$record['email_user_viewed']] = $record['email_user_viewed'];
        }

        return $this->viewed;
    }

    public function loadLastViewedEmail() {
        $records = $this->modelData->loadByAction($this->user->getEmail(), '');
        if (!empty($records)) {
            return end($records)['email_user_viewed'];
        }

        return null;
    }

    public function loadLikedEmails($email) {
        $emails = [];
        $liked_records = $this->modelData->loadByAction($email, 'like');
        foreach ($liked_records as $record) {
            $emails[$record['email_user_viewed']] = $record['email_user_viewed'];
        }

        return $emails;
    }

    //View last user you have seen (if no botton pressed return same user)
    /**
     * 
     * @return Girl
     */
    public function userViewLast() {

        if (empty($this->viewed)) {
            return $this->userViewNext();
        } else {
            return $this->repo->load($this->loadLastViewedEmail());
        }
    }

    //View next user
    public function userViewNext() {
        foreach ($this->repo->loadAll() as $user) {
            if ($this->user->getEmail() != $user->getEmail()) {
                if (!in_array($user->getEmail(), $this->viewed) && $this->user->getGender() != $user->getGender()) {
                    $this->viewed[] = $user->getEmail();
                    $this->modelData->insert($this->user->getEmail(), $user->getEmail(), '');
                    return $user;
                }
            }
        }
    }

    public function userLike() {
        $user = $this->userViewLast();
        if ($user) {
            $this->modelData->update($this->user->getEmail(), $user->getEmail(), 'like');
            $this->liked[] = $this->user->getEmail();
        }
    }

    public function userDislike() {
        $user = $this->userViewLast();
        $this->modelData->update($this->user->getEmail(), $user->getEmail(), 'dislike');
    }

    public function getMatches() {
        $this->matches = [];
        foreach ($this->liked as $email) {
            $user_liked_emails = $this->loadLikedEmails($email);
            if (in_array($this->user->getEmail(), $user_liked_emails)) {
                $this->matches[] = $this->repo->load($email);
            }
        }

        return $this->matches;
    }

}
