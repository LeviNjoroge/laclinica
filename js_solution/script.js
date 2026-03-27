function createformdate() {
const form = document.getElementById("patient_registration_form");
form.addEventListener("submit", async (event) => {
  event.preventDefault();

  const response = await fetch(
    "http://127.0.0.1:3000/api/patients_registration",
    {
      method: "POST",
      headers: {
        "Content-Type": "application.json"
      },
      body: JSON.stringify({
        patient_number: document.getElementById("patient_number").value,
        first_name: document.getElementById("first_name").value,
        middle_name: document.getElementById("middle_name").value,
        last_name: document.getElementById("last_name").value,
        gender: document.querySelector('input[name="gender"]:checked')?.value,
        date_of_birth: document.getElementById("date_of_birth").value,
        registration_date: document.getElementById("registration_date").value,
      }),
    },
  );
  const result = await response.json();
  console.log(result);
});
}