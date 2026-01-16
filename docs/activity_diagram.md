# System Activity Diagram

## Patient Visit Process

This diagram illustrates the core flow of a patient visiting the hospital, from registration to discharge/payment.

```mermaid
activityDiagram
    actor Patient
    actor Staff as Admin/Receptionist
    actor Nurse
    actor Doctor
    actor Pharmacy
    actor Cashier
    
    title Standard Patient Visit Workflow

    %% Registration Phase
    Patient->Staff: Arrives at Hospital
    if (New Patient?) then (yes)
        Staff->Staff: Register New Patient
    else (no)
        Staff->Staff: Search Existing Record
    endif
    
    Staff->Staff: Queue to Department
    Staff-->Nurse: Notify Triage

    %% Triage Phase
    Nurse->Patient: Call Patient
    Nurse->Nurse: Perform Primary Survey (Triage)
    Nurse->Nurse: Record Vitals
    Nurse-->Doctor: Ready for Examination

    %% Examination Phase
    Doctor->Patient: Call Patient
    Doctor->Doctor: Medical Examination
    
    %% Treatment Decisions
    fork
        Doctor->Doctor: Prescribe Medication
    fork again
        Doctor->Doctor: Order Lab Tests
    fork again
        Doctor->Doctor: Order Radiology
    end fork

    %% Order Fulfillment (Parallel)
    par
        if (Has Prescription?) then (yes)
            Doctor-->Pharmacy: Send Prescription
            Pharmacy->Pharmacy: Verify & Prepare Meds
        endif
    and
        if (Has Lab Order?) then (yes)
            Doctor-->Staff: Order Request
            Staff->Staff: Process Lab Sample
        endif
    end par

    %% Billing & Payment Phase
    Doctor->Doctor: Finalize Diagnosis
    Doctor-->Cashier: Generate Bill
    
    Cashier->Patient: Issue Invoice
    Patient->Cashier: Make Payment
    
    if (Payment Successful?) then (yes)
        Cashier->Cashier: Record Payment
        Cashier->Patient: Provide Receipt & Meds
        stop
    else (no)
        Cashier->Patient: Request Retry
    endif
```
