#Deployment Script for fresho server deployment

#parameter number check
if [ "$#" -ne 4 ]; then
    echo "Please provide proper no of arguments"
    echo "try executing like\nsh deployment_script.sh <git-mail-id> <git-username> <hostname> <version-for-git-tag>"
    exit 2
fi
echo "Starting deployment process"

#####
# Install necessary packages
#####

apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10
echo 'deb http://downloads-distro.mongodb.org/repo/ubuntu-upstart dist 10gen' |  tee /etc/apt/sources.list.d/mongodb.list
apt-get update

apt-get install -y vim nginx php5-fpm logrotate php5-mongo mongodb-org supervisor git php5-mcrypt

#####
# Get the code
#####

#First generate ssh key of the machine
ssh-keygen -t rsa -C "$1"

#add ssh key to github.com user account
file="/root/.ssh/id_rsa.pub"
ssh_key=$(cat "$file")
curl -u "$2" --data '{"title":"deployment-key","key":"'"$ssh_key"'"}' https://api.github.com/user/keys


cd /usr/local/
git clone git@github.com:paragdakle/fresho.git

cd fresho/portal
mkdir /var/www/
mkdir /var/www/fresho
mv -R css/ /var/www/fresho/
mv -R fonts/ /var/www/fresho/
mv -R js/ /var/www/fresho/
mv -R resources/ /var/www/fresho/
mv -R *.html /var/www/fresho/
mv -R *.php /var/www/fresho/

# nginx
mkdir /etc/nginx/certs

cp $script_path/server.crt /etc/nginx/certs/ # dummy.cer should be replaced by your .crt file name
cp $script_path/server.key /etc/nginx/certs/  # dummy.key should be replaced by your .key file name

cd /etc/nginx/certs
#openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout server.key -out server.crt -subj "/C=US/ST=California/O=Tritium, Inc./localityName=San Francisco/commonName=Tritium Appliance"
cp server.crt ca.crt
cp server.key ca.key

no_of_workers=$(grep ^processor /proc/cpuinfo | wc -l)

cd /etc/nginx
cat << EOF > nginx.conf
user www-data;
worker_processes $no_of_workers;
worker_rlimit_nofile 100000;
pid /run/nginx.pid;

events {
        worker_connections 5000;
        multi_accept on;
        use epoll;
}

