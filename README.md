```yaml
project:
  name: "aws-skill-builder-projects"
  title: "Three-Tier Architecture on AWS"
  description: >
    This project demonstrates how to deploy a highly available, secure, scalable 
    Three-Tier Architecture on AWS using VPC, Subnets, Route Tables, ALB, EC2, 
    NAT Gateways, and a Multi-AZ Database Tier.

architecture:
  tiers:
    - Web Tier (Public)
    - App Tier (Private)
    - Database Tier (Private Multi-AZ)
  components:
    - Frontend ALB
    - Backend ALB
    - EC2 Frontend Servers
    - EC2 Backend Servers
    - NAT Gateway
    - Internet Gateway
    - Security Groups
    - Route Tables

diagram:
  type: mermaid
  code: |
    flowchart TB
        subgraph VPC["VPC (10.0.0.0/16)"]
            subgraph AZA["Availability Zone A"]
                PWA["public-web-subnet-a"]
                PVA["private-web-subnet-a"]
                PAA["private-app-subnet-a"]
                PDA["private-db-subnet-a"]
                FE_SRV_A["Frontend Server A"]
                BE_SRV_A["Backend Server A"]
                DB_A["DB-A (Multi-AZ)"]
            end

            subgraph AZB["Availability Zone B"]
                PWB["public-web-subnet-b"]
                PVB["private-web-subnet-b"]
                PAB["private-app-subnet-b"]
                PDB["private-db-subnet-b"]
                FE_SRV_B["Frontend Server B"]
                BE_SRV_B["Backend Server B"]
                DB_B["DB-B (Multi-AZ)"]
            end

            subgraph AZC["Availability Zone C"]
                PWC["public-web-subnet-c"]
                PVC["private-web-subnet-c"]
                PAC["private-app-subnet-c"]
                PDC["private-db-subnet-c"]
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

project_steps:
  - step: "Create VPC"
    details: "CIDR block 10.0.0.0/16"

  - step: "Create Subnets"
    web_public:
      - public-web-subnet-a
      - public-web-subnet-b
      - public-web-subnet-c
    web_private:
      - private-web-subnet-a
      - private-web-subnet-b
      - private-web-subnet-c
    app_private:
      - private-app-subnet-a
      - private-app-subnet-b
      - private-app-subnet-c
    db_private:
      - private-db-subnet-a
      - private-db-subnet-b
      - private-db-subnet-c

  - step: "Create Route Tables"
    route_tables:
      - Web Public Route Table
      - Web Private Route Table (1a, 1b, 1c)
      - App Private Route Table (1a, 1b, 1c)
      - DB Private Route Table (1a, 1b, 1c)

  - step: "Associate Route Tables with Subnets"

  - step: "Create Internet Gateway"
    action:
      - Create IGW
      - Attach IGW to VPC

  - step: "Create NAT Gateway"
    action:
      - Create NAT in public subnet
      - Allocate Elastic IP

  - step: "Add Routes"
    public_routes:
      - "0.0.0.0/0 → IGW"
    private_routes:
      - "0.0.0.0/0 → NAT Gateway"

  - step: "Create Security Groups"
    security_groups:
      frontend_alb_sg:
        - allow HTTP 80 from anywhere
      frontend_server_sg:
        - allow HTTP 80 from frontend ALB
      backend_alb_sg:
        - allow HTTP 80 from frontend servers
      backend_server_sg:
        - allow HTTP 80 from backend ALB
      database_sg:
        - allow DB port only from backend servers

components_used:
  networking:
    - VPC
    - Public Subnets
    - Private Web Subnets
    - Private App Subnets
    - Private DB Subnets
    - Route Tables
    - Internet Gateway
    - NAT Gateway
  compute:
    - EC2 Frontend Servers
    - EC2 Backend Servers
    - Frontend ALB
    - Backend ALB
  database:
    - RDS Multi-AZ
  security:
    - Security Groups
    - IAM Roles
    - NACL (optional)

learning_outcomes:
  - Multi-AZ VPC design
  - Subnet tiering & separation
  - NAT vs IGW routing
  - ALB load balancing flows
  - Backend communication logic
  - RDS Multi-AZ reliability
  - AWS security best practices

folder_structure: |
  aws-skill-builder-projects/
  ├── three-tier-architecture/
  │   ├── README.md
  │   ├── diagrams/
  │   │   └── architecture.png
  │   ├── terraform/
  │   ├── cloudformation/
  │   └── notes/
  └── future-projects/

future_enhancements:
  - Terraform automation
  - CloudFormation templates
  - Auto Scaling
  - CloudFront + WAF
  - CloudWatch monitoring
  - CI/CD Pipeline
