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
     * @var ModelTinderViews
     */
    private $modelViews;

    /**
     *
     * @var ModelTinderLikes
     */
    private $modelLikes;

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

        $this->modelViews = new ModelTinderViews($db, 'tinderviews');
        $this->modelLikes = new ModelTinderLikes($db, 'tinderlikes');

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
        $viewed_records = $this->modelViews->load($this->user->getEmail());
        foreach ($viewed_records as $record) {
            $this->viewed[$record['email_user_viewed']] = $record['email_user_viewed'];
        }

        return $this->viewed;
    }

    public function loadLikedEmails($email) {
        $emails = [];
        $liked_records = $this->modelLikes->load($email);
        foreach ($liked_records as $record) {
            $emails[$record['email_user_likes']] = $record['email_user_likes'];
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
            $email = end($this->viewed);
            return $this->repo->load($email);
        }
    }

    //View next user
    public function userViewNext() {
        foreach ($this->repo->loadAll() as $user) {
            if ($this->user->getEmail() != $user->getEmail()) {
                if (!in_array($user->getEmail(), $this->viewed) && $this->user->getGender() != $user->getGender()) {
                    $this->viewed[] = $user->getEmail();
                    $this->modelViews->insert($this->user->getEmail(), $user->getEmail());
                    return $user;
                }
            }
        }
    }

    public function userLike() {
        $user = $this->userViewLast();
        $this->modelLikes->insert($this->user->getEmail(), $user->getEmail());
        // if ($user->tryMatch()) {
        //    $this->matches[] = $user;
        //}
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
