<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Lab Management System</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f7f7f7;
            padding: 20px;
        }
        h1, h2, h3 {
            color: #4CAF50;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }
        h3 {
            font-size: 1.6em;
            margin-bottom: 8px;
        }
        p {
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        ul {
            margin-bottom: 20px;
        }
        code {
            background-color: #f4f4f4;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .highlight {
            background-color: #e8f5e9;
            border: 1px solid #4CAF50;
            padding: 15px;
            margin-bottom: 20px;
        }
        .table-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        footer {
            text-align: center;
            font-size: 1em;
            padding: 10px;
            background-color: #333;
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>Computer Lab Management System</h1>
    
    <p>The <strong>Computer Lab Management System</strong> is a web-based application designed to help manage and monitor devices within a computer lab. This tool allows administrators to efficiently track and manage the status of systems, including CPUs, UPS units, and monitors, ensuring the lab operates smoothly and without disruption.</p>

    <h2>Features</h2>
    <ul>
        <li><strong>System Monitoring:</strong> View detailed information on each device in the lab.</li>
        <li><strong>Device Status Management:</strong> Easily update and manage the status of each device (Active, Inactive, Maintenance, Fault).</li>
        <li><strong>Real-Time Updates:</strong> Track changes to device status in real-time.</li>
        <li><strong>User-Friendly Interface:</strong> Navigate the system easily with a responsive and intuitive interface.</li>
    </ul>

    <h2>Technologies Used</h2>
    <ul>
        <li><strong>Frontend:</strong> HTML5, CSS3, Bootstrap</li>
        <li><strong>Backend:</strong> PHP</li>
        <li><strong>Database:</strong> MySQL</li>
        <li><strong>Web Server:</strong> Apache (for local development)</li>
    </ul>

    <h2>Installation</h2>
    <p>To install and set up the Computer Lab Management System, follow the steps below:</p>

    <div class="highlight">
        <h3>Prerequisites</h3>
        <ul>
            <li>XAMPP or WAMP for local server setup (includes Apache and MySQL)</li>
            <li>PHP 7.4 or higher</li>
            <li>MySQL 5.7 or higher</li>
        </ul>
    </div>

    <div class="highlight">
        <h3>Steps</h3>
        <ol>
            <li>Clone the repository:
                <br><code>git clone https://github.com/yourusername/computer-lab-management.git</code>
            </li>
            <li>Navigate to the project directory:
                <br><code>cd computer-lab-management</code>
            </li>
            <li>Create a new MySQL database:
                <br><code>CREATE DATABASE lab_management;</code>
            </li>
            <li>Import the database schema by running the SQL file <code>lab_management.sql</code> in your MySQL environment.</li>
            <li>Update the database connection in <code>header.php</code> with your credentials.</li>
            <li>Start Apache and MySQL through XAMPP or WAMP.</li>
            <li>Open the application in your browser: <br><code>http://localhost/computer-lab-management</code></li>
        </ol>
    </div>

    <h2>Usage</h2>
    <p>Once the system is up and running, you can:</p>
    <ul>
        <li><strong>Monitor Systems:</strong> View all devices and their details (CPU, Monitor, UPS).</li>
        <li><strong>Update Device Status:</strong> Change the status of each device to Active, Inactive, Maintenance, or Fault.</li>
        <li><strong>View Detailed Device Status:</strong> View the last updated status for each system in real-time.</li>
    </ul>

    <h2>Current Device Status</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>System ID</th>
                    <th>CPU ID</th>
                    <th>Status</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>CPU123 - Monitor456 - UPS789</td>
                    <td>CPU123</td>
                    <td>Active</td>
                    <td>2024-12-13 12:00</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>CPU124 - Monitor457 - UPS790</td>
                    <td>CPU124</td>
                    <td>Maintenance</td>
                    <td>2024-12-13 14:00</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    <h2>Contributing</h2>
    <p>We welcome contributions! If you'd like to help improve the project, follow these steps:</p>
    <ol>
        <li>Fork the repository.</li>
        <li>Create a new branch: <code>git checkout -b feature-name</code></li>
        <li>Make your changes and commit them: <code>git commit -m 'Add feature'</code></li>
        <li>Push your changes: <code>git push origin feature-name</code></li>
        <li>Create a pull request to merge your changes.</li>
    </ol>

    <h2>License</h2>
    <p>This project is licensed under the MIT License. See the <code>LICENSE</code> file for details.</p>

    <footer>
        <p>&copy; 2024 Computer Lab Management. All rights reserved.</p>
    </footer>

</body>
</html>
