# Elmotaheda Company API Documentation

A secure, high-performance RESTful API built with Laravel to power the web platform and administrative dashboard of **Elmotaheda Sabagh**.

This document serves as the official reference for all available API endpoints, authentication rules, request payloads, and response structures.

---

## 🌐 Base URL

### Production
```text
https://elmotahedasabagh.com/api
```

### Local Development
```text
http://localhost:8000/api
```

---

# 🔒 Authentication & Headers

All protected endpoints require **Laravel Sanctum Authentication**.

## Required Headers

| Header | Value |
|---------|---------|
| Accept | application/json |
| Content-Type | application/json |
| Authorization | Bearer {your_sanctum_token} |

---

# 📌 API Endpoints

## 1. Authentication

### Register a New Admin Account

**Endpoint**

```http
POST /api/register
```

**Authentication Required**

```text
No
```

**Request Body**

```json
{
    "name": "Admin Name",
    "email": "admin@example.com",
    "password": "securepassword123",
    "password_confirmation": "securepassword123"
}
```

**Success Response**

```json
{
    "status": true,
    "message": "registered successfully",
    "data": {
        "id": 1,
        "name": "Admin Name",
        "email": "admin@example.com"
    }
}
```

---

# 2. Public Website Modules

## Submit Contact Form

**Endpoint**

```http
POST /api/contact-us
```

**Authentication Required**

```text
No
```

**Request Body**

```json
{
    "name": "John Doe",
    "phone": "+201012345678",
    "area": "Fifth Settlement",
    "service_type": "Interior Painting",
    "message": "I want to estimate the cost for a 150m apartment."
}
```

**Success Response**

```json
{
    "status": true,
    "message": "Message submitted successfully",
    "data": {}
}
```

---

## Track Visitor

**Endpoint**

```http
POST /api/track-visit
```

**Authentication Required**

```text
No
```

**Request Body**

```text
None
```

**Success Response**

```json
{
    "status": true,
    "message": "Visit tracked successfully"
}
```

---

# 3. Dashboard Statistics

## Fetch Dashboard Statistics

**Endpoint**

```http
GET /api/dashboard/stats
```

**Authentication Required**

```text
Yes (Sanctum)
```

**Success Response**

```json
{
    "status": true,
    "data": {
        "total_visitors": 1420,
        "total_messages": 35,
        "total_portfolios": 18
    }
}
```

---

# 4. Contact Messages Management

## List Contact Messages

**Endpoint**

```http
GET /api/contact-messages
```

**Authentication Required**

```text
Yes (Sanctum)
```

**Success Response**

```json
{
    "status": true,
    "count": 35,
    "data": []
}
```

---

## Delete Contact Message

**Endpoint**

```http
DELETE /api/contact-messages/{id}
```

**Authentication Required**

```text
Yes (Sanctum)
```

**Path Parameters**

| Parameter | Description |
|------------|------------|
| id | Message ID |

**Success Response**

```json
{
    "status": true,
    "message": "deleted successfully"
}
```

---

# 5. Admin Management

## List Admins

**Endpoint**

```http
GET /api/admins
```

**Authentication Required**

```text
Yes (Sanctum)
```

**Success Response**

```json
{
    "status": true,
    "data": []
}
```

---

## Create Admin

**Endpoint**

```http
POST /api/admins
```

**Authentication Required**

```text
Yes (Sanctum)
```

**Request Body**

```json
{
    "name": "Assistant Admin",
    "email": "assistant@example.com",
    "password": "password123"
}
```

**Success Response**

```json
{
    "status": true,
    "message": "added successfully",
    "data": {}
}
```

---

## Delete Admin

**Endpoint**

```http
DELETE /api/admins/{id}
```

**Authentication Required**

```text
Yes (Sanctum)
```

**Security Note**

```text
Self-deletion is not allowed.
```

**Success Response**

```json
{
    "status": true,
    "message": "deleted successfully"
}
```

---

# 6. Portfolio Management

## Create Portfolio Item

**Endpoint**

```http
POST /api/portfolios
```

**Authentication Required**

```text
Yes (Sanctum)
```

**Request Type**

```text
multipart/form-data
```

**Success Response**

```json
{
    "status": true,
    "message": "created successfully",
    "data": {}
}
```

---

## Update Portfolio Item

**Endpoint**

```http
PUT /api/portfolios/{id}
```

or

```http
POST /api/portfolios/{id}
```

with:

```text
_method=PUT
```

**Authentication Required**

```text
Yes (Sanctum)
```

**Success Response**

```json
{
    "status": true,
    "message": "updated successfully",
    "data": {}
}
```

---

## Delete Portfolio Item

**Endpoint**

```http
DELETE /api/portfolios/{id}
```

**Authentication Required**

```text
Yes (Sanctum)
```

**Success Response**

```json
{
    "status": true,
    "message": "deleted successfully"
}
```

---

# 📊 HTTP Status Codes

| Code | Meaning |
|--------|--------|
| 200 | Request completed successfully |
| 201 | Resource created successfully |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Resource not found |
| 422 | Validation error |
| 500 | Internal server error |

---

# 🚀 Example Authenticated Request

```bash
curl --request GET \
  --url https://elmotahedasabagh.com/api/dashboard/stats \
  --header "Accept: application/json" \
  --header "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

# 📝 Notes

- All protected endpoints require a valid Sanctum token.
- Portfolio image uploads should use `multipart/form-data`.
- Visitor tracking stores unique IP addresses per day.
- All responses are returned in JSON format.

---