http {

        ##
        # Basic Settings
        ##

        sendfile on;
        tcp_nopush on;
        tcp_nodelay on;
        keepalive_timeout 65;
        types_hash_max_size 2048;
        # server_tokens off;

        # server_names_hash_bucket_size 64;
        # server_name_in_redirect off;

        include /etc/nginx/mime.types;
        default_type application/octet-stream;

        ##
        # Logging Settings
        ##

        access_log /var/log/nginx/access.log;
        error_log /var/log/nginx/error.log;

        ##
        # Gzip Settings
        ##

        gzip on;
        gzip_disable "msie6";

        # gzip_vary on;
        # gzip_proxied any;
        # gzip_comp_level 6;
        # gzip_buffers 16 8k;
        # gzip_http_version 1.1;
        # gzip_types text/plain text/css application/json application/x-javascript text/xml application/xml application/xml+rss text/javascript;

        ##
        # Virtual Host Configs
        ##

        include /etc/nginx/conf.d/*.conf;
        include /etc/nginx/sites-enabled/*;
}
EOF

cd /etc/nginx/sites-available
#insert ip or server name here
HOSTNAME=$3
cat << EOF | sed "s/HOSTNAME/${HOSTNAME}/" > tritium
server {
  listen      80;
  server_name HOSTNAME;
  return      301 https://\$server_name\$request_uri;
}

server {

  listen 443;
  ssl on;
  root /var/www/tritonportal;
  index index.php;
  server_name HOSTNAME;
  client_max_body_size 20M;

  ssl_certificate        /etc/nginx/certs/server.crt;
  ssl_certificate_key    /etc/nginx/certs/server.key;
  ssl_client_certificate /etc/nginx/certs/ca.crt;
  ssl_verify_client      optional;
  ssl_verify_depth       1;
 
  # "debug | info | notice | warn | error | crit | alert | emerg"
  error_log /var/log/nginx/error.log error;

  location / {
    if (!-e \$request_filename) {
      rewrite ^(.*)$ /index.php;
    }
  }

  location ~ \.php$ {
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    fastcgi_pass 127.0.0.1:9000;
    fastcgi_read_timeout 300;
    fastcgi_param  VERIFIED \$ssl_client_verify;
    fastcgi_param  CLIENT_CERT \$ssl_client_raw_cert;
    fastcgi_param  DN \$ssl_client_s_dn;
    fastcgi_index index.php;
    include fastcgi_params;

    # dev env settings
    fastcgi_param PHP_VALUE "short_open_tag=on \n display_errors=on \n error_reporting=E_ALL";

    # prod env settings
    fastcgi_param PHP_VALUE "short_open_tag=on \n display_errors=off \n error_reporting=E_ALL";
  }

}
EOF
rm /etc/nginx/sites-enabled/default
ln -s /etc/nginx/sites-available/tritium /etc/nginx/sites-enabled/tritium ##EDIT THIS
service nginx restart

# Php-fpm
sed -i -e 's/listen = \/var\/run\/php5-fpm.sock/listen = 127.0.0.1:9000/' /etc/php5/fpm/pool.d/www.conf
sed -i -e 's/max_execution_time = 30/max_execution_time = 300/' /etc/php5/fpm/php.ini
sed -i -e 's/post_max_size = 8M/post_max_size = 21M/' /etc/php5/fpm/php.ini
sed -i -e 's/upload_max_filesize = 2M/upload_max_filesize = 21M/' /etc/php5/fpm/php.ini
sed -i -e 's/;request_terminate_timeout = 0/request_terminate_timeout = 30/' /etc/php5/fpm/pool.d/www.conf
sed -i -e 's/pm.max_children = 5/pm.max_children = 500/' /etc/php5/fpm/pool.d/www.conf
sed -i -e 's/pm.start_servers = 2/pm.start_servers = 450/' /etc/php5/fpm/pool.d/www.conf
sed -i -e 's/pm.min_spare_servers = 1/pm.min_spare_servers = 450/' /etc/php5/fpm/pool.d/www.conf
sed -i -e 's/pm.max_spare_servers = 3/pm.max_spare_servers = 500/' /etc/php5/fpm/pool.d/www.conf
sed -i -e 's/;listen.backlog = /listen.backlog = /' /etc/php5/fpm/pool.d/www.conf
sed -i -e 's/;catch_workers_output = /catch_workers_output = /' /etc/php5/fpm/pool.d/www.conf
sed -i -e 's/;php_admin_value\[error_log\] = /php_admin_value\[error_log\] = /' /etc/php5/fpm/pool.d/www.conf
sed -i -e 's/;php_admin_flag\[log_errors\] = /php_admin_flag\[log_errors\] = /' /etc/php5/fpm/pool.d/www.conf
service php5-fpm restart

# Sysctl configurations
cd /etc
cat << EOF > sysctl.conf
#
# /etc/sysctl.conf - Configuration file for setting system variables
# See /etc/sysctl.d/ for additional system variables.
# See sysctl.conf (5) for information.
#

#kernel.domainname = example.com

# Uncomment the following to stop low-level messages on console
#kernel.printk = 3 4 1 3

##############################################################
# Functions previously found in netbase
#

# Uncomment the next two lines to enable Spoof protection (reverse-path filter)
# Turn on Source Address Verification in all interfaces to
# prevent some spoofing attacks
#net.ipv4.conf.default.rp_filter=1
#net.ipv4.conf.all.rp_filter=1

# Uncomment the next line to enable TCP/IP SYN cookies
# See http://lwn.net/Articles/277146/
# Note: This may impact IPv6 TCP sessions too
#net.ipv4.tcp_syncookies=1

# Uncomment the next line to enable packet forwarding for IPv4
#net.ipv4.ip_forward=1

# Uncomment the next line to enable packet forwarding for IPv6
#  Enabling this option disables Stateless Address Autoconfiguration
#  based on Router Advertisements for this host
#net.ipv6.conf.all.forwarding=1


###################################################################
# Additional settings - these settings can improve the network
# security of the host and prevent against some network attacks
# including spoofing attacks and man in the middle attacks through
# redirection. Some network environments, however, require that these
# settings are disabled so review and enable them as needed.
#
# Do not accept ICMP redirects (prevent MITM attacks)
#net.ipv4.conf.all.accept_redirects = 0
#net.ipv6.conf.all.accept_redirects = 0
# _or_
# Accept ICMP redirects only for gateways listed in our default
# gateway list (enabled by default)
# net.ipv4.conf.all.secure_redirects = 1
#
# Do not send ICMP redirects (we are not a router)
#net.ipv4.conf.all.send_redirects = 0
#
# Do not accept IP source route packets (we are not a router)
#net.ipv4.conf.all.accept_source_route = 0
#net.ipv6.conf.all.accept_source_route = 0
#
# Log Martian Packets
#net.ipv4.conf.all.log_martians = 1
#

### IMPROVE SYSTEM MEMORY MANAGEMENT ###

# Increase size of file handles and inode cache
fs.file-max = 2097152

# Do less swapping
vm.swappiness = 10
vm.dirty_ratio = 60
vm.dirty_background_ratio = 2

### GENERAL NETWORK SECURITY OPTIONS ###

# Number of times SYNACKs for passive TCP connection.
net.ipv4.tcp_synack_retries = 2

# Allowed local port range
net.ipv4.ip_local_port_range = 2000 65535

# Protect Against TCP Time-Wait
net.ipv4.tcp_rfc1337 = 1

# Decrease the time default value for tcp_fin_timeout connection
net.ipv4.tcp_fin_timeout = 15

# Decrease the time default value for connections to keep alive
net.ipv4.tcp_keepalive_time = 300
net.ipv4.tcp_keepalive_probes = 5
net.ipv4.tcp_keepalive_intvl = 15

### TUNING NETWORK PERFORMANCE ###

# Default Socket Receive Buffer
net.core.rmem_default = 31457280

# Maximum Socket Receive Buffer
net.core.rmem_max = 12582912

# Default Socket Send Buffer
net.core.wmem_default = 31457280

# Maximum Socket Send Buffer
net.core.wmem_max = 12582912

# Increase number of incoming connections
net.core.somaxconn = 15000

# Increase number of incoming connections backlog
net.core.netdev_max_backlog = 65536

# Increase the maximum amount of option memory buffers
net.core.optmem_max = 25165824

# Increase the maximum total buffer-space allocatable
# This is measured in units of pages (4096 bytes)
net.ipv4.tcp_mem = 65536 131072 262144
net.ipv4.udp_mem = 65536 131072 262144

# Increase the read-buffer space allocatable
net.ipv4.tcp_rmem = 8192 87380 16777216
net.ipv4.udp_rmem_min = 16384

# Increase the write-buffer-space allocatable
net.ipv4.tcp_wmem = 8192 65536 16777216
net.ipv4.udp_wmem_min = 16384

# Increase the tcp-time-wait buckets pool size to prevent simple DOS attacks
net.ipv4.tcp_max_tw_buckets = 1440000
net.ipv4.tcp_tw_recycle = 1
net.ipv4.tcp_tw_reuse = 1
EOF

sudo sysctl -p

# File limit changes

cd /etc/security
cat << EOF > limits.conf
# /etc/security/limits.conf
#
#Each line describes a limit for a user in the form:
#
#<domain>        <type>  <item>  <value>
#
#Where:
#<domain> can be:
#        - a user name
#        - a group name, with @group syntax
#        - the wildcard *, for default entry
#        - the wildcard %, can be also used with %group syntax,
#                 for maxlogin limit
#        - NOTE: group and wildcard limits are not applied to root.
#          To apply a limit to the root user, <domain> must be
#          the literal username root.
#
#<type> can have the two values:
#        - "soft" for enforcing the soft limits
#        - "hard" for enforcing hard limits
#
#<item> can be one of the following:
#        - core - limits the core file size (KB)
#        - data - max data size (KB)
#        - fsize - maximum filesize (KB)
#        - memlock - max locked-in-memory address space (KB)
#        - nofile - max number of open files
#        - rss - max resident set size (KB)
#        - stack - max stack size (KB)
#        - cpu - max CPU time (MIN)
#        - nproc - max number of processes
#        - as - address space limit (KB)
#        - maxlogins - max number of logins for this user
#        - maxsyslogins - max number of logins on the system
#        - priority - the priority to run user process with
#        - locks - max number of file locks the user can hold
#        - sigpending - max number of pending signals
#        - msgqueue - max memory used by POSIX message queues (bytes)
#        - nice - max nice priority allowed to raise to values: [-20, 19]
#        - rtprio - max realtime priority
#        - chroot - change root to directory (Debian-specific)
#
#<domain>      <type>  <item>         <value>
#

#*               soft    core            0
#root            hard    core            100000
#*               hard    rss             10000
#@student        hard    nproc           20
#@faculty        soft    nproc           20
#@faculty        hard    nproc           50
#ftp             hard    nproc           0
#ftp             -       chroot          /ftp
#@student        -       maxlogins       4
* soft nofile 500000
* hard nofile 500000
root soft nofile 500000
root hard nofile 500000
nginx soft nofile 500000
nginx hard nofile 500000
# End of file
EOF
