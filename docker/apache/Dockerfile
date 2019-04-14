FROM centos:7.2.1511
RUN yum -y install httpd ; yum clean all
RUN systemctl enable httpd.service
RUN rpm -Uvh http://dl.fedoraproject.org/pub/epel/7/x86_64/Packages/e/epel-release-7-11.noarch.rpm
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
RUN yum -y --enablerepo=remi,remi-php56 install php php-mysql php-devel php-gd php-pecl-memcache php-pspell php-snmp php-xmlrpc php-xml ; yum clean all
RUN yum -y --enablerepo=remi,remi-php56 install php-mcrypt ; yum clean all
RUN yum -y --enablerepo=remi,remi-php56 install php-mbstring ; yum clean all
RUN yum -y install git ; yum clean all
COPY ./my-httpd.conf /etc/httpd/conf/httpd.conf
COPY docker-entrypoint.sh /entrypoint.sh
COPY .env /
ENTRYPOINT ["/entrypoint.sh"]
