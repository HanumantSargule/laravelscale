# Service Marketplace Platform

A scalable Laravel-based service marketplace platform where providers can create listings, customers can search and send enquiries, and administrators can moderate content.

This project demonstrates clean architecture, performance-focused database design, RESTful APIs, and scalable search implementation.

---

## 🧱 Tech Stack

- Laravel 11
- MySQL
- Bootstrap (Blade UI)
- Sanctum (API Authentication)
- Cursor Pagination
- Service Layer Architecture

---

## 🏗 Architecture Overview

The application follows a clean separation of concerns:

Presentation Layer:
- Blade (Web UI)
- RESTful API

Application Layer:
- Controllers (thin)
- Form Requests (validation)
- Policies (authorization)

Domain Layer:
- Services (business logic)
- Actions (write operations)

Data Layer:
- Eloquent Models
- Indexed database schema

---

## 👥 User Roles

- Guest (browse listings)
- Customer (send enquiries)
- Provider (create/manage listings)
- Administrator (moderate listings)

---

## 📦 Core Features

### Listings
- Title & description
- Category
- Location (city)
- Pricing (hourly / fixed)
- Status:
  - draft
  - pending
  - approved
  - suspended

### Search & Discovery
- Keyword search (Full-text index)
- Filters:
  - Category
  - City
  - Price range
- Sorting:
  - Relevance
  - Newest
  - Price
- Cursor-based infinite scroll

### Enquiry Flow
- Customers send enquiry to providers
- Providers reply via internal messaging
- No direct email exposure
- Thread-based conversations
- Role-based access control

---

## 🔍 Scalability Strategy

To support millions of listings:

- Composite indexing (status + created_at)
- Indexes on price, city, foreign keys
- Full-text search on title & description
- Cursor pagination (no OFFSET)
- Optimized select queries
- Service-based reusable search logic

Future scalability improvements:
- Redis caching
- Elasticsearch integration
- Read replicas
- Queue-based indexing

---

## 🔐 Security

- Sanctum API authentication
- Policy-based authorization
- Role-based enquiry access
- No email exposure between users
- Input validation via FormRequest
- Middleware protection for admin routes

---

## 🌐 RESTful API Endpoints

### Public

GET /api/listings  
GET /api/listings/{id}

### Protected (Sanctum Required)

POST /api/listings  
PUT /api/listings/{id}  
DELETE /api/listings/{id}

POST /api/listings/{listing}/enquiries  
GET /api/enquiries/{id}  
POST /api/enquiries/{id}/reply  

---

## 📄 Web Routes

GET / → Loads listing page (Blade)  
Listings loaded dynamically via API using infinite scroll.

---

## ⚙️ Setup Instructions

### 1️⃣ Clone Repository

