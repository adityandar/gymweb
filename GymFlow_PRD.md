# PRD --- GymFlow: Gym Membership Management Platform

## 1. Product Overview

### Product Name

GymFlow

### Product Vision

GymFlow is a full-stack gym membership management platform that helps
gym owners manage members, memberships, payments, attendance, trainers,
and workout progress digitally.

### Portfolio Objective

This project demonstrates full-stack engineering capabilities:

-   Frontend architecture
-   Backend API development
-   Database design
-   Authentication and authorization
-   Payment integration
-   Dashboard development
-   Deployment and DevOps

------------------------------------------------------------------------

# 2. Target Users

## Admin / Gym Owner

Goals: - Manage gym members - Manage membership plans - Monitor
revenue - View attendance analytics

## Trainer

Goals: - Manage assigned members - Create workout programs - Track
member progress

## Member

Goals: - Purchase membership - View membership status - Track workout
progress - Book classes

------------------------------------------------------------------------

# 3. Technology Stack

## Frontend

Recommended:

-   React
-   TypeScript
-   Vite
-   TanStack Query
-   React Router
-   TailwindCSS
-   Shadcn UI

## Backend

Recommended:

-   NestJS
-   Prisma ORM
-   PostgreSQL
-   JWT Authentication
-   Docker

## Deployment

Frontend: - Vercel

Backend: - Docker VPS

Database: - PostgreSQL

------------------------------------------------------------------------

# 4. Core Features

# Authentication & Authorization

## Requirements

Implement:

-   Register
-   Login
-   Logout
-   Forgot password
-   JWT authentication
-   Role-based access control

Roles:

    ADMIN
    TRAINER
    MEMBER

Rules:

-   Unauthenticated users cannot access private pages.
-   Member cannot access admin dashboard.
-   API must validate user permissions.

------------------------------------------------------------------------

# Membership Management

## Admin Features

Admin can:

-   Create membership plans
-   Update membership plans
-   Delete membership plans
-   Enable/disable plans

Example plans:

  Name      Duration    Price
  --------- ----------- ---------
  Basic     1 Month     300000
  Premium   3 Months    750000
  Annual    12 Months   2500000

Database:

    membership_plans

    id
    name
    duration_month
    price
    description
    status
    created_at

------------------------------------------------------------------------

# Member Management

Admin dashboard must provide:

-   Member list
-   Search member
-   Filter membership status
-   Member detail

Member detail:

-   Profile information
-   Active membership
-   Payment history
-   Attendance history
-   Workout progress

------------------------------------------------------------------------

# Membership Purchase Flow

Member workflow:

    Select Plan
        |
    Create Order
        |
    Payment Pending
        |
    Payment Success
        |
    Membership Activated

Order entity:

    orders

    id
    user_id
    plan_id
    amount
    status
    payment_method
    created_at

Order status:

    PENDING
    PAID
    FAILED
    EXPIRED

------------------------------------------------------------------------

# Payment Integration

Use:

-   Midtrans Sandbox

Requirements:

-   Generate payment request
-   Receive webhook callback
-   Update payment status
-   Activate membership automatically

Flow:

    Payment Gateway
            |
          Webhook
            |
          Backend
            |
        Update Database

------------------------------------------------------------------------

# Attendance System

Member can check in.

Preferred implementation:

QR Code attendance.

Flow:

    Member opens dashboard
            |
    Generate QR
            |
    Gym scans QR
            |
    Attendance recorded

Entity:

    attendance

    id
    member_id
    check_in_time
    date

------------------------------------------------------------------------

# Workout Progress Tracking

Trainer can create workout programs.

Example:

    Workout Day 1

    Exercise:
    Bench Press

    Sets:
    3

    Reps:
    10

    Weight:
    80kg

Entities:

    workout_plans

    id
    trainer_id
    member_id
    title


    exercise_logs

    id
    plan_id
    exercise_name
    sets
    reps
    weight
    notes

------------------------------------------------------------------------

# Class Booking System

Gym classes:

Examples:

-   Yoga
-   Boxing
-   Zumba

Features:

-   View schedule
-   Book class
-   Cancel booking
-   Capacity management

Entities:

    classes

    id
    name
    trainer_id
    schedule
    capacity


    bookings

    id
    class_id
    member_id
    status

------------------------------------------------------------------------

# Notification System

Notifications:

-   Membership expiration reminder
-   Payment confirmation
-   Class reminder

Implementation:

Phase 1: - Email notification

Phase 2: - Web push notification

------------------------------------------------------------------------

# 5. Frontend Pages

## Public Pages

    /
    Pricing
    About
    Login
    Register

## Member Pages

    /dashboard
    /membership
    /payment-history
    /workout
    /classes
    /profile

## Admin Pages

    /admin/dashboard
    /admin/members
    /admin/plans
    /admin/payments
    /admin/reports

------------------------------------------------------------------------

# 6. Backend Architecture

Architecture:

    Controller

        |

    Service

        |

    Repository

        |

    Database

Modules:

    Auth Module

    User Module

    Membership Module

    Payment Module

    Attendance Module

    Workout Module

    Class Module

------------------------------------------------------------------------

# 7. Database Design

Main entities:

    Users

    Membership Plans

    Membership

    Orders

    Payments

    Attendance

    Workout Plans

    Exercise Logs

    Classes

    Bookings

Relationship:

    User
     |
     |--- Membership
     |
     |--- Payment
     |
     |--- Attendance
     |
     |--- Workout Progress

------------------------------------------------------------------------

# 8. Non Functional Requirements

## Security

-   Hash password with bcrypt
-   JWT authentication
-   Request validation
-   Rate limiting

## Performance

-   API response target \< 300ms
-   Pagination for large datasets
-   Database indexing

## Code Quality

-   Clean architecture
-   Modular design
-   Environment configuration
-   Automated testing

------------------------------------------------------------------------

# 9. Development Roadmap

## Phase 1: MVP

Duration: 2-3 weeks

Features:

-   Authentication
-   Role system
-   Membership CRUD
-   Member dashboard
-   Admin dashboard

## Phase 2: Business Features

Duration: 2 weeks

Features:

-   Payment integration
-   Membership activation
-   Attendance system

## Phase 3: Advanced Features

Duration: 2-3 weeks

Features:

-   Trainer dashboard
-   Workout tracking
-   Class booking
-   Notifications

------------------------------------------------------------------------

# 10. AI Agent Development Instructions

The coding agent should:

1.  Build features incrementally.
2.  Keep frontend and backend separated.
3.  Follow clean architecture principles.
4.  Create reusable components.
5.  Write API documentation.
6.  Add database migrations.
7.  Use environment variables.
8.  Create Docker configuration.
9.  Add tests for critical business logic.

Priority order:

    1. Project Setup
    2. Database Schema
    3. Authentication
    4. Membership System
    5. Dashboard
    6. Payment
    7. Attendance
    8. Workout
    9. Deployment

------------------------------------------------------------------------

# 11. Future Enhancements

Possible future features:

-   Mobile application
-   AI workout assistant
-   Multi-gym SaaS support
-   Revenue analytics
-   Subscription billing
