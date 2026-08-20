<?php

require_once __DIR__ . "/../config/database.php";

class Patient
{
    private mysqli $conn;

    public function __construct()
    {
        global $conn;

        $this->conn = $conn;
    }

    // Get all patients
    public function getAllPatients(): array
    {
        $sql = "SELECT * FROM patients ORDER BY id DESC";

        $result = $this->conn->query($sql);

        $patients = [];

        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }

        return $patients;
    }

    // Get patient by ID
    public function getPatientById(int $id): ?array
    {
        $sql = "SELECT * FROM patients WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        $patient = $result->fetch_assoc();

        return $patient ?: null;
    }

    // Create patient
    public function createPatient(array $data): int
    {
        $sql = "
            INSERT INTO patients
            (name, age, gender, phone)
            VALUES (?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "siss",
            $data["name"],
            $data["age"],
            $data["gender"],
            $data["phone"]
        );

        $stmt->execute();

        return $this->conn->insert_id;
    }

    // Update patient
    public function updatePatient(int $id, array $data): bool
    {
        $sql = "
            UPDATE patients
            SET name = ?, age = ?, gender = ?, phone = ?
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sissi",
            $data["name"],
            $data["age"],
            $data["gender"],
            $data["phone"],
            $id
        );
        
        return $stmt->execute();
    }

    // Delete patient
    public function deletePatient(int $id): bool
    {
        $sql = "DELETE FROM patients WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>