<?php

try {
  include __DIR__ . '/../includes/DatabaseConnection.php';
  include __DIR__ . '/../classes/DatabaseTable.php';

  //include __DIR__ . '/../includes/DatabaseFunctions.php';
  $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
  $authorsTable = new DatabaseTable($pdo, 'author', 'id');
  $result = $jokesTable->findAll();

  $jokes = [];
  foreach ($result as $joke) {
      $author = $authorsTable->findById($joke['authorId']);
      $jokes[] = [
        'id' => $joke['id'],
        'joketext' => $joke['joketext'],
        'jokedate' => $joke['jokedate'],
        'name' => $author['name'],
        'email' => $author['email']
      ];
  }

  $title = '유머 글 목록';

  $totalJokes = $jokesTable->total();

  ob_start();

  include  __DIR__ . '/../templates/jokes.html.php';

  $output = ob_get_clean();

}
catch (PDOException $e) {
  $title = '오류가 발생했습니다';

  $output = '데이터베이스 오류: ' . $e->getMessage() . ', 위치: ' .
  $e->getFile() . ':' . $e->getLine();
}

include  __DIR__ . '/../templates/layout.html.php';