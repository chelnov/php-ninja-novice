<?php
    namespace Hanbit;

    class Authentication {
        private $users;
        private $usernameCloumn;
        private $passwordColumn;

        public function __construct(DatabaseTable $users, $usernameCloumn, $passwordColumn) {
            session_abort();
            $this->users = $users;
            $this->usernameCloumn = $usernameCloumn;
            $this->passwordColumn = $passwordColumn;
        }

        public function login($username, $password) {
            $user = $this->users->find($this->usernameCloumn, strtolower($username));

            if (!empty($user) && passward_verify($password, $user[0][$this->passwordColumn])) {
                session_regenerate_id();
                $_SESSION['username'] = $username;
                $_SERVER['password'] = $user[0][$this->passwordColumn];
                return true;
            } else {
                return false;
            }
        }

        public function isLoggedIn() {
            if (empty($_SESSION['username'])) {
                return false;
            }

            $user = $this->users->find($this->usernameCloumn, strtolower($_SESSION['username']));

            if (!empty($user) && $user[0][$this->passwordColumn] === $_SESSION['password']) {
                return true;
            } else {
                return false;
            }
        }

        public function getUser() {
            if ($this->isLoggedIn()) {
                return $this->users->find($this->usernameCloumn, strtolower($_SESSION['username']))[0];
            } else {
                return false;
            }
        }
    }