# LaClinica Patient Registration, Vitals and Assessment System

> **Update Note (JavaScript Backend Added):**  
> I first completed this project using the PHP approach so I could deliver the full implementation end-to-end.  
> After that, I added a JavaScript/Node.js backend implementation (see `js_solution/`) as I refreshed my JavaScript skills (been a minute since I wrote js fr).  
> In this JavaScript stack, the backend is implemented around API endpoints for the actual data operations, compared to the earlier PHP flow where frontend and backend handling were structured differently.

## Added Module: `js_solution` (JavaScript + Node.js)

The repository now includes `js_solution/`, which is a JavaScript-based implementation of the same assignment flow:
- Frontend pages in HTML/CSS (`index.html`, `vitals_form.html`, `general_assessment_form.html`, `overweight_assessment_form.html`, `patients_listing.html`)
- Backend API in Node.js + Express (`js_solution/backend/`)
- MySQL persistence through `mysql2` queries in `js_solution/backend/database.js`

### JS Backend Endpoints

| Method | Endpoint | Purpose |
|---|---|---|
| GET | `/api` | API health/welcome route |
| GET | `/api/patient_listing` | Return latest patient listing (supports `?date=YYYY-MM-DD`) |
| POST | `/api/patients_registration` | Save patient registration and redirect to vitals form |
| POST | `/api/vitals` | Save vitals, compute BMI, and route to the right assessment form |
| POST | `/api/general_assessment` | Save general assessment and redirect to listing |
| POST | `/api/overweight_assessment` | Save overweight assessment and redirect to listing |

### JS Backend Config (`.env`)

- `MYSQL_HOST`
- `MYSQL_USER`
- `MYSQL_PASSWORD`
- `MYSQL_DATABASE`
- `SERVER_PORT` (optional, defaults to `3000`)
- `CLIENT_PORT` (optional, defaults to `5500`)

### Running `js_solution`

1. `cd js_solution/backend`
2. `npm install`
3. Create a `.env` file with the variables listed above.
4. Start backend: `node index.js`
5. Serve the frontend in `js_solution/` (for example with Live Server on port `5500`, or update `CLIENT_PORT` accordingly), then open `js_solution/index.html`.

This repository is my submission for the **Web App & Backend Development Practical** assignment.

The solution delivers both parts requested in the brief:
- **Web front-end development (60%)**: Implemented as a web app with 5 pages.
- **Backend development (40%)**: Implemented with PHP + MySQL persistence endpoints.

## Assignment Approach

The assignment allowed either:
- consuming the provided Postman APIs, or
- building custom backend endpoints.

This implementation uses the **custom backend endpoint approach**.

Reference Postman documentation from the brief:
- https://documenter.getpostman.com/view/18832855/2sB3Wnx2PF

## Tech Stack

- PHP (server-side rendering + form handlers)
- MySQL (data persistence)
- HTML/CSS (UI)
- PHP sessions (carry active patient context across forms)

## Implemented User Flow (5 Pages)

1. **Patient Registration Page** (`index.php`)
2. **Vitals Form** (`vitals_form.php`)
3. **Overweight Assessment Form** (`overweight_assessment_form.php`)
4. **General Assessment Form** (`general_assessment_form.php`)
5. **Patient Listing Page** (`patients_listing.php`)

## Requirement Coverage

### 1) Patient Registration

Implemented fields:
- Patient Number (used as unique identifier)
- Registration Date
- First Name
- Middle Name (extra optional field)
- Last Name
- Date of Birth
- Gender

Business rules implemented:
- A patient cannot be registered twice with the same patient number.
- On successful registration, the app redirects to the Vitals page.

Handler:
- `POST /backend/actions/save_patients.php`

### 2) Vitals Form

Implemented fields:
- Visit Date
- Height (cm)
- Weight (kg)
- BMI (calculated server-side)

Business rules implemented:
- BMI formula: `BMI = weight / (height_in_meters^2)`
- A patient can submit multiple vitals records, but not on the same visit date.
- If BMI `<= 25`: redirect to General Assessment.
- If BMI `> 25`: redirect to Overweight Assessment.

Handler:
- `POST /backend/actions/save_vitals.php`

### 3) Overweight Assessment Form

Implemented fields:
- Visit Date
- General Health (Good/Poor)
- Have you ever been on a diet to lose weight? (Yes/No)
- Comments

Business rules intended by flow:
- Form is shown after vitals when BMI `> 25`.
- On save, user is redirected to Patient Listing.

Handler:
- `POST /backend/actions/save_assessments.php` with `form_type=overweight`

### 4) General Assessment Form

Implemented fields:
- Visit Date
- General Health (Good/Poor)
- Are you currently using any drugs? (Yes/No)
- Comments

