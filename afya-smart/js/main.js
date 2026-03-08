document.addEventListener("DOMContentLoaded", () => {
    const dietForm = document.getElementById("dietForm");
    const dietResult = document.getElementById("dietResult");

    if (dietForm && dietResult) {
        dietForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const diet = document.getElementById("diet").value;
            const activity = document.getElementById("activity").value;
            const goal = document.getElementById("goal").value;

            const lines = ["Your Personalized Wellness Plan:", ""];

            if (diet === "vegetarian") {
                lines.push("- Focus on vegetables, fruits, legumes, and whole grains.");
            } else if (diet === "high-protein") {
                lines.push("- Include eggs, fish, beans, and lean protein sources.");
            } else {
                lines.push("- Maintain a balanced mix of all food groups.");
            }

            if (activity === "low") {
                lines.push("- Add light movement such as walking and stretching.");
            } else if (activity === "moderate") {
                lines.push("- Aim for at least 30 minutes of moderate activity daily.");
            } else {
                lines.push("- Keep high-intensity workouts balanced with recovery.");
            }

            if (goal === "stress") {
                lines.push("- Use breathing exercises and short mindfulness breaks.");
            } else if (goal === "energy") {
                lines.push("- Prioritize hydration, regular meals, and sleep routine.");
            } else {
                lines.push("- Track portions and maintain healthy consistency.");
            }

            dietResult.textContent = lines.join("\n");
            dietResult.classList.remove("d-none");
        });
    }

    const moodBtn = document.getElementById("moodBtn");
    const moodSelect = document.getElementById("mood");
    const responseBox = document.getElementById("response");

    if (moodBtn && moodSelect && responseBox) {
        moodBtn.addEventListener("click", async () => {
            const mood = moodSelect.value;
            const messages = {
                happy: "Great to hear. Keep up the routines that support your mood and share your positive energy with others.",
                stressed: "Stress can build quickly. Try slow breathing, take short breaks, and reduce task overload where possible.",
                sad: "Feeling sad is valid. Reach out to someone you trust and choose one small activity that helps you feel grounded.",
                anxious: "Anxiety can feel intense. Focus on controlled breathing, stay in the present moment, and limit stress triggers.",
                tired: "Your body may need recovery. Prioritize sleep, hydration, and lighter tasks until your energy improves."
            };

            responseBox.textContent = messages[mood] || "Select your current mood so we can provide support guidance.";
            responseBox.classList.remove("d-none");

            if (mood) {
                try {
                    const fd = new FormData();
                    fd.append("mood", mood);
                    await fetch("backend/save_mood.php", { method: "POST", body: fd });
                } catch (err) {
                    console.warn("Mood save failed", err);
                }
            }
        });
    }

    const dueBanner = document.getElementById("dueReminderBanner");
    if (dueBanner) {
        const count = Number(dueBanner.dataset.count || "0");
        if (count > 0 && "Notification" in window) {
            if (Notification.permission === "default") {
                Notification.requestPermission().then((p) => {
                    if (p === "granted") {
                        new Notification("AfyaSmart Reminder", {
                            body: `You have ${count} reminder(s) due within 60 minutes.`
                        });
                    }
                });
            } else if (Notification.permission === "granted") {
                new Notification("AfyaSmart Reminder", {
                    body: `You have ${count} reminder(s) due within 60 minutes.`
                });
            }
        }
    }

    const sosBtn = document.getElementById("sosBtn");
    const locationNode = document.getElementById("location");
    const mapNode = document.getElementById("emergencyMap");
    const nearbyNode = document.getElementById("nearbyFacilities");

    const defaultLat = -1.286389;
    const defaultLon = 36.817223;

    function haversineKm(lat1, lon1, lat2, lon2) {
        const toRad = (v) => (v * Math.PI) / 180;
        const R = 6371;
        const dLat = toRad(lat2 - lat1);
        const dLon = toRad(lon2 - lon1);
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    async function loadNearbyFacilities(lat, lon, map) {
        if (!nearbyNode) return;
        nearbyNode.innerHTML = "<li class='list-group-item'>Finding nearby hospitals and clinics...</li>";

        const query = `
[out:json][timeout:20];
(
  node["amenity"="hospital"](around:5000,${lat},${lon});
  node["amenity"="clinic"](around:5000,${lat},${lon});
  way["amenity"="hospital"](around:5000,${lat},${lon});
  way["amenity"="clinic"](around:5000,${lat},${lon});
);
out center 12;
`;

        try {
            const url = "https://overpass-api.de/api/interpreter?data=" + encodeURIComponent(query);
            const res = await fetch(url);
            const data = await res.json();

            if (!data.elements || data.elements.length === 0) {
                nearbyNode.innerHTML = "<li class='list-group-item'>No nearby facilities found.</li>";
                return;
            }

            const places = data.elements.map((el) => {
                const plat = el.lat || (el.center && el.center.lat);
                const plon = el.lon || (el.center && el.center.lon);
                const name = (el.tags && el.tags.name) ? el.tags.name : "Unnamed facility";
                const amenity = (el.tags && el.tags.amenity) ? el.tags.amenity : "facility";
                return {
                    name,
                    amenity,
                    lat: plat,
                    lon: plon,
                    dist: haversineKm(lat, lon, plat, plon)
                };
            }).filter((p) => p.lat && p.lon).sort((a, b) => a.dist - b.dist).slice(0, 5);

            nearbyNode.innerHTML = "";
            places.forEach((p) => {
                const li = document.createElement("li");
                li.className = "list-group-item";
                const gmaps = `https://www.google.com/maps/dir/?api=1&destination=${p.lat},${p.lon}`;
                li.innerHTML = `<strong>${p.name}</strong><br><small>${p.amenity} - ${p.dist.toFixed(2)} km away</small><br><a href="${gmaps}" target="_blank" rel="noopener">Get directions</a>`;
                nearbyNode.appendChild(li);

                if (map && window.L) {
                    window.L.marker([p.lat, p.lon]).addTo(map).bindPopup(`${p.name}`);
                }
            });
        } catch (err) {
            nearbyNode.innerHTML = "<li class='list-group-item'>Could not load nearby facilities right now.</li>";
        }
    }

    if (mapNode && window.L) {
        const map = window.L.map("emergencyMap").setView([defaultLat, defaultLon], 13);
        window.L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
            attribution: "&copy; OpenStreetMap contributors"
        }).addTo(map);

        let userMarker;

        const setUserLocation = (lat, lon) => {
            map.setView([lat, lon], 14);
            if (userMarker) map.removeLayer(userMarker);
            userMarker = window.L.marker([lat, lon]).addTo(map).bindPopup("Your location").openPopup();
            if (locationNode) {
                locationNode.textContent = `Latitude: ${lat.toFixed(5)}, Longitude: ${lon.toFixed(5)}`;
            }
            loadNearbyFacilities(lat, lon, map);
        };

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    setUserLocation(position.coords.latitude, position.coords.longitude);
                },
                () => {
                    if (locationNode) locationNode.textContent = "Unable to retrieve location. Showing Nairobi default.";
                    setUserLocation(defaultLat, defaultLon);
                }
            );
        } else {
            if (locationNode) locationNode.textContent = "Geolocation unavailable. Showing Nairobi default.";
            setUserLocation(defaultLat, defaultLon);
        }
    } else if (locationNode && navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const { latitude, longitude } = position.coords;
                locationNode.textContent = `Latitude: ${latitude.toFixed(5)}, Longitude: ${longitude.toFixed(5)}`;
            },
            () => {
                locationNode.textContent = "Unable to retrieve location.";
            }
        );
    }

    if (sosBtn) {
        sosBtn.addEventListener("click", () => {
            alert("SOS request initiated. Contact emergency services immediately if this is urgent.");
        });
    }
});
