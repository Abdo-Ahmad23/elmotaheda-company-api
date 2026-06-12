# Elmotaheda Company API Documentation

A secure, high-performance RESTful API built with Laravel to power the web platform and administrative dashboard of **Elmotaheda Sabagh**. This document serves as the absolute reference for all available API endpoints, request payloads, and authentication rules.

---

## 🔒 Authentication & Headers

All protected endpoints require token-based authentication via **Laravel Sanctum**.

### Required Headers for All Requests:
- `Accept`: `application/json`
- `Content-Type`: `application/json`
- `Authorization`: `Bearer {your_secret_sanctum_token}` *(Required only for Protected Endpoints)*

---

## 🔌 API Endpoints Reference

### 1. Authentication Modules
#### 🔹 Register a New Admin Account (Initial Setup / Public Access)
- **Method:** `POST`
- **Endpoint:** `/api/register`
- **Auth Required:** No
- **Request Body (JSON):**
  ```json
  {
      "name": "Admin Name",
      "email": "admin@example.com",
      "password": "securepassword123",
      "password_confirmation": "securepassword123"
  }
  

### 2. Public Website Modules (Visitor Facing)

#### 🔹 Submit Contact Form / Message
- **Method:** `POST`
- **Endpoint:** `/api/contact-us`
- **Auth Required:** No
- **Request Body (JSON):**
  ```json
  {
      "name": "John Doe",
      "phone": "+201012345678",
      "area": "Fifth Settlement",
      "service_type": "Interior Painting",
      "message": "I want to estimate the cost for a 150m apartment."
  }
  
Success Response (201 Created): Returns status: true, a success message, and the saved message object.



🔹 Track Unique Visitor Traffic
Method: POST

Endpoint: /api/track-visit

Auth Required: No

Description: Invoked automatically by the frontend application upon home page load. Automatically filters and stores unique client IP addresses per day.

Request Body: None (Laravel automatically captures the request IP).

Success Response (200 OK): {"status": true, "message": "Visit tracked successfully"}

### 3. Administrative Dashboard Modules

#### 🔹 Fetch Dashboard Aggregated Statistics
- **Method:** `GET`
- **Endpoint:** `/api/dashboard/stats`
- **Auth Required:** Yes (Sanctum)
- **Description:** Fetches summary metrics to render analytical counters on the dashboard view.
- **Success Response (200 OK):**
  ```json
  {
      "status": true,
      "data": {
          "total_visitors": 1420,
          "total_messages": 35,
          "total_portfolios": 18
      }
  }
  

4. Contact Messages Management (Admin Panel)
🔹 List All Contact Messages
Method: GET

Endpoint: /api/contact-messages

Auth Required: Yes (Sanctum)

Description: Fetches all inquiries sent by clients, sorted from newest to oldest.

Success Response (200 OK): Returns status: true, total count of messages, and an array containing all message objects.

🔹 Delete a Contact Message
Method: DELETE

Endpoint: /api/contact-messages/{id}

Auth Required: Yes (Sanctum)

URL Parameters: id (The database ID of the message to delete).

Success Response (200 OK): {"status": true, "message": "deleted successfully"}

5. Admin User Management (Admin Panel)
🔹 List All Registered Admins
Method: GET

Endpoint: /api/admins

Auth Required: Yes (Sanctum)

Success Response (200 OK): Returns an array of all backend managers who have access to the panel.

🔹 Add a New Admin Account
Method: POST

Endpoint: /api/admins

Auth Required: Yes (Sanctum)

Request Body (JSON):

JSON


{
    "name": "Assistant Admin",
    "email": "assistant@example.com",
    "password": "password123"
}
Success Response (201 Created): {"status": true, "message": "added successfully", "data": {...}}

🔹 Delete an Admin Account
Method: DELETE

Endpoint: /api/admins/{id}

Auth Required: Yes (Sanctum)

URL Parameters: id (The database ID of the admin to delete).

Security Check: Prevents the currently logged-in admin from self-deletion.

Success Response (200 OK): {"status": true, "message": "deleted successfully"}

6. Portfolio Management Modules (Admin Panel)
🔹 Create a New Portfolio Item
Method: POST

Endpoint: /api/portfolios

Auth Required: Yes (Sanctum)

Request Body (Multipart Form-Data / JSON): Fields containing portfolio project specific details (Title, Description, Images, etc.).

Success Response (201 Created): Returns the newly created portfolio item configuration.

🔹 Update an Existing Portfolio Item
Method: PUT / POST (with _method=PUT Form-Data if handling file uploads)

Endpoint: /api/portfolios/{id}

Auth Required: Yes (Sanctum)

URL Parameters: id (The database ID of the portfolio item to modify).

Success Response (200 OK): Returns updated model object details.

🔹 Delete a Portfolio Item
Method: DELETE

Endpoint: /api/portfolios/{id}

Auth Required: Yes (Sanctum)

URL Parameters: id (The database ID of the portfolio item to drop).

Success Response (200 OK): Confirms the deletion of the specified portfolio object.
