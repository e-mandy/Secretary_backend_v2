# Secretary Backend API — Integration Guide

REST API for managing secretary operations. Base URL for all endpoints: `{APP_URL}/api`

---

## Authentication

Most endpoints require a Bearer token obtained from login.

```
Authorization: Bearer <access_token>
```

Access tokens expire after **15 minutes**. Use the refresh endpoint with the `refresh_token` cookie to obtain a new pair without re-logging in.

### Login

```
POST /secretary/login
Content-Type: application/json
```

**Body**
```json
{
  "email": "secretary@example.com",
  "password": "password"
}
```

**Response `200`**
```json
{
  "type": "Secretary Login",
  "message": "Connexion réussie",
  "data": {
    "access_token": "<token>",
    "token_type": "Bearer"
  }
}
```

> A `refresh_token` HttpOnly cookie is also set automatically.

### Refresh Token

```
POST /refresh
```

No body needed — the refresh token is read from the cookie.

**Response `200`** — same shape as login, issues a new access token and rotates the refresh cookie.

---

## Allowed Enum Values

These values are enforced by the API. Any other value returns `422`.

| Field | Accepted values |
|---|---|
| `filiere` | `Master`, `Licence` |
| `option` | `AL`, `SI`, `SRC`, `IA` |

---

## Defense Report Module

Manages defense proceedings (PV de soutenance). All files must be **PDF**, max **4 MB**.

### Resource shape

Every endpoint that returns a defense report uses this structure:

```json
{
  "id": 1,
  "owner": "Jean Dupont",
  "theme": "Intelligence artificielle appliquée à la santé",
  "defense_date": "2025-06-20",
  "filiere": "Master",
  "option": "IA",
  "note": 16.50,
  "file_url": "http://yourapp.com/storage/uploads/defense_reports/report.pdf",
  "created_at": "2025-06-20T09:00:00.000000Z"
}
```

---

### List defense reports

```
GET /secretary/defense-reports?page=1
Authorization: Bearer <token>
```

Returns **10 records per page**, sorted by newest first.

**Response `200`**
```json
{
  "type": "Get Defense Reports",
  "data": {
    "data": [ ...defense report objects... ],
    "links": {
      "first": ".../defense-reports?page=1",
      "last":  ".../defense-reports?page=4",
      "prev":  null,
      "next":  ".../defense-reports?page=2"
    },
    "meta": {
      "current_page": 1,
      "last_page": 4,
      "per_page": 10,
      "total": 38,
      "from": 1,
      "to": 10
    }
  }
}
```

> Navigate pages with `?page=N`. When `links.next` is `null` you are on the last page.

---

### Get a single defense report

```
GET /secretary/defense-report/{id}
Authorization: Bearer <token>
```

**Response `200`**
```json
{
  "type": "Get Defense Report",
  "data": { ...defense report object... }
}
```

**Response `404`** — record not found.

---

### Create a defense report

```
POST /secretary/defense-report/create
Authorization: Bearer <token>
Content-Type: multipart/form-data
```

**Fields**

| Field | Type | Required | Rules |
|---|---|---|---|
| `owner` | string | yes | Student / candidate full name |
| `theme` | string | yes | Max 255 characters |
| `defense_date` | string | yes | Format `YYYY-MM-DD` |
| `filiere` | string | yes | `Master` or `Licence` |
| `option` | string | yes | `AL`, `SI`, `SRC`, or `IA` |
| `note` | decimal | yes | Up to 2 decimal places (e.g. `16.50`) |
| `file` | file | yes | PDF only, max 4 MB |

**Example request (curl)**
```bash
curl -X POST http://yourapp.com/api/secretary/defense-report/create \
  -H "Authorization: Bearer <token>" \
  -F "owner=Jean Dupont" \
  -F "theme=IA appliquée à la santé" \
  -F "defense_date=2025-06-20" \
  -F "filiere=Master" \
  -F "option=IA" \
  -F "note=16.50" \
  -F "file=@/path/to/report.pdf"
```

**Response `201`**
```json
{
  "type": "Defense Report Storage",
  "message": "PV de soutenance créé avec succès",
  "data": { ...defense report object... }
}
```

---

### Update a defense report

All fields are optional — send only what changed. If a new `file` is provided the old PDF is deleted automatically.

```
PUT /secretary/defense-report/{id}
Authorization: Bearer <token>
Content-Type: multipart/form-data
```

**Fields** — same as create, all `optional`

**Response `200`**
```json
{
  "type": "Defense Report Update",
  "message": "PV de soutenance mis à jour avec succès",
  "data": { ...updated defense report object... }
}
```

**Response `404`** — record not found.

---

### Delete a defense report

Deletes the record and removes the associated PDF from storage.

```
DELETE /secretary/defense-report/{id}
Authorization: Bearer <token>
```

**Response `200`**
```json
{
  "type": "Defense Report Delete",
  "message": "PV de soutenance supprimé avec succès"
}
```

**Response `404`** — record not found.

---

## Common Error Responses

| Status | Meaning |
|---|---|
| `400` | Bad request (business rule violation, e.g. duplicate email) |
| `401` | Missing or expired access token |
| `404` | Resource not found (Route Model Binding returns this automatically) |
| `422` | Validation failed — response includes a `errors` object keyed by field name |
| `500` | Server error |

**Validation error shape (`422`)**
```json
{
  "message": "The filiere field is required.",
  "errors": {
    "filiere": ["The filiere field is required."],
    "file": ["The file field must be a file of type: pdf."]
  }
}
```

---

## Other Modules

### Professors

| Method | URL | Description |
|---|---|---|
| `GET` | `/secretary/professors` | List professors (10 per page) |
| `GET` | `/secretary/professors/search?search=query` | Search by name or email |
| `GET` | `/secretary/professor/{id}` | Get professor with matters and documents |
| `POST` | `/secretary/professor/create` | Create professor (`multipart/form-data`, optional `documents[]`) |
| `PUT` | `/secretary/professor/{id}` | Update professor |
| `DELETE` | `/secretary/professor/{id}` | Delete professor |
| `POST` | `/secretary/documents/{professor_id}/add` | Attach documents to a professor |

### Matters

| Method | URL | Description |
|---|---|---|
| `GET` | `/matters` | List all matters (no auth required) |

### Documents

| Method | URL | Description |
|---|---|---|
| `GET` | `/documents/{id}/download` | Download a document file |
| `DELETE` | `/documents/{id}` | Delete a document |
