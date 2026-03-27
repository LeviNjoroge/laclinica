// this will be the backend server of the application laclinica

const CLIENT_PORT = process.env.CLIENT_PORT || 5500

const express = require('express');
const app = express();

const dotenv = require('dotenv');
dotenv.config()

app.use(express.json());

// for the PORTS security issue
const cors = require('cors');
app.use(cors());

// to encode data from client
app.use(express.urlencoded({ extended: true }));

const { readPatientsListing, readPatientsListingForDate, createPatient, createVitalsRecord, createGenAssessentRecord, createOverweightAssessmentRecord } = require('./database');

app.get('/api',(req,res)=>{
    res.send("Welcome to laclinica");
})

app.get('/api/patient_listing', async (req, res)=>{
    const date = req.query.date;
    let patients_listing;
    if(!date){
        patients_listing = await readPatientsListing();
    }else{
        patients_listing = await readPatientsListingForDate(date);
    }
    res.send(patients_listing);
})

app.post('/api/patients_registration', async (req, res) => {
    const patient = {
        patient_number: req.body.patient_number,
        first_name: req.body.first_name,
        middle_name: req.body.middle_name,
        last_name: req.body.last_name,
        gender: req.body.gender,
        date_of_birth: req.body.date_of_birth,
        registration_date: req.body.registration_date
    }
    try {
        await createPatient(patient.patient_number, patient.first_name, patient.middle_name, patient.last_name, patient.gender, patient.date_of_birth, patient.registration_date);

        // send respose to client - for api testing
        // res.send({ "message": "Record saved successfully!", "body": patient});

        // redirect client - real app testing
        res.redirect(`http://127.0.0.1:${CLIENT_PORT}/vitals_form.html`)
    }
    catch (error) {
        res.status(500).send("Failed to save record")
    }
});

app.post('/api/vitals/', async (req, res) => {
    // get data from backend
    const vitals = {
        patient_number: req.body.patient_number,
        visit_date: req.body.visit_date,
        height: req.body.height,
        weight: req.body.weight
    }

    // calculate BMI
    const heightM = vitals.height / 100;
    const BMI = vitals.weight / (heightM * heightM)

    try {// send data to dtb
        await createVitalsRecord(vitals.patient_number, vitals.visit_date, vitals.height, vitals.weight, BMI)

        // choose redirect location based on BMI
        let redirect_location;
        if (BMI <= 25) {
            redirect_location = "/general_assessment_form.html"
        } else {
            redirect_location = "/overweight_assessment_form.html"
        }

        // completed, send message to api -- for API testing
        // res.send({ "message": "Record saved successfully!", "body": { ...vitals, "BMI": BMI }, "redirect_location": redirect_location })

        // redirect client, for custom application
        res.redirect(301, `http://127.0.0.1:${CLIENT_PORT}${redirect_location}`)
    }
    catch (error) {
        res.status(500).send("Failed to save record")
    }
});

app.post('/api/general_assessment', async (req, res) => {
    // get data from client
    const records = {
        patient_number: req.body.patient_number,
        visit_date: req.body.visit_date,
        gen_health: req.body.gen_health,
        on_drugs: req.body.on_drugs,
        comments: req.body.comments
    }
    try {
        // store data in database
        await createGenAssessentRecord(records.patient_number, records.visit_date, records.gen_health, records.on_drugs, records.comments)
        // send respose to client - for api testing
        // res.send({ "message": "Record successfully saved!", "body": records })

        // redirect client - real app testing
        res.redirect(301, `http://127.0.0.1:${CLIENT_PORT}/patients_listing.html`)
    }
    catch (error) {
        res.status(500).send({ "message": "Failed to save record", "error": error.message })
    }
})

app.post('/api/overweight_assessment', async (req, res) => {
    // get data from client
    const records = {
        patient_number: req.body.patient_number,
        visit_date: req.body.visit_date,
        gen_health: req.body.gen_health,
        been_on_diet: req.body.been_on_diet,
        comments: req.body.comments
    }
    try {
        // store data in database
        await createOverweightAssessmentRecord(records.patient_number, records.visit_date, records.gen_health, records.been_on_diet, records.comments)
        // send respose to client - for api testing
        // res.send({ "message": "Record successfully saved!", "body": records })

        // redirect client - real app testing
        res.redirect(301, `http://127.0.0.1:${CLIENT_PORT}/patients_listing.html`)
    }
    catch (error) {
        res.status(500).send("Failed to save record")
    }
})

const PORT = process.env.SERVER_PORT || 3000

app.listen(PORT, ()=>{
    console.log(`Listening to port ${PORT}`)
})