<?php

require_once __DIR__ . "/../models/Patient.php";
require_once __DIR__ . "/../helpers/Response.php";

class PatientController
{
    private Patient $patient;

    public function __construct()
    {
        $this->patient = new Patient();
    }

    // GET /api/patients
    public function getAllPatients(): void
    {
        $patients = $this->patient->getAllPatients();

        sendResponse(
            200,
            true,
            "Patients fetched successfully",
            $patients
        );
    }

    // GET /api/patients/{id}
    public function getPatientById(int $id): void
    {
            if (!ctype_digit((string)$id)) {
        sendResponse(400, false, "Invalid patient ID");
        }
        

        $id = (int) $id;

        $patient = $this->patient->getPatientById($id);

        if ($patient === null) {
            sendResponse(
                404,
                false,
                "Patient not found"
            );
        }

        sendResponse(
            200,
            true,
            "Patient fetched successfully",
            $patient
        );
    }

    // POST /api/patients
    public function createPatient(): void
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if (
            !isset($data["name"]) ||
            !isset($data["age"]) ||
            !isset($data["gender"]) ||
            !isset($data["phone"])
        ) {
            sendResponse(
                400,
                false,
                "All patient fields are required"
            );
        }

        $id = $this->patient->createPatient($data);

        sendResponse(
            201,
            true,
            "Patient created successfully",
            ["id" => $id]
        );
    }

    // PUT /api/patients/{id}
    public function updatePatient(int $id): void
    {
        $existingPatient = $this->patient->getPatientById($id);

        if ($existingPatient === null) {
            sendResponse(
                404,
                false,
                "Patient not found"
            );
        }

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if (
            !isset($data["name"]) ||
            !isset($data["age"]) ||
            !isset($data["gender"]) ||
            !isset($data["phone"])
        ) {
            sendResponse(
                400,
                false,
                "All patient fields are required"
            );
        }

        $updated = $this->patient->updatePatient($id, $data);

        if (!$updated) {
            sendResponse(
                400,
                false,
                "Failed to update patient"
            );
        }

        sendResponse(
            200,
            true,
            "Patient updated successfully"
        );
    }

    // DELETE /api/patients/{id}
    public function deletePatient(int $id): void
    {
        $existingPatient = $this->patient->getPatientById($id);

        if ($existingPatient === null) {
            sendResponse(
                404,
                false,
                "Patient not found"
            );
        }

        $deleted = $this->patient->deletePatient($id);

        if (!$deleted) {
            sendResponse(
                400,
                false,
                "Failed to delete patient"
            );
        }

        sendResponse(
            200,
            true,
            "Patient deleted successfully"
        );
    }
}

?>