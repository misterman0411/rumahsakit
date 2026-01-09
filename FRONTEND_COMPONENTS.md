# Frontend Components - Hospital Management System

## Daftar Komponen/Halaman yang Perlu Dibuat

---

## 1. Autentikasi & Keamanan

### Pages
- [ ] **Login Page** (`/login`)
  - Form email & password
  - Remember me checkbox
  - Link lupa password
  - Button login dengan loading state
  - Error message display
  
- [ ] **Forgot Password Page** (`/forgot-password`)
  - Form input email
  - Submit button
  - Link kembali ke login
  
- [ ] **Reset Password Page** (`/reset-password/:token`)
  - Form password baru
  - Konfirmasi password
  - Submit button
  
- [ ] **Logout Functionality**
  - Confirmation modal
  - Clear session/token

---

## 2. Dashboard (Per Role)

### Dashboard Admin (`/admin/dashboard`)
- [ ] Statistik keseluruhan sistem
- [ ] Total pasien, dokter, perawat
- [ ] Grafik kunjungan bulanan
- [ ] Grafik pendapatan
- [ ] Pasien rawat inap aktif
- [ ] Bed occupancy rate
- [ ] Recent activities
- [ ] Quick actions

### Dashboard Dokter (`/doctor/dashboard`)
- [ ] Jadwal praktik hari ini
- [ ] Daftar janji temu hari ini
- [ ] Pasien yang menunggu
- [ ] Riwayat konsultasi terbaru
- [ ] Quick access ke rekam medis
- [ ] Statistik pasien pribadi

### Dashboard Perawat (`/nurse/dashboard`)
- [ ] Daftar tugas hari ini
- [ ] Pasien rawat inap yang ditangani
- [ ] Vital signs yang perlu dicek
- [ ] Medication schedule
- [ ] Alert & notifications
- [ ] Quick access input vital signs

### Dashboard Front Office (`/frontoffice/dashboard`)
- [ ] Sistem antrian real-time
- [ ] Daftar janji temu hari ini
- [ ] Check-in status
- [ ] Quick registration pasien baru
- [ ] Statistik kunjungan hari ini

### Dashboard Apoteker (`/pharmacist/dashboard`)
- [ ] Daftar resep pending
- [ ] Stock alert (stok rendah)
- [ ] Obat expired yang akan datang
- [ ] Statistik penjualan obat
- [ ] Quick access input stock

### Dashboard Lab Technician (`/lab/dashboard`)
- [ ] Order lab pending
- [ ] Order yang perlu diproses
- [ ] Hasil yang sudah selesai
- [ ] Statistik test bulanan
- [ ] Quick access input hasil

### Dashboard Radiologi (`/radiology/dashboard`)
- [ ] Order radiologi pending
- [ ] Order dalam proses
- [ ] Hasil yang sudah selesai
- [ ] Statistik imaging bulanan
- [ ] Quick access upload hasil

### Dashboard Kasir (`/cashier/dashboard`)
- [ ] Invoice pending pembayaran
- [ ] Pembayaran hari ini
- [ ] Total pendapatan hari ini
- [ ] Metode pembayaran summary
- [ ] Quick access create invoice

### Dashboard Management (`/management/dashboard`)
- [ ] Executive summary
- [ ] Financial reports
- [ ] Grafik revenue & expenses
- [ ] Departmental performance
- [ ] Laporan komprehensif
- [ ] Export reports

---

## 3. Manajemen Pasien

### Pages
- [ ] **Patient List** (`/patients`)
  - Table dengan search & filter
  - Filter by: status, gender, department
  - Sort by: name, MR number, registration date
  - Pagination
  - Quick view patient info
  - Action buttons: View, Edit, Delete
  
- [ ] **Register New Patient** (`/patients/create`)
  - Form biodata lengkap
  - Auto-generate MR number
  - Upload foto (optional)
  - Emergency contact info
  - Insurance information
  - Validation & error handling
  
- [ ] **Patient Detail** (`/patients/:id`)
  - Patient profile card
  - Tab navigation:
    - Overview
    - Medical Records
    - Appointments
    - Prescriptions
    - Lab Results
    - Radiology Results
    - Inpatient History
    - Billing History
  - Action buttons
  
- [ ] **Edit Patient** (`/patients/:id/edit`)
  - Pre-filled form
  - Update functionality
  - Confirmation modal

---

## 4. Janji Temu & Antrian

### Pages
- [ ] **Appointment Calendar** (`/appointments`)
  - Calendar view (daily, weekly, monthly)
  - Color coded by status
  - Filter by doctor, department
  - Click to view detail
  - Drag & drop reschedule
  
