# Patient Management REST API

A lightweight RESTful API for managing patient records, built using **Core PHP and MySQL** without any framework.

The project demonstrates REST API architecture, HTTP methods, JSON communication, URL routing, middleware, HTTP status codes, database CRUD operations, and API testing.

---

## Features

* RESTful API architecture
* Patient CRUD operations
* Core PHP with no framework
* MySQL database integration
* JSON request and response handling
* HTTP status code handling
* Centralized JSON response helper
* JSON middleware
* `.htaccess` URL rewriting
* MVC-style separation of concerns
* Prepared statements for database queries
* API testing with Thunder Client

---

## Tech Stack

| Technology     | Purpose                 |
| -------------- | ----------------------- |
| PHP            | Backend API development |
| MySQL          | Database                |
| Apache         | Web server              |
| JSON           | API data format         |
| Thunder Client | API testing             |
| `.htaccess`    | URL rewriting           |

---

## Project Structure

patient-api/
│
├── api/
│   ├── index.php
│   │
│   ├── config/
│   │   └── database.php
│   │
│   ├── controllers/
│   │   └── PatientController.php
│   │
│   ├── models/
│   │   └── Patient.php
│   │
│   ├── middlewares/
│   │   └── JsonMiddleware.php
│   │
│   └── helpers/
│       └── Response.php
│
├── .htaccess
└── README.md

### Architecture

The API follows a simple layered architecture:

Client
  │
  │ HTTP Request
  ▼
.htaccess
  │
  ▼
index.php
  │
  ▼
JSON Middleware
  │
  ▼
Controller
  │
  ▼
Model
  │
  ▼
MySQL
  │
  ▼
JSON Response
  │
  ▼
Client

---

## Database

### Database

hospital_db

### Patients Table

CREATE DATABASE hospital_db;


CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender VARCHAR(10) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

### Sample Data

INSERT INTO patients (name, age, gender, phone)
VALUES (
    'Arun Kumar',
    35,
    'Male',
    '9876543210'
);

---

## Configuration

Update the database credentials in:

api/config/database.php

Example:

$host = "localhost";
$username = "root";
$password = "";
$database = "hospital_db";

Make sure **Apache** and **MySQL** are running in WAMP/XAMPP.

---

## Base URL

When running locally:

http://localhost/patient-api/api

---

# API Endpoints

| Method | Endpoint         | Description                | Success |
| ------ | ---------------- | -------------------------- | ------- |
| GET    | `/patients`      | Retrieve all patients      | 200     |
| GET    | `/patients/{id}` | Retrieve a patient by ID   | 200     |
| POST   | `/patients`      | Create a new patient       | 201     |
| PUT    | `/patients/{id}` | Update an existing patient | 200     |
| DELETE | `/patients/{id}` | Delete a patient           | 200     |

---

## 1. Get All Patients

### Request

GET /api/patients

### Example

http://localhost/patient-api/api/patients

### Response

{
    "status": true,
    "message": "Patients fetched successfully",
    "data": [
        {
            "id": "1",
            "name": "Arun Kumar",
            "age": "35",
            "gender": "Male",
            "phone": "9876543210",
            "created_at": "2026-08-20 06:27:56"
        }
    ]
}

### Status

200 OK

---

## 2. Get Patient By ID

### Request

GET /api/patients/{id}

### Example

http://localhost/patient-api/api/patients/1

### Response

{
    "status": true,
    "message": "Patient fetched successfully",
    "data": {
        "id": "1",
        "name": "Arun Kumar",
        "age": "35",
        "gender": "Male",
        "phone": "9876543210",
        "created_at": "2026-08-20 06:27:56"
    }
}

### Patient Not Found

{
    "status": false,
    "message": "Patient not found",
    "data": []
}

### Status

200 OK
404 Not Found

---

## 3. Create Patient

### Request

POST /api/patients

### Headers

Content-Type: application/json

### Request Body

{
    "name": "Priya Darshini",
    "age": 23,
    "gender": "Female",
    "phone": "9876543210"
}

### Response

