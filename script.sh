docker stop $(docker ps -aq)
docker rm $(docker ps -aq)

docker build -t res/apache_php1 docker-images/apache-php-image/Cluster1/
docker build -t res/apache_php2 docker-images/apache-php-image/Cluster2/
docker build -t res/express_image1 docker-images/express-image/Cluster1/
docker build -t res/express_image2 docker-images/express-image/Cluster2/

docker build -t res/apache_rp docker-images/apache-reverse-proxy/

docker run -d --name apache_static1 res/apache_php1
docker run -d --name apache_static2 res/apache_php2
docker run -d --name express_dynamic1 res/express_image1
docker run -d --name express_dynamic2 res/express_image2
docker run -d -v /var/run/docker.sock:/var/run/docker.sock portainer/portainer

docker run -d -p 8080:80 --name apache_rp -e STATIC_APP1=172.17.0.2:80 -e STATIC_APP2=172.17.0.3:80 -e DYNAMIC_APP1=172.17.0.4:3000 -e DYNAMIC_APP2=172.17.0.5:3000 -e PORTAINER_APP=172.17.0.6:9000 res/apache_rp
