<?php

require_once __DIR__ . "/middlewares/JsonMiddleware.php";
require_once __DIR__ . "/controllers/PatientController.php";

jsonMiddleware();

$method = $_SERVER["REQUEST_METHOD"];

$request = $_GET["request"] ?? "";

$request = trim($request, "/");

$parts = $request === "" ? [] : explode("/", $request);

$resource = $parts[0] ?? "";

$id = isset($parts[1]) ? $parts[1] : null;

$controller = new PatientController();


/*
|--------------------------------------------------------------------------
| GET /api/patients
|--------------------------------------------------------------------------
*/

if ($method === "GET" && $resource === "patients" && $id === null) {

    $controller->getAllPatients();

}


/*
|--------------------------------------------------------------------------
| GET /api/patients/{id}
|--------------------------------------------------------------------------
*/

elseif ($method === "GET" && $resource === "patients" && $id !== null) {

    $controller->getPatientById($id);

}


/*
|--------------------------------------------------------------------------
| POST /api/patients
|--------------------------------------------------------------------------
*/

elseif ($method === "POST" && $resource === "patients" && $id === null) {

    $controller->createPatient();

}


/*
|--------------------------------------------------------------------------
| PUT /api/patients/{id}
|--------------------------------------------------------------------------
*/

elseif ($method === "PUT" && $resource === "patients" && $id !== null) {

    $controller->updatePatient($id);

}


/*
|--------------------------------------------------------------------------
| DELETE /api/patients/{id}
|--------------------------------------------------------------------------
*/

elseif ($method === "DELETE" && $resource === "patients" && $id !== null) {

    $controller->deletePatient($id);

}


/*
|--------------------------------------------------------------------------
| Invalid route
|--------------------------------------------------------------------------
*/

else {

    sendResponse(
        404,
        false,
        "Endpoint not found"
    );

}

?>