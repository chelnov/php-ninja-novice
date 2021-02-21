<?php
    namespace Ijdb\Controllers;
    use \Hanbit\DatabaseTable;
    use \Hanbit\Authentication;

    class Joke {
        private $authorsTable;
        private $jokesTable;
        private $authentication;

        public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, Authentication $authentication) {
            $this->jokesTable = $jokesTable;
            $this->authorsTable = $authorsTable;
            $this->authentication = $authentication;
        }

        public function list() {
            $result = $this->jokesTable->findAll();
            $jokes = [];
            foreach ($result as $joke) {
                $author = $this->authorsTable->findById($joke['authorId']);
                $jokes[] = [
                  'id' => $joke['id'],
                    'joketext' => $joke['joketext'],
                    'jokedate' => $joke['jokedate'],
                    'name' => $author['name'],
                    'email' => $author['email']
                ];
            }

            $title = '유머 글 목록';

            $totalJokes = $this->jokesTable->total();

            return ['template' => 'jokes.html.php',
                    'title' => $title,
                    'variables' => [
                        'totalJokes' => $totalJokes,
                        'jokes' => $jokes

                     ]
                   ];
        }

        public function home() {
            $title = '인터넷 유머 세상';

            return ['template' => 'home.html.php', 'title' => $title];
        }

        public function delete() {
            $this->jokesTable->delete($_POST['id']);

            header('location: index.php?action=list');
        }

        public function saveEdit() {
            $author = $this->authentication->getUser();

            $joke = $_POST['joke'];
            $joke['jokedate'] = new \DateTime();
            $joke['authorId'] = $author['id'];

            $this->jokesTable->save($joke);

            header('location: /joke/list');
        }

        public function edit() {
            if (isset($_GET['id'])) {
                $title = '유머 글 수정';
                $joke = $this->jokesTable->findById($_GET['id']);
            } else {
                $title = '유머 글 작성!';
                $joke = [];
                $joke['id'] = '';
                $joke['joketext'] = '';
            }

            return ['template' => 'editjoke.html.php', 'title' => $title,
                    'variables' => [
                        'joke' => $joke ?? null
                    ]
            ];
        }
    }