Business rules implemented:
- Form is shown after vitals when BMI `<= 25`.
- On save, user is redirected to Patient Listing.

Handler:
- `POST /backend/actions/save_assessments.php` with `form_type=general`

### 5) Patient Listing + Date Filter

Displayed columns:
- Patient Name
- Age
- Last BMI Status
- Last Assessment Date (visit date of latest vitals shown)

Business rules implemented:
- BMI status mapping:
  - `< 18.5` -> Underweight
  - `>= 18.5 and < 25` -> Normal
  - `>= 25` -> Overweight
- Listing can be filtered by visit date.

Source:
- `patients_listing.php`
- `backend/logic/listing_logic.php`

## Backend Endpoint Summary

| Method | Endpoint | Purpose |
|---|---|---|
| POST | `/backend/actions/save_patients.php` | Save patient registration and start patient session context |
| POST | `/backend/actions/save_vitals.php` | Save vitals + compute BMI + route to correct assessment form |
| POST | `/backend/actions/save_assessments.php` | Save general/overweight assessment and route to listing |

## Project Structure

```text
.
|-- index.php
|-- vitals_form.php
|-- overweight_assessment_form.php
|-- general_assessment_form.php
|-- patients_listing.php
|-- style.css
`-- backend
    |-- actions
    |   |-- save_patients.php
    |   |-- save_vitals.php
    |   `-- save_assessments.php
    |-- config
    |   |-- database.php
    |   `-- example.database.php
    `-- logic
        |-- patients_logic.php
        |-- vitals_logic.php
        |-- assessment_logic.php
        `-- listing_logic.php
```

## Local Setup

### Prerequisites

- PHP 8+
- MySQL 8+ (or compatible)

### 1) Configure database connection

Update DB credentials in:
- `backend/config/database.php`

You can use `backend/config/example.database.php` as a template.

### 2) Create database and tables

Use the SQL below (or adapt to your preferred schema names/types).

```sql
CREATE DATABASE IF NOT EXISTS laclinica;
USE laclinica;

CREATE TABLE IF NOT EXISTS PATIENTS_REGISTRATION (
    PATIENT_NUMBER INT PRIMARY KEY,
    FIRST_NAME VARCHAR(50) NOT NULL,
    MIDDLE_NAME VARCHAR(50) NULL,
    LAST_NAME VARCHAR(50) NOT NULL,
    GENDER VARCHAR(10) NOT NULL,
    DATE_OF_BIRTH DATE NOT NULL,
    REGISTRATION_DATE DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS VITALS_RECORDS (
    PATIENT_NUMBER INT NOT NULL,
    VISIT_DATE DATE NOT NULL,
    HEIGHT INT NOT NULL,
    WEIGHT INT NOT NULL,
    BMI INT NOT NULL
);

CREATE TABLE IF NOT EXISTS ASSESSMENT_RECORDS (
    PATIENT_NUMBER INT NOT NULL,
    VISIT_DATE DATE NOT NULL,
    GEN_HEALTH VARCHAR(10) NOT NULL,
    ON_DRUGS VARCHAR(5) NOT NULL,
    COMMENTS TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS OVERWEIGHT_ASSESSMENT_RECORDS (
    PATIENT_NUMBER INT NOT NULL,
    VISIT_DATE DATE NOT NULL,
    GEN_HEALTH VARCHAR(10) NOT NULL,
    BEEN_ON_DIET VARCHAR(5) NOT NULL,
    COMMENTS TEXT NOT NULL
);
```

### 3) Start the app

From project root:

```bash
php -S localhost:8000
```

Open:
- `http://localhost:8000/index.php`

## Quick Demo Script

1. Register a new patient on `index.php`.
2. Enter vitals on `vitals_form.php`.
3. Observe routing behavior:
   - BMI `<= 25` -> `general_assessment_form.php`
   - BMI `> 25` -> `overweight_assessment_form.php`
4. Save assessment.
5. Review records on `patients_listing.php` and test date filter.

## Notes and Design Decisions

- Patient context is passed using PHP session variables after registration.
- BMI status shown in listing is derived from latest available vitals per patient.
- Filtering in the listing page is by visit date as required in the assignment.
- Form handlers currently use server-side redirects to move across pages.

## Assignment Deliverable Checklist

- [x] Patient registration page
- [x] Vitals page with BMI calculation
- [x] Conditional routing to two custom forms
- [x] General assessment form
- [x] Overweight assessment form
- [x] Patient listing with BMI status
- [x] Listing filter by visit date
- [x] Backend endpoints for registration, vitals, and assessment records

---

If you are reviewing this submission, start from `index.php` and follow the flow end-to-end.
