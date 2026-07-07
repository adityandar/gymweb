# PRD: Restrict Attendance to Members with Active Membership

## Background

The current attendance feature allows every registered member to generate an attendance QR code and check in to the gym, regardless of their membership status.

As a result, members whose memberships have expired—or who have never purchased a membership—can still access the attendance feature. This behavior does not align with the gym's business policy, where only paying members should be able to use gym facilities.

The attendance system should therefore be tied directly to the membership lifecycle.

---

## Problem Statement

The attendance feature currently does not verify whether a member has an active membership before allowing check-in.

This creates several business issues:

- Members with expired memberships can continue using gym facilities.
- New users who have never purchased a membership can access attendance.
- Gym staff cannot rely on attendance records to represent valid active members.
- The attendance feature does not reinforce the membership renewal process.

---

## Goals

- Ensure that only members with an active membership can access the attendance feature.
- Align the attendance system with the gym's membership policy.
- Encourage timely membership renewal by restricting access after expiration.
- Improve the accuracy and integrity of attendance records.

---

## User Stories

### As a gym member

I want to check in only when my membership is active so that my attendance reflects my valid membership.

### As a gym owner

I want attendance to be limited to active members so that only paying members can access gym facilities.

---

## Expected Behavior

### Active Membership

A member with an active membership should be able to:

- Access the attendance feature.
- Generate a check-in QR code.
- Successfully complete gym check-in.

### Expired Membership

A member whose membership has expired should not be able to:

- Generate a check-in QR code.
- Perform gym check-in.

The system should clearly inform the member that their membership has expired and needs to be renewed.

### No Membership

A registered user who has never purchased a membership should also be prevented from accessing the attendance feature and should be directed to purchase a membership.

---

## Business Flow

1. A member purchases a membership package.
2. The membership becomes active.
3. During the active membership period, the member can check in to the gym.
4. Once the membership expires, attendance access is automatically unavailable.
5. After renewing the membership, attendance access becomes available again.

---

## Success Criteria

The feature will be considered successful when:

- Members with active memberships can continue using the attendance feature without interruption.
- Members without an active membership are unable to access attendance.
- Users receive a clear message explaining why attendance is unavailable.
- Attendance records only represent members with valid active memberships.

---

## Out of Scope

This enhancement does not include:

- Changes to the membership purchasing process.
- Membership renewal workflow improvements.
- QR code format or attendance scanning changes.
- Membership suspension or freeze functionality.
