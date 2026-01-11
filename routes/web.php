<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientPortalController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\RadiologyController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\InpatientController;
use App\Http\Controllers\InpatientDailyLogController;
use App\Http\Controllers\InpatientChargeController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\VitalSignController;
use App\Http\Controllers\QueueDisplayController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{medication}', [App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');


// Midtrans Webhook (must be outside auth middleware)
Route::post('/api/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');

// Midtrans callback routes (must be outside auth middleware for callback)
Route::get('billing/payment-success', [MidtransController::class, 'paymentSuccess'])->name('billing.payment-success');
Route::get('billing/payment-pending', [MidtransController::class, 'paymentPending'])->name('billing.payment-pending');
Route::get('billing/payment-failed', [MidtransController::class, 'paymentFailed'])->name('billing.payment-failed');
Route::get('billing/payment-multiple-success', [BillingController::class, 'paymentMultipleSuccess'])->name('billing.payment-multiple-success');

// Public Queue Display (for TV screens in waiting rooms)
Route::get('/queue/display/{department}', [QueueDisplayController::class, 'display'])->name('queue.display');
Route::get('/queue/ticket/{appointment}', [QueueDisplayController::class, 'printTicket'])->name('queue.ticket');

// ============================================
// PATIENT PORTAL (for logged-in patients)
// ============================================
Route::middleware(['auth'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [PatientPortalController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/book', [PatientPortalController::class, 'bookAppointment'])->name('appointments.book');
    Route::post('/appointments', [PatientPortalController::class, 'storeAppointment'])->name('appointments.store');
    Route::get('/medical-records', [PatientPortalController::class, 'medicalRecords'])->name('medical-records');
    Route::get('/prescriptions', [PatientPortalController::class, 'prescriptions'])->name('prescriptions');
    Route::get('/lab-results', [PatientPortalController::class, 'labResults'])->name('lab-results');
    Route::get('/radiology-results', [PatientPortalController::class, 'radiologyResults'])->name('radiology-results');
    Route::get('/invoices', [PatientPortalController::class, 'invoices'])->name('invoices');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ============================================
    // PATIENT MANAGEMENT
    // ============================================
    // Front Office - register and edit patients
    Route::middleware(['role:front_office,admin'])->group(function () {
        Route::get('patients/create', [PatientController::class, 'create'])->name('patients.create');
        Route::post('patients', [PatientController::class, 'store'])->name('patients.store');
        Route::get('patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
        Route::put('patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    });
    
    // Admin only - delete patients
    Route::middleware(['role:admin'])->group(function () {
        Route::delete('patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
    });
    
    // View access - most roles
    Route::middleware(['role:front_office,doctor,nurse,pharmacist,lab_technician,radiologist,admin'])->group(function () {
        Route::get('patients', [PatientController::class, 'index'])->name('patients.index');
        Route::get('patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    });

    // ============================================
    // APPOINTMENTS
    // ============================================
    // Front Office - manage appointments
    Route::middleware(['role:front_office,admin'])->group(function () {
        Route::get('appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    });
    
    // Front Office + Nurse - check in
    Route::middleware(['role:front_office,nurse,admin'])->group(function () {
        Route::put('appointments/{appointment}/check-in', [AppointmentController::class, 'checkIn'])->name('appointments.check-in');
        Route::post('appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
        Route::post('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    });
    
    // View access
    Route::middleware(['role:front_office,doctor,nurse,admin'])->group(function () {
        Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    });

    // ============================================
    // MEDICAL RECORDS
    // ============================================
    // Doctor only - full CRUD
    Route::middleware(['role:doctor,admin'])->group(function () {
        Route::get('medical-records/create', [MedicalRecordController::class, 'create'])->name('medical-records.create');
        Route::post('medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
        Route::get('medical-records/{medical_record}/edit', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
        Route::put('medical-records/{medical_record}', [MedicalRecordController::class, 'update'])->name('medical-records.update');
        Route::delete('medical-records/{medical_record}', [MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');
    });
    
    // Doctor + Nurse - view only
    Route::middleware(['role:doctor,nurse,admin'])->group(function () {
        Route::get('medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
        Route::get('medical-records/{medical_record}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
    });

    // ============================================
    // VITAL SIGNS
    // ============================================
    // Nurse only - record vital signs
    Route::middleware(['role:nurse,admin'])->group(function () {
        Route::get('vital-signs/create', [VitalSignController::class, 'create'])->name('vital-signs.create');
        Route::post('vital-signs', [VitalSignController::class, 'store'])->name('vital-signs.store');
        Route::get('vital-signs/{vital_sign}/edit', [VitalSignController::class, 'edit'])->name('vital-signs.edit');
        Route::put('vital-signs/{vital_sign}', [VitalSignController::class, 'update'])->name('vital-signs.update');
        Route::delete('vital-signs/{vital_sign}', [VitalSignController::class, 'destroy'])->name('vital-signs.destroy');
    });
    
    // Nurse + Doctor - view vital signs
    Route::middleware(['role:nurse,doctor,admin'])->group(function () {
        Route::get('vital-signs', [VitalSignController::class, 'index'])->name('vital-signs.index');
        Route::get('vital-signs/{vital_sign}', [VitalSignController::class, 'show'])->name('vital-signs.show');
    });

    // ============================================
    // LABORATORY
    // ============================================
    // Doctor only - create orders and verify results
    Route::middleware(['role:doctor,admin'])->group(function () {
        Route::get('laboratory/create', [LaboratoryController::class, 'create'])->name('laboratory.create');
        Route::post('laboratory', [LaboratoryController::class, 'store'])->name('laboratory.store');
        Route::post('laboratory/{laboratory}/verify', [LaboratoryController::class, 'verify'])->name('laboratory.verify');
    });
    
    // Lab Tech - collect samples and enter results
    Route::middleware(['role:lab_technician,admin'])->group(function () {
        Route::post('laboratory/{laboratory}/collect-sample', [LaboratoryController::class, 'collectSample'])->name('laboratory.collect-sample');
        Route::post('laboratory/{laboratory}/enter-results', [LaboratoryController::class, 'enterResults'])->name('laboratory.enter-results');
    });
    
    // View access
    Route::middleware(['role:doctor,lab_technician,nurse,admin'])->group(function () {
        Route::get('laboratory', [LaboratoryController::class, 'index'])->name('laboratory.index');
        Route::get('laboratory/{laboratory}', [LaboratoryController::class, 'show'])->name('laboratory.show');
        Route::get('laboratory/{laboratory}/print', [LaboratoryController::class, 'print'])->name('laboratory.print');
    });
    
    // Edit/Update/Delete - Lab Tech + Doctor
    Route::middleware(['role:doctor,lab_technician,admin'])->group(function () {
        Route::get('laboratory/{laboratory}/edit', [LaboratoryController::class, 'edit'])->name('laboratory.edit');
        Route::put('laboratory/{laboratory}', [LaboratoryController::class, 'update'])->name('laboratory.update');
        Route::delete('laboratory/{laboratory}', [LaboratoryController::class, 'destroy'])->name('laboratory.destroy');
    });

    // ============================================
    // RADIOLOGY
    // ============================================
    // Doctor only - create orders
    Route::middleware(['role:doctor,admin'])->group(function () {
        Route::get('radiology/create', [RadiologyController::class, 'create'])->name('radiology.create');
        Route::post('radiology', [RadiologyController::class, 'store'])->name('radiology.store');
    });
    
    // Radiologist - schedule, upload, interpret, finalize, revise
    Route::middleware(['role:radiologist,admin'])->group(function () {
        Route::post('radiology/{radiology}/schedule', [RadiologyController::class, 'schedule'])->name('radiology.schedule');
        Route::post('radiology/{radiology}/enter-interpretation', [RadiologyController::class, 'enterInterpretation'])->name('radiology.enter-interpretation');
        Route::post('radiology/{radiology}/finalize', [RadiologyController::class, 'finalizeReport'])->name('radiology.finalize');
        Route::post('radiology/{radiology}/revise', [RadiologyController::class, 'createRevision'])->name('radiology.revise');
    });
    
    // View access
    Route::middleware(['role:doctor,radiologist,nurse,admin'])->group(function () {
        Route::get('radiology', [RadiologyController::class, 'index'])->name('radiology.index');
        Route::get('radiology/{radiology}', [RadiologyController::class, 'show'])->name('radiology.show');
        Route::get('radiology/{radiology}/print', [RadiologyController::class, 'print'])->name('radiology.print');
    });
    
    // Edit/Update/Delete - Radiologist + Doctor
    Route::middleware(['role:doctor,radiologist,admin'])->group(function () {
        Route::get('radiology/{radiology}/edit', [RadiologyController::class, 'edit'])->name('radiology.edit');
        Route::put('radiology/{radiology}', [RadiologyController::class, 'update'])->name('radiology.update');
        Route::delete('radiology/{radiology}', [RadiologyController::class, 'destroy'])->name('radiology.destroy');
    });

    // ============================================
    // PRESCRIPTIONS
    // ============================================
    // Doctor only - create prescriptions
    Route::middleware(['role:doctor,admin'])->group(function () {
        Route::get('prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
        Route::post('prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
        Route::get('prescriptions/{prescription}/edit', [PrescriptionController::class, 'edit'])->name('prescriptions.edit');
        Route::put('prescriptions/{prescription}', [PrescriptionController::class, 'update'])->name('prescriptions.update');
        Route::delete('prescriptions/{prescription}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');
    });
    
    // Pharmacist - verify and dispense
    Route::middleware(['role:pharmacist,admin'])->group(function () {
        Route::post('prescriptions/{prescription}/verify', [PrescriptionController::class, 'verify'])->name('prescriptions.verify');
        Route::post('prescriptions/{prescription}/dispense', [PrescriptionController::class, 'dispense'])->name('prescriptions.dispense');
        Route::post('prescriptions/{prescription}/reject', [PrescriptionController::class, 'reject'])->name('prescriptions.reject');
    });
    
    // View access
    Route::middleware(['role:doctor,pharmacist,nurse,admin'])->group(function () {
        Route::get('prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
        Route::get('prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
    });

    // ============================================
    // INPATIENT
    // ============================================
    // Front Office + Nurse - admit patients
    Route::middleware(['role:front_office,nurse,admin'])->group(function () {
        Route::get('inpatient/create', [InpatientController::class, 'create'])->name('inpatient.create');
        Route::post('inpatient', [InpatientController::class, 'store'])->name('inpatient.store');
    });
    
    // Doctor + Nurse - discharge
    Route::middleware(['role:doctor,nurse,admin'])->group(function () {
        Route::post('inpatient/{inpatient}/discharge', [InpatientController::class, 'discharge'])->name('inpatient.discharge');
    });
    
    // View access
    Route::middleware(['role:doctor,nurse,pharmacist,front_office,cashier,admin'])->group(function () {
        Route::get('inpatient', [InpatientController::class, 'index'])->name('inpatient.index');
        Route::get('inpatient/{inpatient}', [InpatientController::class, 'show'])->name('inpatient.show');
    });
    
    // Edit/Update/Delete
    Route::middleware(['role:nurse,front_office,admin'])->group(function () {
        Route::get('inpatient/{inpatient}/edit', [InpatientController::class, 'edit'])->name('inpatient.edit');
        Route::put('inpatient/{inpatient}', [InpatientController::class, 'update'])->name('inpatient.update');
        Route::delete('inpatient/{inpatient}', [InpatientController::class, 'destroy'])->name('inpatient.destroy');
    });

    // ============================================
    // INPATIENT DAILY LOGS
    // ============================================
    // Doctor + Nurse - manage daily logs
    Route::middleware(['role:doctor,nurse,admin'])->group(function () {
        Route::get('inpatient/{inpatient}/daily-logs', [InpatientDailyLogController::class, 'index'])->name('inpatient.daily-logs.index');
        Route::get('inpatient/{inpatient}/daily-logs/create', [InpatientDailyLogController::class, 'create'])->name('inpatient.daily-logs.create');
        Route::post('inpatient/{inpatient}/daily-logs', [InpatientDailyLogController::class, 'store'])->name('inpatient.daily-logs.store');
        Route::get('inpatient/{inpatient}/daily-logs/{log}', [InpatientDailyLogController::class, 'show'])->name('inpatient.daily-logs.show');
        Route::get('inpatient/{inpatient}/daily-logs/{log}/edit', [InpatientDailyLogController::class, 'edit'])->name('inpatient.daily-logs.edit');
        Route::put('inpatient/{inpatient}/daily-logs/{log}', [InpatientDailyLogController::class, 'update'])->name('inpatient.daily-logs.update');
        Route::delete('inpatient/{inpatient}/daily-logs/{log}', [InpatientDailyLogController::class, 'destroy'])->name('inpatient.daily-logs.destroy');
    });

    // ============================================
    // INPATIENT CHARGES
    // ============================================
    // Cashier + Admin - manage charges
    Route::middleware(['role:cashier,nurse,doctor,admin'])->group(function () {
        Route::get('inpatient/{inpatient}/charges', [InpatientChargeController::class, 'index'])->name('inpatient.charges.index');
        Route::get('inpatient/{inpatient}/charges/create', [InpatientChargeController::class, 'create'])->name('inpatient.charges.create');
        Route::post('inpatient/{inpatient}/charges', [InpatientChargeController::class, 'store'])->name('inpatient.charges.store');
        Route::delete('inpatient/{inpatient}/charges/{charge}', [InpatientChargeController::class, 'destroy'])->name('inpatient.charges.destroy');
    });

    // ============================================
    // BILLING & PAYMENT
    // ============================================
    // Cashier - process payments
    Route::middleware(['role:cashier,admin'])->group(function () {
        Route::post('billing/{invoice}/payment', [BillingController::class, 'payment'])->name('billing.payment');
        Route::get('billing/payment-multiple', [BillingController::class, 'showMultiplePayment'])->name('billing.payment-multiple.show');
        Route::post('billing/payment-multiple', [BillingController::class, 'paymentMultiple'])->name('billing.payment-multiple');
        Route::post('billing/payment-multiple-midtrans', [BillingController::class, 'paymentMultipleMidtrans'])->name('billing.payment-multiple-midtrans');
    });
    
    // Cashier + Management + Doctor + Front Office - view billing
    Route::middleware(['role:cashier,management,admin,doctor,front_office'])->group(function () {
        Route::get('billing', [BillingController::class, 'index'])->name('billing.index');
        Route::get('billing/{invoice}', [BillingController::class, 'show'])->name('billing.show');
        Route::get('billing/payments/history', [BillingController::class, 'payments'])->name('billing.payments');
        Route::get('billing/payment-multiple/success', [BillingController::class, 'showPaymentSuccess'])->name('billing.payment-multiple.success');
        
        // Midtrans payment gateway
        Route::post('billing/{invoice}/midtrans/create', [MidtransController::class, 'createPayment'])->name('billing.midtrans.create');
        Route::post('billing/{invoice}/midtrans/verify', [MidtransController::class, 'verifyAndUpdatePayment'])->name('billing.midtrans.verify');
        Route::get('billing/midtrans/check/{orderId}', [MidtransController::class, 'checkStatus'])->name('billing.midtrans.check');
    });

    // ============================================
    // MASTER DATA - DOCTORS
    // ============================================
    // Admin + Management - manage doctors
    Route::middleware(['role:admin,management'])->group(function () {
        Route::get('doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
        Route::post('doctors', [DoctorController::class, 'store'])->name('doctors.store');
        Route::get('doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
        Route::put('doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
        Route::delete('doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
    });
    
    // View access - all authenticated
    Route::get('doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');

    // ============================================
    // MASTER DATA - MEDICATIONS
    // ============================================
    // Pharmacist + Admin - manage medications
    Route::middleware(['role:pharmacist,admin'])->group(function () {
        Route::get('medications/create', [MedicationController::class, 'create'])->name('medications.create');
        Route::post('medications', [MedicationController::class, 'store'])->name('medications.store');
        Route::get('medications/{medication}/edit', [MedicationController::class, 'edit'])->name('medications.edit');
        Route::put('medications/{medication}', [MedicationController::class, 'update'])->name('medications.update');
        Route::delete('medications/{medication}', [MedicationController::class, 'destroy'])->name('medications.destroy');
    });
    
    // View access
    Route::middleware(['role:doctor,nurse,pharmacist,admin'])->group(function () {
        Route::get('medications', [MedicationController::class, 'index'])->name('medications.index');
        Route::get('medications/{medication}', [MedicationController::class, 'show'])->name('medications.show');
    });

    // ============================================
    // STOCK MOVEMENTS
    // ============================================
    // Pharmacist + Admin - manage stock movements
    Route::middleware(['role:pharmacist,admin'])->group(function () {
        Route::get('stock-movements', [StockMovementController::class, 'index'])->name('stock-movements.index');
        Route::get('stock-movements/create', [StockMovementController::class, 'create'])->name('stock-movements.create');
        Route::post('stock-movements', [StockMovementController::class, 'store'])->name('stock-movements.store');
        Route::get('stock-movements/{medication}', [StockMovementController::class, 'show'])->name('stock-movements.show');
    });

    // ============================================
    // MASTER DATA - ROOMS
    // ============================================
    // Admin + Management - manage rooms
    Route::middleware(['role:admin,management'])->group(function () {
        Route::get('rooms/create', [RoomController::class, 'create'])->name('rooms.create');
        Route::post('rooms', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
        Route::put('rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
        Route::delete('rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    });
    
    // View access
    Route::middleware(['role:nurse,front_office,admin,management'])->group(function () {
        Route::get('rooms', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
    });

    // ============================================
    // MASTER DATA - DEPARTMENTS
    // ============================================
    // Admin + Management - manage departments
    Route::middleware(['role:admin,management'])->group(function () {
        Route::get('departments/create', [DepartmentController::class, 'create'])->name('departments.create');
        Route::post('departments', [DepartmentController::class, 'store'])->name('departments.store');
        Route::get('departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
        Route::put('departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
    });
    
    // View access - all authenticated
    Route::get('departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');

    // ============================================
    // MANAGEMENT REPORTS
    // ============================================
    Route::middleware(['role:management,admin'])->prefix('management')->name('management.')->group(function () {
        Route::get('/', [App\Http\Controllers\ManagementReportController::class, 'index'])->name('index');
        Route::get('/financial', [App\Http\Controllers\ManagementReportController::class, 'financial'])->name('financial');
        Route::get('/operational', [App\Http\Controllers\ManagementReportController::class, 'operational'])->name('operational');
        Route::get('/patient-flow', [App\Http\Controllers\ManagementReportController::class, 'patientFlow'])->name('patient-flow');
        Route::get('/staff-performance', [App\Http\Controllers\ManagementReportController::class, 'staffPerformance'])->name('staff-performance');
    });
});

// ============================================
// PROFILE MANAGEMENT
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

require __DIR__.'/auth.php';
