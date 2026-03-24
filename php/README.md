# LaClinica PHP Project

Simple PHP/MySQL patient workflow app with these pages:

- `index.php` - patient registration form
- `vitals_form.php` - captures visit date, height, weight, calculates BMI
- `general_assessment_form.php` - general assessment form
- `overweight_assessment_form.php` - overweight assessment form
- `patients_listing.php` - lists patients with age, BMI status, and visit date filter

## Backend Files

- `backend/actions/save_patients.php` - saves registration and redirects to vitals form
- `backend/actions/save_vitals.php` - saves vitals, calculates BMI, routes to general/overweight form
- `backend/actions/save_assessments.php` - saves assessment and redirects to listing
- `backend/logic/*.php` - helper/session/query logic for forms and listing
- `backend/config/database.php` - active DB connection config
- `backend/config/example.database.php` - DB config template

## Styling

- `style.css` - shared styles for forms and listing table

## Run Locally

1. Update DB credentials in `backend/config/database.php`.
2. Ensure the required MySQL database/tables exist.
3. Start PHP server from project root:

```bash
php -S localhost:8000
```

4. Open:

`http://localhost:8000/index.php`
