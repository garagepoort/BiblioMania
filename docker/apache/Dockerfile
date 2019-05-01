FROM centos:7.2.1511
RUN yum -y install httpd ; yum clean all
RUN systemctl enable httpd.service
RUN yum -y install epel-release ; yum clean all
RUN yum -y install http://rpms.remirepo.net/enterprise/remi-release-7.rpm ; yum clean all
RUN yum -y install yum-utils ; yum clean all
RUN yum-config-manager --enable remi-php72 ; yum clean all
RUN yum -y update ; yum clean all
RUN yum -y install php ; yum clean all
RUN yum -y install php-mysql ; yum clean all
RUN yum -y install php-pdo ; yum clean all
RUN yum -y install php-pdo_mysql ; yum clean all
RUN yum -y install git ; yum clean all
COPY ./my-httpd.conf /etc/httpd/conf/httpd.conf
COPY docker-entrypoint.sh /entrypoint.sh
COPY .env /
ENTRYPOINT ["/entrypoint.sh"]
