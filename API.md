# API Documentation

Base URL: `/api/v1`

## Authentication

### POST `/login`

Request body:

```json
{
  "email": "user@example.com",
  "password": "password"
}
```

Response (200):

```json
{
  "success": true,
  "message": "Login successful",
  "token": "1|...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "user_type": 3
  }
}
```

Use the token in subsequent requests:

```
Authorization: Bearer {token}
```

### POST `/logout` (auth required)

### GET `/me` (auth required)

## Resources (auth required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/notes` | List notes (filtered by role) |
| GET | `/emplois-du-temps` | List schedules |
| GET | `/absences` | List absences |
| GET | `/modules` | List modules |

User types: `1` Admin, `2` Teacher, `3` Student, `4` Parent.
