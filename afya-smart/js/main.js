document.addEventListener("DOMContentLoaded", function () {

    /* =====================
       HELPER: SUCCESS ALERT
    ====================== */
    function showSuccess(message, container) {
        if (!container) return;
        const alert = document.createElement("div");
        alert.className = "alert alert-success mt-3";
        alert.textContent = message;
        container.prepend(alert);
        setTimeout(() => alert.remove(), 2500);
    }

    /* =====================
       DIET & WELLNESS
    ====================== */
    const dietForm = document.getElementById("dietForm");
    const dietResult = document.getElementById("dietResult");

    if (dietForm && dietResult) {
        dietForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const diet = document.getElementById("diet").value;
            const activity = document.getElementById("activity").value;
            const goal = document.getElementById("goal").value;

            let result = "Your Personalized Wellness Plan:\n\n";

            if (diet === "vegetarian") {
                result += "• Focus on vegetables, fruits, legumes, and whole grains.\n";
            } else if (diet === "high-protein") {
                result += "• Include eggs, fish, beans, and lean meat.\n";
            } else {
                result += "• Maintain a balanced mix of all food groups.\n";
            }

            if (activity === "low") {
                result += "• Engage in light activities like walking and stretching.\n";
            } else if (activity === "moderate") {
                result += "• Aim for at least 30 minutes of exercise daily.\n";
            } else {
                result += "• Maintain high-intensity workouts with adequate rest.\n";
            }

            if (goal === "stress") {
                result += "• Practice meditation, breathing exercises, and relaxation.\n";
            } else if (goal === "energy") {
                result += "• Stay hydrated and eat regular healthy meals.\n";
            } else {
                result += "• Control portions and maintain consistency.\n";
            }

            dietResult.textContent = result;
            dietResult.style.whiteSpace = "pre-line";
            dietResult.classList.remove("d-none");

            showSuccess("Wellness plan generated successfully.", dietForm);
        });
    }

    /* =====================
       MENTAL HEALTH SUPPORT
    ====================== */
   /* =====================
   MENTAL HEALTH SUPPORT
===================== */
const moodBtn = document.getElementById("moodBtn");
const moodSelect = document.getElementById("mood");
const responseBox = document.getElementById("response");

if (moodBtn && moodSelect && responseBox) {
    moodBtn.addEventListener("click", function () {

        const mood = moodSelect.value;
        let message = "";

        if (!mood) {
            message = "Please select how you are feeling so we can support you.";
        } 
        else if (mood === "happy") {
            message =
                "That’s great to hear! 😊\n\n" +
                "• Keep doing activities that make you happy\n" +
                "• Share your positive energy with others\n" +
                "• Maintain healthy habits to sustain this mood";
        } 
        else if (mood === "stressed") {
            message =
                "It sounds like you’re feeling stressed.\n\n" +
                "• Take slow deep breaths\n" +
                "• Take short breaks\n" +
                "• Try light physical activity or stretching";
        } 
        else if (mood === "sad") {
            message =
                "Feeling sad is okay.\n\n" +
                "• Talk to someone you trust\n" +
                "• Do something comforting\n" +
                "• Remember that emotions change with time";
        } 
        else if (mood === "anxious") {
            message =
                "Anxiety can be overwhelming.\n\n" +
                "• Focus on slow breathing\n" +
                "• Ground yourself in the present moment\n" +
                "• Limit overthinking and negative news";
        } 
        else if (mood === "tired") {
            message =
                "Your body may need rest.\n\n" +
                "• Get enough sleep\n" +
                "• Stay hydrated\n" +
                "• Take breaks and avoid overworking";
        }

        responseBox.textContent = message;
        responseBox.classList.remove("d-none");
    });
}

    /* =====================
       MEDICATION REMINDER (localStorage)
    ====================== */
   /* =====================
   MEDICATION REMINDER (DATABASE)
===================== */

const reminderForm = document.getElementById("reminderForm");
const reminderList = document.getElementById("reminderList");

if (reminderForm && reminderList) {

    // Load medications
    fetch("backend/get_medications.php")
        .then(res => res.json())
        .then(data => {
            data.forEach(med => addMedicationToUI(med));
        });

    // Add medication
    reminderForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(reminderForm);

        fetch("backend/add_medication.php", {
            method: "POST",
            body: formData
        }).then(() => location.reload());
    });
}

function addMedicationToUI(med) {
    const li = document.createElement("li");
    li.className = "list-group-item d-flex justify-content-between align-items-center";

    li.innerHTML = `
        <div>
            <strong>${med.medicine_name}</strong> (${med.dosage})<br>
            <small>${med.reminder_time}</small>
        </div>
        <button class="btn btn-sm btn-danger">Delete</button>
    `;

    li.querySelector("button").onclick = () => {
        const fd = new FormData();
        fd.append("id", med.medication_id);

        fetch("backend/delete_medication.php", {
            method: "POST",
            body: fd
        }).then(() => li.remove());
    };

    reminderList.appendChild(li);
}


    /* =====================
       HEALTH RECORDS (localStorage)
    ====================== */
  if (document.getElementById("recordTable")) {

    fetch("backend/get_records.php")
        .then(res => res.json())
        .then(data => {
            data.forEach(rec => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${rec.record_type}</td>
                    <td>${rec.description}</td>
                    <td>${rec.record_date}</td>
                `;
                document.getElementById("recordTable").appendChild(row);
            });
        });

    document.getElementById("healthForm").addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("backend/add_record.php", {
            method: "POST",
            body: formData
        }).then(() => location.reload());
    });
}
});