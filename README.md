# Three-Tier Architecture on AWS

This README provides a complete, step-by-step guide for deploying a Highly Available Multi-AZ Three-Tier Architecture on AWS. It includes VPC, subnets, route tables, NAT, IGW, EC2 front-end, EC2 backend, ALBs, RDS Database, Launch Templates, and Auto Scaling Groups.

---

## Table of Contents
1. Overview  
2. Mermaid Architecture Diagram  
3. Prerequisites  
4. High-Level Steps  
5. Step-by-Step Deployment  
6. AWS CLI Commands  
7. Production Checklist  
8. Troubleshooting  
9. References  

---

# 1. Overview

A complete cloud architecture following 3-tier separation:

### Web Tier  
- Public-facing Application Load Balancer  
- Frontend EC2 private servers  
- Hosted in *public + private-web subnets*

### Application Tier  
- Backend EC2  
- Hosted in *private-app subnets*

### Database Tier  
- Multi-AZ RDS  
- Hosted in *private-db subnets*

Benefits:  
- High Availability  
- Secure Network Segmentation  
- Auto Scaling  
- Multi-AZ Fault Tolerance  

---

# 2. Mermaid Architecture Diagram

```mermaid
flowchart TB

subgraph VPC["VPC: 10.0.0.0/16"]
direction TB

    %% ------------------- AZ A -------------------
    subgraph AZA["Availability Zone A"]
        subgraph PUBA["Public Web Subnet A"]
            ALB_A((ALB))
        end
        subgraph PWA["Private Web Subnet A"]
            FE_A[Frontend EC2]
        end
        subgraph APA["Private App Subnet A"]
            BE_A[Backend EC2]
        end
        subgraph DBA["Private DB Subnet A"]
            DB_A[(RDS Primary)]
        end
    end

    %% ------------------- AZ B -------------------
    subgraph AZB["Availability Zone B"]
        subgraph PUBB["Public Web Subnet B"]
            ALB_B((ALB))
        end
        subgraph PWB["Private Web Subnet B"]
            FE_B[Frontend EC2]
        end
        subgraph APB["Private App Subnet B"]
            BE_B[Backend EC2]
        end
        subgraph DBB["Private DB Subnet B"]
            DB_B[(RDS Standby)]
        end
    end

    %% ------------------- AZ C -------------------
    subgraph AZC["Availability Zone C"]
        subgraph PUBC["Public Web Subnet C"]
            ALB_C((ALB))
        end
        subgraph PWC["Private Web Subnet C"]
            FE_C[Frontend EC2]
        end
        subgraph APC["Private App Subnet C"]
            BE_C[Backend EC2]
        end
        subgraph DBC["Private DB Subnet C"]
            DB_C[(RDS Replica)]
        end
    end
end

%% ---------------- Connections ----------------

ALB_A --> FE_A
ALB_B --> FE_B
ALB_C --> FE_C

FE_A --> BE_A
FE_B --> BE_B
FE_C --> BE_C

BE_A --> DB_A
BE_B --> DB_B
BE_C --> DB_C

%% Multi-AZ DB arrows (GitHub-safe version)
DB_A --> DB_B
DB_B --> DB_C
DB_C --> DB_A

---

3. Prerequisites

AWS Account

AWS CLI Installed (aws configure)

IAM permissions

SSH Key Pair

Basic Linux knowledge

Understanding of ALB, EC2, RDS



---

4. High-Level Steps

1. Create VPC


2. Create Web / App / DB subnets


3. Create route tables


4. Create IGW


5. Create NAT gateway


6. Add routing


7. Create security groups


8. Create database subnet group


9. Create RDS DB (Multi-AZ)


10. Create ALB + target groups


11. Create AMIs (frontend/backend)


12. Create Launch Templates


13. Create Auto Scaling Groups


14. Final Testing




---

5. Step-by-Step Deployment


---

Step 1: Create VPC

CIDR: 10.0.0.0/16


---

Step 2: Create Subnets

Public Web Subnets

public-web-subnet-a

public-web-subnet-b

public-web-subnet-c


Private Web Subnets (Frontend EC2)

private-web-subnet-a

private-web-subnet-b

private-web-subnet-c


Private App Subnets (Backend EC2)

private-app-subnet-a

private-app-subnet-b

private-app-subnet-c


Private DB Subnets

private-db-subnet-a

private-db-subnet-b

private-db-subnet-c



---

Step 3: Create Route Tables

Public → IGW

Private → NAT GW



---

Step 4: Create Internet Gateway

Attach IGW to VPC.


---

Step 5: NAT Gateway

Place NAT in public subnet.


---

Step 6: Add Routing

Subnet Type	Route

Public	0.0.0.0/0 → IGW
Private	0.0.0.0/0 → NAT



---

Step 7: Security Groups

ALB SG

Allow:

80 / 443 from internet


Frontend SG

Allow:

80 / 443 from ALB


Backend SG

Allow:

8080 from Frontend


DB SG

Allow:

3306 from Backend



---

Step 8: Create DB Subnet Group

Add all 3 DB subnets.


---

Step 9: Create RDS Database (Multi-AZ)

Engine Example:

MySQL

PostgreSQL



---

Step 10: Create Frontend ALB

Create:

Listener (80)

Target Group



---

Step 11: Create Backend ALB

Create:

Listener (8080)

Target Group



---

Step 12: Create AMIs

Frontend AMI

sudo yum install nginx git -y

Backend AMI

sudo yum install php httpd mysql git -y


---

Step 13: Create Launch Templates

Include:

AMI ID

Instance type

Security group

UserData



---

Step 14: Create Auto Scaling Groups

Attach:

Subnets

Target Groups

Policies



---

Step 15: Test

Open ALB DNS

Ensure frontend reaches backend

Ensure backend reaches DB



---

6. AWS CLI Commands

VPC

aws ec2 create-vpc --cidr-block 10.0.0.0/16

Subnet

aws ec2 create-subnet --vpc-id <VPC_ID> --cidr-block 10.0.0.0/20

IGW

aws ec2 create-internet-gateway
aws ec2 attach-internet-gateway --vpc-id <VPC_ID> --internet-gateway-id <IGW_ID>

NAT

aws ec2 create-nat-gateway --subnet-id <PUBLIC_SUBNET> --allocation-id <EIP_ID>

Target Group

aws elbv2 create-target-group --name frontend-tg --protocol HTTP --port 80 --vpc-id <VPC_ID>


---

7. Production Checklist

[x] VPC created

[x] All subnets created

[x] IGW working

[x] NAT working

[x] RDS accessible only from backend

[x] ALB healthy

[x] ASG working

[x] Security groups correct



---

8. Troubleshooting

ALB Unhealthy?

App not running

Wrong security group

Wrong port


Backend cannot reach DB?

DB SG missing inbound rule


EC2 cannot reach internet?

NAT or route table incorrect



---

9. References

AWS VPC Docs

AWS EC2 Docs

AWS ELB Docs

AWS RDS Docs



---
