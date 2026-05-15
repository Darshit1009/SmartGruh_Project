# SmartGruh - Smart Home Automation System

SmartGruh is a modern, real-time home automation platform designed for users to monitor their homes and for electricians to manage infrastructure. It bridges the gap between traditional electrical systems and IoT.

## 🚀 Key Features

- **Multi-Role Dashboard**: Tailored experiences for **Users** (control), **Electricians** (setup & maintenance), and **Admins** (system overview).
- **Interactive Switchboard**: 
    - **Visual Control**: Aesthetic switches for Lights, Fans, ACs, and TVs.
    - **Drag & Drop**: Customizable layout using `interact.js`.
    - **Instant Feedback**: Real-time UI updates using `MQTT.js`.
- **Real-Time IoT Synchronization**:
    - **Hybrid Control**: Publish MQTT messages instantly from the browser for zero-latency control.
    - **Two-Way Sync**: UI automatically reflects changes made from external sources (ESP32, HiveMQ Console, etc.) via MQTT subscriptions.
    - **Persistent State**: Background AJAX synchronization ensures the database always reflects the current device state.
- **Secure Authentication**: 
    - Email-based signup/login.
    - **OTP Verification**: Secure verification via PHPMailer for sensitive operations.
- **Environment Management**: Securely managed credentials using `php-dotenv`.

## 🛠 Tech Stack

- **Backend**: PHP 8.x, MySQL.
- **Frontend**: Vanilla CSS (Professional UI), JavaScript.
- **IoT Protocol**: MQTT (HiveMQ Cloud).
- **Libraries**:
    - `MQTT.js`: Persistent WebSocket connections for instant IoT control.
    - `interact.js`: For draggable switchboard elements.
    - `PHPMailer`: For transactional emails and OTPs.
    - `php-mqtt/client`: For backend MQTT capabilities.

## 📦 Installation & Setup

1.  **Dependencies**: Run `composer install`.
2.  **Database**: Import `smartgruh.sql` to MySQL.
3.  **Environment**: Configure `.env` with:
    - Database credentials.
    - SMTP settings (for OTP).
    - HiveMQ Cloud credentials (use port 8884 for WSS in JS).

## 🔌 MQTT Architecture

- **Protocol**: WebSockets over SSL (WSS) on Port 8884.
- **Broker**: HiveMQ Cloud.
- **Logic**: 
    - **Publish**: `client.publish('home/room/led', 'ON')`
    - **Subscribe**: `client.subscribe('home/room/led')`
    - **Sync**: Listener updates `.switch-btn.active` class instantly on incoming messages.

---
Developed as a robust solution for modern smart home management.
