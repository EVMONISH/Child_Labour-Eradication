# Child Labour Eradication System - Documentation

This document outlines the entire structure, modules, frontend views, and backend logic of the Child Labour Eradication System project.

## 1. System Modules

The application is divided into three primary modules based on user roles and accessibility:

### 1.1 Public Module
Designed for anonymous or registered citizens to report incidents of child labour and track the status of their reports.
- **Features**: Submit a new complaint, receive a unique tracking ID, and check the status of a previously submitted complaint.

### 1.2 Admin Module
The central command hub for system administrators or government officials.
- **Features**: 
  - Review public complaints and approve (convert to active cases) or reject them.
  - Manage active rescue operations (Cases) and assign them to registered NGOs.
  - Manage a centralized database of rescued children.
  - View analytics and trends regarding child labour reports and rescue operations.

### 1.3 NGO Module
A dedicated portal for Non-Governmental Organizations involved in the rescue and rehabilitation process.
- **Features**:
  - View active cases assigned to their organization.
  - Add progress updates and logs for the rescue operation.
  - Register rescued children into the system database linked to the specific case.

---

## 2. Backend Logic (Controllers & Routing)

The backend is built with Laravel and utilizes standard MVC architecture.

### Public Controllers
- **`ComplaintController`**: 
  - `create()` / `store()`: Displays and processes the public complaint form. Generates a unique `tracking_id`.
  - `success()`: Displays the success page with the tracking ID.
  - `track()`: Looks up a complaint by its tracking ID and displays its current status.

### Auth Controllers
- **`LoginController`**: Handles user authentication and redirects users to either the Admin Dashboard or NGO Dashboard based on their role (`admin` or `ngo`).

### Admin Controllers (`App\Http\Controllers\Admin`)
- **`DashboardController`**: Aggregates summary statistics (total complaints, active cases, rescued children) for the admin dashboard.
- **`ComplaintAdminController`**: Lists pending/all complaints, and contains logic to `approve()` (which creates a new `ChildCase`) or `reject()` a complaint.
- **`CaseController`**: Lists active cases. The `assignNgo()` method links an NGO to a case, and `updateStatus()` manages the case lifecycle (e.g., pending, in-progress, resolved).
- **`ChildController`**: Provides CRUD operations for the registry of rescued children.
- **`AnalyticsController`**: Prepares chart data (e.g., complaints per month, cases by status) for the analytics view.

### NGO Controllers (`App\Http\Controllers\Ngo`)
- **`NgoCaseController`**: 
  - `dashboard()`: Lists cases assigned specifically to the logged-in NGO.
  - `show()`: Displays detailed case information.
  - `updateProgress()`: Appends a new `CaseUpdate` log to the case history.
  - `addChild()`: Allows NGOs to register a rescued child directly from the case view.

---

## 3. Database Models

- **`User`**: Core authentication model. Includes a `role` attribute (`admin` or `ngo`).
- **`Ngo`**: Stores detailed information about the NGO, linked to a User account.
- **`Complaint`**: Represents a public report. Fields include reporter details (optional), incident description, location, and status (`pending`, `approved`, `rejected`).
- **`ChildCase`**: An active rescue operation spawned from an approved complaint. Tracks the `ngo_id`, case status, and linked `complaint_id`.
- **`CaseUpdate`**: A log entry representing progress on a `ChildCase`.
- **`Child`**: The profile of a rescued individual, containing demographic information, condition upon rescue, and linked to the `ChildCase`.

---

## 4. Frontend (Blade Views)

The frontend is built using Laravel Blade templating and styled with CSS (managed via Vite).

### Public Views
- `welcome.blade.php`: The main landing page with system information and a call-to-action to report incidents.
- `complaint/create.blade.php`: The incident reporting form.
- `complaint/track.blade.php`: Form to check complaint status via tracking ID.

### Admin Views (`resources/views/admin/`)
- `dashboard.blade.php`: The main dashboard featuring summary cards and quick links.
- `complaints/index.blade.php` & `show.blade.php`: Interfaces for reviewing and processing incoming reports.
- `cases/index.blade.php` & `show.blade.php`: Case management views where admins can assign NGOs and review progress logs.
- `children/index.blade.php` & `show.blade.php`: The database table view for rescued children profiles.
- `analytics.blade.php`: Visual representation of system data using chart libraries.

### NGO Views (`resources/views/ngo/`)
- `dashboard.blade.php`: A customized dashboard showing only cases assigned to the logged-in NGO.
- `cases/show.blade.php`: A detailed case view with forms specifically for submitting progress updates and registering newly rescued children.

### Shared / Layout Views
- `layouts/app.blade.php`: The primary layout wrapper containing the navigation bar, sidebar, and core assets inclusion (`@vite`).
- `auth/login.blade.php`: The login screen for Admins and NGOs.
