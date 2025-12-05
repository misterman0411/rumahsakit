# Login Credentials - Hospital Management System

## Default User Accounts

All accounts use the default password: **`password`**

### Administrator
- **Email**: admin@hospital.com
- **Password**: password
- **Role**: Admin
- **Access**: Full system access

### Medical Staff

#### Doctors
- **Email**: ahmad@hospital.com
- **Password**: password
- **Role**: Doctor
- **Access**: Medical records, prescriptions, appointments

#### Nurses
- **Email**: siti@hospital.com
- **Password**: password
- **Role**: Nurse
- **Access**: Patient care, vital signs, daily logs

### Support Staff

#### Front Office
- **Email**: budi@hospital.com
- **Password**: password
- **Role**: Front Office
- **Access**: Patient registration, appointments, queue management

#### Pharmacist
- **Email**: dewi@hospital.com
- **Password**: password
- **Role**: Pharmacist
- **Access**: Medication management, prescriptions, stock control

#### Lab Technician
- **Email**: rudi@hospital.com
- **Password**: password
- **Role**: Lab Technician
- **Access**: Laboratory orders, test results

#### Radiologist
- **Email**: andi@hospital.com
- **Password**: password
- **Role**: Radiologist
- **Access**: Radiology orders, imaging results

#### Cashier
- **Email**: fitri@hospital.com
- **Password**: password
- **Role**: Cashier
- **Access**: Billing, payments, invoices

#### Management
- **Email**: hendra@hospital.com
- **Password**: password
- **Role**: Management
- **Access**: Reports, analytics, system overview

---

## Total Users Seeded: 17

### Role Distribution:
- **9 Different Roles**
- Admin: 1 user
- Doctor: 6 users
- Nurse: 5 users
- Front Office: 1 user
- Pharmacist: 1 user
- Lab Technician: 1 user
- Radiologist: 1 user
- Cashier: 1 user
- Management: 1 user

---

## Sample Data Included:

### Patients
- 10 patients with complete profiles
- Medical record numbers (MR format)
- Contact information and addresses

### Appointments
- 38 appointments with queue system
- Status: Scheduled, Confirmed, Check-in, In Progress, Completed, Cancelled, No Show

### Medical Records
- 5 complete medical records
- ICD-10 diagnosis codes
- ICD-9 procedure codes
- Vital signs (JSON format)

### Laboratory
- 5 laboratory orders
- 6 lab results with values and reference ranges
- Test types: Complete Blood Count, Urinalysis, Lipid Profile, Liver Function, Kidney Function

### Radiology
- 4 radiology orders (2 completed)
- Test types: X-Ray, CT Scan, MRI, Ultrasound

### Pharmacy
- 30 medications with prices
- 4 prescriptions with 8 medication items
- Stock management system

### Inpatient
- 3 inpatient admissions (1 active)
- 5 daily nursing logs
- 5 vital sign records
- 4 additional charges

### Billing
- 5 invoices with multiple items
- 4 payments recorded
- Payment methods: Cash, Credit Card, Debit Card, Bank Transfer, Insurance

### Infrastructure
- 5 departments
- 5 rooms with 11 beds
- 15 lab test types
- 15 radiology test types
- 10 service charges

---

## Security Notes

⚠️ **IMPORTANT**: 
- Change all passwords before deploying to production
- Default password `password` is for development only
- Update `APP_KEY` in `.env` file
- Secure database credentials
- Enable 2FA for admin accounts in production

---

## Database Configuration

**Database Name**: `hospital_management`
**Tables**: 31 tables
**Migrations**: 29 migration files
**Seeders**: ComprehensiveDataSeeder, DatabaseSeeder

To reset and reseed database:
```bash
php artisan migrate:fresh --seed
```

---

**Last Updated**: December 5, 2025