- [ ] **Create Appointment** (`/appointments/create`)
  - Select patient (search autocomplete)
  - Select doctor
  - Select date & time
  - Select department
  - Appointment type
  - Notes/keluhan
  - Auto queue number generation
  
- [ ] **Appointment Detail** (`/appointments/:id`)
  - Full appointment info
  - Patient info card
  - Doctor info card
  - Status badge
  - Action buttons: Check-in, Cancel, Reschedule
  - Change status
  
- [ ] **Queue Management** (`/queue`)
  - Real-time queue display
  - Current queue number (large display)
  - Waiting list
  - Call next patient
  - Queue statistics
  - Audio/visual notification

---

## 5. Rekam Medis

### Pages
- [ ] **Medical Records List** (`/medical-records`)
  - Filter by patient, doctor, date
  - Search by diagnosis, procedure
  - Table view with key info
  - Export functionality
  
- [ ] **Create Medical Record** (`/medical-records/create`)
  - Select patient & appointment
  - Chief complaint (keluhan utama)
  - Vital signs input
  - Physical examination
  - ICD-10 diagnosis (autocomplete)
  - ICD-9 procedure codes
  - Treatment plan
  - Medication prescribed
  - Follow-up schedule
  - Doctor notes
  
- [ ] **Medical Record Detail** (`/medical-records/:id`)
  - Complete record view
  - Vital signs chart
  - Diagnosis & procedures
  - Treatment history
  - Print/export PDF
  - Edit button (with permission)
  
- [ ] **Vital Signs Form** (Component/Modal)
  - Blood pressure
  - Heart rate
  - Temperature
  - Respiratory rate
  - Oxygen saturation
  - Height & weight
  - BMI calculation
  - Timestamp

---

## 6. Resep & Farmasi

### Pages
- [ ] **Prescription List** (`/prescriptions`)
  - Filter by status: pending, dispensed
  - Filter by doctor, patient
  - Date range filter
  - Search functionality
  
- [ ] **Create Prescription** (`/prescriptions/create`)
  - Select patient
  - Select medical record (optional)
  - Add medication items:
    - Search medication (autocomplete)
    - Dosage
    - Frequency
    - Duration
    - Instructions
  - Total price calculation
  - Doctor signature
  
- [ ] **Prescription Detail** (`/prescriptions/:id`)
  - Patient info
  - Doctor info
  - Medication items table
  - Dosage instructions
  - Total price
  - Dispense button (pharmacist)
  - Print prescription
  
- [ ] **Medication Management** (`/medications`)
  - Medication master list
  - Add/edit/delete medication
  - Stock level indicator
  - Price management
  - Category/type filter
  - Low stock alert
  
- [ ] **Stock Management** (`/medications/stock`)
  - Current stock table
  - Add stock (purchase)
  - Remove stock (expired/damaged)
  - Stock movement history
  - Stock opname
  - Export stock report

---

## 7. Laboratorium

### Pages
- [ ] **Lab Orders List** (`/laboratory/orders`)
  - Filter by status: pending, in-progress, completed
  - Filter by patient, test type
  - Date range filter
  - Search functionality
  
- [ ] **Create Lab Order** (`/laboratory/orders/create`)
  - Select patient
  - Select medical record (optional)
  - Select test types (multiple selection)
  - Clinical notes
  - Urgent/routine flag
  - Ordering doctor
  
- [ ] **Lab Order Detail** (`/laboratory/orders/:id`)
  - Patient info
  - Ordered tests
  - Status tracking
  - Input results button
  - Print lab form
  
- [ ] **Input Lab Results** (`/laboratory/results/:orderId`)
  - Test parameters form
  - Value input
  - Reference range display
  - Abnormal flag
  - Lab technician notes
  - Verification signature
  - Upload images/attachments
  
- [ ] **Lab Test Types Management** (`/laboratory/test-types`)
  - Master data test types
  - Add/edit/delete tests
  - Price management
  - Parameter configuration
  
- [ ] **Lab Results View** (`/laboratory/results/:id`)
  - Complete results display
  - Parameters table
  - Abnormal flags highlighted
  - Print results
  - Export PDF

---

## 8. Radiologi

### Pages
- [ ] **Radiology Orders List** (`/radiology/orders`)
  - Filter by status: pending, in-progress, completed
  - Filter by patient, test type
  - Date range filter
  - Search functionality
  
