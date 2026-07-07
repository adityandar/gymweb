---

# Payment Configuration

## Overview

The application must support two payment modes that can be switched by the administrator through the system settings.

Only one payment mode can be active at a time.

Available modes:

- AUTOMATIC (Midtrans)
- MANUAL (Admin Verification)

---

# System Settings

The application provides a Settings page accessible only by administrators.

### Payment Settings

| Setting      | Type | Default   |
| ------------ | ---- | --------- |
| payment_mode | enum | AUTOMATIC |

Allowed values:

```text
AUTOMATIC
MANUAL
```

Example database:

```text
system_settings

id
payment_mode
updated_at
```

---

# Automatic Payment Mode

When the payment mode is set to `AUTOMATIC`:

- The checkout process uses Midtrans.
- Membership is activated automatically after a successful payment callback.
- No payment proof upload is required.

Workflow

```text
Choose Membership
        │
Create Order
        │
Generate Midtrans Transaction
        │
Complete Payment
        │
Receive Webhook
        │
Activate Membership
```

---

# Manual Payment Mode

When the payment mode is set to `MANUAL`:

- Midtrans is not used.
- The user uploads proof of payment.
- Membership remains inactive until verified by an administrator.

Workflow

```text
Choose Membership
        │
Create Order
        │
Upload Payment Proof
        │
Waiting for Verification
        │
Admin Review
      ├─────────────┐
      │             │
Approve         Reject
      │             │
Membership      User uploads
Activated       another proof
```

---

# Payment Proof

The member must upload a payment proof.

Supported file types:

- JPG
- JPEG
- PNG
- PDF

Maximum size:

- 5 MB

Database example:

```text
payment_proofs

id
order_id
file_path
notes
uploaded_at
verified_by
verified_at
```

---

# Admin Verification

The administrator can:

- View payment proof
- Approve payment
- Reject payment
- Add verification notes

When approved:

- Order status becomes PAID.
- Membership is activated automatically.

When rejected:

- Order status becomes REJECTED.
- Member may upload a new payment proof.

---

# Order Status

```text
PENDING
WAITING_CONFIRMATION
PAID
REJECTED
FAILED
EXPIRED
```

---

# Backend Requirements

Admin API

- Update payment mode
- View payment confirmations
- Approve payment
- Reject payment

Member API

- Create order
- Upload payment proof
- View payment status

---

# Frontend Requirements

## Settings

Admin can switch payment mode using a simple toggle or select input.

```
Payment Mode

○ Automatic (Midtrans)

○ Manual Verification
```

## Checkout

When Automatic:

- Redirect user to Midtrans.

When Manual:

- Show gym bank account information.
- Upload payment proof.
- Show "Waiting for Verification" status after upload.

---

# Acceptance Criteria

- Only administrators can change the payment mode.
- Payment mode changes take effect immediately.
- Midtrans integration is skipped completely in Manual mode.
- Membership activation follows the configured payment mode.
- Existing orders are not modified when the payment mode changes.
