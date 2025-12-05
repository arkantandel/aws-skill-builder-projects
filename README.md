# 🏗️ Three-Tier Architecture on AWS  
**Repository:** `aws-skill-builder-projects`

This project demonstrates how to deploy a **highly available, secure, scalable Three-Tier Architecture** on AWS using VPC, Subnets, Route Tables, ALB, EC2, NAT Gateways, and Database Tier.

The architecture contains:  
- **Web Tier** → Public Subnets  
- **App Tier** → Private Subnets  
- **DB Tier** → Private Subnets (Multi-AZ)  
- **Frontend ALB**, **Backend ALB**  
- **NAT Gateway**, **IGW**  
- **Security Groups**, **Routing**, **High-Availability** (3 AZ)

---

## 📌 **Architecture Overview (Mermaid Diagram)**

```mermaid
flowchart TB
    subgraph VPC["VPC (10.0.0.0/16)"]
        
        subgraph AZA["Availability Zone A"]
            PWA["public-web-subnet-a<br/>10.0.8.0/28"]
            PVA["private-web-subnet-a<br/>10.0.48.0/28"]
            PAA["private-app-subnet-a<br/>10.96.0.0/28"]
            PDA["private-db-subnet-a<br/>10.144.0.0/28"]

            FE_SRV_A["Frontend Server"]
            BE_SRV_A["Backend Server"]
            DB_A["Database (Multi-AZ node)"]
        end

        subgraph AZB["Availability Zone B"]
            PWB["public-web-subnet-b<br/>10.8.16.0/28"]
            PVB["private-web-subnet-b<br/>10.8.64.0/28"]
            PAB["private-app-subnet-b<br/>10.112.0.0/28"]
            PDB["private-db-subnet-b<br/>10.168.0.0/28"]

            FE_SRV_B["Frontend Server"]
            BE_SRV_B["Backend Server"]
            DB_B["Database (Multi-AZ node)"]
        end

        subgraph AZC["Availability Zone C"]
            PWC["public-web-subnet-c<br/>10.8.32.0/28"]
            PVC["private-web-subnet-c<br/>10.8.88.0/28"]
            PAC["private-app-subnet-c<br/>10.128.0.0/28"]
            PDC["private-db-subnet-c<br/>10.184.0.0/28"]
        end

        ALB_F["Frontend ALB"]
        ALB_B["Backend ALB"]
    end

    ALB_F --> FE_SRV_A
    ALB_F --> FE_SRV_B

    FE_SRV_A --> ALB_B
    FE_SRV_B --> ALB_B

    ALB_B --> BE_SRV_A
    ALB_B --> BE_SRV_B

    BE_SRV_A --> DB_A
    BE_SRV_B --> DB_B