- [ ] **Create Radiology Order** (`/radiology/orders/create`)
  - Select patient
  - Select medical record (optional)
  - Select test type (X-Ray, CT, MRI, Ultrasound)
  - Body part/region
  - Clinical indication
  - Urgent/routine flag
  - Ordering doctor
  
- [ ] **Radiology Order Detail** (`/radiology/orders/:id`)
  - Patient info
  - Test details
  - Status tracking
  - Input results button
  - Print form
  
- [ ] **Input Radiology Results** (`/radiology/results/:orderId`)
  - Upload images (DICOM/JPG/PNG)
  - Image viewer
  - Radiologist interpretation
  - Findings
  - Impression/conclusion
  - Radiologist signature
  
- [ ] **Radiology Test Types Management** (`/radiology/test-types`)
  - Master data test types
  - Add/edit/delete tests
  - Price management
  
- [ ] **Radiology Results View** (`/radiology/results/:id`)
  - Images gallery/viewer
  - Zoom, pan, brightness control
  - Interpretation text
  - Print results
  - Export PDF

---

## 9. Rawat Inap

### Pages
- [ ] **Inpatient Admissions List** (`/inpatient/admissions`)
  - Filter by status: active, discharged
  - Filter by room, department
  - Date range filter
  - Bed occupancy overview
  
- [ ] **Create Admission** (`/inpatient/admissions/create`)
  - Select patient
  - Select room & bed
  - Admission date & time
  - Admission diagnosis
  - Attending doctor
  - Admission type (emergency/elective)
  - Estimated LOS (length of stay)
  
- [ ] **Admission Detail** (`/inpatient/admissions/:id`)
  - Patient card
  - Room & bed info
  - Admission details
  - Tabs:
    - Daily Logs
    - Vital Signs
    - Medications
    - Additional Charges
    - Documents
  - Discharge button
  
- [ ] **Daily Nursing Log** (`/inpatient/admissions/:id/logs`)
  - Date & shift selector
  - Progress notes
  - Nursing interventions
  - Patient condition
  - Add log entry form
  - Timeline view
  
- [ ] **Vital Signs Monitoring** (`/inpatient/admissions/:id/vitals`)
  - Multiple daily entries
  - Vital signs form
  - Chart/graph visualization
  - Trend analysis
  - Alert for abnormal values
  
- [ ] **Additional Charges** (`/inpatient/admissions/:id/charges`)
  - Add charge item
  - Service/procedure list
  - Medicine used
  - Equipment rental
  - Total charges calculation
  
- [ ] **Discharge Patient** (`/inpatient/admissions/:id/discharge`)
  - Discharge date & time
  - Discharge condition
  - Discharge instructions
  - Follow-up appointment
  - Discharge summary
  - Generate final bill
  
- [ ] **Room & Bed Management** (`/inpatient/rooms`)
  - Room list by department
  - Bed availability status
  - Visual bed map
  - Room types & rates
  - Cleaning/maintenance status

---

## 10. Billing & Pembayaran

### Pages
- [ ] **Invoice List** (`/billing/invoices`)
  - Filter by status: unpaid, partial, paid
  - Filter by patient, date range
  - Search by invoice number
  - Outstanding amount summary
  
- [ ] **Create Invoice** (`/billing/invoices/create`)
  - Select patient
  - Link to appointment/admission
  - Add invoice items:
    - Service type (consultation, procedure, etc.)
    - Description
    - Quantity
    - Unit price
    - Subtotal
  - Discount
  - Tax
  - Total calculation
  - Notes
  
- [ ] **Invoice Detail** (`/billing/invoices/:id`)
  - Invoice header (number, date, patient)
  - Items table
  - Subtotal, tax, discount, grand total
  - Payment status
  - Payment history
  - Pay button
  - Print invoice
  - Send email
  
- [ ] **Payment Form** (`/billing/invoices/:id/pay`)
  - Invoice summary
  - Amount to pay
  - Payment method selection
  - Payment details (ref number, etc.)
  - Process payment button
  - Integration Midtrans (if online)
  
- [ ] **Payment Receipt** (`/billing/payments/:id`)
  - Receipt display
  - Payment details
  - Amount paid
  - Change amount
  - Print receipt
  
- [ ] **Payment History** (`/billing/payments`)
  - All payments list
  - Filter by date, method, cashier
  - Export to Excel
  - Daily closing report

---

## 11. Infrastruktur & Settings

### Pages
- [ ] **Department Management** (`/settings/departments`)
  - Department list
  - Add/edit/delete department
  - Department head assignment
  
