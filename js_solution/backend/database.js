// this will handle all the database actions:
// retrieving data from and posting data to

const mysql = require('mysql2');
const dotenv = require('dotenv');
dotenv.config()

const pool = mysql.createPool({
    host: process.env.MYSQL_HOST,
    user: process.env.MYSQL_USER,
    password: process.env.MYSQL_PASSWORD,
    database: process.env.MYSQL_DATABASE
}).promise()

async function readPatientsListing() {
    const [rows] = await pool.query(`
        SELECT DISTINCT FIRST_NAME, MIDDLE_NAME, LAST_NAME, DATE_OF_BIRTH, BMI, VISIT_DATE
        FROM PATIENTS_REGISTRATION P
        JOIN VITALS_RECORDS V
        ON P.PATIENT_NUMBER = V.PATIENT_NUMBER
        AND V.VISIT_DATE = (SELECT MAX(V2.VISIT_DATE)
                            FROM VITALS_RECORDS V2
                            WHERE V2.PATIENT_NUMBER = P.PATIENT_NUMBER)
    `);
    return rows;
}

async function readPatientsListingForDate(date) {
    const [rows] = await pool.query(`
        SELECT DISTINCT FIRST_NAME, MIDDLE_NAME, LAST_NAME, DATE_OF_BIRTH, BMI, VISIT_DATE
        FROM PATIENTS_REGISTRATION P
        JOIN VITALS_RECORDS V
        ON P.PATIENT_NUMBER = V.PATIENT_NUMBER
        AND V.VISIT_DATE = (SELECT MAX(V2.VISIT_DATE)
                            FROM VITALS_RECORDS V2
                            WHERE V2.PATIENT_NUMBER = P.PATIENT_NUMBER)
        AND V.VISIT_DATE = ?
    `, [date]);
    return rows;
}

async function createPatient(patient_number, first_name, middle_name, last_name, gender, date_of_birth, registration_date) {
    const result = await pool.query(`
        INSERT INTO PATIENTS_REGISTRATION(patient_number, first_name, middle_name, last_name, gender, date_of_birth, registration_date)
        VALUES(?,?,?,?,?,?,?)
        `, [patient_number, first_name, middle_name, last_name, gender, date_of_birth, registration_date]);
    return result;
}

async function createVitalsRecord(patient_number, visit_date, height, weight, bmi) {
    const result = await pool.query(`
        INSERT INTO VITALS_RECORDS(patient_number, visit_date, height, weight, bmi)
        VALUES(?,?,?,?,?)
        `, [patient_number, visit_date, height, weight, bmi]);
    return result;
}

async function createGenAssessentRecord(patient_number, visit_date, gen_health, on_drugs, comments) {
    const result = await pool.query(`
        INSERT INTO ASSESSMENT_RECORDS(patient_number, visit_date, gen_health, on_drugs, comments)
        VALUES(?,?,?,?,?)
        `, [patient_number, visit_date, gen_health, on_drugs, comments]);
    return result;
}

async function createOverweightAssessmentRecord(patient_number, visit_date, gen_health, been_on_diet, comments) {
    const result = await pool.query(`
        INSERT INTO OVERWEIGHT_ASSESSMENT_RECORDS(patient_number, visit_date, gen_health, been_on_diet, comments)
        VALUES(?,?,?,?,?)
        `, [patient_number, visit_date, gen_health, been_on_diet, comments]);
    return result;
}

module.exports = {
    readPatientsListing,
    readPatientsListingForDate,
    createPatient,
    createVitalsRecord,
    createGenAssessentRecord,
    createOverweightAssessmentRecord,
};

createVitalsRecord(2001, "2026-7-7", 180, 50.6, 20)