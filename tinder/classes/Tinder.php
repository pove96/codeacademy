<?php

class Tinder {

    private $users;
    private $matches;

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
     *
     * @var User
     */
    private $user;
    private $liked;
    private $viewed;

    public function __construct(UserRepository $repo, Session $session) {
        $this->viewed = [];
        $this->matches = [];
        $this->repo = $repo;
        $this->session = $session;
        $this->user = $session->getCurrentUser();
        if ($this->user) {
            $data = $this->user->getData();
            $this->viewed = $data['viewed'] ?? [];
            $this->liked = $data['liked'] ?? [];
        }
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
            return $this->repo->loadUser($email);
        }
    }

    //View next user
    public function userViewNext() {
        foreach ($this->repo->loadAllUsers() as $user) {
            if ($this->user->getEmail() != $user->getEmail()) {
                if (!in_array($user->getEmail(), $this->viewed)
                        && $this->user->getDataItem('gender') != $user->getDataItem('gender')) {
                    $this->viewed[] = $user->getEmail();
                    return $user;
                }
            }
        }
    }

    public function userLike() {
        $user = $this->userViewLast();
        $this->liked[$user->getEmail()] = $user->getEmail();
        //  if ($user->tryMatch()) {
        //     $this->matches[] = $user;
        // }
    }

    public function getMatches() {
        $this->matches = [];
        foreach ($this->liked as $email) {
            $likedUser = $this->repo->loadUser($email);
            $user_likes = $likedUser->getDataItem('liked') ?? [];
            if (in_array($this->user->getEmail(), $user_likes)) {
                $this->matches[] = $likedUser;
            }
        }

        return $this->matches;
    }

    //Load the data from a file
    public function load() {
//        $data = $this->db->load();
//
//        $this->viewed = $data['viewed'] ?? [];
//        $this->matches = $data['matches'] ?? [];
    }

//Save data to cookies
    public function save() {
        $this->user->setDataItem('viewed', $this->viewed);
        $this->user->setDataItem('liked', $this->liked);
        $this->repo->updateUser($this->user);
    }

    public function delete() {
        //  $this->db->delete();
    }

}