- [ ] **Room Management** (`/settings/rooms`)
  - Room list by department
  - Add/edit/delete room
  - Room type & capacity
  - Daily rate
  
- [ ] **Bed Management** (`/settings/beds`)
  - Bed list by room
  - Add/edit/delete bed
  - Bed status (available, occupied, maintenance)
  
- [ ] **Service Charges** (`/settings/service-charges`)
  - Service catalog
  - Add/edit/delete service
  - Price management
  - Service category

---

## 12. Manajemen User & Staff

### Pages
- [ ] **User List** (`/users`)
  - Filter by role, department, status
  - Search by name, email
  - Table view
  
- [ ] **Add User** (`/users/create`)
  - User information form
  - Assign role
  - Assign department
  - Set permissions
  - Set password
  
- [ ] **User Detail** (`/users/:id`)
  - User profile
  - Role & permissions
  - Activity log
  - Edit button
  
- [ ] **Doctor Management** (`/doctors`)
  - Doctor list with specialization
  - Schedule management
  - Available hours
  - Consultation rates
  
- [ ] **Nurse Management** (`/nurses`)
  - Nurse list
  - Shift assignment
  - Ward assignment
  
- [ ] **Role & Permission** (`/settings/roles`)
  - Role list
  - Create custom role
  - Assign permissions
  - Permission matrix

---

## 13. Laporan & Analitik

### Pages
- [ ] **Patient Visit Report** (`/reports/visits`)
  - Date range selector
  - Filter by department, doctor
  - Table & chart view
  - Export to Excel/PDF
  
- [ ] **Revenue Report** (`/reports/revenue`)
  - Date range selector
  - Revenue by service type
  - Revenue by department
  - Payment method breakdown
  - Chart visualization
  - Export functionality
  
- [ ] **Medication Stock Report** (`/reports/medication-stock`)
  - Current stock levels
  - Stock movement history
  - Low stock items
  - Expired items
  - Export to Excel
  
- [ ] **Lab & Radiology Report** (`/reports/lab-radiology`)
  - Order statistics
  - Turnaround time analysis
  - Test volume by type
  - Export functionality
  
- [ ] **Inpatient Report** (`/reports/inpatient`)
  - Bed occupancy rate
  - Average LOS
  - Admission & discharge statistics
  - Revenue per bed
  - Export functionality

---

## 14. Komponen Umum (Reusable Components)

### UI Components
- [ ] **Layout Components**
  - Sidebar navigation
  - Top navbar
  - Breadcrumb
  - Footer
  
- [ ] **Form Components**
  - Input text, number, date, time
  - Select dropdown
  - Autocomplete search
  - File upload
  - Rich text editor
  - Form validation
  
- [ ] **Table Components**
  - Data table with sorting
  - Pagination
  - Search & filter
  - Export buttons
  - Bulk actions
  
- [ ] **Modal/Dialog**
  - Confirmation modal
  - Alert dialog
  - Form modal
  - Image viewer modal
  
- [ ] **Card Components**
  - Stat card (dashboard)
  - Patient card
  - Doctor card
  - Info card
  
- [ ] **Charts**
  - Line chart
  - Bar chart
  - Pie chart
  - Area chart
  
- [ ] **Notification System**
  - Toast notifications
  - Alert banners
  - Badge indicators
  
- [ ] **Loading States**
  - Skeleton loaders
  - Spinner
  - Progress bar
  
- [ ] **Empty States**
  - No data placeholder
  - Error states
  - 404 page
  
- [ ] **Print Components**
  - Print layout wrapper
  - Printable forms
  - CSS print styles

---

## 15. Fitur Advanced

### Features
- [ ] **Search Global**
  - Search across all modules
  - Recent searches
  - Quick navigation
  
- [ ] **Notifications Center**
  - Real-time notifications
  - Notification list
  - Mark as read
  - Notification settings
  
- [ ] **Export Functionality**
  - Export to PDF
  - Export to Excel
  - Export to CSV
  - Custom report builder
  
- [ ] **User Profile**
  - Edit profile
  - Change password
  - Avatar upload
  - Preferences/settings
  
- [ ] **Activity Logs**
  - User activity tracking
  - Audit trail
  - Login history
  
- [ ] **System Settings**
  - General settings
  - Email configuration
  - Payment gateway settings
  - Backup & restore
  
- [ ] **Help & Documentation**
  - User guide
  - FAQ
  - Video tutorials
  - Support contact

---

## 16. API Integration Checklist

