
![Badge em Desenvolvimento](http://img.shields.io/static/v1?label=STATUS&message=EM%20DESENVOLVIMENTO&color=GREEN&style=for-the-badge)

# Índice 

* [Título e Imagem de capa](#Título-e-Imagem-de-capa)
* [Badges](#badges)
* [Índice](#índice)
* [Descrição do Projeto](#descrição-do-projeto)
* [Status do Projeto](#status-do-Projeto)
* [Funcionalidades e Demonstração da Aplicação](#funcionalidades-e-demonstração-da-aplicação)
* [Acesso ao Projeto](#acesso-ao-projeto)
* [Tecnologias utilizadas](#tecnologias-utilizadas)
* [Pessoas Contribuidoras](#pessoas-contribuidoras)
* [Pessoas Desenvolvedoras do Projeto](#pessoas-desenvolvedoras)
* [Licença](#licença)
* [Conclusão](#conclusão)

Tutorial PipeLine
https://medium.com/@peacevan/criando-um-simples-pipeline-ci-cd-com-githubaction-laravel-aws-ec2-31d1cbe90184


1. Instalar o Nginx
sudo yum install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx


2. Instalar o PHP 8.2.x
sudo yum install -y php php-cli php-fpm php-mysqlnd php-zip php-devel php-gd php-mbstring php-curl php-xml php-pear php-bcmath php-json
sudo systemctl start php-fpm
sudo systemctl enable php-fpm


3. Configurar o Nginx para o Laravel
server {
    listen 80;
    server_name homolog.imwpga.com.br; 
    root /var/www/html/imw/public; # Substitua pelo caminho correto

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass unix:/var/run/php-fpm/www.sock; # Verifique o caminho correto
        try_files $uri =404;
    }
}


sudo nginx -t
sudo systemctl restart nginx

4. Instalar o Certbot para Certificado SSL
sudo yum install certbot python3-certbot-nginx -y
sudo certbot --nginx -d homolog.imwpga.com.br 

5. Configurar o Laravel
sudo chown -R nginx:nginx /var/www/laravel
sudo chmod -R 777 /var/www/laravel/storage
sudo chmod -R 755 /var/www/laravel/bootstrap/cache

6. git 
sudo yum install git -y
git --version
cd /var/www/hml/
git clone https://github.com/Lioh23/imw.git

7. Composer
sudo curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
cd /var/www/hml/imw 
#dentro da pasta /var/www/hml/imw
	composer install #dentro da pasta /var/www/hml/imw , digite Y em todas as etapas
	sudo php artisan migrate #rodar as migrações
	sudo sudo php artisan db:seed #rodas os seeds iniciais


8. Arquivo .env
mv /var/www/html/imw/.env.example /var/www/html/imw/.env