{
    "status": true,
    "message": "Patient created successfully",
    "data": {
        "id": 2
    }
}

### Status

201 Created

---

## 4. Update Patient

### Request

PUT /api/patients/{id}

### Example

http://localhost/patient-api/api/patients/2

### Headers

Content-Type: application/json

### Request Body

{
    "name": "Priya Darshini",
    "age": 24,
    "gender": "Female",
    "phone": "9876543211"
}

### Response

{
    "status": true,
    "message": "Patient updated successfully",
    "data": []
}

### Status

200 OK

---

## 5. Delete Patient

### Request

DELETE /api/patients/{id}

### Example

http://localhost/patient-api/api/patients/2

### Response

{
    "status": true,
    "message": "Patient deleted successfully",
    "data": []
}

### Status

200 OK

---

# HTTP Status Codes

| Code  | Meaning     | Usage                             |
| ----- | ----------- | --------------------------------- |
| `200` | OK          | Successful GET, PUT, DELETE       |
| `201` | Created     | Successful POST                   |
| `400` | Bad Request | Invalid or missing request data   |
| `404` | Not Found   | Patient or endpoint doesn't exist |

---

# JSON Response Format

All API responses follow a consistent structure:

{
    "status": true,
    "message": "Operation completed successfully",
    "data": []
}

### Response Fields

| Field     | Type         | Description                    |
| --------- | ------------ | ------------------------------ |
| `status`  | Boolean      | Indicates success or failure   |
| `message` | String       | Describes the operation result |
| `data`    | Array/Object | Contains the response data     |

---

# Routing

The API uses Apache `.htaccess` to provide clean REST-style URLs.

### `.htaccess`

RewriteEngine On

RewriteRule ^api/(.*)$ api/index.php?request=$1 [QSA,L]

For example:

/api/patients

is internally routed to:

/api/index.php?request=patients

The main router then identifies:

* HTTP method
* Resource
* Patient ID

and forwards the request to the appropriate controller method.

---

# Middleware

The project includes a JSON middleware that sets the response content type:

header("Content-Type: application/json");

This ensures that API responses are returned as JSON.

---

# Testing

The API is tested using **Thunder Client**.

### Test Cases

GET     /api/patients
GET     /api/patients/1
GET     /api/patients/999
POST    /api/patients
PUT     /api/patients/2
DELETE  /api/patients/2

### Expected Results

GET existing patient     → 200 OK
GET missing patient      → 404 Not Found
POST valid patient       → 201 Created
PUT existing patient     → 200 OK
DELETE existing patient  → 200 OK

---

# Running the Project Locally

### 1. Clone or place the project

Place the project inside the WAMP `www` directory or XAMPP `htdocs` directory.

C:\wamp64\www\patient-api

### 2. Start services

Start:

Apache
MySQL

### 3. Create the database

Create:

hospital_db

and the `patients` table using the SQL provided above.

### 4. Configure database connection

Update:

api/config/database.php

with your MySQL credentials.

### 5. Test the API

Open Thunder Client and send:

GET http://localhost/patient-api/api/patients

---

# Design Principles

The project separates responsibilities into different layers:

### Router

`api/index.php`

Handles:

* Request method
* URL parsing
* Route matching
* Controller selection

### Controller

`api/controllers/PatientController.php`

Handles:

* Request data
* Validation
* Business-level decisions
* API responses

### Model

`api/models/Patient.php`

Handles:

* SQL queries
* Database operations
* Patient CRUD

### Middleware

`api/middlewares/JsonMiddleware.php`

Handles:

* Common JSON response headers

### Response Helper

`api/helpers/Response.php`

Handles:

* HTTP status codes
* Standard JSON response structure

---

# Learning Outcomes

This project demonstrates practical understanding of:

* REST API architecture
* HTTP methods
* CRUD operations
* JSON request and response
* HTTP status codes
* URL routing
* Apache rewrite rules
* Middleware concepts
* Prepared SQL statements
* Core PHP and MySQL integration
* API testing

---

## Author
Priyadarshni M
Built as part of a Core PHP & MySQL REST API training project.