### API Endpoints to Integrate
- [ ] Authentication (login, logout, refresh)
- [ ] Patients CRUD
- [ ] Appointments CRUD
- [ ] Medical Records CRUD
- [ ] Prescriptions CRUD
- [ ] Laboratory CRUD
- [ ] Radiology CRUD
- [ ] Inpatient CRUD
- [ ] Invoices & Payments
- [ ] Users & Staff Management
- [ ] Reports & Analytics
- [ ] File Upload/Download
- [ ] Midtrans Payment Gateway

---

## 17. Technology Stack Recommendation

### Frontend Framework
- **Vue.js 3** with Composition API + TypeScript
- **React.js** with Hooks + TypeScript
- **Next.js** for SSR/SSG

### UI Library
- **Tailwind CSS** for styling
- **Shadcn UI** / **Headless UI** for components
- **PrimeVue** / **Ant Design** / **Material UI** (full component library)

### State Management
- **Pinia** (Vue)
- **Zustand** / **Redux Toolkit** (React)

### HTTP Client
- **Axios** or **Fetch API**

### Charts
- **Chart.js** / **Apache ECharts** / **Recharts**

### Date/Time
- **date-fns** / **dayjs** / **luxon**

### Form Handling
- **Vee-Validate** (Vue) / **React Hook Form** (React)
- **Zod** / **Yup** for validation

### Table
- **TanStack Table** (React Table v8)
- **Vue Good Table**

### Calendar
- **FullCalendar**
- **VueUse** / **React Day Picker**

### File Upload
- **vue-dropzone** / **react-dropzone**

### Rich Text Editor
- **Quill** / **TipTap**

### PDF Generation
- **jsPDF** / **pdfmake**

### Notifications
- **Vue Toastification** / **React Toastify**

### Icons
- **Heroicons** / **Lucide Icons** / **Font Awesome**

---

## 18. Prioritas Development

### Phase 1 (MVP - Essential)
1. ✅ Login & Authentication
2. ✅ Dashboard per role (basic)
3. ✅ Patient Registration & List
4. ✅ Appointment System
5. ✅ Queue Management
6. ✅ Basic Medical Record
7. ✅ Invoice & Payment

### Phase 2 (Core Features)
1. Prescription Management
2. Laboratory Module
3. Radiology Module
4. Vital Signs
5. User Management
6. Reports (basic)

### Phase 3 (Advanced)
1. Inpatient Module
2. Medication Stock Management
3. Advanced Reports
4. Notifications
5. Activity Logs

### Phase 4 (Enhancement)
1. Advanced Analytics
2. Print Customization
3. Export Advanced
4. Mobile Responsive Optimization
5. Performance Optimization

---

## 19. File Structure Recommendation (Vue.js Example)

```
src/
├── assets/
│   ├── css/
│   ├── images/
│   └── icons/
├── components/
│   ├── common/
│   │   ├── Button.vue
│   │   ├── Modal.vue
│   │   ├── Table.vue
│   │   └── ...
│   ├── forms/
│   │   ├── Input.vue
│   │   ├── Select.vue
│   │   └── ...
│   ├── layout/
│   │   ├── Sidebar.vue
│   │   ├── Navbar.vue
│   │   └── ...
│   └── charts/
│       ├── LineChart.vue
│       └── ...
├── views/
│   ├── auth/
│   │   ├── Login.vue
│   │   └── ...
│   ├── dashboard/
│   ├── patients/
│   ├── appointments/
│   ├── medical-records/
│   ├── prescriptions/
│   ├── laboratory/
│   ├── radiology/
│   ├── inpatient/
│   ├── billing/
│   ├── users/
│   └── reports/
├── router/
│   └── index.js
├── stores/
│   ├── auth.js
│   ├── patients.js
│   └── ...
├── services/
│   ├── api.js
│   ├── authService.js
│   ├── patientService.js
│   └── ...
├── utils/
│   ├── helpers.js
│   ├── validators.js
│   └── constants.js
├── composables/
│   ├── useAuth.js
│   ├── useApi.js
│   └── ...
├── middleware/
│   └── auth.js
├── App.vue
└── main.js
```

---

## 20. Testing Strategy

### Unit Testing
- [ ] Test components
- [ ] Test composables/hooks
- [ ] Test utilities
- [ ] Test store/state management

### Integration Testing
- [ ] Test API integration
- [ ] Test form submissions
- [ ] Test navigation flow

### E2E Testing
- [ ] Test critical user flows
- [ ] Test different roles

---

**Last Updated**: January 9, 2026
**Status**: 🚧 Planning Phase
**Total Components**: 150+ pages/components
