FROM docker.elastic.co/elasticsearch/elasticsearch:6.4.3

ADD elasticsearch.yml /usr/share/elasticsearch/config/
USER root
RUN chown elasticsearch:elasticsearch /usr/share/elasticsearch/config/elasticsearch.yml

USER elasticsearch
EXPOSE 9200 9300