# Follow these installation steps on the AMI EC2 instance:

## Install PHP, Apache, and MySQL client:


## Install git:
```
sudo dnf install git -y
```

## Add the following EC2 instance userdata to the Launch Template:

```
#!/bin/bash
sudo systemctl start httpd
cd /var/www/html
sudo git clone https://github.com/ajitinamdar-tech/three-tier-architecture-aws.git
sudo mkdir api
sudo mv /var/www/html/three-tier-architecture-aws/backend/api/* /var/www/html/api/
sudo rm -rf /var/www/html/three-tier-architecture-aws
sed -i 's/update-me-host/insert-your-database-host-here/g' /var/www/html/api/db_connection.php
sed -i 's/update-me-username/insert-your-database-username-here/g' /var/www/html/api/db_connection.php
sed -i 's/update-me-password/insert-your-database-password-here/g' /var/www/html/api/db_connection.php
```
