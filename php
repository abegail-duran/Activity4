<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Sensor Data</title>

    <!-- Firebase SDKs -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js";
        import { getFirestore, collection, query, orderBy, limit, onSnapshot } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-firestore.js";

        const firebaseConfig = {
            apiKey: "AIzaSyBJ8tP3h_mTYNtfO-OdnlQyZuyByKeTIgI",
            authDomain: "fir-abby-6e255.firebaseapp.com",
            projectId: "fir-abby-6e255",
            storageBucket: "fir-abby-6e255.appspot.com",
            messagingSenderId: "783014531044",
            appId: "1:783014531044:web:c5830573b70723d19f41f1",
            measurementId: "G-ERS2YJ6TWN"
        };

        const app = initializeApp(firebaseConfig);
        const db = getFirestore(app);

        const q = query(collection(db, "sd"), orderBy("timestamp", "desc"), limit(1));

        onSnapshot(q, (snapshot) => {
            if (!snapshot.empty) {
                const doc = snapshot.docs[0];
                const data = doc.data();

                console.log("Live Data:", data);

                document.getElementById("temperature").innerText = (data.temperature ?? "--") + " °C";
                document.getElementById("humidity").innerText = (data.humidity ?? "--") + " %";
                document.getElementById("light").innerText = data.light_level ?? "--";

                if (data.light_level === undefined) {
                    console.warn("Light level data is not defined in Firestore.");
                }
            } else {
                console.log("No live sensor data found.");
                document.getElementById("temperature").innerText = "-- °C";
                document.getElementById("humidity").innerText = "-- %";
                document.getElementById("light").innerText = "--";
            }
        }, (error) => {
            console.error("Error fetching sensor data:", error);
        });
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #ffe6f2;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #d147a3;
        }

        .dashboard {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            width: 100%;
            max-width: 900px;
        }

        .card {
            background: #ffd6e7;
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            font-size: 1.5rem;
            color: #d147a3;
            margin-bottom: 15px;
        }

        .value {
            font-size: 3rem;
            font-weight: bold;
            color: #d147a3;
        }

        @media (max-width: 600px) {
            h2 {
                font-size: 2rem;
            }

            .value {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>
    <h2>Live Sensor Data Dashboard</h2>

    <div class="dashboard">
        <div class="card">
            <h3>Temperature</h3>
            <p class="value" id="temperature">-- °C</p>
        </div>

        <div class="card">
            <h3>Humidity</h3>
            <p class="value" id="humidity">-- %</p>
        </div>

        <div class="card">
            <h3>Light Level</h3>
            <p class="value" id="light">--</p>
        </div>
    </div>
</body>

</html>
