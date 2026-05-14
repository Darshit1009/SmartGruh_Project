# SmartGruh - Smart Home Automation System

SmartGruh is a web-based smart home automation dashboard that allows users to manage rooms and switches, and enables electricians to control devices via MQTT.

## Features

- **User Authentication**: Secure login and signup with OTP verification (via PHPMailer).
- **Role-based Access**: Different dashboards for Admin, User, and Electrician.
- **Room Management**: Create and manage rooms.
- **Switchboard**: Interactive switchboard with drag-and-drop support (via interact.js).
- **MQTT Integration**: Real-time device control using HiveMQ and MQTT.js.
- **Environment Configuration**: Secure credential management using `.env`.

## Tech Stack

- **Backend**: PHP (MySQLi)
- **Frontend**: HTML, CSS, JavaScript (interact.js, MQTT.js)
- **Email**: PHPMailer
- **Database**: MySQL

## Installation

1.  **Clone the repository**:
    ```bash
    git clone https://github.com/your-username/smartgruh.git
    cd smartgruh
    ```

2.  **Install dependencies**:
    ```bash
    composer install
    ```

3.  **Database Setup**:
    - Import `smartgruh.sql` into your MySQL database.
    - Configure your database credentials in `.env` (copy from `.env.example`).

4.  **Environment Configuration**:
    - Create a `.env` file based on `.env.example` and provide your credentials:
      - `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`
      - `MAIL_HOST`, `MAIL_USER`, `MAIL_PASS`, `MAIL_PORT`
      - `MQTT_HOST`, `MQTT_USER`, `MQTT_PASS`

5.  **Run the application**:
    - Point your web server to the project directory.

## Security

- Prepared statements are used to prevent SQL injection.
- Passwords are hashed using `password_hash()`.
- Sensitive credentials are stored in `.env` and excluded from version control.

## License

This project is licensed under the MIT License.
