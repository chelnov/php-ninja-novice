<?php
include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../classes/DatabaseTable.php';

$jokesTable = new DatabaseTable($pdo, 'joke', 'id');

try {
		if (isset($_POST['joketext'])) {
                $joke = $_POST['joketext'];
                $joke['jokedate'] = new DateTime();
                $joke['authorId'] = 1;

		        $jokesTable->save($joke);

		header('location: jokes.php');

    	} else {

	        if (isset($_GET['id'])) {
	           $joke = $jokesTable->findById($_GET['id']);
        }
		    $title = '유머 글 수정';

		    ob_start();

		    include  __DIR__ . '/../templates/editjoke.html.php';

		    $output = ob_get_clean();
	   }
}
catch (PDOException $e) {
	$title = '오류가 발생했습니다';

	$output = '데이터베이스 오류: ' . $e->getMessage() . ', 위치: ' .
	$e->getFile() . ':' . $e->getLine();
}

include  __DIR__ . '/../templates/layout.html.php';