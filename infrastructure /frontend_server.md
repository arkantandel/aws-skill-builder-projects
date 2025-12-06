# Follow these installation steps on the AMI EC2 instance:

## Install Nginx server and git
```
sudo dnf install nginx -y
sudo dnf install git -y
```
Replace the server block in /etc/nginx/nginx.conf with the content from the nginx_config file.

## Add the following EC2 instance userdata to the Launch Template:

```
#!/bin/bash
sed -i 's/update-me/insert-your-backend-alb-url-here/g' /etc/nginx/nginx.conf
sudo systemctl start nginx
cd /usr/share/nginx/html
sudo git clone https://github.com/ajitinamdar-tech/three-tier-architecture-aws.git
mv /usr/share/nginx/html/three-tier-architecture-aws/frontend/* /usr/share/nginx/html/
sudo rm -rf /usr/share/nginx/html/three-tier-architecture-aws
```

