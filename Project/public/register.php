<?php
function loadTemplae($templateFileName, $variables = []) {
    extract($variables);

    ob_start();
    include __DIR__ . '/../templates/' . $templateFileName;

    return ob_get_clean();
}

try {

    $controllerName = $_GET['controller'] ?? 'joke';
    $controllerName = ucfirst($_GET['controller']) . 'Controller';

    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../classes/DatabaseTable.php';
    include __DIR__ . '/../controllers/' . $controllerName . '.php';

    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');
    $Controller = new RegigsterController($authorsTable);

    $action = $_GET['action'] ?? 'home';

    if ($action == strtolower($action) && $controllerName == strtolower($controllerName)) {
        $page = $Controller->$action();
    } else {
        http_response_code(301);
        header('location: index.php?action=' . strtolower($action));
    }

    $page = $Controller->$action();

    $title = $page['title'];

    if (isset($page['variables'])) {
        $output = loadTemplae($page['template'], $page['variables']);
    } else {
        $output = loadTemplae($page['template']);
    }

} catch (PDOException $e) {
    $title = '오류가 발생했습니다';

    $output = '데이터베이스 오류: ' . $e->getMessage() . ', 위치: ' .
        $e->getFile() . ':' . $e->getLine();
}

include  __DIR__ . '/../templates/layout.html.php';