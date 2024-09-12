#!/usr/bin/sh
wget https://repo.zabbix.com/zabbix/6.0/ubuntu/pool/main/z/zabbix-release/zabbix-release_6.0-4+ubuntu22.04_all.deb
sudo dpkg -i zabbix-release_6.0-4+ubuntu22.04_all.deb
sudo apt update 
sudo apt install -y zabbix-agent 
sudo systemctl restart zabbix-agent
sudo systemctl enable zabbix-agent
sudo sed -i 's/^Server=127.0.0.1/Server=<ip_zabbix>/' /etc/zabbix/zabbix_agentd.conf
sudo sed -i 's/^ServerActive=127.0.0.1/ServerActive=<ip_zabbix>/' /etc/zabbix/zabbix_agentd.conf
