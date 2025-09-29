<?php
// Pre-defined seat sections for all gates
$sections = array(
    "A" => array(
        "1" => array(101, 102, 103, 104, 105, 106, 107, 108, 109),
        "2" => array(201, 202, 203),
        "3" => array(327, 328, 329, 330, 331, 332, 333, 334, 301, 302, 303)
    ),
    "B" => array(
        "1" => array(101, 102, 103, 104, 105, 106, 107, 108, 109),
        "2" => array(201, 202, 203, 204, 205, 206, 207),
        "3" => array(301, 302, 303, 304, 305, 306, 307, 308, 309)
    ),
    "C" => array(
        "1" => array(110, 112, 113, 114, 115, 116, 117, 118, 119),
        "2" => array(208, 209, 210, 211, 212, 213, 214, 215, 216),
        "3" => array(310, 311, 312, 313, 314, 315, 316, 317, 318)
    ),
    "D" => array(
        "1" => array(120, 121, 122, 123, 124, 125),
        "2" => array(216, 217, 218, 219, 220, 223, 224),
        "3" => array(318, 319, 320, 321, 322, 323, 324, 325, 326, 327)
    ),
    "E" => array(
        "1" => array(126, 127),
        "2" => array(221, 222, 223)
    ),
    "F" => array(
        "1" => array(128, 129, 130, 131, 132, 133, 134),
        "2" => array(225, 226, 227, 228, 229, 230, 231, 232, 233)
    ),
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ticket Purchase System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 20px;
        }

        .container {
            max-width: 1000px;
            width: 90%;
            margin: 30px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }

        .image-container {
            flex: 1;
            max-width: 60%;
        }

        .image-container img {
            width: 100%;
            border-radius: 5px;
        }

        .form-container {
            flex: 1;
            max-width: 40%;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background-color: #3e8e41;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .image-container, .form-container {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

<header>
    <h1>Choose Your Seat</h1>
</header>

<div class="container">
    <div class="image-container">
        <img src="images1/snbj.png" alt="Stadium Map">
    </div>

    <div class="form-container">
        <form action="submit_seatsection.php" method="post">
            <select id="gate" name="gate" required>
                <option value="">Select a Gate</option>
                <option value="A">Gate A</option>
                <option value="B">Gate B</option>
                <option value="C">Gate C</option>
                <option value="D">Gate D</option>
                <option value="E">Gate E</option>
                <option value="F">Gate F</option>
            </select>

            <select id="level" name="level" required>
                <option value="">Select a Level</option>
                <option value="1">Level 1</option>
                <option value="2">Level 2</option>
                <option value="3">Level 3</option>
            </select>

            <select id="seat" name="seat" required disabled>
                <option value="">Select a Seat Section</option>
            </select>

            <button type="submit">Buy Ticket</button>
        </form>
    </div>
</div>

<script>
    const sections = {
        "A": {
            "1": [101, 102, 103, 104, 105, 106, 107, 108, 109],
            "2": [201, 202, 203],
            "3": [327, 328, 329, 330, 331, 332, 333, 334, 301, 302, 303]
        },
        "B": {
            "1": [101, 102, 103, 104, 105, 106, 107, 108, 109],
            "2": [201, 202, 203, 204, 205, 206, 207],
            "3": [301, 302, 303, 304, 305, 306, 307, 308, 309]
        },
        "C": {
            "1": [110, 112, 113, 114, 115, 116, 117, 118, 119],
            "2": [208, 209, 210, 211, 212, 213, 214, 215, 216],
            "3": [310, 311, 312, 313, 314, 315, 316, 317, 318]
        },
        "D": {
            "1": [120, 121, 122, 123, 124, 125],
            "2": [216, 217, 218, 219, 220, 223, 224],
            "3": [318, 319, 320, 321, 322, 323, 324, 325, 326, 327]
        },
        "E": {
            "1": [126, 127],
            "2": [221, 222, 223]
        },
        "F": {
            "1": [128, 129, 130, 131, 132, 133, 134],
            "2": [225, 226, 227, 228, 229, 230, 231, 232, 233]
        }
    };

    // Populate seats dynamically based on gate and level
    function populateSeats() {
        const gate = document.getElementById("gate").value;
        const level = document.getElementById("level").value;
        const seatDropdown = document.getElementById("seat");

        // Clear old options
        seatDropdown.innerHTML = '<option value="">Select a Seat Section</option>';

        if (gate && level && sections[gate] && sections[gate][level]) {
            seatDropdown.disabled = false;

            // Populate new seat options
            sections[gate][level].forEach(seat => {
                const option = document.createElement("option");
                option.value = seat;
                option.textContent = `Section ${seat}`;
                seatDropdown.appendChild(option);
            });
        } else {
            seatDropdown.disabled = true;
        }
    }

    // Event listeners
    document.getElementById("gate").addEventListener("change", populateSeats);
    document.getElementById("level").addEventListener("change", populateSeats);
</script>

</body>
</html>

