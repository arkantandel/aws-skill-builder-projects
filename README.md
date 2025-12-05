

# Three-Tier Architecture on AWS

This repository contains a complete guide to building a *Highly Available Multi-AZ Three-Tier Architecture* on AWS using VPC, Subnets, Route Tables, NAT Gateway, Internet Gateway, EC2, ALB, Auto Scaling, and RDS.

---

## Table of Contents
1. Overview  
2. Architecture Diagram (GitHub-Safe Mermaid)  
3. Prerequisites  
4. High-Level Steps  
5. Step-by-Step Deployment  
6. AWS CLI Commands  
7. Security Groups Overview  
8. Auto Scaling Overview  
9. Troubleshooting  
10. Production Checklist  
11. References  

---

# 1. Overview

A *three-tier AWS architecture* separates your application into:

### Web Tier
- Internet-facing Application Load Balancer  
- Frontend EC2 servers  
- Public + private web subnets  

### Application Tier
- Backend application EC2 servers  
- Private app subnets  

### Database Tier
- Amazon RDS Multi-AZ  
- Private DB subnets  

### Benefits
- High Availability  
- Scalability (Auto Scaling Groups)  
- Security Isolation  
- Multi-AZ resilience  

---

# 2. Architecture Diagram (GitHub-Safe Mermaid)

This diagram renders correctly on GitHub.

```mermaid
flowchart TB

subgraph VPC["VPC"]
    subgraph AZA["AZ A"]
        ALB_A((ALB))
        FE_A[Frontend EC2]
        BE_A[Backend EC2]
        DB_A[(DB A)]
    end

    subgraph AZB["AZ B"]
        ALB_B((ALB))
        FE_B[Frontend EC2]
        BE_B[Backend EC2]
        DB_B[(DB B)]
    end

    subgraph AZC["AZ C"]
        ALB_C((ALB))
        FE_C[Frontend EC2]
        BE_C[Backend EC2]
        DB_C[(DB C)]
    end
end

ALB_A --> FE_A
ALB_B --> FE_B
ALB_C --> FE_C

FE_A --> BE_A
FE_B --> BE_B
FE_C --> BE_C

BE_A --> DB_A
BE_B --> DB_B
BE_C --> DB_C


---

3. Prerequisites

AWS Account

AWS CLI Installed

IAM admin or power-user permissions

SSH Key Pair

Basic Linux knowledge



---

4. High-Level Steps

1. Create VPC


2. Create public / private subnets


3. Create route tables


4. Create Internet Gateway


5. Create NAT Gateway


6. Add routes


7. Create security groups


8. Create DB subnet group


9. Launch RDS


10. Create Frontend ALB


11. Create Backend ALB


12. Create Frontend AMI


13. Create Backend AMI


14. Create Launch Templates


15. Create Auto Scaling Groups


16. Test application




---

5. Step-by-Step Deployment


---

Step 1: Create VPC

CIDR: 10.0.0.0/16


---

Step 2: Create Subnets

Public Subnets

public-web-subnet-a

public-web-subnet-b

public-web-subnet-c


Private Web Subnets (Frontend)

private-web-subnet-a

private-web-subnet-b

private-web-subnet-c


Private App Subnets (Backend)

private-app-subnet-a

private-app-subnet-b

private-app-subnet-c


Private DB Subnets

private-db-subnet-a

private-db-subnet-b

private-db-subnet-c



---

Step 3: Route Tables

Public Route Table

0.0.0.0/0 → IGW


Private Route Table

0.0.0.0/0 → NAT Gateway



---

Step 4: Internet Gateway

Attach IGW to VPC.


---

Step 5: NAT Gateway

Create NAT in a public subnet.


---

Step 6: Routing

Subnet Type	Route

Public	0.0.0.0/0 → IGW
Private	0.0.0.0/0 → NAT GW



---

7. Security Groups Overview

Frontend ALB SG

Allow: 80 / 443 from internet


Frontend EC2 SG

Allow: 80/443 from ALB SG


Backend EC2 SG

Allow: backend port (e.g., 8080) from Frontend SG


DB SG

Allow: DB port (3306 / 5432) from Backend SG



---

8. Auto Scaling Overview

Frontend Auto Scaling Group

Uses private web subnets

Attached to frontend target group


Backend Auto Scaling Group

Uses private app subnets

Attached to backend target group



---

9. Troubleshooting

ALB shows “Unhealthy”

Wrong SG

Wrong port

Application not running


Backend cannot reach DB

DB SG does not allow backend SG


EC2 has no internet

NAT not working

Wrong route table



---

10. Production Checklist

[x] VPC created

[x] Subnets created across AZs

[x] IGW attached

[x] NAT Gateway running

[x] Route tables configured

[x] Security groups correct

[x] ALB healthy

[x] Backend reachable

[x] RDS reachable from backend only

[x] ASG scaling correctly



---

11. References

AWS VPC Documentation

AWS EC2 Documentation

AWS RDS Documentation

AWS ALB Documentation



---

